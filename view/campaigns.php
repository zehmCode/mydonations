<?php $title = "My Donation - campaigns";

ob_start();
?>

<?php include 'partials/_navbar.php' ?>
	
	<?php if(!isset($_GET['category_id'])){ ?>
    <section class="ftco-section ftco-no-pb">	
        <div class="container mt-5">
            <div class="row justify-content-center pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">Meilleures collectes de fonds</span>
                    <h2>Tous les collectes de fonds</h2>
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
        </div>
    </section>

	<section class="ftco-section ftco-no-pb">
        <div class="container">
            <div class="row justify-content-center pb-5 mb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">Catégories disponible</span>
                    <h2>Parcourir les collectes de fonds par catégorie</h2>
                </div>
            </div>
            <div class="row">
				<?php
				// $categories = $categories->fetchAll();
					foreach($categories as $categorie){
				?>
				<div class="col-md-2 col-4">
					<div class="categorie text-secondary">
						<a href="campaigns&category_id=<?= $categorie['category_id'] ?>" class="text-secondary">
							<i class="<?= $categorie['icon'] ?>"></i>
							<p><?= $categorie['category_name'] ?></p>
						</a>
					</div>
				</div>
				<?php } ?>
			</div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pb">
        <div class="container">
            
            <?php
					foreach($categories as $categorie){
                        $postesOfCategory = getCampaignOfCategorie($categorie['category_id']);
			?>
            <div class="row pb-3">
                <div class="col-md-7 heading-section ftco-animate">
                    <h2>Categorie <?= $categorie['category_name'] ?></h2>
                </div>
            </div>
            <div class="row">
				<?php
					$max_length = 50; 
					if($postesOfCategory->rowCount() != 0){
					foreach($postesOfCategory as $poste){
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
				<?php 
						} 
					}else{
				?>
					<div class="card w-100 mb-4 ftco-animate">
                        <div class="card-body">
                            <p class='text-center font-weight-bold'>Cette catégorie n'a aucune campagne assigné ! <a class='d-block text-center' href='create'>commencer maintenant</a></p>
                        </div>
                    </div>
				<?php
					} 
				?>
			</div>
            <p class="d-flex justify-content-center mb-5 ftco-animate"><a href="campaigns&category_id=<?= $poste['category_id'] ?>" class="btn btn-secondary">voir
                    plus</a></p>
            <?php } ?>
        </div>
    </section>
	<?php }else{
	?>

<section class="ftco-section ftco-no-pb">
        <div class="container mt-5">
            <div class="row justify-content-center pb-5 mb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">Catégories disponible</span>
                    <h2>Parcourir les collectes de fonds par catégorie</h2>
                </div>
            </div>
            <div class="row">
				<?php
				// $categories = $categories->fetchAll();
					foreach($categories as $categorie){
				?>
				<div class="col-md-2 col-4">
					<div class="categorie cactive text-secondary">
						<a href="campaigns&category_id=<?= $categorie['category_id'] ?>" class="text-secondary">
							<i class="<?= $categorie['icon'] ?> <?php echo ($_GET['category_id'] == $categorie['category_id']) ? "active" : ""; ?>"></i>
							<p><?= $categorie['category_name'] ?></p>
						</a>
					</div>
				</div>
				<?php } ?>
			</div>
        </div>
    </section>
	
	<section class="ftco-section ftco-no-pb">
        <div class="container">

            <?php
				$postesOfCategory = getCampaignOfCategorie($_GET['category_id']);
				$categorie = getCategory($_GET['category_id']);
				$categorie = $categorie->fetch();
			?>
            <div class="row pb-3">
                <div class="col-md-7 heading-section ftco-animate">
					<h2>Categorie <?= $categorie['category_name'] ?></h2>
                </div>
            </div>
            <div class="row">
				<?php
					$max_length = 50; 
					if($postesOfCategory->rowCount() != 0){
					foreach($postesOfCategory as $poste){
						$percentage = ($poste['current_amount'] / $poste['goal_amount']) * 100;
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
				<?php 
						} 
					}else{
				?>
					<div class="card w-100 mb-4 ftco-animate">
                        <div class="card-body">
                            <p class='text-center font-weight-bold'>Cette catégorie n'a aucune campagne assigné ! <a class='d-block text-center' href='create'>commencer maintenant</a></p>
                        </div>
                    </div>
				<?php
					} 
				?>
			</div>
        </div>
    </section>
	<?php } ?>
<?php include 'partials/_footer.php' ?>

<?php $content=ob_get_clean();?>
<?php require('template.php');?>