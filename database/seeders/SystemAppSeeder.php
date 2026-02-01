<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing to avoid duplicates if re-seeding
        DB::table('system_apps')->truncate();

        $apps = [
            // [
            //     'app_key' => 'dining',
            //     'app_name' => 'Dining',
            //     'app_name_en' => 'Dining',
            //     'icon_path' => 'https://via.placeholder.com/150?text=Dining', // Android uses local icon
            //     'is_visible' => true,
            //     'sort_order' => 1,
            //     'android_package' => null,
            //     'created_at' => now(), 'updated_at' => now()
            // ],
            // [
            //     'app_key' => 'amenities',
            //     'app_name' => 'Amenities',
            //     'app_name_en' => 'Amenities',
            //     'icon_path' => 'https://via.placeholder.com/150?text=Amenities',
            //     'is_visible' => true,
            //     'sort_order' => 2,
            //     'android_package' => null,
            //     'created_at' => now(), 'updated_at' => now()
            // ],
            [
                'app_key' => 'facilities',
                'app_name' => 'Facilities',
                'app_name_en' => 'Facilities',
                'icon_path' => 'https://via.placeholder.com/150?text=Facilities',
                'is_visible' => true,
                'sort_order' => 3,
                'android_package' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'app_key' => 'info',
                'app_name' => 'Hotel Info',
                'app_name_en' => 'Hotel Info',
                'icon_path' => 'https://via.placeholder.com/150?text=Info',
                'is_visible' => true,
                'sort_order' => 4,
                'android_package' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            // [
            //     'app_key' => 'apps',
            //     'app_name' => 'Apps',
            //     'app_name_en' => 'Apps',
            //     'icon_path' => 'https://via.placeholder.com/150?text=Apps',
            //     'is_visible' => true,
            //     'sort_order' => 5,
            //     'android_package' => null,
            //     'created_at' => now(), 'updated_at' => now()
            // ],
            [
                'app_key' => 'clear_cache',
                'app_name' => 'Clean Cache',
                'app_name_en' => 'Clean Cache',
                'icon_path' => 'https://via.placeholder.com/150?text=Clean',
                'is_visible' => true,
                'sort_order' => 6,
                'android_package' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
        ];

        DB::table('system_apps')->insert($apps);
    }
}
