<?php

namespace Lara\Front\Services;

use Google\Cloud\Translate\TranslateClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lara\Admin\Enums\CustomFieldType;
use Lara\Common\Models\Blacklist;
use stdClass;

/**
 * Spam detection, blacklist checks and validation rules for front form submissions.
 *
 * Extracted from the HasFrontSecurity trait, which is now a delegating shim.
 */
final class FrontSecurityGuard
{
    /**
     * Length of a varchar custom field column, as HasLaraBuilder creates it (string() default).
     */
    private const VARCHAR_LENGTH = 255;

    /**
     * @param  list<CustomFieldType>  $fieldtypes  the custom field types to check for links and email addresses
     * @return object
     */
    public function detectSpam(object $entity, object $object, array $fieldtypes)
    {

        $data = new stdClass;

        // patch 6.2.23 - start
        $isBlackListed = false;
        if (isset($object->ipaddress)) {
            $isBlackListed = $this->isBlacklisted($object->ipaddress);
        }

        if ($isBlackListed) {

            // ip address is blacklisted
            // no further checks necessary
            $data->result = true;
            $data->message = 'too many requests ...';

        } else {
            // patch 6.2.23 - end

            $spamScore = 0;

            // check for links
            $fieldsWithLinks = $this->detectLinkInString($entity, $object, $fieldtypes);
            if ($fieldsWithLinks) {
                $spamScore = $spamScore + config('lara.forms_anti_spam.spam_score_link');
            }

            // check for email addresses
            $fieldsWithEmails = $this->detectEmailInString($entity, $object, $fieldtypes);
            if ($fieldsWithEmails) {
                $spamScore = $spamScore + config('lara.forms_anti_spam.spam_score_email');
            }

            // detect language
            $matchLang = $this->matchLanguage($entity, $object);
            if (! $matchLang) {
                $spamScore = $spamScore + config('lara.forms_anti_spam.spam_score_language');
            }

            // check total score
            if ($spamScore >= config('lara.forms_anti_spam.threshold')) {
                $data->result = true;
                $data->message = 'spam detected';

                $this->markFieldsAsSpam($entity, $object, array_values(array_unique([...$fieldsWithLinks, ...$fieldsWithEmails])));

                // patch 6.2.23 - start
                $this->addToBlacklist($object->ipaddress);
                // patch 6.2.23 - end

            } else {
                $data->result = false;
                $data->message = 'passed';
            }
        }

        return $data;

    }

    /*
     * part of patch 6.2.23
     */
    private function addToBlacklist($ipaddress)
    {

        return Blacklist::create(['ipaddress' => $ipaddress]);

    }

