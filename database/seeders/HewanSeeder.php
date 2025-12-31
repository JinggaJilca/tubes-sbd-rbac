<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class HewanSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk tabel tb_hewan.
     */
    public function run(): void
    {
        // 1. Persiapan (Mencegah memory limit dan memuat Faker)
        ini_set('memory_limit', '-1');
        $faker = Faker::create('id_ID');

        // 2. Konfigurasi Batch Insert (Untuk Kecepatan)
        $total_data = 50000;
        $data_per_batch = 2000;
        $total_batch = ceil($total_data / $data_per_batch);

        // 3. Ambil Data Pendukung (Untuk Foreign Key)
        $minPemilikId = DB::table('tb_pemilik')->min('id_pemilik');
        $maxPemilikId = DB::table('tb_pemilik')->max('id_pemilik');

        if (!$minPemilikId || !$maxPemilikId) {
            $this->command->error('Tabel tb_pemilik kosong! Jalankan PemilikSeeder terlebih dahulu.');
            return;
        }
        
        $this->command->info("Memulai seeding $total_data data hewan...");

        // 4. Loop Utama (Per Batch)
        for ($i = 0; $i < $total_batch; $i++) {
            $data_batch = [];
            
            // Loop Internal (Mengisi array batch)
            for ($j = 0; $j < $data_per_batch; $j++) {
                // Cek agar tidak melebihi total data jika batch terakhir tidak penuh
                if (($i * $data_per_batch + $j) >= $total_data) break;

                // Variasi Data Hewan
                $jenisKelamin = $faker->randomElement(['Jantan', 'Betina']);
                
                // Daftar ras hewan (campuran kucing dan anjing umum)
                // Daftar ras hewan yang diperbanyak
                $rasList = [
                    // --- KUCING (CATS) ---
                    'Kucing Persia (Persian)',
                    'Kucing Anggora (Turkish Angora)',
                    'Kucing Kampung (Domestik Short Hair)',
                    'Kucing Siam (Siamese)',
                    'Kucing Maine Coon',
                    'Kucing Ragdoll',
                    'Kucing British Shorthair',
                    'Kucing Scottish Fold',
                    'Kucing Sphynx (Tanpa Bulu)',
                    'Kucing Bengal',
                    'Kucing Abyssinian',
                    'Kucing Birman',
                    'Kucing Russian Blue',
                    'Kucing Munchkin (Kaki Pendek)',
                    'Kucing Himalaya',
                    'Kucing American Shorthair',

                    // --- ANJING (DOGS) ---
                    // Ras Besar & Sedang
                    'Anjing Golden Retriever',
                    'Anjing Labrador Retriever',
                    'Anjing German Shepherd (Herder)',
                    'Anjing Siberian Husky',
                    'Anjing Alaskan Malamute',
                    'Anjing Bulldog (English Bulldog)',
                    'Anjing Rottweiler',
                    'Anjing Doberman Pinscher',
                    'Anjing Boxer',
                    'Anjing Great Dane',
                    // Ras Kecil & Toy
                    'Anjing Poodle (Toy/Miniature)',
                    'Anjing Chihuahua',
                    'Anjing Pomeranian (Pom)',
                    'Anjing Shih Tzu',
                    'Anjing Pug',
                    'Anjing Beagle',
                    'Anjing Dachshund (Anjing Sosis)',
                    'Anjing Yorkshire Terrier',
                    'Anjing Maltese',
                    'Anjing French Bulldog',
                    'Anjing Corgi (Welsh Corgi)',
                    'Anjing Kintamani (Lokal Bali)',

                    // --- KELINCI (RABBITS) ---
                    'Kelinci Lokal (Jawa)',
                    'Kelinci Anggora',
                    'Kelinci Rex',
                    'Kelinci Flemish Giant',
                    'Kelinci Holland Lop (Telinga Turun)',
                    'Kelinci Netherland Dwarf',
                    'Kelinci Lionhead',

                    // --- HAMSTER & RODENTS ---
                    'Hamster Campbell',
                    'Hamster Syrian',
                    'Hamster Winter White',
                    'Hamster Roborovski',
                    'Marmut (Guinea Pig)',
                    'Tupai Terbang (Sugar Glider)',

                    // --- LAINNYA (EXOTIC/BIRDS) ---
                    'Kura-kura Brazil (Red-Eared Slider)',
                    'Kura-kura Darat (Tortoise)',
                    'Iguana Hijau',
                    'Burung Lovebird',
                    'Burung Kenari',
                    'Burung Kakatua',
                    'Landak Mini (Hedgehog)',
                ];

                $data_batch[] = [
                    // Ambil ID pemilik secara acak dari rentang yang ada
                    'id_pemilik'      => $faker->numberBetween($minPemilikId, $maxPemilikId),
                    
                    // Nama hewan acak (menggunakan first name manusia sebagai nama hewan)
                    'nama_hewan'      => $faker->firstName($jenisKelamin == 'Jantan' ? 'male' : 'female'),
                    
                    'jenis_kelamin'   => $jenisKelamin,
                    
                    // Tahun lahir antara 2010 sampai tahun ini
                    'tahun_kelahiran' => $faker->numberBetween(2010, (int)date('Y')),
                    
                    'ras_hewan'       => $faker->randomElement($rasList),
                    
                    // Berat hewan acak antara 0.5 kg sampai 25.0 kg dengan 2 desimal
                    'berat_hewan'     => $faker->randomFloat(2, 0.5, 25.0),
                ];
            }

            // 5. Eksekusi Bulk Insert per Batch
            DB::table('tb_hewan')->insert($data_batch);
            
            // Tampilkan progres di terminal
            $processed = min(($i + 1) * $data_per_batch, $total_data);
            $this->command->info("Batch " . ($i + 1) . "/$total_batch berhasil. Total: $processed data.");
        }

        $this->command->info("SELESAI! Berhasil membuat $total_data data hewan.");
    }
}