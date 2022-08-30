<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMapel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'mapel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public $daftar_mapel = [
        'bahasa' => 'bahasa ',
        'underscore' => ' ',
        'p a' => 'pelajaran agama ',
        'pai' => 'pelajaran agama islam',
        'pak' => 'pelajaran agama kristen',
        'pbo' => 'pemrograman berorientasi objek',
        'pkwu' => 'prakarya dan kewirausahaan',
        'kwh' => 'prakarya dan kewirausahaan',
        'pjok' => 'pendidikan jasmani olahraga dan kesehatan',
        'penjaskes' => 'pendidikan jasmani olahraga dan kesehatan',
        'penjas' => 'pendidikan jasmani olahraga dan kesehatan',
        'penjasorkes' => 'pendidikan jasmani olahraga dan kesehatan',
        'pkn' => 'pendidikan kewarganegaraan',
    ];

    /**
     * Hapus semua underscore dan perbaikan nama mapel
     */
    public function sanitizeMapel($nama = null, $id_mapel = null)
    {
        $replace = [
            'key' => [
                'bahasa' => 'b_',
                'underscore' => '_',
                'p a' => 'p a',
                'pai' => 'pai',
                'pak' => 'pak',
                'pbo' => 'pbo',
                'pkwu' => 'pkwu',
                'kwh' => 'kwh',
                'pjok' => 'pjok',
                'penjaskes' => 'penjaskes',
                'penjas' => 'penjas',
                'penjasorkes' => 'penjasorkes',
                'mtk' => 'mtk',
                'pkn' => 'pkn',
            ],
            'value' => [
                'bahasa' => 'bahasa ',
                'underscore' => ' ',
                'p a' => 'pelajaran agama ',
                'pai' => 'pelajaran agama islam',
                'pak' => 'pelajaran agama kristen',
                'pbo' => 'pemrograman berorientasi objek',
                'pkwu' => 'prakarya dan kewirausahaan',
                'kwh' => 'prakarya dan kewirausahaan',
                'pjok' => 'pendidikan jasmani olahraga dan kesehatan',
                'penjaskes' => 'pendidikan jasmani olahraga dan kesehatan',
                'penjas' => 'pendidikan jasmani olahraga dan kesehatan',
                'penjasorkes' => 'pendidikan jasmani olahraga dan kesehatan',
                'mtk' => 'matematika',
                'pkn' => 'pendidikan kewarganegaraan',
            ]
        ];

        if (!isset($nama) && !isset($id_mapel)) {
            $mapel = $this->findAll();
            foreach ($mapel as &$value) {
                $value['nama'] = strtolower($value['nama']);
            }
            unset($value);
            foreach ($mapel as &$value) {
                $value['nama'] = str_replace($replace['key'], $replace['value'], $value['nama']);
            }
            unset($value);
        }

        if (isset($id_mapel)) {
            $nama = $this->like('id', $id_mapel)->first()['nama'];

            $mapel = strtolower($nama);

            $mapel = str_replace($replace['key'], $replace['value'], $mapel);
        }

        if (isset($nama)) {
            $mapel = strtolower($nama);

            $mapel = str_replace($replace['key'], $replace['value'], $mapel);
        }
        return $mapel;
    }
}
