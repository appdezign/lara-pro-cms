<?php

namespace Lara\Admin\Concerns;

use Binafy\LaravelStub\Facades\LaravelStub;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Lara\Admin\Enums\CustomFieldType;
use Lara\Admin\Enums\FormFieldType;
use Lara\Common\Entities\EntityFieldName;
use Lara\Common\Entities\EntityLabel;
use Lara\Common\Models\Entity;
use Lara\Common\Models\EntityCustomField;
use RuntimeException;
use Throwable;

/**
 * Generates the code and the database table for entities, and the columns for custom fields.
 *
 * The schema is changed at runtime on purpose: webmasters create entities and fields from the
 * admin, without server or database access. MySQL commits every schema change immediately, so
 * nothing can be rolled back by a transaction. Instead every build method:
 * - checks everything it can before it changes anything,
 * - changes the schema in steps that each register how to undo them,
 * - verifies the result before the entity or field row keeps its new values,
 * - and on failure undoes the completed steps, restores the row and notifies the user.
 */
trait HasLaraBuilder
{
	/**
	 * The columns a geolocation field consists of.
	 *
	 * @var list<string>
	 */
	private const GEO_COLUMNS = ['geo_address', 'geo_pcode', 'geo_city', 'geo_country', 'geo_location', 'geo_latitude', 'geo_longitude'];

	/**
	 * Guard the label before it is turned into class names and written to disk.
	 *
	 * The admin form validates this too, but the generator is the last point at
	 * which a bad value can still be rejected cheaply - past here it becomes a
	 * PHP file that cannot be loaded, and a resource that cannot be opened.
	 *
	 * @throws InvalidArgumentException
	 */
	private static function assertLabelIsUsableAsClassName(Entity $entity): void
	{
		$label = (string) $entity->label_single;

		$rejection = EntityLabel::reject($label);

		if ($rejection !== null) {
			throw new InvalidArgumentException(
				'Entity label "'.$label.'" cannot be used to derive a class name. '.$rejection
			);
		}
	}

	/**
	 * Generate the code and the table for a new entity, or leave nothing behind.
	 *
	 * On failure the generated files, a table created here and the entity row itself are removed,
	 * so the webmaster can correct the input and try again.
	 */
	private static function buildEntity(Entity $entity): bool
	{
		try {
			static::assertEntityCanBeBuilt($entity);
		} catch (Throwable $e) {
			$entity->delete();
			static::notifyBuildFailure('The entity could not be created', $e);

			return false;
		}

		$tablename = static::getEntityTableName($entity, Str::plural($entity->label_single));
		$paths = static::getGeneratedPaths($entity);
		$existingFiles = array_values(array_filter($paths['files'], fn (string $path): bool => File::exists($path)));
		$existingDirectories = array_values(array_filter($paths['directories'], fn (string $path): bool => File::isDirectory($path)));
		$tableExisted = Schema::hasTable($tablename);

		try {
			static::runSchemaSteps([
				[
					fn () => static::createEntity($entity),
					function () use ($paths, $existingFiles, $existingDirectories) {
						File::delete(array_diff($paths['files'], $existingFiles));
						foreach (array_diff($paths['directories'], $existingDirectories) as $directory) {
							File::deleteDirectory($directory);
						}
					},
				],
				[
					fn () => static::checkDatabaseTable($entity),
					function () use ($tablename, $tableExisted) {
						if (! $tableExisted) {
							Schema::dropIfExists($tablename);
						}
					},
				],
				[
					function () use ($tablename, $paths) {
						foreach ($paths['files'] as $path) {
							if (! File::exists($path)) {
								throw new RuntimeException('File was not generated: '.$path);
							}
						}
						if (! Schema::hasTable($tablename)) {
							throw new RuntimeException('Table was not created: '.$tablename);
						}
					},
					null,
				],
			]);
		} catch (Throwable $e) {
			$entity->delete();
			static::notifyBuildFailure('The entity could not be created', $e);

			return false;
		}

		// a table left behind by an entity that was deleted earlier is reused, with its data
		if ($tableExisted) {
			Notification::make()
				->title('Existing table reused: '.$tablename)
				->warning()
				->send();
		}

		return true;
	}

