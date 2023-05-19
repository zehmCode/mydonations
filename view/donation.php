<?php $title = "My Donations - Donate";
ob_start();
?>

<?php include 'partials/_navbar.php' ?>

<div style="overflow-x: hidden;">
    <div class="d-flex justify-content-center align-items-center">
        <div class="container mt-5 pt-5">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="px-3 py-4 bg-light mt-5 border">
                        <div class="mx-auto">
                            <a href="campaign&campaign_id=<?= $_GET['campaign_id'] ?>" class="btn border bg-white"><i class="fa-solid fa-caret-left"></i> Revenir</a>
                            <div class="d-flex mt-3" style="gap:10px;">
                                <div class="core h-100" style="width: 8.25rem; display:block;">
                                    <div class="core-entity" style="background-image: url(<?= $poste[0]['image'] ?>);"></div>
                                </div>
                                <div class="content">
                                    <p class="text-dark font-weight-bold">
                                        Vous soutenez  <span class="font-weight-bold text-secondary"><?= $poste[0]['title'] ?></span> 
                                        <br>
                                        Votre don profitera à <span class="font-weight-bold text-secondary"><?= $poste[0]['first_name'] . " " . $poste[0]['last_name'] ?></span>.
                                    </p>
                                </div>
                            </div>

                            <p class="m-0 mt-2 text-dark font-weight-bold">Aidez-nous à collecter des fonds pour changer des vies. Votre don compte énormément. </p>
                            <hr>
                            <form action="" method="POST" class="appointment p-0 mt-3">
                            <?php
                                if(isset($_GET['error']) || isset($_GET['success'])){
                            ?>
                                <div class="alert alert-<?= (isset($_GET['success'])) ? "success" : "danger" ?>">
                                     <?= (isset($_GET['success'])) ? "<i class=\"fa-solid fa-square-check\"></i> " . $_GET['success'] : "<i class=\"fa-solid fa-triangle-exclamation\"></i>" . $_GET['error'] ?>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="row">
                                <label for="name" class="text-dark font-weight-bold col-md-12" style="font-size:24px;">Montant à donner  en <i class="fa-solid fa-euro-sign"></i></label>
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <div class="input-wrap">
                                            <input type="number" style="font-size:32px;" value="1.00" min="1" step="0.10" name="amount" class="form-control py-5 border" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" style="font-size:18px;">
                                        <div class="d-lg-flex">
                                            <div class="form-checkbox mr-3">
                                                <span class="fill-control-description text-dark font-weight-bold">Voulez-vous que ce don soi anonyme?</span> <br>
                                                <input type="checkbox" name="anonyme" id="anonyme"> <label for="anonyme" class="text-dark font-weight-bold">Oui</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="submit" name="donate" value="Confirmer" class="btn btn-secondary py-3 px-4">
                                    </div>
                                </div>
                            </div>
                        </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $content=ob_get_clean();?>
<?php require('template.php');?>