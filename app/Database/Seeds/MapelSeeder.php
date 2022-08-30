<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run()
    {
        $mapel = [
            [
                'nama' => 'bahasa indonesia',
            ],
            [
                'nama' => 'bahasa inggris',
            ],
            [
                'nama' => 'matematika',
            ],
            [
                'nama' => 'pemrograman web',
            ],
            [
                'nama' => 'pelajaran agama islam',
            ],
            [
                'nama' => 'basis data',
            ],
            [
                'nama' => 'bahasa jepang',
            ],
            [
                'nama' => 'prakarya dan kewirausahaan',
            ],
            [
                'nama' => 'pendidikan jasmani olahraga dan kesehatan',
            ],
            [
                'nama' => 'pemrograman berorientasi objek',
            ],
        ];

        foreach ($mapel as $data) {
            $this->db->table('mapel')->insert($data);
        }
    }
}