	/**
	 * Everything that can be checked before files are written or the schema is changed.
	 *
	 * @throws InvalidArgumentException
	 */
	private static function assertEntityCanBeBuilt(Entity $entity): void
	{
		static::assertLabelIsUsableAsClassName($entity);

		$resourceSlug = Str::plural($entity->label_single);

		if (Entity::where('resource_slug', $resourceSlug)->whereKeyNot($entity->getKey())->exists()) {
			throw new InvalidArgumentException('An entity with the resource slug "'.$resourceSlug.'" already exists.');
		}

		// checked on disk: a failed class_exists() is cached by the autoloader for the rest of the
		// request, so the model could not be loaded after it has been generated
		$modelFile = static::getGeneratedPaths($entity)['files'][0];
		if (File::exists($modelFile)) {
			throw new InvalidArgumentException('The model '.$modelFile.' already exists. Generating it again would overwrite it.');
		}

		if (! array_key_exists($entity->cgroup.'_prefix', config('lara-common.database.entity'))) {
			throw new InvalidArgumentException('No table prefix is configured for the group "'.$entity->cgroup.'".');
		}

		$tablename = static::getEntityTableName($entity, $resourceSlug);
		if (strlen($tablename) > 64) {
			throw new InvalidArgumentException('The table name '.$tablename.' is longer than 64 characters.');
		}

		foreach (static::getGeneratedPaths($entity)['writable'] as $directory) {
			if (File::isDirectory($directory) && ! File::isWritable($directory)) {
				throw new InvalidArgumentException('The directory '.$directory.' is not writable.');
			}
		}
	}

	/**
	 * The files and resource directory createEntity() writes, and the directories it writes into.
	 *
	 * @return array{files: list<string>, directories: list<string>, writable: list<string>}
	 */
	private static function getGeneratedPaths(Entity $entity): array
	{
		$modelNameSingle = ucfirst($entity->label_single);
		$modelNamePlural = ucfirst(Str::plural($entity->label_single));

		$appPath = base_path('laracms/app/');
		$resourceDirPath = $appPath.'Filament/Resources/'.$modelNamePlural;

		return [
			'files' => [
				$appPath.'Models/'.$modelNameSingle.'.php',
				$appPath.'Entities/'.$modelNamePlural.'Entity.php',
				$appPath.'Policies/'.$modelNameSingle.'Policy.php',
				$appPath.'Http/Controllers/Front/Entity/'.$modelNamePlural.'Controller.php',
				$appPath.'Database/Factories/'.$modelNameSingle.'Factory.php',
				$resourceDirPath.'/'.$modelNameSingle.'Resource.php',
			],
			'directories' => [
				$resourceDirPath,
			],
			'writable' => [
				$appPath.'Models',
				$appPath.'Entities',
				$appPath.'Policies',
				$appPath.'Http/Controllers/Front/Entity',
				$appPath.'Database/Factories',
				$appPath.'Filament/Resources',
			],
		];
	}

	private static function getEntityTableName(Entity $entity, ?string $resourceSlug = null): string
	{
		$entityPrefixes = config('lara-common.database.entity');

		return $entityPrefixes[$entity->cgroup.'_prefix'].($resourceSlug ?? $entity->resource_slug);
	}

