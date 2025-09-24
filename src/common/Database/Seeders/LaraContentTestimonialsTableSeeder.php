<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraContentTestimonialsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_content_testimonials')->delete();
        
        \DB::table('lara_content_testimonials')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Darrell Steward',
                'slug' => 'darrell-steward',
                'slug_lock' => 0,
                'lead' => '<p>Dolor, a eget elementum, integer nulla volutpat, nunc, sit. Quam iaculis varius mauris magna sem. Egestas sed sed suscipit dolor faucibus dui imperdiet at eget. Tincidunt imperdiet quis hendrerit aliquam feugiat neque cras sed. Dictum quam integer volutpat tellus, faucibus platea. Pulvinar turpis proin faucibus at mauris. Sagittis gravida vitae porta enim, nulla arcu fermentum massa volutpat pretium.</p>',
                'body' => NULL,
                'quoteshort' => 'Cool and experienced team to develop your web application',
                'role' => 'Co-founder of Lorem Company',
                'stars' => '5',
                'created_at' => '2025-08-24 12:36:50',
                'updated_at' => '2025-08-24 12:46:05',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-24 12:36:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Annette Black',
                'slug' => 'annette-black',
                'slug_lock' => 0,
                'lead' => '<p>Vero minima sequi adipisci architecto dolorum, error animi delectus dicta perferendis! A, exercitationem soluta quam reprehenderit rem animi amet eligendi voluptates consequatur ipsam pariatur necessitatibus laboriosam in illo eos molestias ex explicabo eaque assumenda voluptatibus ducimus consectetur perferendis! Architecto molestias, rerum reprehenderit amet sunt natus fuga blanditiis suscipit.</p>',
                'body' => NULL,
                'quoteshort' => 'Efficient and Innovative: Our Experience with Silicon.',
                'role' => 'Strategic Advisor at Company LLC',
                'stars' => '4',
                'created_at' => '2025-08-24 12:44:37',
                'updated_at' => '2025-08-24 12:45:21',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-24 12:44:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'John MacIntosh',
                'slug' => 'john-macintosh',
                'slug_lock' => 0,
                'lead' => '<p>In quas adipisci assumenda voluptas eveniet obcaecati est quis sapiente voluptatum iste porro blanditiis debitis ut beatae, fugit quidem fugiat eum molestias? Dolore magni harum officia tempore eos sapiente. Voluptatibus pariatur omnis libero unde quasi optio, tenetur reprehenderit tempore necessitatibus harum mollitia qui. Maxime, quas tempore. Sunt quaerat porro facere blanditiis voluptatibus.</p>',
                'body' => NULL,
                'quoteshort' => 'Exceptional Service and Quality Results.',
                'role' => 'Founder & CEO, Uber',
                'stars' => '5',
                'created_at' => '2025-08-24 12:46:29',
                'updated_at' => '2025-08-24 12:48:36',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-24 12:46:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Annette Black',
                'slug' => 'annette-black-2',
                'slug_lock' => 0,
                'lead' => '<p>Mi semper risus ultricies orci pulvinar in at enim orci. Quis facilisis nunc pellentesque in ullamcorper sit. Lorem blandit arcu sapien, senectus libero, amet dapibus cursus quam. Eget pellentesque eu purus volutpat adipiscing malesuada. Purus nisi, tortor vel lacus.</p>',
                'body' => NULL,
                'quoteshort' => NULL,
                'role' => 'Strategic Advisor at Company LLC',
                'stars' => '5',
                'created_at' => '2025-08-24 12:48:52',
                'updated_at' => '2025-08-24 12:49:39',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-24 12:48:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Ralph Edwards',
                'slug' => 'ralph-edwards',
                'slug_lock' => 0,
                'lead' => '<p>Vestibulum nunc lectus auctor quis. Natoque lectus tortor lacus, eu. Nunc feugiat nisl maecenas nulla hac morbi. Vitae, donec facilisis sed nunc netus. Venenatis posuere faucibus enim est. Vel dignissim morbi blandit morbi tellus. Arcu ullamcorper quis enim.</p>',
                'body' => NULL,
                'quoteshort' => NULL,
                'role' => 'Head of Marketing at Lorem Ltd.',
                'stars' => '5',
                'created_at' => '2025-08-24 12:51:01',
                'updated_at' => '2025-08-24 12:51:50',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-24 12:50:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Darrell Steward',
                'slug' => 'darrell-steward-2',
                'slug_lock' => 0,
                'lead' => '<p>Ac at sed sit senectus massa. Massa ante amet ultrices magna porta tempor. Aliquet diam in et magna ultricies mi at. Lectus enim, vel enim egestas nam pellentesque et leo. Elit mi faucibus laoreet aliquam pellentesque sed aliquet integer massa. Orci leo tortor ornare.</p>',
                'body' => NULL,
                'quoteshort' => NULL,
                'role' => 'Project Manager at Ipsum Ltd.',
                'stars' => NULL,
                'created_at' => '2025-08-24 12:52:56',
                'updated_at' => '2025-08-24 12:53:19',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-24 12:52:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
        ));
        
        
    }
}