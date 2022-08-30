<?php

use App\Models\ModelGuru;
use App\Models\ModelKelas;
use App\Models\ModelMateri;

$modelGuru = new ModelGuru();
$modelKelas =  new ModelKelas();
$modelMateri = new ModelMateri();
?>

<?= $this->extend("layout/app"); ?>

<?= $this->section("body"); ?>
<div class="container my-3">
    <div class="row">
        <div class="col">
            <?= form_open('materi/tambah') ?>
            <?= csrf_field(); ?>
            <div class="form-floating mb-3">
                <input type="text" name="judul" size="255" placeholder="Judul" id="judul" class="form-control <?= $isInvalid = (isset($error['judul'])) ? 'is-invalid' : ''; ?>" value="<?= $judul ?? '' ?>">
                <label for="judul">Judul</label>
                <?php if (isset($error['judul'])) : ?>
                    <div class="text-bg-danger rounded-bottom">
                        <div class="ms-3"><?= $error['judul'] ?? '' ?></div>
                    </div>
                <?php endif ?>
            </div>
            <div class="form-floating form-group mb-3">
                <select class="form-select <?= $isInvalid = (isset($error['id_kelas'])) ? 'is-invalid' : ''; ?>" name="id_kelas" id="kelas">
                    <option <?= $selected = (!isset($id_kelas)) ? 'selected' : ''; ?> disabled value="">Pilih...</option>
                    <?php $data = $modelKelas->getKelas();
                    foreach ($data as $row) :
                    ?>
                        <option value="<?= $row['id'] ?>" <?= $selected = (isset($id_kelas)) ? 'selected' : ''; ?>><?= $row['nama'] ?></option>
                    <?php endforeach ?>
                </select>
                <label for="kelas">Kelas</label>
                <?php if (isset($error['id_kelas'])) : ?>
                    <div class="text-bg-danger rounded-bottom">
                        <div class="ms-3">
                            <?= $error['id_kelas'] ?? '' ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <div class="form-floating form-group mb-3">
                <select class="form-select <?= $isInvalid = (isset($error['id_guru'])) ? 'is-invalid' : ''; ?>" name="id_guru" id="guru" disabled>
                    <option selected disabled value="<?= $id_guru_pre ?>"><?= $nama_guru_pre ?> (<?= ucwords($nama_mapel_pre) ?>)</option>
                </select>
                <label for="guru">Guru</label>
                <?php if (isset($error['id_guru'])) : ?>
                    <div class="text-bg-danger rounded-bottom">
                        <div class="ms-3">
                            <?= $error['id_guru'] ?? '' ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <div class="form-floating form-group mb-3">
                <input type="text" name="deskripsi" size="255" placeholder="deskripsi" id="deskripsi" class="form-control <?= $isInvalid = (isset($error['deskripsi'])) ? 'is-invalid' : ''; ?>" value="<?= $deskripsi ?? '' ?>">
                <label for="deskripsi">Deskripsi (Opsional)</label>
                <?php if (isset($error['deskripsi'])) : ?>
                    <div class="text-bg-danger rounded-bottom">
                        <div class="ms-3">
                            <?= $error['deskripsi'] ?? '' ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <div class="form-floating form-group mb-3">
                <input type="url" name="link_youtube" size="255" placeholder="youtube" id="youtube" class="form-control <?= $isInvalid = (isset($error['link_youtube'])) ? 'is-invalid' : ''; ?>" title="URL Domain harus dari Youtube" value="<?= $link_youtube ?? '' ?>">
                <label for="youtube">Link Youtube (Opsional)</label>
                <?php if (isset($error['link_youtube'])) : ?>
                    <div class="text-bg-danger rounded-bottom">
                        <div class="ms-3">
                            <?= $error['link_youtube'] ?? '' ?>
                        </div>
                    </div>
                <?php endif ?>
                <div id="linkHelpBlock" class="form-text">
                    Pastikan URL dimulai dengan <code>https://www.youtube.com/watch?v=</code> atau <code>https://youtu.be/</code>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="isi_materi">Isi Materi</label>
                <textarea class="form-control <?= $isInvalid = (isset($error['isi_materi'])) ? 'is-invalid' : ''; ?>" name="isi_materi" id="isi_materi" cols="30" rows="10" placeholder="Isi materi pelajaran"><?= $isi_materi ?? '' ?></textarea>
                <?php if (isset($error['isi_materi'])) : ?>
                    <div class="text-bg-danger rounded-bottom">
                        <div class="ms-3">
                            <?= $error['isi_materi'] ?? '' ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <div class="form-floating form-group mb-3">
                <select class="form-select <?= $isInvalid = (isset($error['status'])) ? 'is-invalid' : ''; ?>" name="status" id="status" value="">
                    <option <?= $selected = (!isset($status)) ? 'selected' : ''; ?> disabled>Pilih...</option>
                    <?php $data = $modelMateri->getEnumValues();
                    foreach ($data as $row) : ?>
                        <option value="<?= $row ?>" <?= $selected = (isset($status)) ? 'selected' : ''; ?>><?= $status = ($row === 'draft') ? 'Simpan, tanpa di rilis' : 'Rilis'; ?></option>
                    <?php endforeach ?>
                </select>
                <label for="status">Status</label>
                <?php if (isset($error['status'])) : ?>
                    <div class="text-bg-danger rounded-bottom">
                        <div class="ms-3">
                            <?= $error['status'] ?? '' ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button>
    <a href="<?= base_url('admin') ?>" class="btn btn-outline-secondary">Batal</a>
    <?= form_close() ?>
</div>

<?= $this->endSection(); ?>