	private static function createEntity(Entity $entity): void
	{

		static::assertLabelIsUsableAsClassName($entity);

		$isForm = $entity->cgroup == 'form';

		$modelVarSingle = $entity->label_single;
		$modelVarPlural = Str::plural($modelVarSingle);
		$modelNameSingle = ucfirst($modelVarSingle);
		$modelNamePlural = ucfirst($modelVarPlural);

		// resource
		$resourceName = $modelNameSingle.'Resource';
		$resourceDir = ucfirst($modelVarPlural);

		// policy
		$policyName = $modelNameSingle.'Policy';

		// resource pages, named the way Filament's own generator names them:
		// plural for the list-scoped pages, singular for the record-scoped ones
		$pageNames = [
			'list' => 'List'.$modelNamePlural,
			'create' => 'Create'.$modelNameSingle,
			'edit' => 'Edit'.$modelNameSingle,
			'view' => 'View'.$modelNameSingle,
			'reorder' => 'Reorder'.$modelNamePlural,
		];

		// update entity
		$entity->title = $modelNamePlural;
		$entity->resource_slug = $modelVarPlural;
		$entity->resource = 'Lara\\App\\Filament\\Resources\\'.$resourceDir.'\\'.$resourceName;
		$entity->model_class = 'Lara\\App\\Models\\'.$modelNameSingle;
		$entity->controller = $modelNamePlural.'Controller';
		$entity->policy = 'Lara\\App\\Policies\\'.$modelNameSingle.'Policy';
		$entity->save();

		// table
		$entityPrefixes = config('lara-common.database.entity');

		$entityPrefix = $entityPrefixes[$entity->cgroup.'_prefix'];
		$tablename = $entityPrefix.$modelVarPlural;

		// stubs - paths
		$fromPath = base_path('laracms/core/src/admin/Stubs/');
		$toPath = base_path('laracms/app/');
		$resourcesPath = base_path('laracms/app/Filament/Resources/');

		// make directories for resource pages
		$resourceDirPath = $resourcesPath.DIRECTORY_SEPARATOR.$resourceDir;
		if (! File::isDirectory($resourceDirPath)) {
			File::makeDirectory($resourceDirPath);
		}
		$resourcePagesPath = $resourceDirPath.DIRECTORY_SEPARATOR.'Pages';
		if (! File::isDirectory($resourcePagesPath)) {
			File::makeDirectory($resourcePagesPath);
		}

		// LaravelStub::generate() throws when the destination folder is missing
		// rather than creating it, so make sure each stub target exists
		foreach (['Models', 'Entities', 'Policies', 'Http/Controllers/Front/Entity'] as $stubTarget) {
			$stubTargetPath = $toPath.$stubTarget;
			if (! File::isDirectory($stubTargetPath)) {
				File::makeDirectory($stubTargetPath, recursive: true);
			}
		}

		// stub - model
		LaravelStub::from($fromPath.'model.stub')
			->to($toPath.'Models')
			->name($modelNameSingle)
			->ext('php')
			->replaces([
				'NAMESPACE' => 'Lara\App\Models',
				'CLASS' => $modelNameSingle,
				'MODEL' => $modelNameSingle,
				'FACTORY' => $modelNameSingle.'Factory',
				'TABLE' => $tablename,
			])
			->generate();

		// stub - lara entity
		LaravelStub::from($fromPath.'laraentity.stub')
			->to($toPath.'Entities')
			->name($modelNamePlural.'Entity')
			->ext('php')
			->replaces([
				'NAMESPACE' => 'Lara\App\Entities',
				'CLASS' => $modelNamePlural.'Entity',
				'RESOURCESLUG' => $modelVarPlural,
			])
			->generate();

		// stub - frontend controller
		LaravelStub::from($fromPath.'frontcontroller.stub')
			->to($toPath.'Http/Controllers/Front/Entity')
			->name($modelNamePlural.'Controller')
			->ext('php')
			->replaces([
				'NAMESPACE' => 'Lara\App\Http\Controllers\Front\Entity',
				'CLASS' => $modelNamePlural.'Controller',
				'MODEL' => $modelNameSingle,
			])
			->generate();

		// stub - resource
		$resourceStub = ($isForm) ? 'formresource.stub' : 'resource.stub';
		LaravelStub::from($fromPath.$resourceStub)
			->to($resourceDirPath)
			->name($resourceName)
			->ext('php')
			->replaces([
				'NAMESPACE' => 'Lara\App\Filament\Resources\\'.$resourceDir,
				'RESOURCE' => $resourceName,
				'MODEL' => $modelNameSingle,
				'LISTPAGE' => $pageNames['list'],
				'CREATEPAGE' => $pageNames['create'],
				'EDITPAGE' => $pageNames['edit'],
				'VIEWPAGE' => $pageNames['view'],
				'REORDERPAGE' => $pageNames['reorder'],
			])
			->generate();

		// stub - policy
		LaravelStub::from($fromPath.'policy.stub')
			->to($toPath.'Policies')
			->name($policyName)
			->ext('php')
			->replaces([
				'NAMESPACE' => 'Lara\App\Policies',
				'MODEL' => $modelNameSingle,
				'MODELVARIABLE' => $modelVarSingle,
				'RESOURCE' => $resourceName,
			])
			->generate();

		// stub - factory
		LaravelStub::from($fromPath.'factory.stub')
			->to($toPath.'Database/Factories')
			->name($modelNameSingle.'Factory')
			->ext('php')
			->replaces([
				'NAMESPACE' => 'Lara\App\Database\Factories',
				'CLASS' => $modelNameSingle.'Factory',
				'MODEL' => $modelNameSingle,
				'RESOURCESLUG' => $modelVarPlural,
			])
			->generate();

		// stub - resource pages
		$pagesNamespace = 'Lara\App\Filament\Resources\\'.$resourceDir.'\Pages';

		// a form resource only lists and views its submissions
		$stubsToGenerate = $isForm
			? ['list', 'view']
			: ['list', 'create', 'edit', 'view', 'reorder'];

		foreach ($stubsToGenerate as $page) {
			LaravelStub::from($fromPath.'page-'.$page.'.stub')
				->to($resourcePagesPath)
				->name($pageNames[$page])
				->ext('php')
				->replaces([
					'NAMESPACE' => $pagesNamespace,
					'CLASS' => $pageNames[$page],
					'RESOURCE' => $resourceName,
					'RESOURCEDIR' => $resourceDir,
				])
				->generate();
		}

	}

