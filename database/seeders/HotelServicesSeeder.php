<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. DINING MENUS
        DB::table('dining_menus')->insert([
            [
                'name' => 'Nasi Goreng Spesial',
                'name_en' => 'Special Fried Rice',
                'description' => 'Nasi goreng dengan telur mata sapi, ayam suwir, dan kerupuk udang.',
                'price' => 45000,
                'image_url' => 'https://via.placeholder.com/150/FF5733/FFFFFF?text=Nasi+Goreng',
                'status' => 'active',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'name' => 'Club Sandwich',
                'name_en' => 'Club Sandwich',
                'description' => 'Roti lapis dengan isian ayam, daging asap, keju, dan selada segar.',
                'price' => 55000,
                'image_url' => 'https://via.placeholder.com/150/FFC300/000000?text=Sandwich',
                'status' => 'active',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'name' => 'Es Teh Manis',
                'name_en' => 'Sweet Iced Tea',
                'description' => 'Teh melati segar disajikan dingin.',
                'price' => 15000,
                'image_url' => 'https://via.placeholder.com/150/DAF7A6/000000?text=Ice+Tea',
                'status' => 'active',
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 2. AMENITIES
        DB::table('room_amenities')->insert([
            [
                'name' => 'Handuk Tambahan',
                'name_en' => 'Extra Towel',
                'description' => 'Satu set handuk mandi bersih.',
                'description_en' => 'One set of clean bath usage.',
                'icon_path' => 'https://via.placeholder.com/100/33C1FF/FFFFFF?text=Towel',
                'category' => 'bathroom',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'name' => 'Sikat Gigi',
                'name_en' => 'Toothbrush Kit',
                'description' => 'Sikat gigi dan pasta gigi.',
                'description_en' => 'Toothbrush and toothpaste.',
                'icon_path' => 'https://via.placeholder.com/100/33FF57/000000?text=Toothbrush',
                'category' => 'bathroom',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'name' => 'Air Mineral',
                'name_en' => 'Mineral Water',
                'description' => '2 botol air mineral 600ml.',
                'description_en' => '2 bottles of 600ml mineral water.',
                'icon_path' => 'https://via.placeholder.com/100/FF33A1/FFFFFF?text=Water',
                'category' => 'general',
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 3. HOTEL INFO
        DB::table('hotel_infos')->insert([
            [
                'title' => 'Resepsionis 24 Jam',
                'title_en' => '24h Reception',
                'description' => 'Dial "0" dari telepon kamar Anda untuk menghubungi resepsionis.',
                'description_en' => 'Dial "0" from your room phone to contact reception.',
                'icon_path' => 'https://via.placeholder.com/100/CCCCCC/000000?text=Reception',
                'sort_order' => 1,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'title' => 'Wi-Fi Gratis',
                'title_en' => 'Free Wi-Fi',
                'description' => 'Nama Wifi: AHF_Guest, Password: welcometoparadise',
                'description_en' => 'Wifi Name: AHF_Guest, Password: welcometoparadise',
                'icon_path' => 'https://via.placeholder.com/100/CCCCCC/000000?text=WiFi',
                'sort_order' => 2,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'title' => 'Waktu Check-out',
                'title_en' => 'Check-out Time',
                'description' => 'Waktu Check-out maksimal pukul 12:00 siang.',
                'description_en' => 'Check-out time is maximum at 12:00 PM.',
                'icon_path' => 'https://via.placeholder.com/100/CCCCCC/000000?text=Time',
                'sort_order' => 3,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 4. FACILITIES
        DB::table('hotel_facilities')->insert([
            [
                'name' => 'Kolam Renang',
                'name_en' => 'Swimming Pool',
                'description' => 'Kolam renang infinity di lantai 5.',
                'description_en' => 'Infinity pool located at 5th floor.',
                'icon_path' => 'https://via.placeholder.com/150/0000FF/FFFFFF?text=Pool',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);
    }
}
