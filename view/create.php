<?php $title = "My Donations - Créé votre campagne";
ob_start();
?>

<div style="height: 100vh; overflow-x: hidden;">
    <div class="row h-100">
        <div class="d-none d-md-flex flex-column justify-content-center col-md-5 col-12">
            <div class="row align-items-center">
                <div class="heading-section p-5">
                    <span class="subheading">Créé votre campagne seulement en quelques </span>
                    <h2 class="mb-4">informations à remplir</h2>
                </div>
            </div>
        </div>
        <div class="donation-wrap px-5 col-md-7 d-md-flex flex-column justify-content-center">
            <div class="d-sm-none text-center text-white heading-section pt-5">
                <span class="subheading">Créé votre campagne seulement en quelques </span>
                <h2 class="mb-4">informations à remplir</h2>
            </div>
            <?php if(!isset($_SESSION['categories'])){ ?>
                <h2 class="text-white font-weight-bold">Choisissez vos categories</h2>
                <form action="" method="POST" class="appointment p-0">
                    <?php
                        if(isset($_GET['error'])){
                    ?>
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <?= $_GET['error'] ?>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="row">
                        <?php foreach($categories as $categorie){ ?>
                            <div class="col-md-3">
                                <div class="py-3">
                                    <label for="<?= $categorie['category_name'] ?>" class="cate d-block bg-light text-dark text-center"><?= $categorie['category_name'] ?></label>
                                    <input id="<?= $categorie['category_name'] ?>" class="d-none inputcate" type="checkbox" name="chks[]" value="<?= $categorie['category_id'] ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-12"></div>
                        <div class="col-12 col-md-5 ml-auto">
                            <div class="form-group">
                                <input type="submit" name="categorieSelect" value="continuer" class="btn btn-secondary py-3 px-4">
                            </div>
                        </div>
                    </div>
                </form>
            <?php }else{ ?>

            <form action="" method="POST" enctype="multipart/form-data" class="appointment">
                <?php
                    if(isset($_GET['error'])){
                ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <?= $_GET['error'] ?>
                </div>
                <?php
                    }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="titre">Titre de la campagne</label>
                            <div class="input-wrap">
                                <div class="icon"><i class="fa-solid fa-envelope"></i></div>
                                <input id="titre" type="text" name="titre" class="form-control" placeholder="Donner un titre">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Racontez votre histoire</label>
                            <div class="input-wrap">
                                <textarea name="description" id="description" rows="5" placeholder="Racontez votre histoire ici" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="image">Votre image (optionel)</label>
                            <div class="input-wrap bg-light">
                                <div class="icon"><i class="fa-solid fa-file-image"></i></div>
                                <input id="image" type="file" name="image" class="form-control-file p-1" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Objectif (montant)</label>
                            <div class="input-wrap">
                                <input type="number"  value="1.00" min="1" step="0.01" name="goal_amount" class="form-control"
                                    placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Date limite</label>
                            <div class="input-wrap">
                                <?php $date=date('Y-m-d');?>
                                <input type="date" value="<?= $date ?>" min="<?= $date ?>" name="deadline" class="form-control"
                                    placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-4">
                    <div class="form-group">
                            <input type="submit" name="return" value="retour" class="btn btn-secondary py-3 px-4">
                        </div>
                    </div>
                    <div class="col-md-4 ml-auto">
                        <div class="form-group">
                            <input type="submit" name="createCampaign" value="crée" class="btn btn-secondary py-3 px-4">
                        </div>
                    </div>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</div>

<?php $content=ob_get_clean();?>
<?php require('template.php');?>