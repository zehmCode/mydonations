<?php
// ######################################### PARTIE DE CONNECTION A LA BASE DE DONNEE #########################################

/* 
    function dbConnect(){
        return @object;
    }
*/
function dbConnect(){
    try{
        $db = new PDO("mysql:host=localhost;dbname=mydonations;charset=utf8","root","");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }catch(PDOEcxeption $e){
        die("Erreur - " . $e->getMessage());
    }
}


// ######################################### PARTIE DES AJOUTS #########################################

/* 
cette function nous permet de faire un systeme d'ajout de vue pour avoir le nombres de visiteurs du site web
    function addView(){
        return @void;
    }
*/
function addView(){
    $db = dbConnect();
    $req = $db->prepare("SELECT view FROM views");
    $req->execute();
    $views = $req->fetch();
    if(!isset($_COOKIE['viewed'])){
        $view = $views[0] + 1;
        $req = $db->prepare("UPDATE views set view=?");
        $req->execute(array($view));
        setcookie("viewed","ok",time()+365*24*3600);
    }
}
/* 
    function getViews(){
        return @object;
    }
*/
function getViews(){
    $db = dbConnect();
    $req = $db->prepare("SELECT view FROM views");
    $req->execute();
    return $req->fetch();
}
function getNumUsers(){
    $db = dbConnect();
    $req = $db->prepare("SELECT COUNT(*) AS total FROM users");
    $req->execute();
    return $req->fetch();
}
// ######################################### PARTIE GLOBALE #########################################
/* 
    ---- cette function fais le traitement du formulaire de l'authentification
    function getAllUsers(){
        return @void;
    }
*/

function getRecordsUsers($pageNumber, $recordsPerPage) {
    $db = dbConnect();

    $offset = ($pageNumber - 1) * $recordsPerPage;
    // Fetch records from the database using LIMIT and OFFSET
    $query = "SELECT * FROM users LIMIT $recordsPerPage OFFSET $offset";
    // Execute the query and return the result
    $req = $db->prepare($query);
    $req->execute();

    return $req;
}

// ######################################### PARTIE D'AUTHENTIFICATION (inscription / connection) #########################################

/* 
    ---- cette function fais le traitement du formulaire de l'authentification
    function sysLogin(){
        return @void;
    }
*/
function sysLogin(){
    $db = dbConnect();
    if(isset($_POST['login'])){
        // voir si les tous les champs son remplient
        if(empty($_POST['password']) || empty($_POST['email'])){
            header("Location: login&error=Merci de remplir tous les champs !");
        }else{
            $email=$_POST['email'];
            $password=$_POST['password'];
            
            $req = $db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
            $req->execute(array($email));
            $user = $req->fetch();
            if ($user && password_verify($password, $user['password'])){
                $_SESSION['user_id']=$user['user_id'];
                $_SESSION['firstName']=$user['first_name'];
                $_SESSION['lastName']=$user['last_name'];
                $_SESSION['email']=$user['email'];
                $_SESSION['avatar']=$user['avatar'];
                $_SESSION['rank']=$user['rank'];
                header("Location: home");
            }else{
                header("Location: login&error=Email ou mot de passe incorrecte !"); 
            }
        }  
    }
    
}

/* 
    ---- cette function fais le traitement du formulaire de l'inscription pour s'inscrire dans le site
    function sysSignup(){
        return @void;
    }
*/
function sysSignup(){
    $db = dbConnect();
    if(isset($_POST['signup'])){
        // voir si les tous les champs sont remplient
        if(!isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['confirmedPassword']) || !isset($_POST['confirm'])){
            header("Location: signup&error=Merci de remplir tous les champs et d'accepter les termes et conditions!");
        }else{
            $date=date('Y-m-d H:i:s');

            // remplir les variables avec les valeurs
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmedPassword = $_POST['confirmedPassword'];

            // crypter le mot de passe
            if($password === $confirmedPassword) $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            else{header("Location: signup&error=Verifiez votre mot de passe!"); die();}

            $req = $db->prepare("SELECT email FROM users WHERE email=?");
            $req->execute(array($email));
            $count = $req->rowCount();
            if(!$count>0){
                $req = $db->prepare("INSERT INTO users (user_id,first_name,last_name,email,password,rank,date_created,date_updated) VALUES (?,?,?,?,?,?,?,?)");
                $req->execute(array(null,$firstName,$lastName,$email,$hashed_password,0,$date,$date));
                header("Location: login");
            }else{
                header("Location: signup&error=Cette email est dejà utiliser !");
            }
        }
    }
}


