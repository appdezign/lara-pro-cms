<?php

namespace Lara\Common\Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Lara\Common\Database\Factories\Concerns\HasLaraFactory;
use Lara\Common\Models\Page;

class PageFactory extends Factory
{
    protected ?string $resourceSlug = 'pages';

    use HasLaraFactory;

    protected $model = Page::class;

    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return $this->generateContent($this->resourceSlug);
    }
}
