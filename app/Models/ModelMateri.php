<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMateri extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'materi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul',
        'slug',
        // 'id_mapel',
        'id_guru',
        'id_kelas',
        'deskripsi',
        'isi_materi',
        'link_youtube',
        'status',
    ];

    // Validation
    protected $validationRules      = [
        "judul" => "required|max_length[120]|min_length[3]|is_unique[materi.judul]",
        "id_kelas" => "required|is_natural_no_zero",
        "id_guru" => "required|is_natural_no_zero",
        'deskripsi' => 'permit_empty|min_length[3]|max_length[255]',
        'isi_materi' => 'required',
        'link_youtube' => 'permit_empty',
        'status' => 'required',
    ];
    protected $validationMessages   = [
        "judul" => [
            'required'              => 'Judul materi harus diisi.',
            'max_length'            => 'Judul materi hanya boleh berisi maksimal 50 karakter.',
            'min_length'            => 'Deskripsi materi harus berisi minimal 3 karakter.',
            'is_unique'             => 'Judul materi sudah terdaftar.',
        ],
        'id_kelas' => [
            'required'              => 'Kelas harus dipilih.',
            'is_natural_no_zero'    => 'Nama kelas tidak valid.',
        ],
        'id_guru' => [
            'required'              => 'Guru harus dipilih.',
            'is_natural_no_zero'    => 'Nama guru tidak valid.',
        ],
        'deskripsi' => [
            'permit_empty'          => 'Deskripsi materi tidak boleh kosong.',
            'min_length'            => 'Deskripsi materi harus berisi minimal 3 karakter.',
        ],
        'isi_materi' => [
            'required'              => 'Isi materi harus diisi.',
        ],
        'link_youtube' => [
            'permit_empty'          => 'Link youtube tidak boleh kosong.',
        ],
        'status' => [
            'required'              => 'Status materi harus dipilih.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ngambil semua data dari materi
     */
    public function getMateri($nama_materi = null, $id_materi = null)
    {
        if ($nama_materi == null && $id_materi == null) {
            $materi = $this->findAll();
        } else {
            $materi = $this->where('nama', $nama_materi)->orWhere('id', $id_materi)->first();
        }

        return $materi;
    }

    /**
     * Ngambil semua value enum
     */
    public function getEnumValues($table = 'materi', $field = 'status')
    {
        $enum = (array) $this->db->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'")->getFirstRow();
        // dd($enum);
        preg_match("/^enum\(\'(.*)\'\)$/", $enum['Type'], $matches);
        $enum = explode("','", $matches[1]);


        return $enum;
    }
}