// ######################################### PARTIE DU PROFILE (inscription / connection) #########################################

/* 
    ---- cette function fais le traitement du formulaire de l'inscription pour s'inscrire dans le site
    function sysModifyProfile(){
        return @void;
    }
*/
function sysModifyProfile(){
    $db = dbConnect();
    if(isset($_POST['profileEdit'])){
        // voir si les tous les champs sont remplient
        if(!isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['email'])){
            header("Location: profile&error=Merci de remplir tous les champs et d'accepter les termes et conditions!");
        }else{
            $date=date('Y-m-d H:i:s');

            // remplir les variables avec les valeurs
            $user_id = $_POST['user_id'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];

            if($email != $_SESSION['email']){
                $req = $db->prepare("SELECT email FROM users WHERE email=?");
                $req->execute(array($email));
                $count = $req->rowCount();
            }else{
                $count=null;
            }
            if(!$count>0){
                if(!isset($_POST['password']) || !isset($_POST['confirmedPassword'])){
                    $req = $db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, date_updated = ? WHERE user_id = ?");
                    $req->execute(array($firstName,$lastName,$email,$date,$user_id));
                    $_SESSION['firstName']=$firstName;
                    $_SESSION['lastName']=$lastName;
                    $_SESSION['email']=$email;
                    header("Location: profile");
                }else{
                    if(!empty($_POST['password']) && !empty($_POST['confirmedPassword'])){
                        $password = $_POST['password'];
                        $confirmedPassword = $_POST['confirmedPassword'];
            
                        // crypter le mot de passe
                        if($password === $confirmedPassword) $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                        else{header("Location: profile&error=Verifiez votre mot de passe!"); die();}

                        $req = $db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ?, date_updated = ? WHERE user_id = ?");
                        $req->execute(array($firstName,$lastName,$email,$hashed_password,$date,$user_id));
                        $_SESSION['firstName']=$firstName;
                        $_SESSION['lastName']=$lastName;
                        $_SESSION['email']=$email;
                        header("Location: profile");
                    }else{
                        $req = $db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, date_updated = ? WHERE user_id = ?");
                        $req->execute(array($firstName,$lastName,$email,$date,$user_id));
                        $_SESSION['firstName']=$firstName;
                        $_SESSION['lastName']=$lastName;
                        $_SESSION['email']=$email;
                        header("Location: profile");
                    }
                }
            }else{
                header("Location: profile&error= {$email} est dejà utiliser !");
            }
        }
    }
}

/* 
    ---- cette function fais le traitement du formulaire de l'inscription pour s'inscrire dans le site
    function getProfilePostes(){
        return @array;
    }
*/
function getProfilePostes(){
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM campaigns WHERE user_id=?");
    $req->execute(array($_SESSION['user_id']));
    
    return $req;
}




// ######################################### TABLE CAMPAIGNS #########################################


/*
    ################# PARTIES GETTER
*/
/* 
    ---- cette function nous permet de retourner tous les campaigns cree
    function getAllCampaigns(){
        return @array;
    }
*/

function getAllCampaigns(){
    $db = dbConnect();

    $req = $db->prepare("SELECT * FROM campaigns");
    $req->execute();

    return $req;
}
/* 
    ---- cette function nous permet de retourner tous les campaigns cree
    function getCampaign($id){
        return @array;
    }
*/

function getCampaign($id){
    $db = dbConnect();

    $req = $db->prepare("SELECT c.*,cc.category_name,cc.category_id,u.first_name,u.last_name,u.avatar FROM users u INNER JOIN campaigns c ON u.user_id = c.user_id INNER JOIN campaign_category_map ccm ON c.campaign_id=ccm.campaign_id INNER JOIN campaign_categories cc ON cc.category_id = ccm.category_id WHERE c.campaign_id = ?");
    $req->execute(array($id));

    return $req;
}
/* 
    ---- cette function nous permet de retourner tous les campaigns cree mais avec le system de paginations
    function getRecordsCampaigns(){
        return @array;
    }
*/
function getRecordsCampaigns($pageNumber, $recordsPerPage) {
    $db = dbConnect();

    $offset = ($pageNumber - 1) * $recordsPerPage;
    $query = "SELECT * FROM campaigns LIMIT $recordsPerPage OFFSET $offset";
    $req = $db->prepare($query);
    $req->execute();

    return $req;
}

