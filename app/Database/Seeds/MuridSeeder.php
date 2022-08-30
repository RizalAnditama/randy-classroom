<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MuridSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $jumlah_anak = 50;

        $x = ($faker->randomElements([1, 3]));
        $xi = ($faker->randomElements([2, 4]));
        $xii = 5;

        $no = 1;

        for ($i = 0; $i < $jumlah_anak; $i++) {
            $nama = $faker->firstName . ' ' . $faker->lastName;
            $id_kelas = ($faker->randomElements([1, 2, 3]));

            $random_num = str_replace('+', '0', $faker->e164PhoneNumber);
            $nis = $no++;
            $nisn = substr($random_num, 0, 7);

            $data = [
                'nama' => $nama,
                'nis' => $nis,
                'nisn' => $nisn,
                'id_kelas' => $id_kelas,
            ];

            $this->db->table('murid')->insert($data);
        }
    }
}
