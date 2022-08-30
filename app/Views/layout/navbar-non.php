<?php
$baseurlhome = basename(base_url());
$baseurllogin = basename(base_url('login'));
$baseurlregister = basename(base_url('register'));

$current = basename(current_url());
?>

<header class="p-3">
	<div class="container">
		<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
			<a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
				<img src="https://i.imgur.com/cl0qVur.jpg" alt="Logo Rizalandit" width="50px" class="me-3">
			</a>

			<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
				<li>
					<a id="home" href="" class="nav-link px-2 text-<?= $inactive = ($current != $baseurlhome) ? 'dark' : 'primary'; ?>" onclick="homeActive()">
						Home
					</a>
				</li>
				<li>
					<a id="materi" href="materi" class="nav-link px-2 text-dark" onclick="materiActive()">
						Materi
					</a>
				</li>
			</ul>

			<div class="text-end">
				<?php if (session()->get('isLoggedIn') === null) : ?>
					<a id="login" href="<?= base_url('login') ?>" class="btn btn-<?= $inactive = ($current != $baseurllogin) ? 'outline-dark' : 'primary'; ?> me-2" onclick="loginActive()">Login</a>

					<a id="register" href="<?= base_url('register') ?>" class="btn btn-<?= $inactive = ($current != $baseurlregister) ? (($current == $baseurllogin) ? 'outline-dark' : 'success') : 'primary'; ?>" onclick="registerActive()">Register</a>
				<?php endif ?>
			</div>
		</div>
	</div>
</header>

<script type="text/javascript">
	function homeActive() {
		var home = document.getElementById("home");
		home.classList.remove("text-dark");
		home.classList.add("text-primary");

		var login = document.getElementById("login");
		login.classList.remove("btn-primary");
		login.classList.add("btn-outline-dark");

		var register = document.getElementById("register");
		register.classList.remove("btn-primary");
		register.classList.add("btn-success");
	}

	function materiActive() {
		var home = document.getElementById("home");
		home.classList.remove("text-primary");
		home.classList.add("text-dark");

		var materi = document.getElementById("materi");
		materi.classList.remove("text-dark");
		materi.classList.add("text-primary");

		var login = document.getElementById("login");
		login.classList.remove("btn-primary");
		login.classList.add("btn-outline-dark");

		var register = document.getElementById("register");
		register.classList.remove("btn-primary");
		register.classList.add("btn-success");
	}

	function loginActive() {
		var home = document.getElementById("home");
		home.classList.remove("text-success");
		home.classList.add("text-dark");

		var login = document.getElementById("login");
		login.classList.remove("btn-outline-dark");
		login.classList.add("btn-primary");

		var register = document.getElementById("register");
		register.classList.remove("btn-primary");
		register.classList.remove("btn-success");
		register.classList.add("btn-outline-dark");
	}

	function registerActive() {
		var home = document.getElementById("home");
		home.classList.remove("text-success");
		home.classList.add("text-dark");

		var login = document.getElementById("login");
		login.classList.remove("btn-primary");
		login.classList.add("btn-outline-dark");

		var register = document.getElementById("register");
		register.classList.remove("btn-outline-dark");
		register.classList.remove("btn-success");
		register.classList.add("btn-primary");
	}

	function forgotpassActive() {
		var forgotpass = document.getElementById("forgotpass");
		forgotpass.classList.remove("text-primary");
		forgotpass.classList.add("text-white");

		var login = document.getElementById("login");
		login.classList.remove("btn-primary");
		login.classList.add("btn-outline-dark");

		var register = document.getElementById("register");
		register.classList.remove("btn-primary");
		register.classList.add("btn-success");
	}
</script>