/* 
    ---- cette function nous permet de retourner tous les campaigns cree par categorie
    function getCampaignPerCantegorie(){
        return @array;
    }
*/
function getCampaignsPerCategorie($c){
    $db = dbConnect();

    $req = $db->prepare("SELECT c.*,cc.category_name FROM campaigns c JOIN campaign_category_map ccm ON c.campaign_id = ccm.campaign_id JOIN campaign_categories cc ON ccm.category_id = cc.category_id WHERE cc.category_name = ?");
    $req->execute(array($c));

    return $req;
}
/* 
    ---- cette function nous permet de retourner tous les campaigns cree par categorie
    function getCampaignOfCategorie(){
        return @array;
    }
*/
function getCampaignOfCategorie($id){
    $db = dbConnect();

    $req = $db->prepare("SELECT * FROM campaigns c INNER JOIN campaign_category_map ccm ON c.campaign_id = ccm.campaign_id WHERE ccm.category_id = ?");
    $req->execute(array($id));

    return $req;
}
/* 
    ---- cette function nous permet de retourner tous les campaigns cree par categorie avec le system de pagination
    function getRecordsCampaignsPerCategorie(){
        return @array;
    }
*/
function getRecordsCampaignsPerCategorie($pageNumber, $recordsPerPage,$c) {
    $db = dbConnect();

    $offset = ($pageNumber - 1) * $recordsPerPage;
    $query = "SELECT c.*,cc.category_name FROM campaigns c JOIN campaign_category_map ccm ON c.campaign_id = ccm.campaign_id JOIN campaign_categories cc ON ccm.category_id = cc.category_id WHERE cc.category_name = ? LIMIT $recordsPerPage OFFSET $offset";
    $req = $db->prepare($query);
    $req->execute(array($c));

    return $req;
}


/*
    ################# PARTIES DE SYSTEME D'AJOUT
*/
/* 
    ---- cette function nous permet de retourner tous les campaigns cree par categorie avec le system de pagination
    function addCampaign(){
        return @void;
    }
*/
function addCampaign(){
    $db = dbConnect();

    if(isset($_POST['return'])){
        unset($_SESSION['categories']);
        header("Location: create");
    }

    if(isset($_POST['categorieSelect'])){
        if(isset($_POST['chks'])){
            if(count($_POST['chks']) < 1){
                header("Location: create&error= Merci de choisir au moin une categorie!");
            }else{
                $categories = $_POST['chks'];
                $_SESSION['categories'] = $categories;
                header("Location: create");
            }
        }else{
            header("Location: create&error= Merci de choisir au moin une categorie!");
        }
    }

    if(isset($_POST['createCampaign'])){
        if(isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['goal_amount']) && isset($_POST['deadline'])){
            $date=date('Y-m-d H:i:s');
            $titre = $_POST['titre'];
            $desc = nl2br($_POST['description']);
            $goal_amount = $_POST['goal_amount'];
            $deadline = $_POST['deadline'];

            $filesname = explode(' ', basename($_FILES["image"]["name"]));

            $target_dir = "public/img/campaigns/";
            $target_file = $target_dir . random_int(0,10000) . $filesname[count($filesname) - 1];
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check) {
                // Check if file already exists
                // if (file_exists($target_file)) {
                //     $target_file = $target_dir . $_SESSION['user_id'] . basename($_FILES["image"]["name"]);
                // }
                // Check file size
                if ($_FILES["image"]["size"] > 500000) {
                    header("Location: ./create&error=La taille du fichier est trop grande !");
                    exit();
                }
                    
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    header("Location: ./create&error=Désole, que les fichiers d'extension avec JPG, JPEG, PNG et GIF qui sont autorisé!");
                    exit();
                }
                    
                // Check if $uploadOk is set to 0 by an error
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $req = $db->prepare("INSERT INTO campaigns VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                    $req->execute(array(null,$_SESSION['user_id'],$titre,$desc,$target_file,$goal_amount,0,$deadline,'active',$date,$date));
                    $idC = $db->lastInsertId();
                    foreach($_SESSION['categories'] as $categorie){
                        $req = $db->prepare("INSERT INTO campaign_category_map VALUES (?,?)");
                        $req->execute(array($idC,$categorie));
                    }
                    unset($_SESSION['categories']);
                    header("Location: home");
                }else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }else {
                header("Location: ./create&error=Le fichier doit être une image !");
                exit();
            }
        }
    }
}