    /*
     * part of patch 6.2.23
     */
    private function isBlacklisted($ipaddress)
    {

        // an entry expires, so a false positive or a reassigned IP address is not blocked forever
        $blackListCheck = Blacklist::where('ipaddress', $ipaddress)
            ->where('created_at', '>=', now()->subHours(config('lara.forms_anti_spam.blacklist_hours', 24)))
            ->first();

        if ($blackListCheck) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Prefixes the fields that made a submission spam, so the soft-deleted record shows why.
     * A varchar value is cut to the column length, so the prefix cannot make the save fail.
     *
     * @param  list<string>  $fieldnames
     */
    private function markFieldsAsSpam(object $entity, object $object, array $fieldnames): void
    {
        if ($fieldnames === []) {
            return;
        }

        foreach ($entity->getCustomColumns() as $field) {
            $fieldname = $field->field_name;
            if (! in_array($fieldname, $fieldnames, true)) {
                continue;
            }

            $value = '[SPAM] - '.$object->$fieldname;
            if (CustomFieldType::tryFrom($field->field_type)?->getDatabaseColumnType() === 'varchar') {
                $value = mb_substr($value, 0, self::VARCHAR_LENGTH);
            }
            $object->$fieldname = $value;
        }

        $object->save();
    }

    /**
     * @param  list<CustomFieldType>  $fieldtypes
     * @return list<string> the fields that contain an email address
     */
    private function detectEmailInString(object $entity, object $object, array $fieldtypes): array
    {
        // This regular expression extracts all emails from a string:
        $regexp = '/([a-z0-9_\.\-])+(\@|\[at\])+(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';

        $fieldnames = [];

        foreach ($entity->getCustomColumns() as $field) {
            if (in_array(CustomFieldType::tryFrom($field->field_type), $fieldtypes, true)) {
                $fieldname = $field->field_name;
                if (preg_match($regexp, (string) $object->$fieldname)) {
                    $fieldnames[] = $fieldname;
                }
            }
        }

        return $fieldnames;

    }

    /**
     * @param  list<CustomFieldType>  $fieldtypes
     * @return list<string> the fields that contain a link
     */
    private function detectLinkInString(object $entity, object $object, array $fieldtypes): array
    {

        $patterns = config('lara.detect_link_patterns', []);

        $fieldnames = [];

        foreach ($entity->getCustomColumns() as $field) {
            if (in_array(CustomFieldType::tryFrom($field->field_type), $fieldtypes, true)) {
                $fieldname = $field->field_name;
                if (Str::contains((string) $object->$fieldname, $patterns)) {
                    $fieldnames[] = $fieldname;
                }
            }
        }

        return $fieldnames;
    }

    private function matchLanguage(object $entity, $object): bool
    {

        $matchLang = true;

        if (config('lara.detect_language.enabled')) {

            if (config('lara.google_translate_api_key')) {

                $translate = new TranslateClient([
                    'key' => config('lara.google_translate_api_key'),
                ]);

                $allowedLanguages = config('lara.detect_language.languages_allowed');
                $detectFields = config('lara.detect_language.entity_fields');
                $wordThresholdMin = config('lara.detect_language.wordcount_threshold_min');
                $wordThresholdMax = config('lara.detect_language.wordcount_threshold_max');

                if (array_key_exists($entity->getResourceSlug(), $detectFields)) {

                    $entkey = $entity->getResourceSlug();
                    $detectEntityFields = $detectFields[$entkey];

                    foreach ($entity->getCustomColumns() as $field) {
                        if (in_array($field->field_name, $detectEntityFields)) {
                            $fieldname = $field->field_name;
                            $fieldval = $object->$fieldname;
                            if (str_word_count($fieldval) > $wordThresholdMin) {
                                if (str_word_count($fieldval) < $wordThresholdMax) {
                                    $result = $translate->detectLanguage($fieldval);
                                    if (! in_array($result['languageCode'], $allowedLanguages)) {
                                        // detected language is not allowed, mark as spam
                                        $matchLang = false;
                                    }
                                } else {
                                    // too many words, mark as spam
                                    $matchLang = false;
                                }

                            }
                        }
                    }
                }
            }
        }

        return $matchLang;

    }

    /**
     * An HTML checkbox posts "on" when ticked (unless it has a value attribute). Checkbox and
     * toggle fields are stored as 0/1, so "on", "yes" and "true" become 1 before validation.
     */
    public function normalizeFormInput(object $entity, Request $request): void
    {
        foreach ($entity->getCustomColumns() as $field) {
            $fieldType = CustomFieldType::tryFrom($field->field_type);
            $value = $request->input($field->field_name);

            if (in_array($fieldType, [CustomFieldType::Checkbox, CustomFieldType::Toggle], true)
                && is_string($value) && in_array(strtolower($value), ['on', 'yes', 'true'], true)) {
                $request->merge([$field->field_name => 1]);
            }
        }
    }

    /**
     * The validation rules for a form submission, keyed by field name.
     *
     * @return array<string, list<string>>
     */
    public function getValidationRules(object $entity): array
    {

        $validationRules = [];

        // the DNS check needs a network lookup: production only, like reCAPTCHA
        $emailRule = config('app.env') == 'production' ? 'email:rfc,dns' : 'email:rfc';

        foreach ($entity->getCustomColumns() as $field) {

            $fieldType = CustomFieldType::tryFrom($field->field_type);

            $rules = [$field->is_required ? 'required' : 'nullable'];

            // a value of the wrong type is rejected (422) instead of failing on its typed column (500)
            // and so is a value its column cannot hold (too long, out of range)
            $typeRules = match ($fieldType?->getDatabaseColumnType()) {
                'varchar' => ['string', 'max:'.self::VARCHAR_LENGTH],
                'text' => ['string'],
                'int' => ['integer', 'between:-2147483648,2147483647'],
                'decimal' => ['numeric'],
                'tinyint' => ['boolean'],
                'date', 'timestamp' => ['date'],
                'time' => ['date_format:H:i,H:i:s'],
                'json' => ['array'],
                default => [],
            };
            $rules = [...$rules, ...$typeRules];

            if ($fieldType === CustomFieldType::Email) {
                $rules[] = $emailRule;
            }

            $validationRules[$field->field_name] = $rules;
        }

        return $validationRules;

    }
}