	private static function checkDatabaseTable(Entity $entity): void
	{

		// get tablename
		$entityPrefixes = config('lara-common.database.entity');
		$entityPrefix = $entityPrefixes[$entity->cgroup.'_prefix'];
		$tablename = $entityPrefix.$entity->resource_slug;

		// form
		$isForm = $entity->cgroup == 'form';

		// get all tablenames
		$tablenames = config('lara-common.database');

		if ($isForm) {

			if (! Schema::hasTable($tablename)) {
				Schema::create($tablename, function (Blueprint $table) {

					// ID
					$table->bigIncrements('id');

					// Timestamps
					$table->timestamps();
					$table->timestamp('deleted_at')->nullable();

				});
			}

		} else {

			if (! Schema::hasTable($tablename)) {
				Schema::create($tablename, function (Blueprint $table) use ($tablenames) {

					// ID
					$table->bigIncrements('id');

					// User
					$table->bigInteger('user_id')->unsigned();
					$table->foreign('user_id')
						->references('id')
						->on($tablenames['auth']['users'])
						->onDelete('cascade');

					// Language
					$table->string('language')->nullable();
					$table->bigInteger('language_parent')->unsigned()->nullable();

					// Title
					$table->string('title')->nullable();

					// Slug
					$table->string('slug')->nullable();
					$table->boolean('slug_lock')->default(0);

					// Lead
					$table->text('lead')->nullable();

					// Body
					$table->text('body')->nullable();

					// Timestamps
					$table->timestamps();
					$table->timestamp('deleted_at')->nullable();

					$table->boolean('publish')->default(0);
					$table->timestamp('publish_from')->nullable();
					$table->boolean('publish_expire')->default(0);
					$table->timestamp('publish_to')->nullable();
					$table->boolean('publish_hide')->default(0);

					$table->integer('position')->unsigned()->default(0);
					$table->string('cgroup')->nullable();

					$table->timestamp('locked_at')->nullable();
					$table->bigInteger('locked_by')->nullable()->unsigned();
					$table->foreign('locked_by')
						->references('id')
						->on($tablenames['auth']['users'])
						->onDelete('cascade');

				});
			}
		}

	}

	/**
	 * Add the extra body columns (body2, body3, …) after the entity was saved.
	 *
	 * Columns added here are dropped again when a later one fails, and the entity gets its
	 * previous number of extra body fields back.
	 *
	 * @param  array<string, mixed>  $previousValues  The entity's values before the save (Model::getPrevious())
	 */
	private static function buildExtraBodyColumns(Entity $entity, array $previousValues): bool
	{
		$extraFieldCount = (int) $entity->col_extra_body_fields;

		if ($extraFieldCount < 1) {
			return true;
		}

		$addedColumns = [];

		try {
			static::checkDatabaseTable($entity);

			$tablename = $entity->model_class::getTableName();
			$after = Schema::hasColumn($tablename, 'body') ? 'body' : 'id';

			$steps = [];

			for ($i = 1; $i <= $extraFieldCount; $i++) {
				$fieldName = 'body'.($i + 1);

				if (Schema::hasColumn($tablename, $fieldName)) {
					continue;
				}

				$steps[] = [
					fn () => Schema::table($tablename, fn (Blueprint $table) => $table->text($fieldName)->nullable()->after($after)),
					fn () => static::dropColumn($tablename, $fieldName),
				];
				$addedColumns[] = $fieldName;
			}

			$steps[] = [fn () => static::assertColumnsExist($tablename, $addedColumns), null];

			static::runSchemaSteps($steps);
		} catch (Throwable $e) {
			if (array_key_exists('col_extra_body_fields', $previousValues)) {
				$entity->forceFill(['col_extra_body_fields' => $previousValues['col_extra_body_fields']])->save();
			}
			static::notifyBuildFailure('The extra body fields could not be added', $e);

			return false;
		}

		foreach ($addedColumns as $fieldName) {
			Notification::make()
				->title('New column created: '.$fieldName)
				->success()
				->send();
		}

		return true;
	}

	/**
	 * Apply a custom field that was just created or edited to its table.
	 *
	 * The column is changed first and verified; only then does the field row keep its new values.
	 * On failure the completed steps are undone, and the row is deleted (new field) or restored to
	 * its previous values (edited field), so the field and its column always match.
	 *
	 * @param  array<string, mixed>|null  $previousValues  The values before the edit (Model::getPrevious()), null for a new field
	 */
	private static function buildCustomField(EntityCustomField $customField, ?array $previousValues = null): bool
	{
		$isNew = $previousValues === null;

		/** @var list<Notification> $notifications only sent when every step succeeded */
		$notifications = [];

		try {
			$entity = $customField->entity;

			static::checkDatabaseTable($entity);

			$tablename = $entity->model_class::getTableName();

			static::runSchemaSteps(static::getCustomFieldSteps($customField, $tablename, $isNew, $notifications));
		} catch (Throwable $e) {
			if ($isNew) {
				$customField->delete();
			} else {
				// field_name_temp only holds a pending rename; left behind, the next save would retry it
				$customField->forceFill([...$previousValues, 'field_name_temp' => null])->save();
			}
			static::notifyBuildFailure('The field "'.$customField->title.'" could not be saved', $e);

			return false;
		}

		// json columns need no cast in the model: BaseModel derives them from the field config
		foreach ($notifications as $notification) {
			$notification->send();
		}

		return true;
	}

