<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionSeeder extends Seeder
{
    public function run()
    {
        // 1. Global Settings
        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'launcher_enabled'],
            ['setting_value' => '1']
        );

        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'launcher_version'],
            ['setting_value' => '3.3.8']
        );

        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'intro_video_url'],
            ['setting_value' => 'uploads/settings/intro_video_url_1769343575.mp4']
        );

        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'custom_greeting_image'],
            ['setting_value' => 'uploads/settings/custom_greeting_image_1769361656.jpeg']
        );

        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'launcher_home_bg'],
            ['setting_value' => 'uploads/settings/launcher_home_bg_1769343805.jpeg']
        );

        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'loading_logo_url'],
            ['setting_value' => 'uploads/settings/loading_logo_url_1769343971.png']
        );

        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'custom_greeting_title'],
            ['setting_value' => 'SELAMAT DATANG DI FOX HOTEL']
        );

        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'custom_welcome_greeting'],
            ['setting_value' => 'Selamat datang di FOX Hotel. Terima kasih telah memilih hotel kami sebagai tempat menginap Anda. Kami berharap Anda merasa nyaman dan menikmati seluruh fasilitas yang tersedia selama menginap. Apabila membutuhkan bantuan atau informasi, silakan menghubungi staf hotel. Selamat beristirahat dan selamat menikmati layanan kami.']
        );
        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'custom_greeting_title_en'],
            ['setting_value' => 'WELCOME TO FOX HOTEL']
        );

        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'custom_welcome_greeting_en'],
            ['setting_value' => 'Welcome to FOX Hotel. Thank you for choosing our hotel for your stay. We hope you find our hotel comfortable and enjoy all the amenities available during your stay. If you need any assistance or information, please contact our staff. Have a good rest and enjoy our services.']
        );

        // 2. System Marquee
        \App\Models\SystemMarquee::updateOrCreate(
            ['id' => 1],
            [
                'content' => 'Selamat datang di FOX Hotel. Kami berharap Anda mendapatkan pengalaman menginap yang nyaman dan menyenangkan. Nikmati fasilitas yang tersedia di kamar Anda, dan jangan ragu menghubungi staf hotel apabila membutuhkan bantuan. Selamat beristirahat.',
                'is_active' => true
            ]
        );

        // Simpan juga ke GlobalSetting (ID)
        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'marquee_content'],
            ['setting_value' => 'Selamat datang di FOX Hotel. Kami berharap Anda mendapatkan pengalaman menginap yang nyaman dan menyenangkan. Nikmati fasilitas yang tersedia di kamar Anda, dan jangan ragu menghubungi staf hotel apabila membutuhkan bantuan. Selamat beristirahat.']
        );

        // Marquee EN
        \App\Models\GlobalSetting::updateOrCreate(
            ['setting_key' => 'marquee_content_en'],
            ['setting_value' => 'Welcome to FOX Hotel. We hope you enjoy a comfortable and pleasant stay. Please enjoy the facilities in your room, and feel free to contact our staff if you need any assistance. Have a good rest.']
        );


        // 3. System Apps
        // \App\Models\SystemApp::updateOrCreate(
        //     ['app_key' => 'dining'],
        //     array (
        //     'id' => 1,
        //     'app_key' => 'dining',
        //     'app_name' => 'Dining',
        //     'app_name_en' => 'Dining',
        //     'icon_path' => 'https://via.placeholder.com/150?text=Dining',
        //     'is_visible' => 1,
        //     'sort_order' => 1,
        //     'android_package' => NULL,
        //     'apk_url' => NULL,
        //     )
        // );

//         \App\Models\SystemApp::updateOrCreate(
//             ['app_key' => 'amenities'],
//             array (
//   'id' => 2,
//   'app_key' => 'amenities',
//   'app_name' => 'Amenities',
//   'app_name_en' => 'Amenities',
//   'icon_path' => 'https://via.placeholder.com/150?text=Amenities',
//   'is_visible' => 1,
//   'sort_order' => 2,
//   'android_package' => NULL,
//   'apk_url' => NULL,
// )
//         );



        \App\Models\SystemApp::updateOrCreate(
            ['app_key' => 'facilities'],
            array (
  'id' => 3,
  'app_key' => 'facilities',
  'app_name' => 'Facilities',
  'app_name_en' => 'Facilities',
  'icon_path' => 'https://via.placeholder.com/150?text=Facilities',
  'is_visible' => 1,
  'sort_order' => 3,
  'android_package' => NULL,
  'apk_url' => NULL,
)
        );

        \App\Models\SystemApp::updateOrCreate(
            ['app_key' => 'info'],
            array (
  'id' => 4,
  'app_key' => 'info',
  'app_name' => 'Hotel Info',
  'app_name_en' => 'Hotel Info',
  'icon_path' => 'https://via.placeholder.com/150?text=Info',
  'is_visible' => 1,
  'sort_order' => 4,
  'android_package' => NULL,
  'apk_url' => NULL,
)
        );

