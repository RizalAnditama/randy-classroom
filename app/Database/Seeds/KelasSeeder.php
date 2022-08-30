<?php

namespace App\Database\Seeds;

use App\Models\ModelGuru;
use CodeIgniter\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $guru = new ModelGuru();
        $kelas = [
            [
                'nama' => 'X RPL',
                // 'id_walikelas' => $guru->where('nama', 'Eko Sri H, M.M')->get()->getRowArray()['id'],
            ],
            [
                'nama' => 'XI RPL',
                // 'id_walikelas' => $guru->where('nama', 'Sinung Kalimo Nugroho, S.Pd')->get()->getRowArray()['id'],
            ],
            [
                'nama' => 'XII RPL',
                // 'id_walikelas' => $guru->where('nama', 'Ani Rusyani, M.Pd.I')->get()->getRowArray()['id'],
            ],
        ];

        foreach ($kelas as $data) {
            $this->db->table('kelas')->insert($data);
        }
    }
}
