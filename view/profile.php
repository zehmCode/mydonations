<?php $title = "My Donation - {$_SESSION['firstName']} {$_SESSION['lastName']}";
ob_start();
?>

<?php include 'partials/_navbar.php' ?>

<section class="ftco-section ftco-no-pb" style="margin-top: 50px;">
    <div class="container">
        <div class="heading-section ftco-animate">
            <h2 style="font-size:24px;">Bienvenue sur votre profile</h2>
			<span class="subheading">suivez vos activités ou modifier votre profile</span>
		</div>
    </div>
</section>

<section class="ftco-section ftco-no-pb mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mb-2">
                <div class="card">
                    <div class="card-body">
                        <img src="<?= $_SESSION['avatar'] ?>" class="img-thumbnail" alt="">
                            <?php
                                if(isset($_GET['error'])){
                            ?>
                                <div class="alert alert-danger">
                                    <i class="fa-solid fa-triangle-exclamation"></i> <?= $_GET['error'] ?>
                                </div>
                            <?php
                                }
                            ?>
                        <button id="editProfileBtn" class="w-100 btn btn-light mt-1">Editer le profil</button>
                        <form action="profile" method="POST" id="editProfileForm" class="d-none appointment p-0 m-0">
                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                            <div class="form-group">
                                <label for="name" class="text-dark">Votre nom</label>
                                <div class="input-wrap">
                                    <div class="icon"><i class="fa-solid fa-user"></i></div>
                                    <input type="text" name="firstName" value="<?= $_SESSION['firstName'] ?>" class="form-control form-control-sm border" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="name" class="text-dark">Votre prénom</label>
                                <div class="input-wrap">
                                    <div class="icon"><i class="fa-solid fa-user"></i></div>
                                    <input type="text" name="lastName" value="<?= $_SESSION['lastName'] ?>" class="form-control form-control-sm border" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="text-dark">Votre prénom</label>
                                <div class="input-wrap">
                                <div class="icon"><i class="fa-solid fa-envelope"></i></div>
                                    <input type="email" name="email" value="<?= $_SESSION['email'] ?>" class="form-control form-control-sm border" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="text-dark">Mot de passe</label>
                                <div class="input-wrap">
                                <div class="icon"><i class="fa-solid fa-key"></i></div>
                                    <input type="password" name="password" class="form-control form-control-sm border" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="text-dark">Confirmer votre Mot de passe</label>
                                <div class="input-wrap">
                                <div class="icon"><i class="fa-solid fa-key"></i></div>
                                <input type="password" name="confirmedPassword" class="form-control form-control-sm border" placeholder="">
                                </div>
                            </div>
                            <button type="submit" name="profileEdit" class="btn btn-success">Enregisitrer</button>
                            <button type="reset" id="profileCancelBtn" class="btn btn-danger">annuler</button>
                        </form>
                        <hr>
                        <div class="heading-section">
                            <h2 class="mt-2" style="font-size:16px;"><?= $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></h2>
                            <hr>
                            <p class="m-0 p-0 font-weight-bold" style="font-size:14px;"><?= $_SESSION['email'] ?></p>
                            <p class="m-0 p-0 font-weight-bold" style="font-size:14px;">Combien de dons avez-vous fait: <span class="text-secondary font-weight-bold">0</span></p>
                            <p class="m-0 p-0 font-weight-bold" style="font-size:14px;">Combien de dons vous avez reçu: <span class="text-secondary font-weight-bold">0</span></p>
                            <p class="m-0 p-0 font-weight-bold" style="font-size:14px;">Combien de postes vous avez créés: <span class="text-secondary font-weight-bold">0</span></p>
                            <hr>
                            <p class="m-0 p-0 font-weight-bold" style="font-size:14px;">Combien avez-vous donné: <span class="text-secondary font-weight-bold">0 MAD</span></p>
                            <p class="m-0 p-0 font-weight-bold" style="font-size:14px;">Combien d'argent vous avez reçu des dons: <span class="text-secondary font-weight-bold">0 MAD</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <?php
                    if($postes->rowCount() == 0) {
                ?>
                    <div class="card">
                        <div class="card-body">
                            <p class='text-center font-weight-bold'>Vous avez aucune campagnes créé !</p> <a class='d-block text-center' href=''>commencer maintenant</a>
                        </div>
                    </div>
                <?php
                    }else{
                ?>
                <h6>vos postes</h6>
                <?php
                        $max_length = 30;
                        foreach($postes as $poste){
                            $percentage = ($poste['current_amount'] / $poste['goal_amount']) * 100;
                            $description = (strlen($poste['description']) > $max_length) ? substr($poste['description'], 0, $max_length) . "..." : $poste['description'];
                ?>
                        <div class="row">
                            <div class="col-md-6 m-0 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <a href="#" class="text-secondary font-weight-bold"><?= $poste['title'] ?></a>
                                        <p class="text-justify text-dark font-weight-bold m-0 mt-1" style="font-size: 12px;">
                                            description:
                                        </p>
                                        <p class="text-justify" style="font-size: 12px;">
                                            <?= $description ?>
                                        </p>
                                        <p class="m-0"><span class="text-secondary font-weight-bold" style="font-size: 20px;"><?= $poste['current_amount'] ?></span> sur
                                            <span><?= $poste['goal_amount'] ?></span>
                                        </p>
                                        <div class="progress" style="height:5px">
                                            <div class="progress-bar bg-secondary" style="width:<?= $percentage?>%; height:5px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                        }
                ?>
                    
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</section>


<script>
    const editProfileBtn = document.getElementById("editProfileBtn");
    const profileCancelBtn = document.getElementById("profileCancelBtn");
    const editProfileForm = document.getElementById("editProfileForm");

    editProfileBtn.addEventListener('click', () =>{
        editProfileForm.classList.add('d-block');
        editProfileForm.classList.remove('d-none');
        editProfileBtn.classList.add('d-none');
        editProfileBtn.classList.remove('d-block');
    });
    profileCancelBtn.addEventListener('click', () =>{
        editProfileForm.classList.add('d-none');
        editProfileForm.classList.remove('d-block');
        editProfileBtn.classList.add('d-block');
    });
</script>



<?php include 'partials/_footer.php' ?>

<?php $content=ob_get_clean();?>
<?php require('template.php');?>