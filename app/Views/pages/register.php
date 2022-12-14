<?= $this->extend("layout/app") ?>

<?= $this->section("body") ?>

<?php

//? Tempat Debug
// dd($session->get())

?>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4><?= $title ?? 'Register'; ?></h4>
                        </div>

                        <div class="ms-4 text-muted">
                            Already have an account? <a href="<?= base_url('login'); ?>" onclick="loginActive()">Login</a>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="<?= base_url('register'); ?>">
                                <div class="mb-3">
                                    <label for="name">Full Name</label>
                                    <input id="name" type="text" class="form-control <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : ''; ?>" name="name" value="<?= $name ?? '' ?>" autofocus>
                                    <?php if (isset($validation) && $validation->getError('name')) { ?>
                                        <div class='invalid-feedback mb-2'>
                                            <?= $error = $validation->getError('name'); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="email">Email</label>
                                            <input id="email" type="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" value="<?= $email ?? '' ?>">
                                            <?php if (isset($validation) && $validation->getError('email')) { ?>
                                                <div class='invalid-feedback mb-2'>
                                                    <?= $error = $validation->getError('email'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="d-block">Password</label>
                                            <input id="password" type="password" class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" value="<?= $password ?? '' ?>">
                                            <?php if (isset($validation) && $validation->getError('password')) { ?>
                                                <div class='invalid-feedback mb-2'>
                                                    <?= $error = $validation->getError('password'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="username">Username</label>
                                            <input id="username" type="text" class="form-control <?= (isset($validation) && $validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" value="<?= $username ?? '' ?>">
                                            <?php if (isset($validation) && $validation->getError('username')) { ?>
                                                <div class='invalid-feedback mb-2'>
                                                    <?= $error = $validation->getError('username'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_confirm" class="d-block">Confirm Password</label>
                                            <input id="password_confirm" type="password" class="form-control <?= (isset($validation) && $validation->hasError('password_confirm')) ? 'is-invalid' : ''; ?>" name="password_confirm" value="<?= $password_confirm ?? '' ?>">
                                            <?php if (isset($validation) && $validation->getError('password_confirm')) { ?>
                                                <div class='invalid-feedback mb-2'>
                                                    <?= $error = $validation->getError('password_confirm'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block my-2">
                                    Register
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="simple-footer">
                            Copyright &copy; Stisla 2018
                        </div> -->
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>