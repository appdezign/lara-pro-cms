<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CacheTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cache')->delete();
        
        \DB::table('cache')->insert(array (
            0 => 
            array (
                'key' => 'lara_entity_blogs',
                'value' => 'O:25:"Lara\\Common\\Models\\Entity":30:{s:13:"' . "\0" . '*' . "\0" . 'connection";s:5:"mysql";s:8:"' . "\0" . '*' . "\0" . 'table";s:22:"lara_resource_entities";s:13:"' . "\0" . '*' . "\0" . 'primaryKey";s:2:"id";s:10:"' . "\0" . '*' . "\0" . 'keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"' . "\0" . '*' . "\0" . 'with";a:0:{}s:12:"' . "\0" . '*' . "\0" . 'withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"' . "\0" . '*' . "\0" . 'perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"' . "\0" . '*' . "\0" . 'escapeWhenCastingToString";b:0;s:13:"' . "\0" . '*' . "\0" . 'attributes";a:55:{s:2:"id";i:2;s:5:"title";s:4:"Blog";s:13:"resource_slug";s:5:"blogs";s:12:"label_single";s:4:"blog";s:8:"resource";s:40:"Lara\\App\\Filament\\Resources\\BlogResource";s:6:"policy";s:28:"Lara\\App\\Policies\\BlogPolicy";s:11:"model_class";s:20:"Lara\\App\\Models\\Blog";s:10:"controller";s:15:"BlogsController";s:9:"nav_group";s:7:"modules";s:10:"created_at";s:19:"2025-04-14 18:39:44";s:10:"updated_at";s:19:"2025-06-25 18:33:40";s:6:"cgroup";s:6:"entity";s:8:"position";i:210;s:12:"col_has_lead";i:1;s:19:"col_max_body_fields";i:1;s:12:"col_has_body";i:1;s:14:"col_has_status";i:1;s:18:"col_has_expiration";i:1;s:18:"col_has_hideinlist";i:0;s:16:"sort_is_sortable";i:0;s:18:"sort_primary_field";s:2:"id";s:18:"sort_primary_order";s:3:"asc";s:20:"sort_secondary_order";N;s:20:"sort_secondary_field";N;s:11:"show_search";i:1;s:10:"show_batch";i:0;s:11:"show_status";i:1;s:8:"show_seo";i:1;s:14:"show_opengraph";i:1;s:11:"show_author";i:1;s:14:"show_rich_lead";i:1;s:14:"show_rich_body";i:1;s:16:"show_view_action";i:1;s:16:"show_edit_action";i:1;s:18:"show_delete_action";i:1;s:19:"show_restore_action";i:1;s:18:"filter_has_trashed";i:1;s:18:"media_has_featured";i:1;s:15:"media_has_thumb";i:1;s:14:"media_has_hero";i:0;s:14:"media_has_icon";i:0;s:17:"media_has_gallery";i:1;s:21:"media_has_gallery_pro";i:1;s:16:"media_has_videos";i:1;s:20:"media_has_videofiles";i:1;s:15:"media_has_files";i:1;s:17:"media_max_gallery";i:24;s:16:"media_max_videos";i:1;s:20:"media_max_videofiles";i:1;s:15:"media_max_files";i:1;s:16:"objrel_has_terms";i:1;s:17:"objrel_has_groups";i:1;s:19:"objrel_group_values";s:23:"["one", "two", "three"]";s:18:"objrel_has_related";i:1;s:19:"objrel_is_relatable";i:1;}s:11:"' . "\0" . '*' . "\0" . 'original";a:55:{s:2:"id";i:2;s:5:"title";s:4:"Blog";s:13:"resource_slug";s:5:"blogs";s:12:"label_single";s:4:"blog";s:8:"resource";s:40:"Lara\\App\\Filament\\Resources\\BlogResource";s:6:"policy";s:28:"Lara\\App\\Policies\\BlogPolicy";s:11:"model_class";s:20:"Lara\\App\\Models\\Blog";s:10:"controller";s:15:"BlogsController";s:9:"nav_group";s:7:"modules";s:10:"created_at";s:19:"2025-04-14 18:39:44";s:10:"updated_at";s:19:"2025-06-25 18:33:40";s:6:"cgroup";s:6:"entity";s:8:"position";i:210;s:12:"col_has_lead";i:1;s:19:"col_max_body_fields";i:1;s:12:"col_has_body";i:1;s:14:"col_has_status";i:1;s:18:"col_has_expiration";i:1;s:18:"col_has_hideinlist";i:0;s:16:"sort_is_sortable";i:0;s:18:"sort_primary_field";s:2:"id";s:18:"sort_primary_order";s:3:"asc";s:20:"sort_secondary_order";N;s:20:"sort_secondary_field";N;s:11:"show_search";i:1;s:10:"show_batch";i:0;s:11:"show_status";i:1;s:8:"show_seo";i:1;s:14:"show_opengraph";i:1;s:11:"show_author";i:1;s:14:"show_rich_lead";i:1;s:14:"show_rich_body";i:1;s:16:"show_view_action";i:1;s:16:"show_edit_action";i:1;s:18:"show_delete_action";i:1;s:19:"show_restore_action";i:1;s:18:"filter_has_trashed";i:1;s:18:"media_has_featured";i:1;s:15:"media_has_thumb";i:1;s:14:"media_has_hero";i:0;s:14:"media_has_icon";i:0;s:17:"media_has_gallery";i:1;s:21:"media_has_gallery_pro";i:1;s:16:"media_has_videos";i:1;s:20:"media_has_videofiles";i:1;s:15:"media_has_files";i:1;s:17:"media_max_gallery";i:24;s:16:"media_max_videos";i:1;s:20:"media_max_videofiles";i:1;s:15:"media_max_files";i:1;s:16:"objrel_has_terms";i:1;s:17:"objrel_has_groups";i:1;s:19:"objrel_group_values";s:23:"["one", "two", "three"]";s:18:"objrel_has_related";i:1;s:19:"objrel_is_relatable";i:1;}s:10:"' . "\0" . '*' . "\0" . 'changes";a:0:{}s:8:"' . "\0" . '*' . "\0" . 'casts";a:3:{s:10:"created_at";s:8:"datetime";s:10:"updated_at";s:8:"datetime";s:19:"objrel_group_values";s:5:"array";}s:17:"' . "\0" . '*' . "\0" . 'classCastCache";a:0:{}s:21:"' . "\0" . '*' . "\0" . 'attributeCastCache";a:0:{}s:13:"' . "\0" . '*' . "\0" . 'dateFormat";N;s:10:"' . "\0" . '*' . "\0" . 'appends";a:0:{}s:19:"' . "\0" . '*' . "\0" . 'dispatchesEvents";a:0:{}s:14:"' . "\0" . '*' . "\0" . 'observables";a:0:{}s:12:"' . "\0" . '*' . "\0" . 'relations";a:0:{}s:10:"' . "\0" . '*' . "\0" . 'touches";a:0:{}s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"' . "\0" . '*' . "\0" . 'hidden";a:0:{}s:10:"' . "\0" . '*' . "\0" . 'visible";a:0:{}s:11:"' . "\0" . '*' . "\0" . 'fillable";a:0:{}s:10:"' . "\0" . '*' . "\0" . 'guarded";a:3:{i:0;s:2:"id";i:1;s:10:"created_at";i:2;s:10:"updated_at";}}',
                'expiration' => 2066630293,
            ),
            1 => 
            array (
                'key' => 'livewire-rate-limiter:2497e99f688091da644d7c95aa575fd8f8163fea',
                'value' => 'i:1;',
                'expiration' => 1751304569,
            ),
            2 => 
            array (
                'key' => 'livewire-rate-limiter:2497e99f688091da644d7c95aa575fd8f8163fea:timer',
                'value' => 'i:1751304569;',
                'expiration' => 1751304569,
            ),
            3 => 
            array (
                'key' => 'spatie.permission.cache',
                'value' => 'a:3:{s:5:"alias";a:4:{s:1:"a";s:2:"id";s:1:"b";s:4:"name";s:1:"c";s:10:"guard_name";s:1:"r";s:5:"roles";}s:11:"permissions";a:36:{i:0;a:4:{s:1:"a";i:1;s:1:"b";s:13:"view_any_blog";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:4:{s:1:"a";i:2;s:1:"b";s:9:"view_blog";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:"a";i:3;s:1:"b";s:11:"create_blog";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:"a";i:4;s:1:"b";s:11:"update_blog";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:"a";i:5;s:1:"b";s:11:"delete_blog";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:"a";i:6;s:1:"b";s:15:"delete_any_blog";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:3:{s:1:"a";i:19;s:1:"b";s:13:"view_any_page";s:1:"c";s:3:"web";}i:7;a:3:{s:1:"a";i:20;s:1:"b";s:9:"view_page";s:1:"c";s:3:"web";}i:8;a:3:{s:1:"a";i:21;s:1:"b";s:11:"create_page";s:1:"c";s:3:"web";}i:9;a:3:{s:1:"a";i:22;s:1:"b";s:11:"update_page";s:1:"c";s:3:"web";}i:10;a:3:{s:1:"a";i:23;s:1:"b";s:11:"delete_page";s:1:"c";s:3:"web";}i:11;a:3:{s:1:"a";i:24;s:1:"b";s:15:"delete_any_page";s:1:"c";s:3:"web";}i:12;a:3:{s:1:"a";i:31;s:1:"b";s:13:"view_any_team";s:1:"c";s:3:"web";}i:13;a:3:{s:1:"a";i:32;s:1:"b";s:9:"view_team";s:1:"c";s:3:"web";}i:14;a:3:{s:1:"a";i:33;s:1:"b";s:11:"create_team";s:1:"c";s:3:"web";}i:15;a:3:{s:1:"a";i:34;s:1:"b";s:11:"update_team";s:1:"c";s:3:"web";}i:16;a:3:{s:1:"a";i:35;s:1:"b";s:11:"delete_team";s:1:"c";s:3:"web";}i:17;a:3:{s:1:"a";i:36;s:1:"b";s:15:"delete_any_team";s:1:"c";s:3:"web";}i:18;a:3:{s:1:"a";i:37;s:1:"b";s:15:"view_any_entity";s:1:"c";s:3:"web";}i:19;a:3:{s:1:"a";i:38;s:1:"b";s:11:"view_entity";s:1:"c";s:3:"web";}i:20;a:3:{s:1:"a";i:39;s:1:"b";s:13:"create_entity";s:1:"c";s:3:"web";}i:21;a:3:{s:1:"a";i:40;s:1:"b";s:13:"update_entity";s:1:"c";s:3:"web";}i:22;a:3:{s:1:"a";i:41;s:1:"b";s:13:"delete_entity";s:1:"c";s:3:"web";}i:23;a:3:{s:1:"a";i:42;s:1:"b";s:17:"delete_any_entity";s:1:"c";s:3:"web";}i:24;a:3:{s:1:"a";i:43;s:1:"b";s:13:"view_any_user";s:1:"c";s:3:"web";}i:25;a:3:{s:1:"a";i:44;s:1:"b";s:9:"view_user";s:1:"c";s:3:"web";}i:26;a:3:{s:1:"a";i:45;s:1:"b";s:11:"create_user";s:1:"c";s:3:"web";}i:27;a:3:{s:1:"a";i:46;s:1:"b";s:11:"update_user";s:1:"c";s:3:"web";}i:28;a:3:{s:1:"a";i:47;s:1:"b";s:11:"delete_user";s:1:"c";s:3:"web";}i:29;a:3:{s:1:"a";i:48;s:1:"b";s:15:"delete_any_user";s:1:"c";s:3:"web";}i:30;a:3:{s:1:"a";i:49;s:1:"b";s:13:"view_any_role";s:1:"c";s:3:"web";}i:31;a:3:{s:1:"a";i:50;s:1:"b";s:9:"view_role";s:1:"c";s:3:"web";}i:32;a:3:{s:1:"a";i:51;s:1:"b";s:11:"create_role";s:1:"c";s:3:"web";}i:33;a:3:{s:1:"a";i:52;s:1:"b";s:11:"update_role";s:1:"c";s:3:"web";}i:34;a:3:{s:1:"a";i:53;s:1:"b";s:11:"delete_role";s:1:"c";s:3:"web";}i:35;a:3:{s:1:"a";i:54;s:1:"b";s:15:"delete_any_role";s:1:"c";s:3:"web";}}s:5:"roles";a:2:{i:0;a:3:{s:1:"a";i:1;s:1:"b";s:10:"superadmin";s:1:"c";s:3:"web";}i:1;a:3:{s:1:"a";i:2;s:1:"b";s:13:"administrator";s:1:"c";s:3:"web";}}}',
                'expiration' => 1751356693,
            ),
        ));
        
        
    }
}