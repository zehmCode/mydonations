<?php $title = "My Donation";
ob_start();
?>

<?php include 'partials/_navbar.php' ?>

<section class="hero-wrap">
		<div class="home-slider owl-carousel">
			<div class="slider-item" style="background-image:url(public/img/home/bg_1.jpg);">
				<div class="overlay-1"></div>
				<div class="overlay-2"></div>
				<div class="overlay-3"></div>
				<div class="overlay-4"></div>
				<div class="container">
					<div class="row slider-text align-items-center">
						<div class="mx-auto col-md-6 ftco-animate">
							<div class="text text-center w-100">
								<h2>Aidez les gens dans le besoin</h2>
								<h1 class="mb-3">Apportez votre assistance.</h1>
								<div class="mx-auto">
									<div>
										<p class="mb-0">
											<a href="create" class="btn btn-secondary py-3 px-2 px-md-4">Commencer</a>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="ftco-appointment ftco-section ftco-no-pt ftco-no-pb img">
		<div class="overlay"></div>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-7 wrap-about py-5">
					<div class="heading-section pr-md-5 pt-md-5">
						<span class="subheading">Bienvenue sur my donations</span>
						<h2 class="mb-4">La collecte de fonds sur My Donations ne prend que quelques minutes</h2>
						<p>
						<ol>
							<li class="ota">
								<h6 class="text-secondary">Commencez par les bases</h6>
							</li>
							<p>Commencez avec votre nom et votre emplacement.</p>
							<li class="ota">
								<h6 class="text-secondary">Racontez votre histoire</h6>
							</li>
							<p>Nous vous guiderons avec des conseils tout au long du chemin.</p>
							<li class="ota">
								<h6 class="text-secondary">Partagez avec vos amis et votre famille</h6>
							</li>
							<p>Les gens vont vous aider.</p>
						</ol>
						</p>
					</div>
					<div class="row my-md-5">
						<div class="col-md-6 d-flex counter-wrap">
							<div class="block-18 d-flex">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="flaticon-volunteer"></span>
								</div>
								<div class="desc">
									<div class="text">
										<strong class="number" data-number="100">0</strong>
									</div>
									<div class="text">
										<span>Membres inscript</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 d-flex counter-wrap">
							<div class="block-18 d-flex">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="flaticon-donation"></span>
								</div>
								<div class="desc">
									<div class="text">
										<strong class="number" data-number="25">0</strong>
									</div>
									<div class="text">
										<span>Donations</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<p><a href="create" class="btn btn-secondary btn-outline-secondary">Commencer maintenant</a></p>
				</div>
				<div class="col-md-5 wrap-about">
					<img src="public/img/home/hands.jpg" class="img-fluid" alt="hands pic" style="border-radius: 10px;">
				</div>
			</div>
		</div>
	</section>

	<?php if($postes->rowCount() != 0) {?>
	<section class="ftco-section ftco-no-pb">
		<div class="container">
			<div class="row justify-content-center pb-5 mb-3">
				<div class="col-md-7 heading-section text-center ftco-animate">
					<span class="subheading">Meilleures collectes de fonds</span>
					<h2>Les collectes de fonds</h2>
				</div>
			</div>
			<div class="row">
				<?php
					$max_length = 50; 
					foreach($postes as $poste){
						$percentage = floor(($poste['current_amount'] / $poste['goal_amount']) * 100);
				?>
				<div class="col-md-6 col-lg-3">
					<div class="causes causes-2 ftco-animate">
						<a href="campaign&campaign_id=<?= $poste['campaign_id'] ?>" class="img w-100" style="background-image: url(<?= $poste['image'] ?>);"></a>
						<div class="text p-3" style="position:relative;">
							<h2><a href="campaign&campaign_id=<?= $poste['campaign_id'] ?>"><?= $poste['title'] ?></a></h2>
							<p><?= (strlen($poste['description']) > $max_length) ? substr(strip_tags($poste['description']), 0, $max_length) . "..." : strip_tags($poste['description']) ?></p>
							<div class="goal mb-4">
								<p><span><?= $poste['current_amount'] ?></span> sur <span><?= $poste['goal_amount'] ?></span></p>
								<div class="progress" style="height:20px">
									<div class="progress-bar bg-secondary" style="width:<?= $percentage ?>%; height:20px"><?= $percentage ?>%</div>
								</div>
							</div>
							<p><a href="campaign&campaign_id=<?= $poste['campaign_id'] ?>" class="btn btn-primary text-dark w-100">Faire un don</a></p>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<p class="d-flex justify-content-center mb-5 ftco-animate"><a href="#" class="btn btn-secondary">voir plus</a></p>
		</div>
	</section>
	<?php } ?>

	<section class="ftco-counter" id="section-counter">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mb-5 mb-md-0 text-center text-md-left">
					<h2 class="font-weight-bold" style="color: #fff; font-size: 22px;">Nous sommes en mission pour aider
						tous vos problèmes</h2>
					<a href="create" class="btn btn-white btn-outline-white">Faites votre premier pas</a>
				</div>
			</div>
		</div>
	</section>

	<section class="ftco-section ftco-no-pb" style="margin-bottom: 150px;">
		<div class="container">
			<div class="row justify-content-center pb-5 mb-3">
				<div class="col-md-7 heading-section text-center ftco-animate">
					<span class="subheading">Catégories disponible</span>
					<h2>Parcourir les collectes de fonds par catégorie</h2>
				</div>
			</div>
			<div class="row">
				<?php
					foreach($categories as $categorie){
				?>
				<div class="col-md-2 col-4">
					<div class="categorie text-secondary">
						<i class="<?= $categorie['icon'] ?>"></i>
						<p><?= $categorie['category_name'] ?></p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</section>

	<section class="ftco-hireme bg-secondary">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-md-8 col-lg-8 d-flex align-items-center">
					<div class="w-100">
						<h2>Soyez un impact positif sur les gens</h2>
					</div>
				</div>
				<div class="col-md-4 col-lg-4 d-flex align-items-center justify-content-end">
					<p class="mb-0"><a href="create" class="btn btn-primary py-3 px-4"><?= (isset($_SESSION['user_id'])) ? "Commencer maintenant" : "Devenir membre" ?></a></p>
				</div>
			</div>
		</div>
	</section>

    <?php include 'partials/_footer.php' ?>

<?php $content=ob_get_clean();?>
<?php require('template.php');?>