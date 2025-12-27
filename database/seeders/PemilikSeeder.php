<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Faker\Factory as Faker;        

class PemilikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        $faker = Faker::create('id_ID');

        $total_kelompok = 1000;
        $data_per_kelompok = 1000;
        for ($i = 0; $i < $total_kelompok; $i++) {
            $data = [];
            
            for ($j = 0; $j < $data_per_kelompok; $j++) {
                $generateEmailUnik = "pemilik_{$i}_{$j}@test.com";
                $data[] = [
                    'nama_lengkap'=> $faker->name(),
                    'alamat'=> $faker->address(),
                    'nomor_telepon'=> $faker->phoneNumber(),
                    'email'=> $generateEmailUnik,
                ];
            }

            // Masukkan 1.000 data sekaligus (Bulk Insert)
            // Jauh lebih cepat daripada create() satu per satu
            DB::table('tb_pemilik')->insert($data);
            
            // Opsional: Tampilkan progres di terminal agar tidak bosan menunggu
            echo "Kelompok ke-" . ($i+1) . " berhasil diinput.\n";
        }
    }
}
