<?= $this->extend("layout/app"); ?>

<?= $this->section("body"); ?>

<div class="container my-3">
    <div class="row">
        <div class="my-3">
            <a href="<?= base_url('materi/tambah') ?>" class="btn btn-primary"><i class="bi bi-plus"></i></a>
        </div>
        <div class="overflow-x">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mapel</th>
                        <?php if (session()->get('user_role') !== 'guru') : ?>
                            <th>Guru</th>
                        <?php endif ?>
                        <th>Kelas</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Alat</th>
                        <th>Status</th>
                    </tr>
                <tbody>
                    <?php

                    use App\Models\ModelGuru;
                    use App\Models\ModelKelas;
                    use App\Models\ModelMapel;
                    use App\Models\ModelMateri;

                    $modelGuru = new ModelGuru();
                    $modelKelas =  new ModelKelas();
                    $modelMateri = new ModelMateri();
                    $modelMapel = new ModelMapel();
                    $no = 1;

                    foreach ($materis as $materi) :

                        $guru = $modelGuru->where('id', $materi['id_guru'])->get()->getRowArray();
                        $mapel = $modelGuru->db->table('mapel')->where('id', $guru['id_mapel'])->get()->getRowArray();
                        $mapel['nama'] = ucwords($modelMapel->sanitizeMapel($mapel['nama']));
                        $kelas = $modelGuru->db->table('kelas')->where('id', $materi['id_kelas'])->get()->getRowArray();
                        $slug = explode('/', $materi['slug']);
                        $slug_edit = '/edit' . '/materi/' . $slug[2] . '/' . $slug[3] . '/' . $materi['id'];
                    ?>

                        <?php if ($materi['status'] === 'draft' || 'published') : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $mapel['nama'] ?></td>
                                <?php if (session()->get('user_role') !== 'guru') : ?>
                                    <td><?= $guru['nama'] ?></td>
                                <?php endif ?>
                                <td><?= $kelas['nama'] ?></td>
                                <td><?= $materi['judul'] ?></td>
                                <td><?= $deskripsi = ($materi['deskripsi'] !== '') ? $materi['deskripsi'] : '~~kosong~~'; ?></td>
                                <td class="d-flex justify-content-center">
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $materi['id'] ?>"><i class="bi bi-trash3"></i></button>
                                    <a href="<?= base_url() . $materi['slug'] ?>" class="btn btn-success"><i class="bi bi-eye"></i></a>
                                    <a href="admin/edit<?= $materi['slug'] ?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                </td>
                                <td>
                                    <span class="<?= $bg = ($materi['status'] === 'published') ? 'bg-primary' : 'bg-warning'; ?> p-md-2 rounded">
                                        <?= $materi['status'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                </tbody>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<?php foreach ($materis as $materi) : ?>

    <div class="modal fade" id="hapus<?= $materi['id'] ?>" tabindex="-1" aria-labelledby="hapusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-body p-4 text-center">
                    <h5 class="mb-2">Hapus materi</h5>
                    <p class="mb-0">Yakin ingin hapus materi <strong><?= $materi['judul'] ?></strong>? </p>
                </div>
                <?= form_open('materi/hapus') ?>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="submit" class="btn btn-lg btn-link fs-6 text-danger text-decoration-none col-6 m-0 rounded-0 border-end"><strong>Ya</strong></button>
                    <button type="button" class="btn btn-lg btn-link fs-6 text-secondary text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">Batal</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach ?>

<?= $this->endSection(); ?>