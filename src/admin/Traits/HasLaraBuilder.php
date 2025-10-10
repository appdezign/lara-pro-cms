<?php

namespace Lara\Admin\Traits;

use Binafy\LaravelStub\Facades\LaravelStub;
use Filament\Notifications\Notification;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Lara\Admin\Enums\CustomFieldType;
use Lara\Common\Models\Entity;
use Lara\Common\Models\EntityCustomField;

trait HasLaraBuilder
{

	private static function createEntity(Entity $entity): void
	{

		$isForm = $entity->cgroup == 'form';

		$modelVarSingle = $entity->label_single;
		$modelVarPlural = Str::plural($modelVarSingle);
		$modelNameSingle = ucfirst($modelVarSingle);
		$modelNamePlural = ucfirst($modelVarPlural);

		// resource
		$resourceName = $modelNameSingle . 'Resource';
		$resourceDir = ucfirst($modelVarPlural);

		// policy
		$policyName = $modelNameSingle . 'Policy';

		// update entity
		$entity->title = $modelNamePlural;
		$entity->resource_slug = $modelVarPlural;
		$entity->resource = 'Lara\\App\\Filament\\Resources\\' . $resourceDir . '\\' . $resourceName;
		$entity->model_class = 'Lara\\App\\Models\\' . $modelNameSingle;
		$entity->controller = $modelNamePlural . 'Controller';
		$entity->policy = 'Lara\\App\\Policies\\' . $modelNameSingle . 'Policy';
		$entity->save();

		// table
		$entityPrefixes = config('lara-common.database.entity');

		$entityPrefix = $entityPrefixes[$entity->cgroup . '_prefix'];
		$tablename = $entityPrefix . $modelVarPlural;

		// stubs - paths
		$fromPath = base_path('laracms/core/src/admin/Stubs/');
		$toPath = base_path('laracms/app/');
		$resourcesPath = base_path('laracms/app/Filament/Resources/');

		// make directories for resource pages
		$resourceDirPath = $resourcesPath . DIRECTORY_SEPARATOR . $resourceDir;
		if (!File::isDirectory($resourceDirPath)) {
			File::makeDirectory($resourceDirPath);
		}
		$resourcePagesPath = $resourceDirPath . DIRECTORY_SEPARATOR . 'Pages';
		if (!File::isDirectory($resourcePagesPath)) {
			File::makeDirectory($resourcePagesPath);
		}

		// stub - model
		LaravelStub::from($fromPath . 'model.stub')
			->to($toPath . 'Models')
			->name($modelNameSingle)
			->ext('php')
			->replaces([
				'NAMESPACE' => 'Lara\App\Models',
				'CLASS'     => $modelNameSingle,
				'MODEL'     => $modelNameSingle,
				'TABLE'     => $tablename,
			])
			->generate();

		// stub - resource
		$resourceStub = ($isForm) ? 'formresource.stub' : 'resource.stub';
		LaravelStub::from($fromPath . $resourceStub)
			->to($resourceDirPath)
			->name($resourceName)
			->ext('php')
			->replaces([
				'NAMESPACE' => 'Lara\App\Filament\Resources\\' . $resourceDir,
				'RESOURCE'  => $resourceName,
				'MODEL'     => $modelNameSingle,
			])
			->generate();

		// stub - policy
		LaravelStub::from($fromPath . 'policy.stub')
			->to($toPath . 'Policies')
			->name($policyName)
			->ext('php')
			->replaces([
				'NAMESPACE'     => 'Lara\App\Policies',
				'MODEL'         => $modelNameSingle,
				'MODELVARIABLE' => $modelVarSingle,
				'RESOURCE'      => $resourceName,
			])
			->generate();

		// pages namespace
		$pagesNamespace = 'Lara\App\Filament\Resources\\' . $resourceDir . '\Pages';

		// stub - create record page
		if (!$isForm) {
			LaravelStub::from($fromPath . 'createrecord.stub')
				->to($resourcePagesPath)
				->name('CreateRecord')
				->ext('php')
				->replaces([
					'NAMESPACE'   => $pagesNamespace,
					'CLASS'       => 'CreateRecord',
					'RESOURCE'    => $resourceName,
					'RESOURCEDIR' => $resourceDir,
				])
				->generate();

			// stub - edit record page
			LaravelStub::from($fromPath . 'editrecord.stub')
				->to($resourcePagesPath)
				->name('EditRecord')
				->ext('php')
				->replaces([
					'NAMESPACE'   => $pagesNamespace,
					'CLASS'       => 'EditRecord',
					'RESOURCE'    => $resourceName,
					'RESOURCEDIR' => $resourceDir,
				])
				->generate();

			// stub - reorder records page
			LaravelStub::from($fromPath . 'reorderrecords.stub')
				->to($resourcePagesPath)
				->name('ReorderRecords')
				->ext('php')
				->replaces([
					'NAMESPACE'   => $pagesNamespace,
					'CLASS'       => 'ReorderRecords',
					'RESOURCE'    => $resourceName,
					'RESOURCEDIR' => $resourceDir,
				])
				->generate();

		}

		// stub - list records page
		LaravelStub::from($fromPath . 'listrecords.stub')
			->to($resourcePagesPath)
			->name('ListRecords')
			->ext('php')
			->replaces([
				'NAMESPACE'   => $pagesNamespace,
				'CLASS'       => 'ListRecords',
				'RESOURCE'    => $resourceName,
				'RESOURCEDIR' => $resourceDir,
			])
			->generate();

		// stub - view record page
		LaravelStub::from($fromPath . 'viewrecord.stub')
			->to($resourcePagesPath)
			->name('ViewRecord')
			->ext('php')
			->replaces([
				'NAMESPACE'   => $pagesNamespace,
				'CLASS'       => 'ViewRecord',
				'RESOURCE'    => $resourceName,
				'RESOURCEDIR' => $resourceDir,
			])
			->generate();

	}