// ######################################### TABLE CAMPAIGNS_CATEGORIES #########################################



/*
    ################# PARTIES GETTER
*/
/* 
    ---- cette function nous permet de retourner tous le categories disponible
    function getCategory(){
        return @array;
    }
*/

function getCategory($id){
    $db = dbConnect();

    $req = $db->prepare("SELECT * FROM campaign_categories WHERE category_id = ?");
    $req->execute(array($id));

    return $req;
}
/* 
    ---- cette function nous permet de retourner tous le categories disponible
    function getAllCategories(){
        return @array;
    }
*/

function getAllCategories(){
    $db = dbConnect();

    $req = $db->prepare("SELECT * FROM campaign_categories");
    $req->execute();

    return $req;
}
/* 
    ---- cette function nous permet de retourner tous les categories mais avec le system de paginations
    function getRecordsCategories(){
        return @array;
    }
*/
function getRecordsCategories($pageNumber, $recordsPerPage) {
    $db = dbConnect();

    $offset = ($pageNumber - 1) * $recordsPerPage;
    $query = "SELECT * FROM campaign_categories LIMIT $recordsPerPage OFFSET $offset";
    $req = $db->prepare($query);
    $req->execute();

    return $req;
}

/*
    ################# SYS AJOUT
*/
/* 
    ---- cette function nous permet de retourner tous le categories disponible
    function addCategorie(){
        return @array;
    }
*/
function addCategorie(){
    $db = dbConnect();

    if(isset($_POST['createCategorie'])){

    }
}



// ######################################### TABLE DONATIONS #########################################



/*
    ################# PARTIES GETTER
*/
/* 
    ---- cette function nous permet de retourner tous les donations faites dans le site
    function getDonations(){
        return @array;
    }
*/

function getDonations(){
    $db = dbConnect();

    $req = $db->prepare("SELECT * FROM donations");
    $req->execute();

    return $req;
}
/* 
    ---- cette function nous permet de retourner tous les donations faites dans le site
    function numDonationsOfCampaign(){
        return @array;
    }
*/

function numDonationsOfCampaign($id){
    $db = dbConnect();

    $req = $db->prepare("SELECT count(*) as numDonations FROM donations WHERE campaign_id = ?");
    $req->execute(array($id));

    return $req;
}
/* 
    ---- cette function nous permet de retourner tous les donations faites dans le site
    function numDonationsOfCampaign(){
        return @array;
    }
*/

function whoDonate($id){
    $db = dbConnect();

    $req = $db->prepare("SELECT count(*) as nbDonateur,u.avatar,u.first_name,u.last_name,d.anonymous_donation,SUM(d.amount) as don FROM campaigns c JOIN donations d ON c.campaign_id = d.campaign_id JOIN users u ON d.user_id = u.user_id  WHERE c.campaign_id = ? GROUP BY d.user_id ORDER BY d.amount LIMIT 5");
    $req->execute(array($id));

    return $req;
}




/*
    ################# SYS D'AJOUT
*/
/* 
    ---- cette function nous permet de retourner tous les donations faites dans le site
    function getDonations(){
        return @array;
    }
*/
function addDonation(){
    $db = dbConnect();
    if(isset($_POST['donate'])){
        // voir si les tous les champs sont remplient
        if(!isset($_POST['amount'])){
            header("Location: donate&campaign_id={$_GET['campaign_id']}&error=Merci de choisir un montant!");
        }else{
            $date=date('Y-m-d H:i:s');

            // remplir les variables avec les valeurs
            $amount = $_POST['amount'];
            $campaign = $_GET['campaign_id'];
            if(isset($_POST['anonyme'])) $anonyme = 1; else $anonyme = 0;

            $req = $db->prepare("INSERT INTO donations VALUES (?,?,?,?,?,?,?,?)");
            $req->execute(array(null,$_SESSION['user_id'],$campaign,$amount,'pending',$anonyme,$date,$date));

            if($req){
                $req = $db->prepare("SELECT current_amount FROM campaigns WHERE campaign_id = ?");
                $req->execute(array($campaign));
                $req = $req->fetch();

                $current_amount = $req['current_amount'];
                $current_amount += $amount;

                $req = $db->prepare("UPDATE campaigns SET current_amount = ? WHERE campaign_id = ?");
                $req->execute(array($current_amount,$campaign));
            }
            header("Location: donate&campaign_id={$_GET['campaign_id']}&success=Votre donation a été reçu avec succès !");
        }
    }
}