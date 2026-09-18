<?php

namespace Lara\Admin\Resources\Entities\Concerns;

use Closure;
use Illuminate\Support\Str;
use Lara\Common\Models\Entity;

/**
 * Validation for the entity label the code generator turns into class names.
 *
 * `label_single` is not just a label: HasLaraBuilder derives the model, resource,
 * policy and controller class names from it, and the resource slug and database
 * table name from its plural. Anything that is not a bare PHP identifier produces
 * an unloadable class file on disk.
 */
trait HasEntityLabelValidation
{

	/**
	 * Words that are valid identifiers but cannot be used as a class name.
	 *
	 * @var list<string>
	 */
	private const RESERVED_CLASS_NAMES = [
		'abstract', 'and', 'array', 'as', 'bool', 'break', 'callable', 'case', 'catch',
		'class', 'clone', 'const', 'continue', 'declare', 'default', 'do', 'echo', 'else',
		'elseif', 'empty', 'enddeclare', 'endfor', 'endforeach', 'endif', 'endswitch',
		'endwhile', 'enum', 'eval', 'exit', 'extends', 'false', 'final', 'finally', 'float',
		'fn', 'for', 'foreach', 'function', 'global', 'goto', 'if', 'implements', 'include',
		'include_once', 'instanceof', 'insteadof', 'int', 'interface', 'isset', 'iterable',
		'list', 'match', 'mixed', 'namespace', 'never', 'new', 'null', 'object', 'or',
		'print', 'private', 'protected', 'public', 'readonly', 'require', 'require_once',
		'return', 'self', 'static', 'string', 'switch', 'throw', 'trait', 'true', 'try',
		'unset', 'use', 'var', 'void', 'while', 'xor', 'yield',
	];

	/**
	 * Validation rules for the `label_single` field.
	 *
	 * @return array<int, string|Closure>
	 */
	private static function getEntityLabelRules(): array
	{
		return [
			'regex:/^[A-Za-z][A-Za-z0-9]*$/',
			static function (string $attribute, mixed $value, Closure $fail): void {

				$label = is_string($value) ? $value : '';

				if ($label === '') {
					return;
				}

				if (in_array(strtolower($label), self::RESERVED_CLASS_NAMES, true)) {
					$fail('":input" is a reserved PHP word and cannot be used as a class name.');

					return;
				}

				$resourceSlug = Str::plural(lcfirst($label));

				if (Entity::where('resource_slug', $resourceSlug)->exists()) {
					$fail('An entity with the resource slug "' . $resourceSlug . '" already exists.');

					return;
				}

				if (class_exists('Lara\\App\\Models\\' . ucfirst($label))) {
					$fail('A model class for ":input" already exists. Generating it again would overwrite it.');
				}

			},
		];
	}

	/**
	 * Helper text explaining what the label is used for.
	 */
	private static function getEntityLabelHelperText(): string
	{
		return 'Becomes the model, resource and controller class name, and (pluralised) the '
			. 'resource slug and table name. Letters and digits only, starting with a letter '
			. '- for example "Product", not "Product page".';
	}

}
