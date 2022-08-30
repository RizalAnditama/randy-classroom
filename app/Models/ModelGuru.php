<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGuru extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guru';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'email',
        'id_mapel',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ngambil semua data dari guru
     * @return array
     */
    public function getGuru($nama_guru = null, $id_guru = null)
    {
        if ($nama_guru === null && $id_guru === null) {
            $guru = $this->findAll();
        } else {
            $guru = $this->where('nama', $nama_guru)->orWhere('id', $id_guru)->first();
        }

        return $guru;
    }

    /**
     * Hapus semua gelar dan jurusan dari nama guru
     */
    public function sanitizeGuru(string | array $nama = null, string | array $id_guru = null)
    {
        $replace = [
            'key' => [
                'Drs. ' => 'Drs. ',
                ', M.M' => ', M.M',
                ', S.Pd' => ', S.Pd',
                ', M.Pd' => ', M.Pd',
                'H,' => 'H,',
                '.I' => '.I',
                ', S.Kom' => ', S.Kom',
                ', S.S' => ', S.S',
            ],
        ];

        if (!isset($nama) && !isset($id_guru)) {
            $guru = $this->findAll();

            foreach ($guru as &$value) {
                $value['nama'] = str_replace($replace['key'], '', $value['nama']);
            }
            unset($value);
        }

        if (is_array($nama) || is_array($id_guru)) { //! Not working yet
            if (isset($nama)) {
                $guru = $nama;
            }

            if (isset($id_guru)) {
                $guru = $this->where('id', $id_guru)->get()->getResultArray()['nama'];
            }

            foreach ($guru as &$value) {
                $value['nama'] = str_replace($replace['key'], '', $value['nama']);
            }
            unset($value);
        }

        if (isset($id_guru)) {
            $nama = $this->where('id', $id_guru)->first()['nama'];
            $guru = str_replace($replace['key'], '', $nama);
        }

        if (isset($nama)) {
            $guru = str_replace($replace['key'], '', $nama);
        }

        return $guru;
    }
}
