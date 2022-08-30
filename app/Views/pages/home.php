<?= $this->extend('layout/app'); ?>
<?= $this->section('body'); ?>

<?php

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
        $guru = $modelGuru->where('id', $materi['id_guru'])->get()->getRowArray();
        $mapel = $modelGuru->db->table('mapel')->where('id', $guru['id_mapel'])->get()->getRowArray(); ?>.card-head<?= $materi['id'] ?> {
        background-image: url("<?= base_url() ?>/assets/bg-classroom/img_<?= $img_name = $mapel['nama'] === 'b_indonesia' ? 'breakfast' : ($mapel['nama'] === 'b_inggris' ? 'learnlanguage' : ($mapel['nama'] === 'matematika' ? 'math' : ($mapel['nama'] === 'p_a_islam' ? 'socialStudies' : ($mapel['nama'] === 'pemrograman_web' ? 'code' : 'graduation')))) ?>.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    <?php endforeach; ?>.hover-card:hover {
        box-shadow: 1px 2px 20px 5px lightgrey;
        -webkit-box-shadow: 1px 2px 20px 5px lightgrey;
        -moz-box-shadow: 1px 2px 20px 5px lightgrey;
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

    .card-link {
        text-decoration: underline;
    }

    .bi-journal-text {
        cursor: pointer;
    }
</style>
<div class="ms-md-5 mt-md-3">
    <div class="ms-3 my-3 ms-md-4 d-flex flex-wrap">

        <?php

        foreach ($materis as $materi) :
            $guru = $modelGuru->where('id', $materi['id_guru'])->get()->getRowArray();
            $mapel = $modelGuru->db->table('mapel')->where('id', $guru['id_mapel'])->get()->getRowArray();
            $mapel['nama'] = ucwords($modelMapel->sanitizeMapel($mapel['nama']));
            $kelas = $modelGuru->db->table('kelas')->where('id', $materi['id_kelas'])->get()->getRowArray();
            $slug = explode('/', $materi['slug']);
            $link_guru = base_url() . '/materi/' . $slug[2] . '/' . $slug[3];
            $link_kelas = base_url() . '/materi/' . $slug[2];
            $dt = strtotime($materi['created_at']);

            $hari = date('l', $dt);
            $tanggal = date('d F Y', $dt);
        ?>

            <?php if ($materi['status'] === 'published') : ?>
                <div class="card rounded hover-card mt-3 mx-md-2" style="width: 18rem;">
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
                        <a href="<?= $link_guru ?>" title="Buka semua materi <?= $mapel['nama'] . ' | ' . $kelas['nama'] ?>">
                            <i class="bi bi-journal-text"></i>
                        </a>
                    </div>
                </div>
            <?php endif ?>

        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection(); ?>