	/**
	 * The schema steps that bring the table in line with the field.
	 *
	 * @param  list<Notification>  $notifications
	 * @return list<array{0: Closure, 1: Closure|null}>
	 *
	 * @throws InvalidArgumentException when the field cannot be applied; nothing has changed yet
	 */
	private static function getCustomFieldSteps(EntityCustomField $customField, string $tablename, bool $isNew, array &$notifications): array
	{
		$fieldType = CustomFieldType::tryFrom((string) $customField->field_type);

		if ($fieldType === null) {
			throw new InvalidArgumentException('Unknown field type "'.$customField->field_type.'".');
		}

		if ($fieldType === CustomFieldType::Geolocation) {
			return static::getGeolocationSteps($tablename, $notifications);
		}

		$fieldName = (string) $customField->field_name;
		$newFieldName = $customField->field_name_temp ?: null;

		// only a new or a renamed field gets a new column name; existing names are left alone
		if ($isNew || $newFieldName) {
			$targetName = $newFieldName ?? $fieldName;
			$rejection = EntityFieldName::reject($targetName);

			if ($rejection !== null) {
				throw new InvalidArgumentException('The field name "'.$targetName.'" cannot be used. '.$rejection);
			}
		}

		if ($newFieldName) {

			if (Schema::hasColumn($tablename, $newFieldName)) {
				throw new InvalidArgumentException('The table '.$tablename.' already has a column "'.$newFieldName.'".');
			}

			// keep the current column as a backup, add the new one, and only then record the new name
			$steps = Schema::hasColumn($tablename, $fieldName)
				? static::getBackupColumnSteps($tablename, $fieldName, $notifications)
				: [];

			return [
				...$steps,
				...static::getAddColumnSteps($tablename, $newFieldName, $fieldType, $notifications),
				[
					function () use ($customField, $newFieldName) {
						$customField->field_name = $newFieldName;
						$customField->field_name_temp = null;
						$customField->save();
					},
					null,
				],
			];
		}

		if (! Schema::hasColumn($tablename, $fieldName)) {
			return static::getAddColumnSteps($tablename, $fieldName, $fieldType, $notifications);
		}

		if (Schema::getColumnType($tablename, $fieldName) != $fieldType->getDatabaseColumnType()) {
			// the type changed: keep the current column as a backup, and add one of the new type
			return [
				...static::getBackupColumnSteps($tablename, $fieldName, $notifications),
				...static::getAddColumnSteps($tablename, $fieldName, $fieldType, $notifications),
			];
		}

		return [];
	}

	/**
	 * Rename a column to its backup name (_column).
	 *
	 * @param  list<Notification>  $notifications
	 * @return list<array{0: Closure, 1: Closure|null}>
	 *
	 * @throws InvalidArgumentException when an older backup of the column exists; nothing has changed yet
	 */
	private static function getBackupColumnSteps(string $tablename, string $column, array &$notifications): array
	{
		$backupColumn = '_'.$column;

		static::assertNoBackupColumns($tablename, [$backupColumn]);

		return [
			[
				function () use ($tablename, $column, $backupColumn, &$notifications) {
					Schema::table($tablename, fn (Blueprint $table) => $table->renameColumn($column, $backupColumn));

					$notifications[] = static::makeBackupNotification($backupColumn);
				},
				function () use ($tablename, $column, $backupColumn) {
					if (Schema::hasColumn($tablename, $backupColumn) && ! Schema::hasColumn($tablename, $column)) {
						Schema::table($tablename, fn (Blueprint $table) => $table->renameColumn($backupColumn, $column));
					}
				},
			],
		];
	}

	/**
	 * Add a column for a field type and verify it has the expected type.
	 *
	 * @param  list<Notification>  $notifications
	 * @return list<array{0: Closure, 1: Closure|null}>
	 */
	private static function getAddColumnSteps(string $tablename, string $fieldName, CustomFieldType $fieldType, array &$notifications): array
	{
		return [
			[
				function () use ($tablename, $fieldName, $fieldType, &$notifications) {
					static::addColumn($tablename, $fieldName, $fieldType);

					$notifications[] = Notification::make()
						->title('New column created: '.$fieldName)
						->success();
				},
				fn () => static::dropColumn($tablename, $fieldName),
			],
			[fn () => static::assertColumnHasType($tablename, $fieldName, $fieldType->getDatabaseColumnType()), null],
		];
	}

