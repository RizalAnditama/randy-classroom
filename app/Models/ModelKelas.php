<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKelas extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'id_walikelas'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ngambil semua data dari kelas
     */
    public function getKelas($nama_kelas = null, $id_kelas = null)
    {
        if ($nama_kelas === null && $id_kelas === null) {
            $kelas = $this->findAll();
        } else {
            $kelas = $this->where('nama', $nama_kelas)->orWhere('id', $id_kelas)->first();
        }

        return $kelas;
    }

    /**
     * Convert semua angka romawi di nama kelas jadi angka arab
     */
    public function convertClass($nama_kelas)
    {
        $replace = [
            'key' => [
                'X' => '10',
                'XI' => '11',
                'XII' => '12',
            ],
            'value' => [
                'X' => 'X',
                'XI' => 'XI',
                'XII' => 'XII',
            ]
        ];
        return str_replace($replace['key'], $replace['value'], $nama_kelas);
    }

    /**
     * Invert angka arab ke romawi
     */
    public function invertClass($nama_kelas)
    {
        $replace = [
            'key' => [
                'XII',
                'XI',
                'X',
            ],
            'value' => [
                '12',
                '11',
                '10',
            ]
        ];
        return str_replace($replace['key'], $replace['value'], $nama_kelas);
    }
}
