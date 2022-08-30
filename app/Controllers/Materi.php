<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelGuru;
use App\Models\ModelKelas;
use App\Models\ModelMapel;
use App\Models\ModelMateri;
use CodeIgniter\Exceptions\PageNotFoundException;

class Materi extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function landing()
    {
        $data = [
            'title' => 'Randy Education',
        ];
        return view('pages/landing', $data);
    }

    public function admin()
    {
        $model = new ModelMateri();
        $mapel = new ModelMapel();
        $guru = new ModelGuru();

        $data_guru = $guru->like('email', session()->get('user_email'))->first();

        $data = [
            'title' => 'Classroom',
            'subtitle' => 'Admin',
            'materis' => $model->where('id_guru', $data_guru['id'])->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('pages/admin', $data);
    }

    public function home()
    {
        $model = new ModelMateri();
        $modelGuru = new ModelGuru();
        $modelKelas = new ModelKelas();
        $modelMapel = new ModelMapel();

        $data_guru = $modelGuru->like('email', session()->get('user_email'))->first();

        if (!$data_guru) {
            $materis = $model->where('status', 'published')->orderBy('created_at', 'DESC')->findAll();
        } else {
            $materis = $model->where('id_guru', $data_guru['id'])->orderBy('created_at', 'DESC')->findAll();
        }

        $daftar_kelas = $modelKelas->findAll();
        foreach ($daftar_kelas as &$daftar) {
            $daftar = $daftar['nama'];
        }
        unset($daftar);

        //! Function ini beda dengan function home di method viewBlog()
        $listGuru = [];
        foreach ($materis as $materi) {
            $listGuru[] = $modelGuru->find($materi['id_guru']);
        }
        unset($materi);

        $listIdGuru = [];
        foreach ($listGuru as $guru) {
            $listIdGuru[] = $guru['id'];
        }
        unset($guru);
        $listIdGuru = array_unique($listIdGuru);

        $listGuru = $model->findUnique($listGuru, 'nama');
        $listLinkGuru = [];
        $current_url = current_url();
        $current_url = explode('/', $current_url);

        foreach ($listGuru as $guru) {
            $listLinkGuru[] = base_url() . '/search?materi=' . url_title($modelGuru->sanitizeGuru($guru), '+', true);
        }
        unset($guru);

        $listMapel = [];
        foreach ($listIdGuru as $id_guru) {
            $listMapel[] = $modelMapel->find($id_guru);
        }

        $listGuru = compact('listGuru', 'listIdGuru', 'listLinkGuru');

        $data = [
            'title' => 'Materi',
            'materis' => $materis,
            'daftar_kelas' => $daftar_kelas,
            'list_guru' => $listGuru,
            'list_mapel' => $listMapel,
            'current_url' => $current_url,
        ];

        return view('pages/materi', $data);
    }

    public function tambah()
    {
        $model = new ModelMateri();
        $guru = new ModelGuru();
        $kelas = new ModelKelas();
        $mapel = new ModelMapel();

        $data_guru = $guru->like('email', session()->get('user_email'))->first();
        $id_guru = $data_guru['id'];
        $nama_guru = $data_guru['nama'];

        $data_mapel = $mapel->where('id', $data_guru['id_mapel'])->first();
        $nama_mapel = $data_mapel['nama'];
        $id_mapel = $data_mapel['id'];

        $data = [
            'title' => 'Materi',
            'subtitle' => 'Tambah',
            'materi' => $model->findAll(),
            'id_mapel_pre' => $id_mapel,
            'nama_mapel_pre' => $nama_mapel,
            'id_guru_pre' => $id_guru,
            'nama_guru_pre' => $nama_guru,
        ];

        if ($this->request->getMethod() == 'post') {
            $data = [
                'title' => 'Tambah',
                'judul' => $this->request->getVar('judul'),
                'deskripsi' => $this->request->getVar('deskripsi'),
                'id_guru' => $this->request->getVar('id_guru'),
                'id_kelas' => $this->request->getVar('id_kelas'),
                'isi_materi' => $this->request->getVar('isi_materi'),
                'link_youtube' => $this->request->getVar('link_youtube'),
                'status' => $this->request->getVar('status'),
            ];

            if ($this->request->getVar('id_guru') === null && $this->request->getVar('id_kelas') === null) {
                if ($model->insert($data) !== true) {
                    $data['error'] = $model->errors();
                }
                $data['error']['id_guru'] = 'Nama guru tidak boleh kosong';
                $data['error']['id_kelas'] = 'Nama kelas tidak boleh kosong';
                return view('pages/tambah', $data);
            }

            if ($this->request->getVar('id_guru') === null) {
                if ($model->insert($data) !== true) {
                    $data['error'] = $model->errors();
                }
                $data['error']['id_guru'] = 'Nama guru tidak boleh kosong';
                return view('pages/tambah', $data);
            }

            if ($this->request->getVar('id_kelas') === null) {
                if ($model->insert($data) !== true) {
                    $data['error'] = $model->errors();
                }
                $data['error']['id_kelas'] = 'Nama kelas tidak boleh kosong';
                return view('pages/tambah', $data);
            }

            $nama_guru = $guru->getGuru(null, $this->request->getVar('id_guru'))['nama'];
            $kelas = $guru->db->table('kelas')->where('id', $this->request->getVar('id_kelas'))->get()->getRowArray()['nama'];

            $slug = '/materi/' . url_title($kelas, '-', true) . '/' . url_title($guru->sanitizeGuru($nama_guru), '-', true) . '/' . url_title($this->request->getVar('judul'), '-', true);

            $slug_youtube = explode('/', $this->request->getVar('link_youtube'));
            $slug_youtube = end($slug_youtube);
            $slug_youtube = str_replace('watch?v=', '', $slug_youtube);

            $data['id_kelas'] = $this->request->getVar('id_kelas');
            $data['id_guru'] = $this->request->getVar('id_guru');
            $data['slug'] = $slug;
            $data['link_youtube'] = '';
            if ($this->request->getVar('link_youtube') !==  '') {
                $data['link_youtube'] = 'https://www.youtube.com/embed/' . $slug_youtube;
            }

            $insert = $model->insert($data);
            if ($insert === false) {
                $data['error'] = $model->errors();
                return view('pages/tambah', $data);
            }

            return redirect()->to('admin');
        }
        return view('pages/tambah', $data);
    }

    public function edit(string $slug_kelas = null, string $slug_guru = null, string $id_materi = null)
    {
        $model = new ModelMateri();
        $mapel = new ModelMapel();
        $guru = new ModelGuru();

        // $slug = $model->where('id', $id_materi)->first()['slug'];
        $slug_ini = '/' . $slug_kelas . '/' . $slug_guru . '/' . $id_materi;

        $data_guru = $guru->like('email', session()->get('user_email'))->first();
        $id_guru = $data_guru['id'];
        $nama_guru = $data_guru['nama'];

        $data_mapel = $mapel->where('id', $data_guru['id_mapel'])->first();
        $nama_mapel = $data_mapel['nama'];
        $id_mapel = $data_mapel['id'];

        $data = [
            'title' => 'Materi',
            'subtitle' => 'Edit',
            'materi' => $model->where('slug', '/materi' . $slug_ini)->first(),
            'slug' => $slug_ini,
            'id_mapel_pre' => $id_mapel,
            'nama_mapel_pre' => $nama_mapel,
            'id_guru_pre' => $id_guru,
            'nama_guru_pre' => $nama_guru,
        ];
        // dd($this->request->getVar());

        if ($this->request->getMethod() == 'post') {
            $nama_guru = $guru->getGuru(null, $this->request->getVar('id_guru'))['nama'];
            $kelas = $guru->db->table('kelas')->where('id', $this->request->getVar('id_kelas'))->get()->getRowArray()['nama'];

            $slug = '/materi/' . url_title($kelas, '-', true) . '/' . url_title($guru->sanitizeGuru($nama_guru), '-', true) . '/' . url_title($this->request->getVar('judul'), '-', true);

            $slug_youtube = explode('/', $this->request->getVar('link_youtube'));
            $slug_youtube = end($slug_youtube);
            $slug_youtube = str_replace('watch?v=', '', $slug_youtube);

            $data = [
                // 'slug' => substr(preg_replace("/[^a-zA-Z]+/", "", hash('md5', microtime(), false)), 0, 10),
                'materis' => $model->where('slug', $slug)->first(),
                'judul' => $this->request->getVar('judul'),
                'slug' => $slug,
                'deskripsi' => $this->request->getVar('deskripsi'),
                'id_guru' => $this->request->getVar('id_guru'),
                'id_kelas' => $this->request->getVar('id_kelas'),
                'isi_materi' => $this->request->getVar('isi_materi'),
                'link_youtube' => 'https://www.youtube.com/embed/' . $slug_youtube,
                'status' => $this->request->getVar('status'),
            ];

            $model->update($id_materi, $data);
            return redirect()->to('/admin');
        }

        if (!$data['materi']) {
            throw PageNotFoundException::forPageNotFound('Materi tidak ditemukan');
        }

        return view('pages/edit', $data);
    }

    /**
     * Untuk menampilkan blog berdasarkan link yang diberi
     */
    public function viewBlog(string $slug_kelas = null, string $slug_guru = null, string $slug_kode_blog = null)
    {
        $model = new ModelMateri();
        $modelGuru = new ModelGuru();
        $modelMapel = new ModelMapel();
        $modelKelas = new ModelKelas();

        $id_guru = null;

        $string = explode('-', $slug_kelas);
        if (count($string) < 2) {
            throw PageNotFoundException::forPageNotFound(`Materi tidak ditemukan`);
        }

        $daftar_kelas = $modelKelas->findAll();
        foreach ($daftar_kelas as &$daftar) {
            $daftar = $daftar['nama'];
        }
        unset($daftar);

        $kelas = $string[0];
        $jurusan = $string[1];

        $nama_kelas = $kelas . ' ' . $jurusan;
        $kelas = strtoupper($kelas . ' ' . $jurusan);

        if (isset($slug_kelas)) {
            $dataKelas = $model->db->table('kelas')->where('nama', $nama_kelas)->get()->getRowArray();
            if (!$dataKelas) {
                throw PageNotFoundException::forPageNotFound(`Materi di kelas {$nama_kelas} tidak ditemukan`);
            }
            $id_kelas = $dataKelas['id'];

            $materis = $model->where([
                'id_kelas' => $id_kelas,
                'status' => 'published'
            ])->orderBy('created_at', 'DESC')->findAll();
            $guru = $modelGuru->findUnique($materis, 'id_guru');

            foreach ($guru as &$gr) {
                $gr = $modelGuru->where('id', $gr)->first()['nama'];
                $gr = trim($modelGuru->sanitizeGuru($gr));
            }
            unset($value);
            $dataGuru = $guru;

            $dataSlug = $model->where('id_kelas', $id_kelas)->first();
            if (!$dataSlug) {
                throw PageNotFoundException::forPageNotFound(`Materi di kelas {$nama_kelas} tidak ditemukan`);
            }
            $slug = $dataSlug['slug'];

            $daftar_kelas = $modelKelas->findAll();
            foreach ($daftar_kelas as &$daftar) {
                $daftar = $daftar['nama'];
            }
            unset($daftar);

            $listGuru = [];
            foreach ($materis as $materi) {
                $listGuru[] = $modelGuru->find($materi['id_guru']);
            }
            unset($materi);

            $listIdGuru = [];
            foreach ($listGuru as $guru) {
                $listIdGuru[] = $guru['id'];
            }
            unset($guru);
            $listIdGuru = array_unique($listIdGuru);

            $listGuru = $model->findUnique($listGuru, 'nama');
            $listLinkGuru = [];
            $current_url = current_url();
            $current_url = explode('/', $current_url);
            foreach ($listGuru as $guru) {
                foreach ($daftar_kelas as $row => $nama_kelas) {
                    $nama_kelas = url_title($nama_kelas, '-', true);
                    if (in_array($nama_kelas, $current_url)) {
                        $listLinkGuru[] = base_url() . '/materi/' . $nama_kelas . '/' . url_title($modelGuru->sanitizeGuru($guru), '-', true);
                    } else {
                        $listLinkGuru[] = base_url() . '/search?materi=' . url_title($modelGuru->sanitizeGuru($guru), '+', true);
                    }
                    // delete every value of list link guru except the one that contain the nama kelas
                    // also delete the search url if it is the same as the current url
                    if (in_array($nama_kelas, $current_url)) {
                        $listLinkGuru = array_filter($listLinkGuru, function ($value) use ($nama_kelas) {
                            return strpos($value, $nama_kelas) !== false;
                        });
                    } else {
                        $listLinkGuru = array_filter($listLinkGuru, function ($value) {
                            return strpos($value, 'search') === false;
                        });
                    }
                }
            }
            unset($guru);

            $listLinkGuru = array_unique($listLinkGuru);

            $listMapel = [];
            foreach ($listIdGuru as $id_guru) {
                $listMapel[] = $modelMapel->find($id_guru);
            }

            // combine list guru, list id guru and list link guru into a new array called list guru
            // but use the array name as the key of the array
            $listGuru = compact('listGuru', 'listIdGuru', 'listLinkGuru');

            $data = [
                'title' => 'Materi',
                'subtitle' => $kelas,
                'materis' => $materis,
                'daftar_kelas' => $daftar_kelas,
                'kelas' => $kelas,
                'guru' => $dataGuru,
                'list_guru' => $listGuru,
                'list_mapel' => $listMapel,
                'current_url' => $current_url,
            ];
            session()->remove('mapel');
        }

        if (isset($slug_guru)) {
            $guru = explode('-', $slug_guru);
            $guru = $modelGuru->like('nama', $guru[0])->first();

            if (!$guru) {
                throw PageNotFoundException::forPageNotFound(`Materi di kelas {$nama_kelas} tidak ditemukan`);
            }
            // $nama_guru = ucwords(preg_replace('/-/', ' ', $slug_guru)); //* Alternatif

            $listGuru = [];
            foreach ($materis as $materi) {
                $listGuru[] = $modelGuru->find($materi['id_guru']);
            }
            unset($materi);

            $listIdGuru = [];
            foreach ($listGuru as $guru) {
                $listIdGuru[] = $guru['id'];
            }
            unset($guru);
            $listIdGuru = array_unique($listIdGuru);

            $listGuru = $model->findUnique($listGuru, 'nama');
            $listLinkGuru = [];
            $current_url = current_url();
            $current_url = explode('/', $current_url);
            foreach ($listGuru as $guru) {
                foreach ($daftar_kelas as $row => $nama_kelas) {
                    $nama_kelas = url_title($nama_kelas, '-', true);
                    if (in_array($nama_kelas, $current_url)) {
                        $listLinkGuru[] = base_url() . '/materi/' . $nama_kelas . '/' . url_title($modelGuru->sanitizeGuru($guru), '-', true);
                    } else {
                        $listLinkGuru[] = base_url() . '/search?materi=' . url_title($modelGuru->sanitizeGuru($guru), '+', true);
                    }
                    // delete every value of list link guru except the one that contain the nama kelas
                    // also delete the search url if it is the same as the current url
                    if (in_array($nama_kelas, $current_url)) {
                        $listLinkGuru = array_filter($listLinkGuru, function ($value) use ($nama_kelas) {
                            return strpos($value, $nama_kelas) !== false;
                        });
                    } else {
                        $listLinkGuru = array_filter($listLinkGuru, function ($value) {
                            return strpos($value, 'search') === false;
                        });
                    }
                }
            }
            unset($guru);

            $listLinkGuru = array_unique($listLinkGuru);

            $listMapel = [];
            foreach ($listIdGuru as $id_guru) {
                $listMapel[] = $modelMapel->find($id_guru);
            }

            // combine list guru, list id guru and list link guru into a new array called list guru
            // but use the array name as the key of the array
            $listGuru = compact('listGuru', 'listIdGuru', 'listLinkGuru');


            $guru = explode('-', $slug_guru);
            $guru = $modelGuru->like('nama', $guru[0])->first();
            $nama_guru = ucwords($modelGuru->sanitizeGuru($guru['nama']));
            $id_guru = $guru['id'];

            $kelas = explode('-', $slug_kelas);
            $kelas = $kelas[0] . ' ' . $kelas[1];
            $id_kelas = $model->db->table('kelas')->where('nama', $kelas)->get()->getRowArray()['id'];

            $nama_kelas = strtoupper($kelas);
            $id_mapel = $modelGuru->where('id', $id_guru)->first()['id_mapel'];

            $kelas = explode('-', $slug_kelas);
            $kelas = $kelas[0] . ' ' . $kelas[1];
            $nama_kelas = strtoupper($kelas);

            $mapel = ucwords($modelMapel->sanitizeMapel($modelMapel->where('id', $id_mapel)->first()['nama']));

            $materis = $model->where([
                'id_kelas' => $id_kelas,
                'id_guru' => $id_guru,
                'status' => 'published'
            ])->orderBy('created_at', 'DESC')->findAll();

            $data = [
                'title' => 'Materi',
                'subtitle' => $nama_kelas . ' | ' . $mapel,
                'materis' => $materis,
                'daftar_kelas' => $daftar_kelas,
                'kelas' => $nama_kelas,
                'link_guru' => base_url('search?materi=') . url_title($nama_guru, '+', true),
                'list_guru' => $listGuru,
                'list_mapel' => $listMapel,
                'current_url' => $current_url,
            ];

            session()->setFlashdata('guru', $guru['nama']);
            session()->setFlashdata('mapel', $mapel);
        }

        if (isset($slug_kode_blog)) {
            $guru = explode('-', $slug_guru);
            $guru = $modelGuru->like('nama', $guru[0])->first();

            $slug = '/' . 'materi' . '/' . $slug_kelas . '/' . $slug_guru . '/' . $slug_kode_blog;
            $materis = $model->where('slug', $slug)->first();
            $nama_guru = $modelGuru->sanitizeGuru($guru['nama']);
            if (!$materis) {
                throw PageNotFoundException::forPageNotFound(`Materi di kelas {$nama_kelas} tidak ditemukan`);
            }

            $materiCard = $model->where([
                'id_kelas' => $materis['id_kelas'],
                'id_guru' => $guru['id'],
                'status' => 'published'
            ])->orderBy('created_at', 'DESC')->findAll(10);

            $dt = strtotime($materis['created_at']);

            $data = [
                'title' => $materis['judul'],
                'subtitle' =>  strtoupper($kelas) . ' | ' . $nama_guru,
                'materis' => $materis,
                'materiCard' => $materiCard,
                'daftar_kelas' => $daftar_kelas,
                'kelas' => strtoupper($kelas),
                'link_guru' => base_url() . '/materi/' . url_title($kelas, '-', true) . '/' . url_title($nama_guru, '-', true),
                'guru' => $guru,
                'nama_mapel' => $modelMapel->sanitizeMapel($modelMapel->where('id', $guru['id_mapel'])->first()['nama']),
                'hari' => date('l', $dt),
                'tanggal' => date('d', $dt),
            ];

            return view('pages/blog', $data);
        }

        if (!$data['materis']) {
            throw PageNotFoundException::forPageNotFound(`Materi di kelas {$nama_kelas} tidak ditemukan`);
        }

        return view('pages/materi', $data);
    }

    public function hapus()
    {
        $materi = new ModelMateri();

        $materi->delete($this->request->getVar('id'));
        return redirect()->to('admin');
    }

    /**
     * Search materi by keyword
     */
    public function search()
    {
        $modelMateri = new ModelMateri();
        $kelas = new ModelKelas();
        $modelMapel = new ModelMapel();
        $modelGuru = new ModelGuru();
        $modelKelas = new ModelKelas();

        $id_kelas = null;
        $id_guru = null;
        $id_mapel = null;

        $search = $this->request->getVar('materi');
        $search1 = $modelMapel->sanitizeMapel($search);
        $materis = $modelMateri->like('judul', $search)->orLike('deskripsi', $search)->orLike('isi_materi', $search)->orderBy('created_at', 'DESC')->findAll();
        if ($search1 !== $search) {
            $id_mapel = $modelMapel->like('nama', $search1)->first()['id'];
            $id_guru = $modelGuru->where('id_mapel', $id_mapel)->first()['id'];
            $materis = $modelMateri->where('id_guru', $id_guru)->orderBy('created_at', 'DESC')->findAll();
        }

        $nama_kelas = $kelas->convertClass($search);

        $daftar_kelas = $modelKelas->findAll();
        foreach ($daftar_kelas as &$daftar) {
            $daftar = $daftar['nama'];
        }
        unset($daftar);

        // Kalo datanya dari kelas
        $data_kelas = $kelas->where('nama', $nama_kelas)->first();
        if ($data_kelas) {
            $id_kelas = $data_kelas['id'];
            $materis = $modelMateri->where('id_kelas', $id_kelas)->findAll();
        }

        $data_mapel = $modelMapel->like('nama', $search)->findAll();
        if ($data_mapel) {

            foreach ($data_mapel as $mapel) {
                $id_mapel[] = $mapel['id'];
            }
            // d($id_mapel);

            foreach ($id_mapel as $key => $id) {
                $id_guru[] = $modelGuru->where('id_mapel', $id)->first()['id'];
            }
            // d($id_guru);

            foreach ($id_guru as $key => $id) {
                $materis[] = $modelMateri->where('id_guru', $id)->findAll();
            }
            // d($materis);

            // merge all index array
            $materis = call_user_func_array('array_merge', $materis); //? Merge all array. Paling penting

            // remove duplicate array
            $materis = array_unique($materis, SORT_REGULAR);

            // remove empty array
            $materis = array_filter($materis);
            // dd($materis);

            // $id_mapel = $data_mapel['id'];
            // $id_guru  = $guru->where('id_mapel', $id_mapel)->findAll()['id'];
            // $materis  = $modelMateri->where('id_guru', $id_guru)->findAll();
        }

        $data_guru = $modelGuru->like('nama', $search)->first();
        if ($data_guru) {
            $id_guru = $data_guru['id'];
            $materis = $modelMateri->where('id_guru', $id_guru)->findAll();
        }

        //! Function ini beda dengan function home di method viewBlog()
        $listGuru = $modelGuru->getGuru();

        $listIdGuru = [];
        foreach ($listGuru as $guru) {
            $listIdGuru[] = $guru['id'];
        }
        unset($guru);
        $listIdGuru = array_unique($listIdGuru);

        $listGuru = $modelMateri->findUnique($listGuru, 'nama');
        $listLinkGuru = [];
        $current_url = $this->request->getGet('materi');

        foreach ($listGuru as $guru) {
            $listLinkGuru[] = base_url() . '/search?materi=' . url_title($modelGuru->sanitizeGuru($guru), '+', true);
        }
        unset($guru);

        $listMapel = [];
        foreach ($listIdGuru as $id_guru) {
            $listMapel[] = $modelMapel->find($id_guru);
        }

        $listGuru = compact('listGuru', 'listIdGuru', 'listLinkGuru');

        $guru_url_1 = $modelGuru->findUnique($materis, 'id_guru');
        $guru_url = '';
        if ($guru_url_1) {
            $guru_url = $modelGuru->getGuru(null, $guru_url_1)['nama'];
            $guru_url = url_title($modelGuru->sanitizeGuru($guru_url), ' ', true);
        }

        $data = [
            'title' => 'Cari ' . '"' . $search . '"',
            'search' => $search,
            'materis' => $materis,
            'daftar_kelas' => $daftar_kelas,
            'list_guru' => $listGuru,
            'list_mapel' => $listMapel,
            'current_url' => $current_url,
            'guru_url' => $guru_url,
        ];

        if (!$data['materis']) {
            throw PageNotFoundException::forPageNotFound(`Materi tidak ditemukan`);
        }


        return view('pages/materi', $data);
    }
}
