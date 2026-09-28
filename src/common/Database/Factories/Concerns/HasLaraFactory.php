<?php

namespace Lara\Common\Database\Factories\Concerns;

use Carbon\Carbon;
use Closure;
use Exception;
use Lara\Common\Models\Entity;
use Lara\Common\Models\EntityCustomField;
use Lara\Common\Models\User;

trait HasLaraFactory
{
    /**
     * Custom fields that must never get a random value, per resource.
     * A random 'ishome' would create multiple homepages, a random 'menuroute' would break routing.
     *
     * @var array<string, array<string, mixed>>
     */
    private array $fixedFieldValues = [
        'pages' => [
            'ishome' => 0,
            'menuroute' => null,
        ],
    ];

    /**
     * @throws Exception
     */
    private function generateContent($resourceSlug): array
    {

        // get locale
        $locale = config('app.locale');

        // get admin id
        $adminId = $this->getAdminId();
        if (empty($adminId)) {
            throw new Exception('No admin user found');
        }

        // get resource
        $entity = $this->getEntityByResourceSlug($resourceSlug);
        if (empty($entity)) {
            throw new Exception('No resource entity found');
        }

        $content = [
            'user_id' => $adminId,
            'language' => $locale,
            'title' => $this->faker->sentence(5),
            'publish' => 1,
            'publish_from' => Carbon::now(),
        ];

        // lead
        if ($entity->col_has_lead) {
            $content['lead'] = $this->faker->paragraph(1);
        }

        // body
        if ($entity->col_has_body) {
            $content['body'] = $this->faker->paragraph(4);
        }

        // add custom fields
        foreach ($entity->customfields as $customfield) {

            if ($customfield->field_type == 'geolocation') {
                $content = array_merge($content, $this->generateGeolocation());

                continue;
            }

            $content[$customfield->field_name] = $this->generateCustomFieldValue($customfield);

        }

        $content = array_merge($content, $this->fixedFieldValues[$resourceSlug] ?? []);

        $content = $this->alignDateRanges($content);

        // relations
        foreach ($entity->relations as $relation) {
            if ($relation->type == 'belongsTo') {
                $relatedEntity = Entity::find($relation->related_entity_id);
                $content[$relation->foreign_key] = $this->resolveRelatedObject($relatedEntity->model_class, $locale);
            }
        }

        return $content;
    }

    private function generateCustomFieldValue(EntityCustomField $customfield): mixed
    {
        $options = $this->getFieldOptions($customfield);

        return match ($customfield->field_type) {
            'text', 'textarea', 'richeditor', 'richeditormin' => $this->faker->paragraph(1),
            'string' => $this->faker->sentence(3),
            'email' => $this->faker->email(),
            'number' => $this->faker->randomNumber(3, false),
            'date' => $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'time' => $this->faker->time(),
            'datetime' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'toggle', 'checkbox' => (int) $this->faker->boolean(),
            'colorpicker' => $this->faker->hexColor(),
            'decimal_10_1' => $this->faker->randomFloat(1, 0, 1000),
            'decimal_14_2' => $this->faker->randomFloat(2, 0, 1000),
            'decimal_16_4' => $this->faker->randomFloat(4, 0, 1000),
            'latitude_10_8' => $this->faker->latitude(),
            'longitude_11_8' => $this->faker->longitude(),
            'select', 'togglebuttons', 'radio' => empty($options) ? null : $this->faker->randomElement($options),
            'multiselect', 'multitogglebuttons', 'checkboxlist' => empty($options)
                ? null
                : $this->asJsonValue($customfield->field_name, $this->faker->randomElements($options, $this->faker->numberBetween(1, count($options)))),
            'tagsinput' => $this->asJsonValue($customfield->field_name, $this->faker->words(3)),
            default => null,
        };
    }

    /**
     * Resolve the option values a select-like field offers.
     * Dynamic options ('get_...') are resolved the way the admin form does, if they do not depend on the record.
     *
     * @return list<string>
     */
    private function getFieldOptions(EntityCustomField $customfield): array
    {
        $options = $customfield->field_options ?? [];

        if (empty($options) || ! str_starts_with($options[0], 'get_')) {
            return array_values($options);
        }

        if ($options[0] == 'get_entity_resources') {
            return Entity::where('cgroup', 'entity')->pluck('resource_slug')->all();
        }

        return [];
    }

    /**
     * Multi-value fields live in json columns. Models that cast the column encode the array themselves.
     */
    private function asJsonValue(string $fieldName, array $values): array|string
    {
        if ($this->newModel()->hasCast($fieldName, ['array', 'json', 'collection', 'object'])) {
            return $values;
        }

        return json_encode($values);
    }

    /**
     * The geolocation field is not a column itself, but a set of geo_* columns.
     *
     * @return array<string, mixed>
     */
    private function generateGeolocation(): array
    {
        return [
            'geo_address' => $this->faker->streetAddress(),
            'geo_pcode' => $this->faker->postcode(),
            'geo_city' => $this->faker->city(),
            'geo_country' => $this->faker->country(),
            'geo_location' => 'manual',
            'geo_latitude' => $this->faker->latitude(),
            'geo_longitude' => $this->faker->longitude(),
        ];
    }

    /**
     * Make sure every end* field is not before its start* counterpart (startdate/enddate, starttime/endtime).
     *
     * @param  array<string, mixed>  $content
     * @return array<string, mixed>
     */
    private function alignDateRanges(array $content): array
    {
        foreach ($content as $field => $startValue) {

            if (! str_starts_with($field, 'start')) {
                continue;
            }

            $endField = 'end'.substr($field, strlen('start'));

            if (isset($startValue, $content[$endField]) && $content[$endField] < $startValue) {
                $content[$field] = $content[$endField];
                $content[$endField] = $startValue;
            }
        }

        return $content;
    }

    /**
     * Deferred, so nothing is created when the foreign key is overridden, or set with for().
     * Prefers recycled models, then an existing record in the same language, and only then creates one.
     */
    private function resolveRelatedObject(string $relatedModelClass, string $locale): Closure
    {
        return function () use ($relatedModelClass, $locale) {

            $recycledId = $this->getRandomRecycledModel($relatedModelClass)?->getKey();
            if ($recycledId) {
                return $recycledId;
            }

            $existingId = $relatedModelClass::where('language', $locale)->inRandomOrder()->value('id');
            if ($existingId) {
                return $existingId;
            }

            return $relatedModelClass::factory();
        };
    }

    private function getAdminId(): ?int
    {

        $userId = User::role('superadmin')->value('id');
        if (empty($userId)) {
            $userId = User::role('admin')->value('id');
            if (empty($userId)) {
                $userId = null;
            }
        }

        return $userId;
    }

    private function getEntityByResourceSlug($resourceSlug): ?Entity
    {
        return Entity::where('resource_slug', $resourceSlug)->first();
    }
}
