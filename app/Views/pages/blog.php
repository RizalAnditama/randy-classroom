<?= $this->extend('layout/app'); ?>
<?= $this->section('body'); ?>

<?php

use App\Models\ModelGuru;
use App\Models\ModelMapel;

$modelGuru = new ModelGuru();
$modelMapel = new ModelMapel();
?>

<style>
    /*
        * Blog posts
        */
    .blog-post {
        margin-bottom: 4rem;
    }

    .blog-post-title {
        margin-bottom: .25rem;
        font-size: 2rem;
    }

    .blog-post-meta {
        margin-bottom: 1.25rem;
        color: #727272 !important;
    }

    .link {
        font-size: 1rem;
        color: black;
        text-decoration: underline;
        cursor: pointer;
    }

    .link:hover {
        color: black;
        text-decoration: underline;
    }

    <?php foreach ($materiCard as $materi) :
        $dataGuru = $modelGuru->where('id', $materi['id_guru'])->get()->getRowArray();
        $mapel = $modelGuru->db->table('mapel')->where('id', $dataGuru['id_mapel'])->get()->getRowArray(); ?>.card-head<?= $materi['id'] ?> {
        background-image: url("<?= base_url() ?>/assets/bg-classroom/img_<?= $img_name = $mapel['nama'] === 'bahasa indonesia' ? 'breakfast' : ($mapel['nama'] === 'bahasa inggris' ? 'learnlanguage' : ($mapel['nama'] === 'matematika' ? 'math' : ($mapel['nama'] === 'pelajaran agama islam' ? 'socialStudies' : ($mapel['nama'] === 'pemrograman web' ? 'code' : ($mapel['nama'] === 'basis data' ? 'code' : ($mapel['nama'] === 'bahasa jepang' ? 'writing' : ($mapel['nama'] === 'prakarya dan kewirausahaan' ? 'writing' : ($mapel['nama'] === 'pendidikan jasmani olahraga dan kesehatan' ? 'honors' : ($mapel['nama'] === 'pemrograman berorientasi objek' ? 'code' : 'graduation'))))))))) ?>.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    <?php endforeach ?>.card-title {
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
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    
    .card-link:hover {
        color: black;
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
</style>
<?php
$dt = strtotime($materi['created_at']);
$hari = date('l', $dt);
$tanggal = date('d F Y', $dt);
?>
<main class="container my-3">
    <div class="row">
        <div class="col-md-8">
            <div class="blog-post">
                <h5><?= $kelas ?> | <?= ucwords($nama_mapel) ?></h5>
                <h3 class="blog-post-title"><?= $materis['judul'] ?></h3>
                <p class="blog-post-meta"><?= $hari . ', ' . $tanggal ?>. oleh <a class="link blog-post-meta" href="<?= $link_guru ?>"><?= $guru['nama'] ?></a></p>
                <?php if ($materis['link_youtube'] !== null) : ?>
                    <iframe width="700" height="400" src="<?= $materis['link_youtube'] ?>">
                    </iframe>
                <?php endif ?>
                <p><?= $materis['isi_materi'] ?></p>
            </div>
        </div>
        <aside class="col-md-4">
            <h5>Materi terakhir dari <?= ucwords($nama_mapel) ?> | <?= $kelas ?></h5>
            <hr>
            <?php foreach ($materiCard as $materi) :
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
                <div class="card rounded my-md-3">
                    <div class="card-body">
                        <a href="<?= base_url() . $materi['slug'] ?>" class="card-title card-link"><?= $materi['judul'] ?></a>
                        <p class="blog-post-meta mb-0"><?= $hari . ', ' . $tanggal ?></p>
                        <p class="card-text description pb-md-5"><?= $desc = isset($materi['deksripsi']) ? $materi['deskripsi'] : $materi['isi_materi']; ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        </aside>
    </div>
</main>

<?= $this->endSection(); ?>