<?= $this->extend("layout/app") ?>

<?= $this->section("body") ?>


<style>
	.bd-placeholder-img {
		font-size: 1.125rem;
		text-anchor: middle;
		-webkit-user-select: none;
		-moz-user-select: none;
		user-select: none;
	}


	@media (min-width: 768px) {
		.bd-placeholder-img-lg {
			font-size: 3.5rem;
		}
	}
</style>

<div class="">
	<main class="container">
		<section class="d-flex vh-80 text-center">
			<div class="cover-container d-flex w-100 h-100 p-3 mx-auto justify-content-center align-items-center">
				<main class="px-3">
					<div class="my-md-3">
						<img src="<?= base_url('Rizalandit.png') ?>" width="100px">
					</div>
					<h1>Randy School</h1>
					<p class="lead">Read, Lead, Succeed.</p>
					<p class="lead">
						<button class="btn btn-lg btn-secondary">Learn more</button>
					</p>
				</main>
			</div>
		</section>
	</main>
</div>

<?= $this->endSection() ?>