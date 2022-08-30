<?= $this->extend("layout/app") ?>

<?= $this->section("body") ?>
<?php

$baseurlhome = basename(base_url());
$baseurllogin = basename(base_url('login'));
$baseurlregister = basename(base_url('register'));

$current = basename(current_url());
$session = \Config\Services::session();
//? Tempat Debug
// dd($validation->getErrors());
?>
<div id="app">
	<section class="section">
		<div class="container mt-5">
			<div class="row">
				<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
					<?php

					?>
					<div class="card card-primary">
						<div class="card-header">
							<h4><?= $title ?? 'Login'; ?></h4>
						</div>

						<?php if (session()->get('success')) :
						?>
							<div class="alert alert-success" role="alert">
								<?= session()->get('success') ?>
							</div>
						<?php endif; ?>

						<div class="card-body">
							<?= form_open('login') ?>
							<div class="form-group">
								<label class="noselect" for="email">Email</label>
								<input id="email" type="text" class="form-control" name="email" tabindex="1" value="<?= $email ?? '' ?>" required autofocus>
							</div>

							<div class="form-group">
								<div class="d-block">
									<label class="noselect" for="password" class="control-label">Password</label>
								</div>
								<input id="password" type="password" class="form-control" name="password" tabindex="2" value="<?= $password ?? '' ?>" required>
								<div class="invalid-feedback">
									Please fill in your password
								</div>
							</div>

							<?php if (isset($validation)) : ?>
								<div class="col-12">
									<div class="alert alert-danger" role="alert">
										<?php if (($validation->getError('email') === "Email tidak terdaftar")) : ?>
											<?= $validation->getError('email') ?>
											<br>
											<a href="<?= base_url('register'); ?>" onclick="registerActive()">Create account</a>
										<?php else : ?>
											<?= $validation->listErrors() ?>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>

							<div class="form-group my-3">
								<button type="submit" class="btn btn-primary" tabindex="4" onclick="loginActive()">
									Login
								</button>
							</div>

							<?= form_close() ?>
							<div class="mt-5 text-muted text-center noselect">
								Don't have an account? <a href="<?= base_url('register'); ?>" onclick="registerActive()">Create One</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<?= $this->endSection() ?>