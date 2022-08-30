<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap-icons.css') ?>">

    <link rel="icon" type="image/x-icon" href="<?= base_url('Rizalandit.png') ?>">
    <title><?= $title = (!isset($subtitle)) ? $title : ((!isset($title) ? 'Randy Classroom' : $title . ' | ' . $subtitle)); ?></title>
</head>

<body>
    <?php
    $baseurlHome = basename(base_url());
    $baseurlMateri = basename(base_url('materi'));
    $baseurlLogin = basename(base_url('login'));
    $baseurlRegister = basename(base_url('register'));

    $current = basename(current_url());
    ?>

    <?php if ($current === $baseurlHome || $current === $baseurlLogin || $current === $baseurlRegister) : ?>
        <?= $this->include('layout/navbar-non') ?>
    <?php else : ?>
        <?= $this->include('layout/navbar') ?>
    <?php endif ?>
    <div style="margin-top: <?= $mt = ($current === $baseurlMateri) ? '9vh' : '12vh'; ?>;">
        <?= $this->renderSection('body') ?>
    </div>

    <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>