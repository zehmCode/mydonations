<?php $title = "My Donation - campaign";

ob_start();
?>

<?php include 'partials/_navbar.php' ?>

<?php if($poste->rowCount() == 0) header('Location: campaigns'); else $poste = $poste->fetchAll(); ?>
<?php $percentage = floor(($poste[0]['current_amount'] / $poste[0]['goal_amount']) * 100); ?>
<section class="ftco-section ftco-no-pb">
        <div class="container pb-5 pt-5">
            <div class="row">
                <div class="col-md-12 heading-section ftco-animate">
                    <h2 class="text-dark"><?= $poste[0]['title'] ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="causes">
                        <div class="img w-100" style="background-image: url(<?= $poste[0]['image'] ?>); height: 400px;"></div>

                        <p class="text-dark mt-2" style="font-size: 14px;">Créé le <?= $poste[0]['date_created'] ?> <span
                                class="mx-2">∎</span> par <span class="text-secondary"><?= $poste[0]['first_name'] . " " . $poste[0]['last_name'] ?></span></p>

                        <hr>
                        <p style="font-size: 14px;">●
                            <?php foreach($poste as $p){ ?>
                                <u><a class="text-secondary" href="campaigns&category_id=<?= $p['category_id'] ?>"><?= $p['category_name'] ?></a></u> ●
                            <?php } ?>
                        </p>

                        <hr>

                        <div class="d-md-none position-relative">
                            <div class="card position-sticky sticky-top">
                                <div class="card-body">
                                    <div class="goal">
                                        <p class="m-0"><span class="text-secondary font-weight-bold"
                                                style="font-size: 20px;"><?= $poste[0]['current_amount'] ?></span> sur
                                            <span><?= $poste[0]['goal_amount'] ?></span>
                                        </p>
                                        <div class="progress" style="height:4px">
                                            <div class="progress-bar bg-secondary" style="width:<?= $percentage ?>%; height:4px"></div>
                                        </div>
                                    </div>
                                    <p class="mt-1" style="font-size: 12px;">250 <span
                                            class="font-weight-bold">donations</span></p>
                                    <?= (!isset($_SESSION['user_id'])) ? "<p class='text-danger text-center'>Vous devez être connecter !</p>" : "" ?>
                                    <p class="mb-2"><a href="donate&campaign_id=<?= $_GET['campaign_id'] ?>" class="btn btn-primary text-dark w-100 <?= (!isset($_SESSION['user_id'])) ? "disabled" : "" ?>">Faire un don</a>
                                    </p>
                                    <p class="mt-1"><a href="#"
                                            class="btn btn-primary btn-outline-primary text-dark w-100">Partager</a></p>
                                    <p style="font-size: 14px;" class="m-0 text-secondary font-weight-bold"><?= (count($donators) != 0) ? $donators[0]['nbDonateur'] . "personnes viennent de faire un don" : "Personne n'a encore fait d'opération" ?> </p>
                                    <hr>
                                    <p class="font-weight-bold m-0" style="font-size: 14px;">top donateur</p>
                                    <?php if(count($donators) != 0 ){
                                    ?>
                                    <?php foreach($donators as $donator){ ?>
                                            <div class="d-flex" style="gap: 5px;">
                                                <div class="profile-pic">
                                                    <img src="<?= $donator['avatar'] ?>" class="img-responsive" width="40" height="40"
                                                        alt="">
                                                </div>
                                                <div class="content">
                                                    <p class="m-0 text-dark" style="font-size: 14px;">
                                                        <?= ($donator['anonymous_donation'] == 1 ) ? "Anonyme" : $donator['first_name']  . " " . $donator['last_name']?>
                                                    </p>
                                                    <p class="m-0 font-weight-bold"><?= $donator['don'] ?> <i class="fa-solid fa-euro-sign"></i></p>
                                                </div>
                                            </div>
                                    <?php } ?>
                                    <?php } ?>
                                    <hr>
                                </div>
                            </div>
                        </div>

                        <div class="description">
                            <p style="font-size: 14px;" class="text-justify mt-4">
                            <?= $poste[0]['description'] ?>
                            </p>
                            <p class="mb-2 d-inline-block"><a href="donate&campaign_id=<?= $_GET['campaign_id'] ?>" class="btn btn-primary text-dark w-100 <?= (!isset($_SESSION['user_id'])) ? "disabled" : "" ?>">Faire un don</a></p>
                            <p class="mt-1 d-inline-block"><a href="#"
                                    class="btn btn-primary btn-outline-primary text-dark w-100">Partager</a></p>
                        </div>

                        <hr>

                        <div class="organisateur">
                            <h5 class="font-weight-bold">Organisateur et bénéficiaire</h5>
                            <div class="row">
                                <div class="col-6 col-md-6 border-right">
                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                        <div class="profile-pic">
                                            <img src="<?= $poste[0]['avatar'] ?>" class="img-responsive" width="40" height="40"
                                                alt="">
                                        </div>
                                        <div class="content">
                                            <p class="m-0" style="font-size: 14px;"><?= $poste[0]['first_name'] . " " . $poste[0]['last_name'] ?></p>
                                            <p class="m-0 font-weight-bold">Organisateur</p>
                                        </div>
                                    </div>
                                    <p class="mt-3"><a class="btn btn-secondary btn-outline-secondary href="">Contact</a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="commentaire">
                        <h5 class="font-weight-bold">Mots de soutien (2)</h5>
                        <p style="font-size: 12px;">Veuillez faire un don pour partager des mots de soutien.</p>
                        <form action="" method="post">
                            <div class="form-group d-flex position-relative" style="gap:5px;">
                                <div class="profile-pic">
                                    <img src="<?= $poste[0]['avatar'] ?>" class="img-responsive" width="40" height="40" alt="">
                                </div>
                                <textarea class="form-control" name="comment" id="comment" rows="3"
                                    placeholder="laissez votre mot de soutien ici"></textarea>
                                <button
                                    class="btn btn-secondary p-1 mr-2 text-white bg-secondary mb-1 position-absolute"
                                    style="right: 0; bottom: 0;" type="submit" name="commentaire">envoyer</button>
                            </div>
                        </form>
                        <hr>
                        <!-- autre mots de soutien -->

                        <div class="d-flex pt-3" style="gap: 15px;">
                            <div class="profile-pic">
                                <img src="<?= $poste[0]['avatar'] ?>" class="img-responsive" width="40" height="40" alt="">
                            </div>
                            <div class="commentair">
                                <p class="m-0 font-weight-bold text-dark" style="font-size: 14px;">Salma El Halba</p>
                                <p class="m-0 font-weight-bold text-dark" style="font-size: 10px;">il y a 1 heure - 30$
                                </p>
                                <p class="" style="color: #00043c;font-size: 14px;">J'aimerais que nous puissions être
                                    là pour aider en
                                    personne!</p>
                            </div>
                        </div>
                        <div class="d-flex pt-3" style="gap: 15px;">
                            <div class="profile-pic">
                                <img src="<?= $poste[0]['avatar'] ?>" class="img-responsive" width="40" height="40" alt="">
                            </div>
                            <div class="commentair">
                                <p class="m-0 font-weight-bold text-dark" style="font-size: 14px;">Mouhammad al khabir
                                </p>
                                <p class="m-0 font-weight-bold text-dark" style="font-size: 10px;">il y a 3 heures - 15$
                                </p>
                                <p class="" style="color: #00043c;font-size: 14px;">Don de 15 $ de part de Mouhammad al
                                    khabir. Merci beaucoup !</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- sidebar -->
                <div class="col-md-4 d-none d-md-block position-relative">
                    <div class="card position-sticky" style="top: 1rem;">
                        <div class="card-body">
                            <div class="goal">
                                <p class="m-0"><span class="text-secondary font-weight-bold"
                                        style="font-size: 20px;"><?= $poste[0]['current_amount'] ?></span> sur
                                    <span><?= $poste[0]['goal_amount'] ?></span>
                                </p>
                                <div class="progress" style="height:20px">
                                    <div class="progress-bar bg-secondary" style="width:<?= $percentage ?>%; height:20px"><?= $percentage ?>%
                                    </div>
                                </div>
                            </div>
                            <p class="mt-1" style="font-size: 12px;"><?= $nbDonation[0] ?> <span class="font-weight-bold">donations</span>
                            </p>
                            <?= (!isset($_SESSION['user_id'])) ? "<p class='text-danger text-center'>Vous devez être connecter !</p>" : "" ?>
                            <p class="mb-2"><a href="donate&campaign_id=<?= $_GET['campaign_id'] ?>" class="btn btn-primary text-dark w-100 <?= (!isset($_SESSION['user_id'])) ? "disabled" : "" ?>">Faire un don</a>
                            </p>
                            <p class="mt-1"><a href="#"
                                    class="btn btn-primary btn-outline-primary text-dark w-100">Partager</a></p>
                            <p style="font-size: 14px;" class="m-0 text-secondary font-weight-bold"><?= (count($donators) != 0) ? $donators[0]['nbDonateur'] . "personnes viennent de faire un don" : "Personne n'a encore fait d'opération" ?>
                            </p>
                            <hr>
                            <p class="font-weight-bold m-0" style="font-size: 14px;">top donateur</p>
                            <?php if(count($donators) != 0 ){
                            ?>
                            <?php foreach($donators as $donator){ ?>
                                    <div class="d-flex" style="gap: 5px;">
                                        <div class="profile-pic">
                                            <img src="<?= $donator['avatar'] ?>" class="img-responsive" width="40" height="40"
                                                alt="">
                                        </div>
                                        <div class="content">
                                            <p class="m-0 text-dark" style="font-size: 14px;">
                                            <?= ($donator['anonymous_donation'] == 1 ) ? "Anonyme" : $donator['first_name']  . " " . $donator['last_name']?>
                                            </p>
                                            <p class="m-0 font-weight-bold"><?= $donator['don'] ?> <i class="fa-solid fa-euro-sign"></i></p>
                                        </div>
                                    </div>
                            <?php } ?>
                            <?php } ?>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include 'partials/_footer.php' ?>

<?php $content=ob_get_clean();?>
<?php require('template.php');?>