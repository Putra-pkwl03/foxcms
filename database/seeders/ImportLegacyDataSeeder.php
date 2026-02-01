<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportLegacyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. DINING MENUS
        // From dining_menu old table
        // $diningData = [
        //     ['name' => 'Nasi Goreng Spesial', 'price' => 25000, 'image_url' => 'uploads/dining/menu_1762403060_6896.jpg', 'status' => 'active'],
        //     ['name' => 'Mie Goreng Seafood', 'price' => 28000, 'image_url' => 'uploads/dining/menu_1762403046_6137.jpg', 'status' => 'active'],
        //     ['name' => 'Sate Ayam Madura', 'price' => 32000, 'image_url' => 'uploads/dining/menu_1762403025_4402.jpg', 'status' => 'active'],
        //     ['name' => 'Soto Ayam Lamongan', 'price' => 27000, 'image_url' => 'uploads/dining/menu_1762402938_2826.jpg', 'status' => 'active'],
        //     ['name' => 'Ayam Penyet Sambal Ijo', 'price' => 30000, 'image_url' => 'uploads/dining/menu_1762402926_5896.jpg', 'status' => 'active'],
        //     ['name' => 'Capcay Kuah', 'price' => 26000, 'image_url' => 'uploads/dining/menu_1762402914_6848.jpg', 'status' => 'active'],
        //     ['name' => 'Teh Manis Dingin', 'price' => 8000, 'image_url' => 'uploads/dining/menu_1762402903_3623.jpg', 'status' => 'active'],
        //     ['name' => 'Kopi Hitam Tubruk', 'price' => 10000, 'image_url' => 'uploads/dining/menu_1762402893_5054.jpg', 'status' => 'active'],
        //     ['name' => 'Jus Alpukat', 'price' => 15000, 'image_url' => 'uploads/dining/menu_1762402873_2600.jpg', 'status' => 'active'],
        //     ['name' => 'Pisang Goreng Keju', 'price' => 18000, 'image_url' => 'uploads/dining/menu_1762402863_8844.jpg', 'status' => 'active'],
        //     ['name' => 'Nasi Goreng Terasi', 'price' => 35000, 'image_url' => 'uploads/dining/menu_1762402852_1742.jpg', 'status' => 'active'],
        //     ['name' => 'Mie Aceh', 'price' => 100000, 'image_url' => 'uploads/dining/menu_1762751245_7527.jpg', 'status' => 'active'],
        //     ['name' => 'Mie rebus', 'price' => 85000, 'image_url' => 'uploads/dining/menu_1762751152_1853.jpg', 'status' => 'active'],
        //     ['name' => 'nasi Kotak', 'price' => 25000, 'image_url' => 'uploads/dining/menu_1764146230_6897.jpg', 'status' => 'active'],
        // ];

        // // Insert if not exists
        // foreach ($diningData as $item) {
        //     if (!DB::table('dining_menus')->where('name', $item['name'])->exists()) {
        //         DB::table('dining_menus')->insert(array_merge($item, ['created_at' => now(), 'updated_at' => now()]));
        //     }
        // }

        // 2. AMENITIES
        // From room_amenities old table
        // $amenityData = [
        //     ['name' => 'Handuk Tambahan', 'description' => 'Handuk mandi ekstra (1 buah)', 'icon_path' => 'uploads/amenities/amenity_1762854506_5026.jpg'],
        //     ['name' => 'Bantal Tambahan', 'description' => 'Bantal tidur ekstra (1 buah)', 'icon_path' => 'uploads/amenities/amenity_1762854489_6848.jpg'],
        //     ['name' => 'Perlengkapan Mandi', 'description' => 'Sabun, Shampoo, Sikat Gigi', 'icon_path' => 'uploads/amenities/amenity_1762854476_7748.jpg'],
        //     ['name' => 'Sajadah', 'description' => 'Alat sholat (1 set)', 'icon_path' => 'uploads/amenities/amenity_1762854461_1137.jpg'],
        //     ['name' => 'Air Mineral', 'description' => 'Air mineral botol (2 botol)', 'icon_path' => 'uploads/amenities/amenity_1762854450_2040.jpg'],
        //     ['name' => 'Teko Kopi', 'description' => 'Kopi, teh, susu', 'icon_path' => 'uploads/amenities/amenity_1762855317_8455.jpg'],
        // ];

        // foreach ($amenityData as $item) {
        //     if (!DB::table('room_amenities')->where('name', $item['name'])->exists()) {
        //         DB::table('room_amenities')->insert(array_merge($item, ['created_at' => now(), 'updated_at' => now()]));
        //     }
        // }

        // 3. HOTEL INFO
        // From hotel_info old table
        // $infoData = [
        //     ['title' => 'Hotel Kami', 'icon_path' => 'uploads/info/info_1762383411_1981.jpg', 'show_description' => true],
        //     ['title' => 'Check in', 'icon_path' => 'uploads/info/info_1762383434_1467.jpg', 'show_description' => true],
        //     ['title' => 'Analitik', 'icon_path' => 'uploads/info/info_1762383448_2523.jpg', 'show_description' => true],
        //     ['title' => 'Selamat Datang', 'icon_path' => 'uploads/info/info_1762383478_7320.jpg', 'show_description' => true],
        // ];

        // foreach ($infoData as $item) {
        //     if (!DB::table('hotel_infos')->where('title', $item['title'])->exists()) {
        //         DB::table('hotel_infos')->insert(array_merge($item, ['created_at' => now(), 'updated_at' => now()]));
        //     }
        // }

        // // 4. FACILITIES
        // // From hotel_facilities old table
        // $facilityData = [
        //     ['name' => 'Classic', 'icon_path' => 'uploads/facilities/facility_1762374139_7591.jpg', 'is_active' => true],
        //     ['name' => 'Hotel Service', 'icon_path' => 'uploads/facilities/facility_1762374173_2294.jpg', 'is_active' => true],
        //     ['name' => 'Breakfast', 'icon_path' => 'uploads/facilities/facility_1762374195_8430.jpg', 'is_active' => true],
        //     ['name' => 'Sales', 'icon_path' => 'uploads/facilities/facility_1762374266_8271.jpg', 'is_active' => true],
        //     ['name' => 'Bedroom', 'icon_path' => 'uploads/facilities/facility_1762374289_5827.jpg', 'is_active' => true],
        //     ['name' => 'Fasilitas', 'name_en' => 'Facilities', 'description' => 'Tempat yang komplit', 'description_en' => 'Complete Place', 'icon_path' => 'uploads/facilities/fac_1764145694.jpg', 'is_active' => true],
        // ];

        // foreach ($facilityData as $item) {
        //     if (!DB::table('hotel_facilities')->where('name', $item['name'])->exists()) {
        //         DB::table('hotel_facilities')->insert(array_merge($item, ['created_at' => now(), 'updated_at' => now()]));
        //     }
        // }
    }
}
