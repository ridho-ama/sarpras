<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryAndFacilitySeeder extends Seeder
{
    public function run(): void
    {
        // 1. DATA MASTER 5 KATEGORI UTAMA SINKRON SESUAI STRUKTUR PERMINTAAN ANDA
        $categories = [
            [
                'id' => 1,
                'name_category' => 'Bangunan Pembelajaran',
                'description_category' => 'Fasilitas gedung utama yang digunakan untuk kegiatan belajar mengajar teoritis dan praktis siswa.',
                'image_category' => 'pembelajaran.jpg'
            ],
            [
                'id' => 2,
                'name_category' => 'B. Administrasi & Manajemen',
                'description_category' => 'Ruang operasional kerja fungsional bagi kepala sekolah, jajaran wakil, tata usaha, dan guru.',
                'image_category' => 'administrasi.jpg'
            ],
            [
                'id' => 3,
                'name_category' => 'Penunjang Kesehatan & Kesejahteraan',
                'description_category' => 'Fasilitas pendukung untuk menjaga kesehatan fisik, mental, gizi, dan kebutuhan harian siswa.',
                'image_category' => 'kesehatan.jpg'
            ],
            [
                'id' => 4,
                'name_category' => 'B. Peribadahan & Kebudayaan',
                'description_category' => 'Gedung dan sarana ibadah, pengembangan literasi membaca, serta ruang pelestarian kesenian.',
                'image_category' => 'peribadahan.jpg'
            ],
            [
                'id' => 5,
                'name_category' => 'Olahraga & Terbuka',
                'description_category' => 'Sarana lapangan olahraga outdoor/indoor, koridor jalan, serta ruang logistik inventaris barang.',
                'image_category' => 'olahraga.jpg'
            ]
        ];

        DB::table('categories')->insert($categories);

        // 2. DATA MASTER SUB-KATEGORI RUANGAN DEFAULT KOSONGKAN JIKA INGIN DIINPUT MANUAL NANTI
        $facilities = [
            // Kategori 1: Bangunan Pembelajaran
            ['category_id' => 1, 'name_facility' => 'R KELAS', 'location' => 'Gedung Teori Lt. 1-3'],
            ['category_id' => 1, 'name_facility' => 'PERPUSTAKAAN', 'location' => 'Gedung Utama Lt. 2'],
            ['category_id' => 1, 'name_facility' => 'LAB', 'location' => 'Gedung Komputer Lantai Dasar'],
            ['category_id' => 1, 'name_facility' => 'STUDIO', 'location' => 'Gedung Multimedia Lt. 2'],
            ['category_id' => 1, 'name_facility' => 'TEFA', 'location' => 'Bengkel Teaching Factory'],

            // Kategori 2: B. Administrasi & Manajemen
            ['category_id' => 2, 'name_facility' => 'R. KEPALA SEKOLAH', 'location' => 'Gedung Admin Lt. 1'],
            ['category_id' => 2, 'name_facility' => 'R. WAKIL', 'location' => 'Gedung Admin Lt. 1'],
            ['category_id' => 2, 'name_facility' => 'R. GURU', 'location' => 'Gedung Utama Utama Lt. 1'],
            ['category_id' => 2, 'name_facility' => 'TU', 'location' => 'Loket Depan Gedung Administrasi'],
            ['category_id' => 2, 'name_facility' => 'BENDAHARA', 'location' => 'Ruang Dalam Tata Usaha'],

            // Kategori 3: Penunjang Kesehatan & Kesejahteraan
            ['category_id' => 3, 'name_facility' => 'RUANG UKS', 'location' => 'Samping Lapangan Basket'],
            ['category_id' => 3, 'name_facility' => 'RUANG BK', 'location' => 'Gedung Utama Sayap Kiri'],
            ['category_id' => 3, 'name_facility' => 'KANTIN', 'location' => 'Area Belakang Sekolah'],
            ['category_id' => 3, 'name_facility' => 'KAMAR MANDI/TOILET', 'location' => 'Setiap Sudut Lorong Gedung'],
            ['category_id' => 3, 'name_facility' => 'KOPERASI SEKOLAH', 'location' => 'Samping Ruang Tata Usaha'],

            // Kategori 4: B. Peribadahan & Kebudayaan
            ['category_id' => 4, 'name_facility' => 'MUSHOLA/MASJID', 'location' => 'Area Depan Sayap Kanan'],
            ['category_id' => 4, 'name_facility' => 'R. AULA', 'location' => 'Gedung Serbaguna Lt. 2'],
            ['category_id' => 4, 'name_facility' => 'R. LITERASI', 'location' => 'Samping Perpustakaan Pusat'],
            ['category_id' => 4, 'name_facility' => 'R. KESENIAN', 'location' => 'Gedung Budaya Lantai Dasar'],

            // Kategori 5: Olahraga & Terbuka
            ['category_id' => 5, 'name_facility' => 'GOR', 'location' => 'Gedung Olahraga Indoor'],
            ['category_id' => 5, 'name_facility' => 'LAPANGAN', 'location' => 'Area Terbuka Tengah Sekolah'],
            ['category_id' => 5, 'name_facility' => 'GUDANG OLAHRAGA', 'location' => 'Samping Ruang GOR'],
            ['category_id' => 5, 'name_facility' => 'GUDANG SEKETARIAT', 'location' => 'Belakang Ruang OSIS'],
            ['category_id' => 5, 'name_facility' => 'KORIDOR', 'location' => 'Selasar Penghubung Antar Gedung']
        ];

        foreach ($facilities as &$facility) {
            $facility['condition'] = 'Baik';
            $facility['created_at'] = now();
            $facility['updated_at'] = now();
        }

        DB::table('facilities')->insert($facilities);
    }
}
