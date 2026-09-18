<?php

namespace Lara\Admin\Resources\Entities\Concerns;

use Closure;
use Illuminate\Support\Str;
use Lara\Common\Entities\EntityLabel;
use Lara\Common\Models\Entity;

/**
 * Validation for the entity label the code generator turns into class names.
 *
 * The naming rules themselves live in EntityLabel, which HasLaraBuilder also
 * enforces. This adds the checks that only make sense in the form: whether the
 * derived slug or model class is already taken.
 */
trait HasEntityLabelValidation
{

	/**
	 * Validation rules for the `label_single` field.
	 *
	 * The rule is wrapped in an outer closure on purpose. Filament evaluates
	 * any closure passed to ->rules() as one of its own closures, injecting the
	 * parameters by name - it would try to resolve $attribute and fail with
	 * "[$attribute] was unresolvable". Returning the validation closure from a
	 * parameterless closure gives Filament something it can evaluate, and the
	 * Laravel rule comes back out intact.
	 *
	 * @return array<int, Closure>
	 */
	private static function getEntityLabelRules(): array
	{
		return [
			static fn(): Closure => static::validateEntityLabel(...),
		];
	}

	/**
	 * These rules only apply when creating an entity.
	 *
	 * The label is what the generator derives every class name from, so it is
	 * fixed once the code has been written: the field is disabled on edit and
	 * the value cannot change. Validating it there anyway does no good and
	 * actively breaks editing, because the entity's own resource slug and model
	 * class now exist - the uniqueness checks match the record being edited and
	 * reject its unchanged value.
	 *
	 * It also protects entities created before these rules existed, whose label
	 * may not satisfy the current naming pattern, from becoming uneditable.
	 */
	private static function getEntityLabelRuleCondition(): Closure
	{
		return static fn(string $operation): bool => $operation === 'create';
	}

	/**
	 * Laravel closure validation rule for the entity label.
	 */
	private static function validateEntityLabel(string $attribute, mixed $value, Closure $fail): void
	{
		$label = is_string($value) ? $value : '';

		if ($label === '') {
			return;
		}

		$rejection = EntityLabel::reject($label);

		if ($rejection !== null) {
			$fail($rejection);

			return;
		}

		$resourceSlug = Str::plural($label);

		if (Entity::where('resource_slug', $resourceSlug)->exists()) {
			$fail('An entity with the resource slug "' . $resourceSlug . '" already exists.');

			return;
		}

		if (class_exists('Lara\\App\\Models\\' . ucfirst($label))) {
			$fail('A model class for "' . ucfirst($label) . '" already exists. Generating it again would overwrite it.');
		}
	}

	/**
	 * Helper text explaining what the label is used for.
	 *
	 * Only shown while creating. The text is guidance for choosing a label, and
	 * on edit the field is disabled and the value can no longer change, so it
	 * would just be noise. Returning null renders no helper text at all.
	 */
	private static function getEntityLabelHelperText(): Closure
	{
		return static fn(string $operation): ?string => $operation === 'create'
			? 'Becomes the model, resource and controller class name, and (pluralised) the '
				. 'resource slug and table name. One lowercase word, letters and digits only '
				. '- for example "product", not "Product" or "product page".'
			: null;
	}

}
