<!-- Carousel Start -->
<div class="container-fluid px-0 mb-5">
	<div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-item active" style="background: transparent !important;">
				<img class="w-100" src="<?= base_url('assets/landing/') ?>img/wedding1.jpg" alt="Image">
				<div class="carousel-caption">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-7 text-center">
								<p class="fs-4 text-white animated zoomIn">Welcome to <strong class="text-dark">JeWePe Wedding Organizer</strong></p>
								<h1 class="display-1 text-dark mb-4 animated zoomIn">Mengabadikan Setiap Momen Pernikahan Anda</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="carousel-item" style="background: transparent !important;">
				<img class="w-100" src="<?= base_url('assets/landing/') ?>img/wedding2.jpg" alt="Image">
				<div class="carousel-caption">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-7 text-center">
								<p class="fs-4 text-white animated zoomIn">Welcome to <strong class="text-dark">JeWePe Wedding Organizer</strong></p>
								<h1 class="display-1 text-dark mb-4 animated zoomIn">Mengabadikan Setiap Momen Pernikahan Anda</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
			data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
			data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
</div>
<!-- Carousel End -->

<!-- Store Start -->
<div class="container-xxl py-5">
	<div class="container">
		<div class="section-title text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
			<p class="fs-5 fw-medium fst-italic text-primary">Katalog Paket Pernikahan</p>
			<h1 class="display-6">Pilih Paket Pernikahan Impian Anda</h1>
		</div>
		<div class="row g-4">
			<?php
			$delay = 0.1;
			foreach ($getAllKatalog as $katalog) :
			?>
			<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
				<div class="store-item position-relative text-center">
					<img class="img-fluid" src="<?= base_url('assets/files/katalog/') . $katalog->image; ?>" alt="<?= $katalog->package_name; ?>">
					<div class="p-4">
						<h4 class="mb-3"><?= $katalog->package_name; ?></h4>
						<p><?= word_limiter($katalog->description, 20); ?></p>
						<h4 class="text-primary">Rp. <?= number_format($katalog->price, 2, ",", "."); ?></h4>
					</div>
					<div class="store-overlay">
						<a href="<?= base_url('beranda/detail?id=') . $katalog->catalogue_id; ?>" class="btn btn-primary rounded-pill py-2 px-4 m-2">More Detail <i class="fa fa-arrow-right ms-2"></i></a>
					</div>
				</div>
			</div>
			<?php
			$delay += 0.2;
			endforeach;
			?>
			<div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
				<a href="" class="btn btn-primary rounded-pill py-3 px-5">View More Products</a>
			</div>
		</div>
	</div>
</div>
<!-- Store End -->