	/**
	 * Add the geo_* columns that are missing.
	 *
	 * @param  list<Notification>  $notifications
	 * @return list<array{0: Closure, 1: Closure|null}>
	 */
	private static function getGeolocationSteps(string $tablename, array &$notifications): array
	{
		$after = Schema::hasColumn($tablename, 'body') ? 'body' : 'id';

		$geoColumns = [
			'geo_address' => fn (Blueprint $table) => $table->string('geo_address')->nullable()->after($after),
			'geo_pcode' => fn (Blueprint $table) => $table->string('geo_pcode')->nullable()->after($after),
			'geo_city' => fn (Blueprint $table) => $table->string('geo_city')->nullable()->after($after),
			'geo_country' => fn (Blueprint $table) => $table->string('geo_country')->nullable()->after($after),
			'geo_location' => fn (Blueprint $table) => $table->string('geo_location')->nullable()->after($after),
			'geo_latitude' => fn (Blueprint $table) => $table->decimal('geo_latitude', 10, 8)->nullable()->after($after),
			'geo_longitude' => fn (Blueprint $table) => $table->decimal('geo_longitude', 11, 8)->nullable()->after($after),
		];

		$steps = [];

		foreach ($geoColumns as $column => $definition) {
			if (Schema::hasColumn($tablename, $column)) {
				continue;
			}

			$steps[] = [
				function () use ($tablename, $column, $definition, &$notifications) {
					Schema::table($tablename, $definition);

					$notifications[] = Notification::make()
						->title('New column created: '.$column)
						->success();
				},
				fn () => static::dropColumn($tablename, $column),
			];
		}

		$steps[] = [fn () => static::assertColumnsExist($tablename, array_keys($geoColumns)), null];

		return $steps;
	}

	/**
	 * Keep the column of a deleted field as a backup.
	 *
	 * The field row is already gone. When this fails the column simply stays where it is,
	 * so no data is lost.
	 */
	private static function archiveCustomFieldColumn(EntityCustomField $customField): void
	{
		try {
			static::dropCustomColumn($customField);
		} catch (Throwable $e) {
			static::notifyBuildFailure('The column of field "'.$customField->title.'" could not be renamed to a backup column', $e);
		}
	}

	private static function dropCustomColumn(EntityCustomField $customField): void
	{

		$modelClass = $customField->entity->model_class;
		$tablename = $modelClass::getTableName();

		static::assertCustomFieldCanBeArchived($customField);

		if ($customField->field_type == 'geolocation') {

			// rename current column, so we don't lose data
			Schema::table($tablename, function ($table) {
				foreach (static::GEO_COLUMNS as $column) {
					$table->renameColumn($column, '_'.$column);
				}
			});

			static::makeBackupNotification('_geo_*')->send();

		} else {

			$fieldName = $customField->field_name;
			$backupColumn = '_'.$fieldName;

			// rename current column, so we don't lose data
			Schema::table($tablename, function ($table) use ($fieldName, $backupColumn) {
				$table->renameColumn($fieldName, $backupColumn);
			});

			static::makeBackupNotification($backupColumn)->send();
		}

	}

	/**
	 * A deleted field's column becomes a backup column, so an older backup of it must be gone first.
	 * Called before the field row is deleted, so the delete can still be refused.
	 *
	 * @throws InvalidArgumentException
	 */
	private static function assertCustomFieldCanBeArchived(EntityCustomField $customField): void
	{
		$tablename = $customField->entity->model_class::getTableName();

		$columns = $customField->field_type == 'geolocation' ? static::GEO_COLUMNS : [$customField->field_name];

		static::assertNoBackupColumns($tablename, array_map(fn (string $column): string => '_'.$column, $columns));
	}

	/**
	 * @param  list<string>  $backupColumns
	 *
	 * @throws InvalidArgumentException
	 */
	private static function assertNoBackupColumns(string $tablename, array $backupColumns): void
	{
		foreach ($backupColumns as $backupColumn) {
			if (Schema::hasColumn($tablename, $backupColumn)) {
				throw new InvalidArgumentException(
					'An older backup column '.$backupColumn.' exists. Restore or delete it under Backup columns first.'
				);
			}
		}
	}

	private static function makeBackupNotification(string $backupColumn): Notification
	{
		return Notification::make()
			->title('The previous column is kept as backup column '.$backupColumn)
			->body('You can restore or delete it under Backup columns.')
			->warning();
	}

	/**
	 * The backup columns of an entity's table: the columns kept after a field was deleted, renamed
	 * or changed type. The geo_* backups of a geolocation field are grouped into one record.
	 *
	 * @return array<string, array{key: string, columns: list<string>, column_type: string, filled_rows: int}>
	 */
	private static function getBackupColumns(Entity $entity): array
	{
		$tablename = static::getEntityTableName($entity);

		if (! Schema::hasTable($tablename)) {
			return [];
		}

		$backups = [];

		foreach (Schema::getColumns($tablename) as $column) {
			if (! str_starts_with($column['name'], '_')) {
				continue;
			}

			$fieldName = substr($column['name'], 1);
			$key = in_array($fieldName, static::GEO_COLUMNS, true) ? 'geolocation' : $fieldName;

			$backups[$key] ??= [
				'key' => $key,
				'columns' => [],
				'column_type' => $key == 'geolocation' ? 'geolocation' : $column['type_name'],
				'filled_rows' => 0,
			];
			$backups[$key]['columns'][] = $column['name'];
		}

		foreach ($backups as $key => $backup) {
			$backups[$key]['filled_rows'] = DB::table($tablename)
				->where(function ($query) use ($backup) {
					foreach ($backup['columns'] as $column) {
						$query->orWhereNotNull($column);
					}
				})
				->count();
		}

		return $backups;
	}

