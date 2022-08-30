<?= $this->extend('layout/app'); ?>
<?= $this->section('body'); ?>

<?php
if (!isset($guru_url)) {
    $guru_url = '';
}

use App\Models\ModelGuru;
use App\Models\ModelKelas;
use App\Models\ModelMapel;
use App\Models\ModelMateri;

$modelGuru = new ModelGuru();
$modelKelas =  new ModelKelas();
$modelMateri = new ModelMateri();
$modelMapel = new ModelMapel();
?>
<style>
    body {
        margin: 0;
    }

    .container-header {
        padding-right: 80px;
        padding-left: 80px;
        margin-right: auto;
        margin-left: auto;
    }

    .container {
        min-width: 1230px;
        margin: 0 auto;
    }

    .flex-wrap {
        display: flex;
        flex-wrap: wrap;
    }

    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    span,
    a {
        color: black;
    }

    .btn {
        border: none;
    }

    .btn:hover {
        border: none;
    }

    .bg-white {
        background-color: white;
    }

    <?php foreach ($materis as $materi) :
        $dataGuru = $modelGuru->where('id', $materi['id_guru'])->get()->getRowArray();
        $mapel = $modelGuru->db->table('mapel')->where('id', $dataGuru['id_mapel'])->get()->getRowArray(); ?>.card-head<?= $materi['id'] ?> {
        background-image: url("<?= base_url() ?>/assets/bg-classroom/img_<?= $img_name = $mapel['nama'] === 'bahasa indonesia' ? 'breakfast' : ($mapel['nama'] === 'bahasa inggris' ? 'learnlanguage' : ($mapel['nama'] === 'matematika' ? 'math' : ($mapel['nama'] === 'pelajaran agama islam' ? 'socialStudies' : ($mapel['nama'] === 'pemrograman web' ? 'code' : ($mapel['nama'] === 'basis data' ? 'code' : ($mapel['nama'] === 'bahasa jepang' ? 'writing' : ($mapel['nama'] === 'prakarya dan kewirausahaan' ? 'writing' : ($mapel['nama'] === 'pendidikan jasmani olahraga dan kesehatan' ? 'honors' : ($mapel['nama'] === 'pemrograman berorientasi objek' ? 'code' : 'graduation'))))))))) ?>.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    <?php endforeach; ?>.hover-card:hover {
        box-shadow: 1px 2px 20px 5px lightgrey;
        -webkit-box-shadow: 1px 2px 20px 5px lightgrey;
        -moz-box-shadow: 1px 2px 20px 5px lightgrey;
    }

    .bg-head {
        background-image: url("<?= base_url() ?>/assets/bg-classroom/img_<?= $img_name = $mapel['nama'] === 'bahasa indonesia' ? 'breakfast' : ($mapel['nama'] === 'bahasa inggris' ? 'learnlanguage' : ($mapel['nama'] === 'matematika' ? 'math' : ($mapel['nama'] === 'pelajaran agama islam' ? 'socialStudies' : ($mapel['nama'] === 'pemrograman web' ? 'code' : ($mapel['nama'] === 'basis data' ? 'code' : ($mapel['nama'] === 'bahasa jepang' ? 'writing' : ($mapel['nama'] === 'prakarya dan kewirausahaan' ? 'writing' : ($mapel['nama'] === 'pendidikan jasmani olahraga dan kesehatan' ? 'honors' : ($mapel['nama'] === 'pemrograman berorientasi objek' ? 'code' : 'graduation'))))))))) ?>.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .card-title {
        font-size: 1.5rem;
    }

    .card-title-hover {
        text-decoration: none;
        text-decoration-color: white;
        cursor: pointer;
    }

    .card-subtitle {
        font-size: 0.9rem;
    }

    .card-link {
        font-size: 1rem;
        text-decoration: none;
        cursor: pointer;
    }

    .card-link:hover {
        text-decoration: underline;
    }

    .description {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        line-height: 16px;
        /* fallback */
        max-height: 40px;
        /* fallback */
        -webkit-line-clamp: 2;
        /* number of lines to show */
        -webkit-box-orient: vertical;
        line-height: 1.5;
    }

    .card-title-hover:hover {
        text-decoration: underline;
        text-decoration-color: white;
    }

    .nama-kelas {
        font-size: 1.5rem;
    }

    .bi-journal-text {
        cursor: pointer;
    }
</style>
<!-- 404 Not Found start -->
<?php if ($materis === null) : ?>
    <div class="container mt-5">
        <div class="text-center">Materi kosong</div>
    </div>
<?php endif ?>
<!-- 404 Not Found end -->

<!-- Dropdown -->
<div class="container d-inline-flex my-3 ms-md-5 ps-md-4">
    <!-- Dropdown kelas start -->
    <div class="dropdown">
        <button class="btn btn-outline-light text-black dropdown-toggle" type="button" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            foreach ($daftar_kelas as $row => $nama_kelas) {
                $current_url = current_url();
                $current_url = explode('/', $current_url);

                if (in_array(url_title($nama_kelas, '-', true), $current_url)) {
                    $kelas_dropdown = $nama_kelas;
                }
            }
            echo $kelas_dropdown ?? 'Semua kelas';
            ?>
        </button>
        <ul class="dropdown-menu gap-1 p-2 rounded-3 mx-0 shadow">
            <?php
            foreach ($daftar_kelas as $row => $nama_kelas) :
                $current_url = current_url();
                $current_url = explode('/', $current_url);
                $url_kelas = url_title($nama_kelas, '-', true);
            ?>
                <li>
                    <a href="<?= base_url('materi') . '/' . $url_kelas ?>" class="dropdown-item <?= $active = (in_array($url_kelas, $current_url)) ? 'bg-primary text-white disabled' : ''; ?> rounded-2"><?= $nama_kelas ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <!-- Dropdown kelas end -->
    <!-- Dropdown mapel start -->
    <div class="dropdown">
        <button class="btn btn-outline-light text-black dropdown-toggle" type="button" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            foreach ($list_guru['listGuru'] as $key => $value) {
                if (in_array(url_title($modelGuru->sanitizeGuru($value), '-', true), $current_url)) {
                    $id_mapel = $modelGuru->where('nama', $value)->first()['id_mapel'];
                    $nama_mapel = $modelMapel->where('id', $id_mapel)->first()['nama'];
                    $mapel_dropdown = ucwords($nama_mapel);
                }
            }
            echo $mapel_dropdown ?? 'Semua mapel';
            ?>
        </button>
        <ul class="dropdown-menu gap-1 p-2 rounded-3 mx-0 shadow">
            <?php
            foreach ($list_guru['listLinkGuru'] as $row => $value) :
                $nama_guru = explode('/', $value);
                $nama_guru = str_replace('-', ' ', end($nama_guru));
                $nama_guru = str_replace('search?materi=', '', $nama_guru);
                $nama_guru = str_replace('+', ' ', $nama_guru);
                $id_mapel = $modelGuru->like('nama', $nama_guru)->first()['id_mapel'];
                $nama_mapel = ucwords($modelMapel->where('id', $id_mapel)->first()['nama']);

                $value_link = $value;
                $value = explode('/', $value);
                $value = end($value);
            ?>
                <li>
                    <a href="<?= $value_link ?>" class="dropdown-item <?= $active = (in_array($value, $current_url) || $guru_url  === $current_url) ? 'bg-primary text-white disabled' : ''; ?> rounded-2"><?= $nama_mapel ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- Dropdown kelas start -->
</div>

<!-- Header -->
<?php if (isset($kelas)) : ?>
    <div class="container-header">
        <div class="p-4 p-md-5 mb-4 bg-head rounded">
            <div class="col-md-6">
                <a href="/materi/<?= url_title($kelas, '-', true) ?>" class="text-white card-title-hover display-4">
                    <h1 class="card-text text-white"><b><?= $kelas  ?></b></h1>
                </a>
                <h3 class="text-white"><?= $Judul = (session()->getFlashdata('mapel')) ? session()->getFlashdata('mapel')  : '' ?></h3>
                <p class="my-3 text-white">
                    <?php if (isset($guru)) : ?><i class="bi bi-dot"></i>
                        <?php
                        foreach ($guru as $gr => $value) :
                            $link_guru = base_url() . '/materi/' . url_title($kelas, '-', true) . '/' . url_title($value, '-', true);

                            $id_mapel = $modelGuru->like('nama', $value)->first()['id_mapel'];
                            $nama_mapel = $modelMapel->where('id', $id_mapel)->first()['nama'];
                            $nama_mapel = $modelMapel->sanitizeMapel($nama_mapel);
                        ?>
                            <a class="text-white card-link" href="<?= $link_guru ?>">
                                <?= ucwords($nama_mapel); ?>
                            </a><i class="bi bi-dot"></i>
                        <?php endforeach ?>
                    <?php else : ?>
                        <a class="text-white card-link" href="<?= $link_guru ?>"><?= session()->getFlashdata('guru'); ?></a>
                    <?php endif ?>
                </p>
            </div>
        </div>
    </div>
<?php endif ?>

<!-- Cards -->
<div class="container mb-3">
    <div class="d-flex flex-wrap">

        <?php
        foreach ($materis as $materi) :
            $kelas = $modelGuru->db->table('kelas')->where('id', $materi['id_kelas'])->get()->getRowArray();

            $slug = explode('/', $materi['slug']);
            $link_guru = base_url() . '/materi/' . $slug[2] . '/' . $slug[3];
            $link_kelas = base_url() . '/materi/' . $slug[2];

            $guru = $modelGuru->where('id', $materi['id_guru'])->get()->getRowArray();
            $mapel = $modelGuru->db->table('mapel')->where('id', $guru['id_mapel'])->get()->getRowArray();
            $mapel['nama'] = ucwords($modelMapel->sanitizeMapel($mapel['nama']));
            $dt = strtotime($materi['created_at']);

            $hari = date('l', $dt);
            $tanggal = date('d F Y', $dt);
        ?>

            <?php if ($materi['status'] === 'published') : ?>
                <div class="card rounded hover-card mt-3 mx-md-2" style="width: 285px;">
                    <div class="card-body card-head<?= $materi['id'] ?> text-white rounded-top">
                        <div class="d-flex align-items-center mb-md-2">
                            <a href="<?= $link_guru ?>" class="text-white card-title-hover">
                                <h5 class="card-title text-white mb-md-0 p-md-0"><?= $mapel['nama'] ?></h5>
                                <span class="card-subtitle text-white"><?= $modelGuru->sanitizeGuru($guru['nama']) ?></span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="<?= $link_kelas ?>" class="text-white card-title-hover">
                                <p class="card-text fs-6 text-white"><b><?= $kelas['nama'] ?></b></p>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-0">
                                <span class="card-subtitle"><?= $hari . ', ' . $tanggal ?> </span><br>
                                <a href="<?= base_url() . $materi['slug'] ?>" class="materi-judul card-link"><?= $materi['judul'] ?></a><br>
                                <span class="my-2 description card-subtitle text-secondary"><?= $desc = isset($materi['deksripsi']) ? $materi['deskripsi'] : $materi['isi_materi']; ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body border-top d-flex justify-content-end">
                        <a href="<?= $link_guru ?>" data-bs-toggle="tooltip" title="Buka semua materi <?= $mapel['nama'] . ' | ' . $kelas['nama'] ?>">
                            <i class="bi bi-journal-text"></i>
                        </a>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach ?>
        <!-- Classroom card created by Albaro Muyassarun | remastered by rizalandit  -->
    </div>
</div>


<?= $this->endSection(); ?>