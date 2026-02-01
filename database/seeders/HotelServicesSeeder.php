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
        // DB::table('dining_menus')->insert([
        //     [
        //         'name' => 'Nasi Goreng Spesial',
        //         'name_en' => 'Special Fried Rice',
        //         'description' => 'Nasi goreng dengan telur mata sapi, ayam suwir, dan kerupuk udang.',
        //         'price' => 45000,
        //         'image_url' => 'https://via.placeholder.com/150/FF5733/FFFFFF?text=Nasi+Goreng',
        //         'status' => 'active',
        //         'created_at' => now(), 'updated_at' => now()
        //     ],
        //     [
        //         'name' => 'Club Sandwich',
        //         'name_en' => 'Club Sandwich',
        //         'description' => 'Roti lapis dengan isian ayam, daging asap, keju, dan selada segar.',
        //         'price' => 55000,
        //         'image_url' => 'https://via.placeholder.com/150/FFC300/000000?text=Sandwich',
        //         'status' => 'active',
        //         'created_at' => now(), 'updated_at' => now()
        //     ],
        //     [
        //         'name' => 'Es Teh Manis',
        //         'name_en' => 'Sweet Iced Tea',
        //         'description' => 'Teh melati segar disajikan dingin.',
        //         'price' => 15000,
        //         'image_url' => 'https://via.placeholder.com/150/DAF7A6/000000?text=Ice+Tea',
        //         'status' => 'active',
        //         'created_at' => now(), 'updated_at' => now()
        //     ]
        // ]);

        // // 2. AMENITIES
        // DB::table('room_amenities')->insert([
        //     [
        //         'name' => 'Handuk Tambahan',
        //         'name_en' => 'Extra Towel',
        //         'description' => 'Satu set handuk mandi bersih.',
        //         'description_en' => 'One set of clean bath usage.',
        //         'icon_path' => 'https://via.placeholder.com/100/33C1FF/FFFFFF?text=Towel',
        //         'category' => 'bathroom',
        //         'created_at' => now(), 'updated_at' => now()
        //     ],
        //     [
        //         'name' => 'Sikat Gigi',
        //         'name_en' => 'Toothbrush Kit',
        //         'description' => 'Sikat gigi dan pasta gigi.',
        //         'description_en' => 'Toothbrush and toothpaste.',
        //         'icon_path' => 'https://via.placeholder.com/100/33FF57/000000?text=Toothbrush',
        //         'category' => 'bathroom',
        //         'created_at' => now(), 'updated_at' => now()
        //     ],
        //     [
        //         'name' => 'Air Mineral',
        //         'name_en' => 'Mineral Water',
        //         'description' => '2 botol air mineral 600ml.',
        //         'description_en' => '2 bottles of 600ml mineral water.',
        //         'icon_path' => 'https://via.placeholder.com/100/FF33A1/FFFFFF?text=Water',
        //         'category' => 'general',
        //         'created_at' => now(), 'updated_at' => now()
        //     ]
        // ]);

        // 3. HOTEL INFO
        DB::table('hotel_infos')->insert([
            [
                'title' => 'Resepsionis (IN) / EN',
                'title_en' => 'Reception (IN) / EN',
                'description' => 'Deskripsi Resepsionis (IN) / EN.',
                'description_en' => 'Resepsionis Description (IN) / EN.',
                'icon_path' => 'uploads/info/Receptioninfo.jpeg',
                'sort_order' => 1,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],
        ]);

      // 4. FACILITIES
        DB::table('hotel_facilities')->truncate();

        DB::table('hotel_facilities')->insert([

            [
                'name' => 'Kamar Suite',
                'name_en' => 'Suite Room',
                'description' => 'Definisi kemewahan sejati dengan ruang tamu terpisah, kamar mandi marmer dengan bathtub, serta layanan pelayan pribadi (butler) untuk kenyamanan maksimal Anda.',
                'description_en' => 'The definition of true luxury featuring a separate living area, marble bathroom with a bathtub, and personalized butler service for your ultimate comfort.',
                'icon_path' => 'storage/facilities/suite.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

            [
                'name' => 'Kolam Renang Atap',
                'name_en' => 'Sky Pool',
                'description' => 'Nikmati kesegaran berenang di ketinggian dengan pemandangan kota yang menakjubkan. Tempat yang sempurna untuk bersantai sambil menikmati matahari terbenam.',
                'description_en' => 'Experience a refreshing swim at heights with breathtaking city views. The perfect spot to unwind while enjoying the sunset.',
                'icon_path' => 'storage/facilities/pool.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

            [
                'name' => 'Restoran & Kafe',
                'name_en' => 'Restaurant & Cafe',
                'description' => 'Nikmati pengalaman kuliner terbaik dengan pilihan hidangan lokal dan internasional yang disiapkan oleh koki profesional kami dalam suasana yang nyaman.',
                'description_en' => 'Enjoy the finest dining experience with a selection of local and international dishes prepared by our professional chefs in a cozy atmosphere.',
                'icon_path' => 'storage/facilities/restaurant.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

            [
                'name' => 'Resepsionis 24 Jam',
                'name_en' => '24-Hour Reception',
                'description' => 'Tim layanan tamu tersedia 24 jam untuk membantu check-in, check-out, layanan kamar, dan pertanyaan selama menginap.',
                'description_en' => 'Our guest service team is available 24 hours a day to assist with check-in, check-out, room service, and any inquiries during your stay.',
                'icon_path' => 'storage/facilities/reception.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

            [
                'name' => 'Ruang Pertemuan',
                'name_en' => 'Meeting Room',
                'description' => 'Ruang pertemuan fleksibel untuk berbagai acara, dilengkapi proyektor, sistem audio berkualitas, dan koneksi Wi-Fi berkecepatan tinggi.',
                'description_en' => 'Flexible meeting spaces for various events, equipped with projectors, high-quality audio systems, and high-speed Wi-Fi.',
                'icon_path' => 'storage/facilities/meeting.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

            [
                'name' => 'Pusat Kebugaran',
                'name_en' => 'Fitness Center',
                'description' => 'Jaga kebugaran Anda selama menginap dengan peralatan kardio dan angkat beban modern. Tersedia gratis untuk seluruh tamu hotel.',
                'description_en' => 'Stay fit during your stay with our modern cardio and weight-lifting equipment. Complimentary for all in-house guests.',
                'icon_path' => 'storage/facilities/fitness.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

            [
                'name' => 'Kamar Eksekutif',
                'name_en' => 'Executive Room',
                'description' => 'Kenyamanan premium dengan ruang kerja eksklusif, mesin kopi kapsul, dan akses gratis ke Executive Lounge.',
                'description_en' => 'Premium comfort with an exclusive workspace, capsule coffee machine, and complimentary Executive Lounge access.',
                'icon_path' => 'storage/facilities/executive.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

            [
                'name' => 'Kamar Deluxe',
                'name_en' => 'Deluxe Room',
                'description' => 'Kamar luas dengan desain modern yang dilengkapi tempat tidur King/Twin, Wi-Fi gratis, dan pemandangan kota.',
                'description_en' => 'Spacious modern room featuring King/Twin bedding, complimentary Wi-Fi, and a stunning city view.',
                'icon_path' => 'storage/facilities/deluxe.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

            [
                'name' => 'Cub Club',
                'name_en' => 'Kids Club',
                'description' => 'Area bermain anak yang aman dan menyenangkan.',
                'description_en' => 'Safe and fun play area for children.',
                'icon_path' => 'storage/facilities/kids.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

            [
                'name' => 'Ruang Sudut',
                'name_en' => 'Corner Lounge',
                'description' => 'Area lounge rooftop dengan pemandangan panorama kota, kursi berjemur, serta minuman segar di tepi kolam.',
                'description_en' => 'Rooftop lounge area with panoramic city views, sun loungers, and refreshing drinks poolside.',
                'icon_path' => 'storage/facilities/lounge.jpeg',
                'is_active' => true,
                'show_description' => true,
                'created_at' => now(), 'updated_at' => now()
            ],

        ]);

    }
}