	/**
	 * The field types a backup can be restored as: those whose column type matches the backup.
	 *
	 * @param  array{key: string, column_type: string}  $backup
	 * @return array<string, string> field type => label
	 */
	private static function getRestorableFieldTypes(Entity $entity, array $backup): array
	{
		$allowedTypes = $entity->cgroup == 'form'
			? array_column(FormFieldType::cases(), 'value')
			: array_column(CustomFieldType::cases(), 'value');

		$fieldTypes = [];

		foreach (CustomFieldType::cases() as $fieldType) {
			$fits = $backup['key'] == 'geolocation'
				? $fieldType === CustomFieldType::Geolocation
				: $fieldType !== CustomFieldType::Geolocation && $fieldType->getDatabaseColumnType() == $backup['column_type'];

			if ($fits && in_array($fieldType->value, $allowedTypes, true)) {
				$fieldTypes[$fieldType->value] = $fieldType->getLabel();
			}
		}

		return $fieldTypes;
	}

	/**
	 * Turn a backup column back into a field, with its data: rename the column and create the field row.
	 */
	private static function restoreBackupColumn(Entity $entity, string $key, string $fieldType, string $title): bool
	{
		try {
			$backup = static::getBackupColumns($entity)[$key]
				?? throw new InvalidArgumentException('The backup column no longer exists.');

			if (! array_key_exists($fieldType, static::getRestorableFieldTypes($entity, $backup))) {
				throw new InvalidArgumentException('The field type "'.$fieldType.'" does not fit a '.$backup['column_type'].' column.');
			}

			$isGeolocation = $key == 'geolocation';

			if ($isGeolocation) {
				if ($entity->customfields()->where('field_type', 'geolocation')->exists()) {
					throw new InvalidArgumentException('This entity already has a geolocation field.');
				}
			} else {
				$rejection = EntityFieldName::reject($key);

				if ($rejection !== null) {
					throw new InvalidArgumentException('The field name "'.$key.'" cannot be used. '.$rejection);
				}

				if ($entity->customfields()->where('field_name', $key)->exists()) {
					throw new InvalidArgumentException('A field named "'.$key.'" already exists.');
				}
			}

			$tablename = static::getEntityTableName($entity);
			$renames = [];

			foreach ($backup['columns'] as $backupColumn) {
				$column = substr($backupColumn, 1);

				if (Schema::hasColumn($tablename, $column)) {
					throw new InvalidArgumentException('The table already has a column "'.$column.'".');
				}

				$renames[$backupColumn] = $column;
			}

			$steps = [];

			foreach ($renames as $backupColumn => $column) {
				$steps[] = [
					fn () => Schema::table($tablename, fn (Blueprint $table) => $table->renameColumn($backupColumn, $column)),
					function () use ($tablename, $backupColumn, $column) {
						if (Schema::hasColumn($tablename, $column) && ! Schema::hasColumn($tablename, $backupColumn)) {
							Schema::table($tablename, fn (Blueprint $table) => $table->renameColumn($column, $backupColumn));
						}
					},
				];
			}

			$customField = null;

			$steps[] = [
				function () use ($entity, $key, $fieldType, $title, &$customField) {
					$customField = EntityCustomField::create([
						'entity_id' => $entity->id,
						'title' => $title,
						'field_name' => $key,
						'field_type' => $fieldType,
						'field_hook' => $entity->cgroup == 'form' ? 'default' : 'after-last',
						'rule_state' => 'enabled',
						'sort_order' => (int) $entity->customfields()->max('sort_order') + 1,
					]);
				},
				function () use (&$customField) {
					$customField?->delete();
				},
			];

			$steps[] = [
				fn () => $isGeolocation
					? static::assertColumnsExist($tablename, array_values($renames))
					: static::assertColumnHasType($tablename, $key, CustomFieldType::from($fieldType)->getDatabaseColumnType()),
				null,
			];

			static::runSchemaSteps($steps);
		} catch (Throwable $e) {
			static::notifyBuildFailure('The backup column could not be restored', $e);

			return false;
		}

		Notification::make()
			->title('Field "'.$title.'" restored, with its data')
			->success()
			->send();

		return true;
	}

