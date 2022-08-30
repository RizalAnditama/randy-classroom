<?php

namespace App\Database\Seeds;

use App\Models\ModelMapel;
use CodeIgniter\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run()
    {

        $mapel = new ModelMapel();
        $BINDO = $mapel->where('nama', 'bahasa indonesia')->get()->getRowArray()['id'];
        $BING = $mapel->where('nama', 'bahasa inggris')->get()->getRowArray()['id'];
        $MTK = $mapel->where('nama', 'matematika')->get()->getRowArray()['id'];
        $CODEWEB = $mapel->where('nama', 'pemrograman web')->get()->getRowArray()['id'];
        $ISLAM = $mapel->where('nama', 'pelajaran agama islam')->get()->getRowArray()['id'];
        $BASIS = $mapel->where('nama', 'basis data')->get()->getRowArray()['id'];
        $JEPANG = $mapel->where('nama', 'bahasa jepang')->get()->getRowArray()['id'];
        $PKWU = $mapel->where('nama', 'prakarya dan kewirausahaan')->get()->getRowArray()['id'];
        $PJOK = $mapel->where('nama', 'pendidikan jasmani olahraga dan kesehatan')->get()->getRowArray()['id'];
        $PBO = $mapel->where('nama', 'pemrograman berorientasi objek')->get()->getRowArray()['id'];

        $guru = [
            [
                'nama' => 'Samsudin, S.Pd',
                'email' => 'samsudin@gmail.com',
                'id_mapel' => $BINDO,
            ],
            [
                'nama' => 'Drs. Asep Taufik Hidayat, M.Pd',
                'email' => 'asep@gmail.com',
                'id_mapel' => $BING,
            ],
            [
                'nama' => 'Eko Sri H, M.M',
                'email' => 'eko@gmail.com',
                'id_mapel' => $MTK,
            ],
            [
                'nama' => 'Sinung Kalimo Nugroho, S.Pd',
                'email' => 'sinung@gmail.com',
                'id_mapel' => $CODEWEB,
            ],
            [
                'nama' => 'Ani Rusyani, M.Pd.I',
                'email' => 'ani@gmail.com',
                'id_mapel' => $ISLAM,
            ],
            [
                'nama' => 'Irwan Saputra, S.Kom',
                'email' => 'irwan@gmail.com',
                'id_mapel' => $BASIS,
            ],
            [
                'nama' => 'Miki Tanuwijaya, S.S',
                'email' => 'miki@gmail.com',
                'id_mapel' => $JEPANG,
            ],
            [
                'nama' => 'Yenny Andrini, S.Kom',
                'email' => 'yenny@gmail.com',
                'id_mapel' => $PKWU,
            ],
            [
                'nama' => 'Yoga Nugraha, S.Pd',
                'email' => 'yoga@gmail.com',
                'id_mapel' => $PJOK,
            ],
            [
                'nama' => 'Melyanah, S.Pd',
                'email' => 'melyanah@gmail.com',
                'id_mapel' => $PBO,
            ],
        ];

        foreach ($guru as $data) {
            $this->db->table('guru')->insert($data);
        }
    }
}
