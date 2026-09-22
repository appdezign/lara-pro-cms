<?php

namespace Lara\Common\Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

use Lara\Common\Models\Page;
use Lara\Common\Models\User;

use Carbon\Carbon;

/**
 * @extends Factory<Model>
 */
#[UseModel(Page::class)]
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

	    $superAdminId = User::role('superadmin')->value('id');
		$locale = config('app.locale');

        return [
	        'user_id' =>  $superAdminId,
	        'language' =>  $locale,
	        'title' =>  $this->faker->sentence(5),
	        'body' =>  $this->faker->paragraph(2),
	        'body' =>  $this->faker->paragraph(2),
	        'ishome' =>  0,
	        'template' =>  'standard',
	        'publish' =>  1,
	        'publish_from' =>  Carbon::now(),
	        'cgroup' =>  'page',
        ];
    }
}
