<?php

namespace App\Database\Seeds;

use App\Models\ModelGuru;
use App\Models\ModelKelas;
use CodeIgniter\Database\Seeder;

class MateriSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        $faker->addProvider(new \Faker\Provider\Book($faker));
        $faker->addProvider(new \Faker\Provider\Lorem($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));
        $jumlah_blog = 30;

        $modelGuru = new ModelGuru();
        $modelKelas = new ModelKelas();

        for ($i = 0; $i < $jumlah_blog; $i++) {
            $judul = $faker->title();
            $guru = $faker->randomElements([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
            $kelas = $faker->randomElements([1, 2, 3]);

            $slug_kelas = url_title($modelKelas->getKelas(null, $kelas)['nama'], '-', true);
            $slug_guru = url_title($modelGuru->sanitizeGuru($modelGuru->getGuru(null, $guru)['nama'], null), '-', true);

            $slug = '/' . 'materi' . '/' . $slug_kelas . '/' . $slug_guru . '/' . url_title($judul, '-', true);
            // $slug = substr(preg_replace("/[^a-zA-Z]+/", "", hash('md5', microtime(), false)), 0, 10);
            // $slug = substr(hash('md5', microtime(), false), 0, 10);
            // $slug = url_title($judul, '-', true);
            // $slug = $faker->slug(3, false);
            // $mapel = $faker->randomElements([1, 2, 3, 4, 5]);
            // $guru = $this->db->table('guru')->where('id_mapel', $mapel)->get()->getRowArray()['nama'];
            $deskripsi = substr($faker->text(), 0, 30);
            $isi = $faker->text();
            $status = $faker->randomElements(['draft', 'published']);

            $data = [
                'judul'         => $judul,
                'slug'          => $slug,
                // 'id_mapel'   => $mapel,
                'id_guru'       => $guru,
                'id_kelas'      => $kelas,
                'deskripsi'     => $deskripsi,
                'isi_materi'    => $isi,
                'link_youtube'  => 'https://www.youtube.com/embed/' . $faker->lexify('????????????'),
                'status' => 'published',
            ];
            $this->db->table('materi')->insert($data);
        }
    }
}
