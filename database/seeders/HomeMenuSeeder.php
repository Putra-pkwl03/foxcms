<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeMenu;

class HomeMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            // [
            //     'menu_key' => 'apps',
            //     'menu_name' => 'Aplikasi',
            //     'menu_name_en' => 'Apps',
            //     'icon_path' => 'img/menu/apps.png',
            //     'action_type' => 'dialog',
            //     'action_value' => 'show_apps_dialog',
            //     'sort_order' => 1,
            // ],
            // YouTube
            [
                'menu_key' => 'youtube_home',
                'menu_name' => 'YouTube',
                'menu_name_en' => 'YouTube',
                'icon_path' => 'img/menu/youtube.png',
                'action_type' => 'app',
                'action_value' => 'com.google.android.youtube.tv',
                'sort_order' => 4,
            ],

            // TV Channel
            [
                'menu_key' => 'tv_channel',
                'menu_name' => 'TV Channel',
                'menu_name_en' => 'TV Channel',
                'icon_path' => 'img/menu/tv.png',
                'action_type' => 'app',
                'action_value' => 'com.bestv.fmgotv',
                'sort_order' => 5,
            ],


            [
                'menu_key' => 'info',
                'menu_name' => 'Informasi',
                'menu_name_en' => 'Info',
                'icon_path' => 'img/menu/info.png',
                'action_type' => 'dialog',
                'action_value' => 'info',
                'sort_order' => 1,
            ],
            // [
            //     'menu_key' => 'dining',
            //     'menu_name' => 'Restoran',
            //     'menu_name_en' => 'Dining',
            //     'icon_path' => 'img/menu/dining.png',
            //     'action_type' => 'dialog',
            //     'action_value' => 'dining',
            //     'sort_order' => 3,
            // ],
            // [
            //     'menu_key' => 'amenities',
            //     'menu_name' => 'Amenities',
            //     'menu_name_en' => 'Amenities',
            //     'icon_path' => 'img/menu/amenities.png',
            //     'action_type' => 'dialog',
            //     'action_value' => 'amenities',
            //     'sort_order' => 4,
            // ],
            [
                'menu_key' => 'facilities',
                'menu_name' => 'Fasilitas',
                'menu_name_en' => 'Facilities',
                'icon_path' => 'img/menu/wifi.png',
                'action_type' => 'dialog',
                'action_value' => 'facilities',
                'sort_order' => 2,
            ],
            [
                'menu_key' => 'clear_cache',
                'menu_name' => 'Hapus Cache',
                'menu_name_en' => 'Clear Cache',
                'icon_path' => 'img/menu/arrows.png',
                'action_type' => 'function',
                'action_value' => 'clear_cache',
                'sort_order' => 3,
            ],
        ];

        foreach ($menus as $menu) {
            HomeMenu::updateOrCreate(['menu_key' => $menu['menu_key']], $menu);
        }
    }
}