	private static function checkDatabaseTable(Entity $entity): void
	{

		$modelClass = $entity->model_class;
		$model = new $modelClass;
		$tablename = $model->getTable();
		$isForm = $entity->cgroup == 'form';

		$tablenames = config('lara-common.database');

		if ($isForm) {

			if (!Schema::hasTable($tablename)) {
				Schema::create($tablename, function (Blueprint $table) {

					// ID
					$table->bigIncrements('id');

					// Timestamps
					$table->timestamps();
					$table->timestamp('deleted_at')->nullable();

				});
			}

		} else {

			if (!Schema::hasTable($tablename)) {
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

					$table->integer('position')->unsigned()->nullable();
					$table->string('cgroup')->nullable();

				});
			}
		}

	}

	private static function checkExtraDatabaseColumns(Entity $entity): void
	{

		$extraFieldCount = $entity->col_extra_body_fields;

		if ($extraFieldCount > 0) {

			// check table first
			static::checkDatabaseTable($entity);

			// check custom columns
			$modelClass = $entity->model_class;
			$tablename = $modelClass::getTableName();

			if (Schema::hasColumn($tablename, 'body')) {
				$after = 'body';
			} else {
				$after = 'id';
			}

			for ($i = 1; $i <= $extraFieldCount; $i++) {
				$fieldName = 'body' . $i + 1;
				if (!Schema::hasColumn($tablename, $fieldName)) {
					Schema::table($tablename, function ($table) use ($fieldName, $after) {
						$table->text($fieldName)
							->nullable()
							->after($after);

					});
					Notification::make()
						->title('New column created: ' . $fieldName)
						->success()
						->send();
				}
			}
		}
	}

	private static function checkCustomDatabaseColumns(Entity $entity): void
	{

		// check table first
		static::checkDatabaseTable($entity);

		// check custom columns
		$customFields = $entity->customFields;
		foreach ($customFields as $customField) {
			static::checkCustomDatabaseColumn($customField);
		}

	}

	private static function checkCustomDatabaseColumn(EntityCustomField $customField): void
	{

		$modelClass = $customField->entity->model_class;
		$tablename = $modelClass::getTableName();

		$fieldName = $customField->field_name;
		$newFieldName = $customField->field_name_temp;
		$fieldType = CustomFieldType::from($customField->field_type);
		$columnType = $fieldType->getDatabaseColumnType();

		if ($fieldType->value == 'geolocation') {

			static::checkGeoLocationColumns($modelClass, $tablename);

		} else {
			if ($newFieldName) {

				// rename current column, so we don't lose any data
				static::dropCustomColumn($customField);

				$customField->field_name = $customField->field_name_temp;
				$customField->field_name_temp = null;
				$customField->save();

				// create new column
				static::addCustomColumn($customField);

			} else {

				if (!Schema::hasColumn($tablename, $fieldName)) {

					// create new column
					static::addCustomColumn($customField);

				} else {

					// check current column type
					$databaseColumnType = Schema::getColumnType($tablename, $fieldName);

					if ($databaseColumnType != $columnType) {

						// rename current column, so we don't lose any data
						static::dropCustomColumn($customField);
						// create new column
						static::addCustomColumn($customField);

					}

				}

			}

			if($columnType == 'json') {
				$object = new $modelClass;
				if(!key_exists($fieldName, $object->getCasts())) {
					Notification::make()
						->title('Cast missing !')
						->body('Cast array for ' . $fieldName . ' not found in model: ' . $modelClass . '<br><br>Make sure you add the appropriate cast to your model.')
						->seconds(30)
						->danger()
						->send();
				}
			}
		}

	}

	private static function dropCustomColumn(EntityCustomField $customField): void
	{

		$modelClass = $customField->entity->model_class;
		$tablename = $modelClass::getTableName();

		if ($customField->field_type == 'geolocation') {

			// delete old backup columns
			static::dropColumn($tablename, '_geo_address');
			static::dropColumn($tablename, '_geo_pcode');
			static::dropColumn($tablename, '_geo_city');
			static::dropColumn($tablename, '_geo_country');
			static::dropColumn($tablename, '_geo_location');
			static::dropColumn($tablename, '_geo_latitude');
			static::dropColumn($tablename, '_geo_longitude');

			// rename current column, so we don't lose data
			Schema::table($tablename, function ($table) {
				$table->renameColumn('geo_address', '_geo_address');
				$table->renameColumn('geo_pcode', '_geo_pcode');
				$table->renameColumn('geo_city', '_geo_city');
				$table->renameColumn('geo_country', '_geo_country');
				$table->renameColumn('geo_location', '_geo_location');
				$table->renameColumn('geo_latitude', '_geo_latitude');
				$table->renameColumn('geo_longitude', '_geo_longitude');
			});

			Notification::make()
				->title('Please remove geo columns manually!')
				->warning()
				->send();

		} else {

			$fieldName = $customField->field_name;
			$backupColumn = '_' . $fieldName;

			// delete old backup column
			static::dropColumn($tablename, $backupColumn);

			// rename current column, so we don't lose data
			Schema::table($tablename, function ($table) use ($fieldName, $backupColumn) {
				$table->renameColumn($fieldName, $backupColumn);
			});

			Notification::make()
				->title('Please remove column ' . $backupColumn . ' manually!')
				->warning()
				->send();
		}

	}

	private static function dropColumn($tablename, $column): void
	{
		if (Schema::hasColumn($tablename, $column)) {
			Schema::table($tablename, function ($table) use ($column) {
				$table->dropColumn($column);
			});
		}
	}

	private static function addCustomColumn(EntityCustomField $customField, string $after = null): string
	{

		$entity = $customField->entity;
		$modelClass = $entity->model_class;
		$tablename = $modelClass::getTableName();

		if (empty($after)) {
			if (Schema::hasColumn($tablename, 'body')) {
				$after = 'body';
			} else {
				$after = 'id';
			}
		}

		$fieldName = $customField->field_name;
		$fieldType = CustomFieldType::from($customField->field_type);
		$columnType = $fieldType->getDatabaseColumnType();
		$columnSize = static::getColumnSize($customField->field_type);

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
					//

			}

		});

		Notification::make()
			->title('New column created: ' . $fieldName)
			->success()
			->send();

		return $fieldName;

	}

	private static function getColumnSize(string $fieldType): \stdClass
	{

		$size = new \stdClass();

		$parts = explode('_', $fieldType);
		if (sizeof($parts) == 3) {
			$size->precision = $parts[1];
			$size->scale = $parts[2];
		}

		return $size;
	}

	private static function checkGeoLocationColumns($modelClass, $tablename): void
	{

		$after = 'body';

		if (!Schema::hasColumn($tablename, 'geo_address')) {
			Schema::table($tablename, function ($table) use ($after) {
				$table->string('geo_address')
					->nullable()
					->after($after);
			});
		}

		if (!Schema::hasColumn($tablename, 'geo_pcode')) {
			Schema::table($tablename, function ($table) use ($after) {
				$table->string('geo_pcode')
					->nullable()
					->after($after);
			});
		}

		if (!Schema::hasColumn($tablename, 'geo_city')) {
			Schema::table($tablename, function ($table) use ($after) {
				$table->string('geo_city')
					->nullable()
					->after($after);
			});
		}

		if (!Schema::hasColumn($tablename, 'geo_country')) {
			Schema::table($tablename, function ($table) use ($after) {
				$table->string('geo_country')
					->nullable()
					->after($after);
			});
		}

		if (!Schema::hasColumn($tablename, 'geo_location')) {
			Schema::table($tablename, function ($table) use ($after) {
				$table->string('geo_location')
					->nullable()
					->after($after);
			});
		}

		if (!Schema::hasColumn($tablename, 'geo_latitude')) {
			Schema::table($tablename, function ($table) use ($after) {
				$table->decimal('geo_latitude', 10, 8)
					->nullable()
					->after($after);
			});
		}

		if (!Schema::hasColumn($tablename, 'geo_longitude')) {
			Schema::table($tablename, function ($table) use ($after) {
				$table->decimal('geo_longitude', 11, 8)
					->nullable()
					->after($after);
			});
		}

	}

}