	/**
	 * Permanently drop a backup column, or all geo_* backups of a geolocation field.
	 */
	private static function dropBackupColumn(Entity $entity, string $key): bool
	{
		try {
			$backup = static::getBackupColumns($entity)[$key]
				?? throw new InvalidArgumentException('The backup column no longer exists.');

			$tablename = static::getEntityTableName($entity);

			$steps = [];

			foreach ($backup['columns'] as $backupColumn) {
				$steps[] = [fn () => static::dropColumn($tablename, $backupColumn), null];
			}

			$steps[] = [
				function () use ($tablename, $backup) {
					foreach ($backup['columns'] as $backupColumn) {
						if (Schema::hasColumn($tablename, $backupColumn)) {
							throw new RuntimeException('Column '.$backupColumn.' was not dropped.');
						}
					}
				},
				null,
			];

			static::runSchemaSteps($steps);
		} catch (Throwable $e) {
			static::notifyBuildFailure('The backup column could not be deleted', $e);

			return false;
		}

		Notification::make()
			->title('Backup column deleted')
			->success()
			->send();

		return true;
	}

	private static function dropColumn($tablename, $column): void
	{
		if (Schema::hasColumn($tablename, $column)) {
			Schema::table($tablename, function ($table) use ($column) {
				$table->dropColumn($column);
			});
		}
	}

	private static function addColumn(string $tablename, string $fieldName, CustomFieldType $fieldType): void
	{

		$after = Schema::hasColumn($tablename, 'body') ? 'body' : 'id';

		$columnType = $fieldType->getDatabaseColumnType();
		$columnSize = static::getColumnSize($fieldType->value);

		Schema::table($tablename, function ($table) use ($fieldName, $columnType, $columnSize, $after) {

			switch ($columnType) {
				case 'varchar':
					$table->string($fieldName)
						->nullable()
						->after($after);
					break;
				case 'text':
					$table->text($fieldName)
						->nullable()
						->after($after);
					break;
				case 'int':
					$table->integer($fieldName)
						->default(0)
						->after($after);
					break;
				case 'tinyint':
					$table->boolean($fieldName)
						->default(0)
						->after($after);
					break;
				case 'json':
					$table->json($fieldName)
						->nullable()
						->after($after);
					break;
				case 'decimal':
					$table->decimal($fieldName, $columnSize->precision, $columnSize->scale)
						->default(0)
						->after($after);
					break;
				case 'date':
					$table->date($fieldName)
						->nullable()
						->after($after);
					break;
				case 'time':
					$table->time($fieldName)
						->nullable()
						->after($after);
					break;
				case 'timestamp':
					$table->timestamp($fieldName)
						->nullable()
						->after($after);
					break;
				default:
					throw new InvalidArgumentException('No column definition for the column type "'.$columnType.'".');
			}

		});

	}

	private static function getColumnSize(string $fieldType): \stdClass
	{

		$size = new \stdClass;

		$parts = explode('_', $fieldType);
		if (count($parts) == 3) {
			$size->precision = $parts[1];
			$size->scale = $parts[2];
		}

		return $size;
	}

	/**
	 * @param  list<string>  $columns
	 */
	private static function assertColumnsExist(string $tablename, array $columns): void
	{
		foreach ($columns as $column) {
			if (! Schema::hasColumn($tablename, $column)) {
				throw new RuntimeException('Column '.$column.' was not created in table '.$tablename.'.');
			}
		}
	}

	private static function assertColumnHasType(string $tablename, string $column, string $columnType): void
	{
		static::assertColumnsExist($tablename, [$column]);

		$actualType = Schema::getColumnType($tablename, $column);

		if ($actualType != $columnType) {
			throw new RuntimeException('Column '.$column.' in table '.$tablename.' has type '.$actualType.' instead of '.$columnType.'.');
		}
	}

	/**
	 * Run steps in order. Each step is [do, undo].
	 *
	 * The undo is registered before its step runs, so a step that fails halfway is undone as well.
	 * That means every undo must be safe to call when its step did nothing. When a step fails,
	 * the registered undo steps run in reverse order and the failure is rethrown.
	 *
	 * @param  list<array{0: Closure, 1: Closure|null}>  $steps
	 */
	private static function runSchemaSteps(array $steps): void
	{
		$undoSteps = [];

		try {
			foreach ($steps as [$step, $undo]) {
				if ($undo !== null) {
					array_unshift($undoSteps, $undo);
				}

				$step();
			}
		} catch (Throwable $e) {
			foreach ($undoSteps as $undo) {
				try {
					$undo();
				} catch (Throwable $undoFailure) {
					Log::error('lara builder: undo step failed', ['exception' => $undoFailure]);
				}
			}

			throw $e;
		}
	}

	/**
	 * @param  bool  $changesUndone  false when the operation was refused before anything changed
	 */
	private static function notifyBuildFailure(string $title, Throwable $e, bool $changesUndone = true): void
	{
		Log::error('lara builder: '.$title, ['exception' => $e]);

		Notification::make()
			->title($title)
			->body(e(Str::limit($e->getMessage(), 300)).($changesUndone ? '<br><br>The changes made so far have been undone.' : ''))
			->danger()
			->persistent()
			->send();
	}
}
