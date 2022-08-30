<style>
    .logo-link {
        text-decoration: none;
        color: black;
    }

    .logo-link:hover {
        text-decoration: none;
        color: black;
    }

    .search {
        position: relative;
        display: inline-block;
        width: 30vw;
        height: 40px;
        padding: 0 20px 0 20px;
        font-size: 1.2rem;
        color: #ccc;
        transition: all 0.3s ease-in-out;
    }
</style>

<?php

$url = explode('/', current_url());

?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top border-bottom">
    <div class="container-fluid d-flex justify-content-between">
        <span class="navbar-brand d-flex align-items-center">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <i class="bi bi-list fs-5 text-dark"></i>
            </button>
            <img src="img/Menu_50px.png" alt="" width="16px">
            </a>

            <!-- Materi icon -->
            <div class="ms-2" style="transform: rotate(0);">
                <img src="<?= base_url('Rizalandit.png') ?>" width="25px">
                <a href="<?= site_url('materi') ?>" class="fw-semibold stretched-link logo-link">Classroom</a>
            </div>
        </span>

        <?php if (session()->get('user_role') !== 'guru') : ?>
            <!-- Search bar start -->
            <div class="<?= $orientation = (session()->get('isLoggedIn') !== null) ? 'mx-auto' : ''; ?>">
                <form class="search" role="search" action="<?= base_url('search') ?>" method="GET">
                    <div class="input-group">
                        <input name="materi" type="search" class="form-control" placeholder="Mau belajar apa hari ini?" aria-label="Search" value="<?= $search ?? '' ?>" autofocus>
                        <button class="btn btn-primary" type="submit" id="searchButton"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <!-- Search bar end -->
        <?php endif ?>

        <!-- People with access part start -->
        <?php if (session()->get('isLoggedIn') !== null && session()->get('user_role') === 'guru') : ?>
            <div class="navbar-nav ms-auto">
                <div class="dropdown dropstart">
                    <a class="nav-link rounded-circle py-0 d-none d-md-inline dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plus fs-3 text-dark"></i>
                    </a>
                    <ul class="dropdown-menu gap-1 p-2 rounded-3 mx-0 shadow">
                        <li><a class="dropdown-item" href="<?= base_url('admin/tambah') ?>">Tambah materi</a></li>
                        <!-- <li><a class="dropdown-item" href="<? //= base_url('gabung') 
                                                                ?>">Gabung kelas</a></li> -->
                    </ul>
                </div>
            </div>
            <!-- People with access part end -->
        <?php else : ?>
            <div class="mx-md-5 px-md-5"></div>
        <?php endif; ?>
    </div>
</nav>
<!-- navbar end -->

<!-- Offcanvas start -->
<div class="offcanvas offcanvas-start bg-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" data-bs-scroll="true" data-bs-backdrop="true" style="width: 280px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel" style="transform: rotate(0);">
            <img src="<?= base_url('Rizalandit.png') ?>" width="25px">
            <a href="<?= base_url() ?>" class="fw-semibold stretched-link logo-link">Classroom</a>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr class="mt-0">
    <ul class="nav nav-pills flex-column mb-auto">
        <?php if (session()->get('user_role') === 'guru') : ?>
            <li>
                <a href="<?= base_url('admin') ?>" class="nav-link link-dark <?= $selected = (in_array('admin', $url)) ? 'text-primary' : ''; ?>">
                    <i class="bi bi-person-workspace"></i>
                    Admin
                </a>
            </li>
        <?php endif ?>
        <li>
            <a href="<?= base_url('materi') ?>" class="nav-link link-dark <?= $selected = (in_array('materi', $url) && !in_array('admin', $url)) ? 'text-primary' : ''; ?>">
                <i class="bi bi-book"></i>
                Materi
            </a>
        </li>
        <li>
            <a href="<?= base_url() ?>" class="nav-link link-dark">
                <i class="bi bi-house-door"></i>
                Home
            </a>
        </li>
    </ul>
    <?php if (session()->get('user_name') !== null) : ?>
        <hr>
        <div class="dropdown ms-3 mb-3">
            <button class="btn btn-outline-light text-dark d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('assets/img/default/neckless.jpg') ?>" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong><?= session()->get('username') ?></strong>
            </button>
            <ul class="dropdown-menu text-small shadow">
                <li>
                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logout">
                        Logout
                    </button>
                </li>
            </ul>
        </div>
    <?php else : ?>
        <hr>
        <a href="<?= base_url('login') ?>" class="ms-3 mb-3 btn btn-outline-light text-success d-flex align align-items-center text-decoration-none">
            Login
        </a>
    <?php endif ?>
</div>
<!-- Offcanvas end -->

<!-- Modal logout start -->
<div class="modal fade" id="logout" tabindex="-1" aria-labelledby="logoutModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-body p-4 text-center">
                <h5 class="mb-0">Yakin ingin keluar dari akun <strong><?= session()->get('user_name') ?></strong>?</h5>
            </div>
            <form action="UserController/logout" method="get">
                <div class="modal-footer flex-nowrap p-0">
                    <button type="submit" class="btn btn-lg btn-link fs-6 text-danger text-decoration-none col-6 m-0 rounded-0 border-end"><strong>Ya</strong></button>
                    <button type="button" class="btn btn-lg btn-link fs-6 text-secondary text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal logout end -->