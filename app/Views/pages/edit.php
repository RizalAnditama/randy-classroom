<?= $this->extend('layout/app'); ?>
<?= $this->section('body'); ?>

<?php

use App\Models\ModelGuru;
use App\Models\ModelKelas;
use App\Models\ModelMateri;

$modelGuru = new ModelGuru();
$modelKelas =  new ModelKelas();
$modelMateri = new ModelMateri();

?>

<div class="container my-3">
    <div class="row">
        <div class="col">
            <form action="" method="post">
                <?= csrf_field(); ?>
                <div class="form-floating form-group mb-3">
                    <input type="text" name="judul" size="255" placeholder="Judul" id="judul" class="form-control" value="<?= $materi['judul'] ?>" required>
                    <label for="judul">Judul</label>
                </div>
                <div class="form-floating form-group mb-3">
                    <select class="form-control" name="id_kelas" id="kelas" required>
                        <?php $data = $modelKelas->getKelas();
                        foreach ($data as $row) : ?>
                            <option value="<?= $row['id'] ?>" <?= $selected = ($materi['id_kelas'] === $row['id']) ? 'selected' : ''; ?>><?= $row['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="kelas">Kelas</label>
                </div>
                <div class="form-floating form-group mb-3">
                    <select class="form-select" name="id_guru" id="guru" disabled>
                        <option selected disabled value="<?= $id_guru_pre ?>"><?= $nama_guru_pre ?> (<?= ucwords($nama_mapel_pre) ?>)</option>
                    </select>
                    <label for="guru">Guru</label>
                </div>
                <div class="form-floating form-group mb-3">
                    <input type="text" name="deskripsi" size="255" placeholder="deskripsi" id="deskripsi" class="form-control " value="<?= $materi['deskripsi']; ?>">
                    <label for="deskripsi">Deskripsi (Opsional)</label>
                </div>
                <div class="form-floating form-group mb-3">
                    <!-- <input type="url" name="link_youtube" size="255" placeholder="youtube" id="youtube" class="form-control" pattern=".*\.youtube\..*" title="URL Domain harus dari Youtube" value="<? //= $materi['link_youtube'] 
                                                                                                                                                                                                            ?>"> -->
                    <input type="url" name="link_youtube" size="255" placeholder="youtube" id="youtube" class="form-control" title="URL Domain harus dari Youtube" value="<?= $materi['link_youtube'] ?>">
                    <label for="youtube">Link Youtube (Opsional)</label>
                    <div id="linkHelpBlock" class="form-text">
                        Pastikan URL dimulai dengan <code>https://www.youtube.com/watch?v=</code>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="isi_materi">Isi Materi</label>
                    <textarea class="form-control" name=" isi_materi" id="isi_materi" cols="30" rows="10"><?= $materi['isi_materi'] ?></textarea>
                </div>
                <div class="form-floating form-group mb-3">
                    <select class="form-control" name="status" id="status" required>
                        <option value="draft" <?= $selected = ($materi['status'] === 'draft') ? 'selected' : ''; ?>>Simpan, tanpa di rilis</option>
                        <option value="published" <?= $selected = ($materi['status'] === 'publishe') ? 'selected' : ''; ?>>Rilis</option>
                    </select>
                    <label for="status">Status</label>
                </div>

                <button type="submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>