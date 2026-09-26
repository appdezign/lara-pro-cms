<?php

namespace Lara\Common\Entities;

/**
 * Rules for the name of a custom field, which HasLaraBuilder turns into a column.
 *
 * Without them a field named "title" or "body" would be mapped onto a base
 * column, and a type change on it would rename that base column away. Both the
 * admin form validation and the generator's own guard call this, so there is a
 * single definition of what is acceptable.
 */
final class EntityFieldName
{
	/**
	 * Columns every content table already has (see HasLaraBuilder::checkDatabaseTable).
	 *
	 * @var list<string>
	 */
	public const RESERVED = [
		'id', 'user_id', 'language', 'language_parent', 'title', 'slug', 'slug_lock',
		'lead', 'body', 'created_at', 'updated_at', 'deleted_at',
		'publish', 'publish_from', 'publish_expire', 'publish_to', 'publish_hide',
		'position', 'cgroup', 'locked_at', 'locked_by',
	];

	/**
	 * Lowercase letters, digits and underscores, starting with a letter.
	 * A leading underscore is what the builder uses for backup columns.
	 */
	public const PATTERN = '/^[a-z][a-z0-9_]*$/';

	/**
	 * MySQL allows 64 characters, and the backup column adds a leading underscore.
	 */
	public const MAX_LENGTH = 63;

	/**
	 * Why this field name cannot be used, or null when it is acceptable.
	 */
	public static function reject(string $fieldName): ?string
	{
		if (preg_match(self::PATTERN, $fieldName) !== 1) {
			return 'Use lowercase letters, digits and underscores, starting with a letter.';
		}

		if (strlen($fieldName) > self::MAX_LENGTH) {
			return 'Use at most '.self::MAX_LENGTH.' characters.';
		}

		if (in_array($fieldName, self::RESERVED, true)
			|| preg_match('/^body\d+$/', $fieldName) === 1
			|| str_starts_with($fieldName, 'geo_')) {
			return '"'.$fieldName.'" is a standard column of every content table.';
		}

		return null;
	}
}