//         \App\Models\SystemApp::updateOrCreate(
//             ['app_key' => 'apps'],
//             array (
//   'id' => 5,
//   'app_key' => 'apps',
//   'app_name' => 'Apps',
//   'app_name_en' => 'Apps',
//   'icon_path' => 'https://via.placeholder.com/150?text=Apps',
//   'is_visible' => 1,
//   'sort_order' => 5,
//   'android_package' => NULL,
//   'apk_url' => NULL,
// )
//         );

//         \App\Models\SystemApp::updateOrCreate(
//             ['app_key' => 'clear_cache'],
//             array (
//   'id' => 6,
//   'app_key' => 'clear_cache',
//   'app_name' => 'Clean Cache',
//   'app_name_en' => 'Clean Cache',
//   'icon_path' => 'https://via.placeholder.com/150?text=Clean',
//   'is_visible' => 1,
//   'sort_order' => 6,
//   'android_package' => NULL,
//   'apk_url' => NULL,
// )
//         );

        // 4. Home Menus
//         \App\Models\HomeMenu::updateOrCreate(
//             ['menu_key' => 'apps'],
//             array (
//   'id' => 1,
//   'menu_key' => 'apps',
//   'menu_name' => 'Aplikasi',
//   'menu_name_en' => 'Apps',
//   'icon_path' => 'storage/menu_icons/Vaw54gN8kKdEoreT9j6gzt3sFmSS7TFz3gDuCuom.png',
//   'action_type' => 'dialog',
//   'action_value' => 'show_apps_dialog',
//   'sort_order' => 1,
//   'is_active' => true,
// )
//         );

        \App\Models\HomeMenu::updateOrCreate(
            ['menu_key' => 'info'],
            array (
  'id' => 2,
  'menu_key' => 'info',
  'menu_name' => 'Informasi',
  'menu_name_en' => 'Info',
  'icon_path' => 'storage/menu_icons/zUPeb1wXU1O7AFQAwK5Z9XW4WDE7AAdcM7UtBwJl.png',
  'action_type' => 'dialog',
  'action_value' => 'info',
  'sort_order' => 2,
  'is_active' => true,
)
        );

//         \App\Models\HomeMenu::updateOrCreate(
//             ['menu_key' => 'dining'],
//             array (
//   'id' => 3,
//   'menu_key' => 'dining',
//   'menu_name' => 'Restoran',
//   'menu_name_en' => 'Dining',
//   'icon_path' => 'storage/menu_icons/LMVx2Z4MSaq7AyzPnH3c31haJnBfzwShgHj18pK2.png',
//   'action_type' => 'dialog',
//   'action_value' => 'dining',
//   'sort_order' => 3,
//   'is_active' => true,
// )
//         );

//         \App\Models\HomeMenu::updateOrCreate(
//             ['menu_key' => 'amenities'],
//             array (
//   'id' => 4,
//   'menu_key' => 'amenities',
//   'menu_name' => 'Amenities',
//   'menu_name_en' => 'Amenities',
//   'icon_path' => 'storage/menu_icons/3RQc1sPEWziejkFYe5QabIohIOtKgpwBjHK1DuFb.png',
//   'action_type' => 'dialog',
//   'action_value' => 'amenities',
//   'sort_order' => 4,
//   'is_active' => true,
// )
//         );

        \App\Models\HomeMenu::updateOrCreate(
            ['menu_key' => 'facilities'],
            array (
  'id' => 5,
  'menu_key' => 'facilities',
  'menu_name' => 'Fasilitas',
  'menu_name_en' => 'Facilities',
  'icon_path' => 'storage/menu_icons/X1W0VTLBWPsAfjblt4Nb3HhFfRt7T0rwHCPjMwdM.png',
  'action_type' => 'dialog',
  'action_value' => 'facilities',
  'sort_order' => 5,
  'is_active' => true,
)
        );

        \App\Models\HomeMenu::updateOrCreate(
            ['menu_key' => 'clear_cache'],
            array (
  'id' => 6,
  'menu_key' => 'clear_cache',
  'menu_name' => 'Hapus Cache',
  'menu_name_en' => 'Clear Cache',
  'icon_path' => 'storage/menu_icons/UAnD0bt5U3mw1w6N45G0irGxvEHdykSkP1NSMnig.png',
  'action_type' => 'function',
  'action_value' => 'clear_cache',
  'sort_order' => 6,
  'is_active' => true,
)
        );
        



    }
}
