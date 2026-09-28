<?php

namespace Lara\Common\Entities;

/**
 * Rules for the entity label the code generator derives names from.
 *
 * `label_single` is not just a label: HasLaraBuilder turns it into the model,
 * resource, policy and controller class names, and its plural into the resource
 * slug and the database table name. A label that is not a bare lowercase
 * identifier produces PHP files that cannot be parsed.
 *
 * Both the admin form validation and the generator's own guard call this, so
 * there is a single definition of what is acceptable.
 */
final class EntityLabel
{
    /**
     * Valid identifiers that still cannot be used, because ucfirst()-ing them
     * yields a reserved PHP word.
     *
     * @var list<string>
     */
    public const RESERVED = [
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
     * One lowercase word of letters and digits, starting with a letter.
     *
     * Lowercase matters: the generator ucfirst()s this for the class names and
     * pluralises it for the resource slug and table name, so a capital would
     * produce "Products" and "lara_content_Products".
     */
    public const PATTERN = '/^[a-z][a-z0-9]*$/';

    public static function isValid(string $label): bool
    {
        return self::reject($label) === null;
    }

    /**
     * Why this label cannot be used, or null when it is acceptable.
     */
    public static function reject(string $label): ?string
    {
        if (preg_match(self::PATTERN, $label) !== 1) {
            return 'Use one lowercase word of letters and digits, starting with a letter.';
        }

        if (in_array($label, self::RESERVED, true)) {
            return '"'.$label.'" is a reserved PHP word and cannot be used as a class name.';
        }

        return null;
    }
}
