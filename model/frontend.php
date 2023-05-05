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
                $req = $db->prepare("INSERT INTO users VALUES (?,?,?,?,?,?,?,?)");
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

// ######################################### PARTIE POUR LES STATISTIQUES #########################################
// tous les system d'ajout
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




// // function pour avoir les informations du stagiare
// function getUser(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT * FROM users WHERE id=?");
//     $req->execute(array($_SESSION['id']));

//     return $req;
// }

// // function pour avoir les hotels d'une ville
// function getHotelsFromCity($name){
//     $db = dbConnect();

//     $req = $db->prepare("SELECT room,hotel.id as idh,hotel_name,address,description,room,city_name,photo 
//     FROM cities 
//     LEFT JOIN hotel ON city=cities.id 
//     RIGHT JOIN photo ON hotel.id=hotel WHERE city_name=? GROUP BY hotel");
//     $req->execute(array($name));

//     return $req;
// }

// // function pour avoir la liste des pays
// function getCountries(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT * FROM countries");
//     $req->execute();

//     return $req;
// }
// // function pour avoir la liste des villes
// function getCities(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT cities.id as idc,city_name,country_name,thumbnail FROM cities LEFT JOIN countries ON cities.country=countries.id");
//     $req->execute();

//     return $req;
// }

// // function pour avoir la liste des hotels
// function getHotels(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT hotel.id as idh,hotel_name,address,hotel.description,price,room FROM hotel");
//     $req->execute();

//     return $req;
// }
// // function pour avour un seul hotel
// function getHotel($id){
//     $db = dbConnect();

//     $req = $db->prepare("SELECT * FROM hotel INNER JOIN cities ON hotel.city=cities.id WHERE hotel.id=?");
//     $req->execute(array($id));

//     return $req;
// }
// //function pour avoir les information de l'hotel
// function getPhotos($id){
//     $db = dbConnect();

//     $req = $db->prepare("SELECT photo FROM photo WHERE hotel=?");
//     $req->execute(array($id));
//     return $req;
// }

// // function pour avoir les chambres
// function getRooms(){
//     $db = dbConnect();
    
//     $req = $db->prepare("SELECT * FROM rooms");
//     $req->execute();

//     return $req;
// }

// //function pour afficher les villes et nombre d'hotels disponible
// function getHotelCities(){
//     $db = dbConnect();

//     $req = $db->prepare("SELECT cities.id as idc,city_name,thumbnail,count(hotel.id) as hotels FROM cities RIGHT JOIN hotel ON cities.id=hotel.city WHERE country=? GROUP BY city");
//     $req->execute(array(1));

//     return $req;
// }

// // function pour avoir les informartions de la reservation
// function getReservations(){
//     $db = dbConnect();
    
//     $req = $db->prepare("SELECT hotel_name,reservation_price,adults,childs,rooms,name,last_name,reservation.id as idr,created_at 
//     FROM users 
//     INNER JOIN reservation ON user=users.id
//     INNER JOIN hotel ON hotel=hotel.id");
//     $req->execute();

//     return $req;
// }

// // Statistiques
// function countMember(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT count(*) AS nbMember FROM users");
//     $req->execute();

//     return $req;
// }
// function countCountry(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT count(*) AS nbPays FROM countries");
//     $req->execute();

//     return $req;
// }
// function countCity(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT count(*) AS nbVilles FROM cities");
//     $req->execute();

//     return $req;
// }
// function countHotel(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT count(*) AS nbHotel FROM hotel");
//     $req->execute();

//     return $req;
// }
// function countViews(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT view FROM views");
//     $req->execute();

//     return $req;
// }
// function countReservation(){
//     $db = dbConnect();
//     $req = $db->prepare("SELECT count(*) FROM reservation");
//     $req->execute();

//     return $req;
// }




// function addCountry(){
//     $db = dbConnect();

//     if(isset($_POST['addCountry'])){
//         if(isset($_POST['country_name'])){
//             $country = $_POST['country_name'];

//             $req = $db->prepare("INSERT INTO countries VALUES (?,?)");
//             $req->execute(array(null,$country));
//             header("Location: ./country&success=Vous avez ajouter une pays avec success !");
//         }else{
//             header("Location: ./country&error=Merci de remplire les champs demander !");
//             exit();
//         }
//     }
// }

// function addCity(){
//     $db = dbConnect();

//     if(isset($_POST['addCity'])){
//         if(isset($_POST['city_name']) && isset($_POST['country'])){
//             $city = $_POST['city_name'];
//             $country = $_POST['country'];

//             $target_dir = "public/img/thumbnail/";
//             $target_file = $target_dir . basename($_FILES["image"]["name"]);
//             $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


//             // Check if image file is a actual image or fake image
//             $check = getimagesize($_FILES["image"]["tmp_name"]);
//             if($check) {
//                 // Check if file already exists
//                 if (file_exists($target_file)) {
//                     header("Location: ./city&error=Le fichier existe déja !");
//                     exit();
//                 }
//                 // Check file size
//                 if ($_FILES["image"]["size"] > 500000) {
//                     header("Location: ./city&error=La taille du fichier est trop grande !");
//                     exit();
//                 }
                    
//                 // Allow certain file formats
//                 if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
//                     header("Location: ./city&error=Désole, que les fichiers d'extension avec JPG, JPEG, PNG et GIF qui sont autorisé!");
//                     exit();
//                 }
                    
//                 // Check if $uploadOk is set to 0 by an error
//                 if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
//                     $req = $db->prepare("INSERT INTO cities VALUES (?,?,?,?)");
//                     $req->execute(array(null,$city,$country,$target_file));
//                     header("Location: ./city&success=Vous avez ajouter une ville avec success !");
//                 }else {
//                     echo "Sorry, there was an error uploading your file.";
//                 }
//             }else {
//                 header("Location: ./city&error=Le fichier doit être une image !");
//                 exit();
//             }
//         }
//     }
// }

// function addHotel(){
//     $db = dbConnect();

//     if(isset($_POST['addHotel'])){
//         if(isset($_POST['hotel_name']) && isset($_POST['hotel_adresse']) && isset($_POST['room']) && isset($_POST['hotel_city']) && isset($_POST['hotel_description']) && isset($_POST['hotel_price']) && isset($_FILES['photo'])){
//             $hotel_name = $_POST['hotel_name'];
//             $hotel_adresse = $_POST['hotel_adresse'];
//             $hotel_description = $_POST['hotel_description'];
//             $hotel_price = $_POST['hotel_price'];
//             $room = $_POST['room'];


//             $hotel_city = $_POST['hotel_city'];

//             $req = $db->prepare("SELECT cities.id as idc FROM cities WHERE city_name=?");
//             $req->execute(array($hotel_city));
//             $city = $req->fetch();

//             if($city){
//                 $req = $db->prepare("INSERT INTO hotel VALUES (?,?,?,?,?,?,?)");
//                 $req->execute(array(null,$hotel_name,$hotel_adresse,$hotel_description,$hotel_price,$room,$city['idc'])); 
//                 $last_id = $db->lastInsertId();
//                 $target_dir = "public/img/hotels/$last_id-";
//                 $countFile = count($_FILES['photo']['name']);
                
//                 for($i=0;$i<$countFile;$i++){
//                     $target_file = $target_dir . basename($_FILES['photo']['name'][$i]);
//                     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//                     // Check if image file is a actual image or fake image
//                     $check = getimagesize($_FILES["photo"]["tmp_name"][$i]);
//                     if($check) {
//                         // Check if file already exists
//                         if (file_exists($target_file)) {
//                             header("Location: ./addHotel&error=Le fichier existe déja !");
//                             exit();
//                         }
//                         // Check file size
//                         if ($_FILES["photo"]["size"][$i] > 500000) {
//                             header("Location: ./addHotel&error=La taille du fichier est trop grande !");
//                             exit();
//                         }
                            
//                         // Allow certain file formats
//                         if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
//                             header("Location: ./addHotel&error=Désole, que les fichiers d'extension avec JPG, JPEG, PNG et GIF qui sont autorisé!");
//                             exit();
//                         }
                            
//                         // Check if $uploadOk is set to 0 by an error
//                         if (move_uploaded_file($_FILES["photo"]["tmp_name"][$i], $target_file)) {
//                             $req = $db->prepare("INSERT INTO photo VALUES (?,?,?)");
//                             $req->execute(array(null,$target_file,$last_id));
//                             header("Location: ./addHotel&success=Vous avez ajouter une ville avec success !");
//                         }else {
//                             header("Location: ./addHotel&error=Desole, il y a eu un probleme.");
//                         }
//                     }else {
//                         header("Location: ./addHotel&error=Le fichier doit être une image !");
//                         exit();
//                     }
//                 }
//             }else{
//                 header("Location: ./addHotel&error=Il y a eu un probleme d'ajout !");
//                 exit();
//             }
//         }
//     }
// }
// function addRoom(){
//     $db = dbConnect();

//     if(isset($_POST['addRoom'])){
//         if(isset($_POST['room_name']) && isset($_POST['room_price'])){
//             $category = $_POST['room_name'];
//             $room_price = $_POST['room_price'];

//             $req = $db->prepare("INSERT INTO rooms VALUES (?,?,?)");
//             $req->execute(array(null,$category,$room_price));
//             header("Location: ./room&success=Vous avez ajouter une chambre avec success !");
//         }else{
//             header("Location: ./room&error=Merci de remplire les champs demander !");
//             exit();
//         }
//     }
// }


// // tous les system de modification
// function editHotel($id){
//     $db = dbConnect();

//     if(isset($_POST['editHotel'])){
//         if(isset($_POST['hotel_name']) && isset($_POST['hotel_adresse']) && isset($_POST['room']) && isset($_POST['hotel_city']) && isset($_POST['hotel_description']) && isset($_POST['hotel_price'])){
//             $hotel_name = $_POST['hotel_name'];
//             $hotel_adresse = $_POST['hotel_adresse'];
//             $hotel_description = $_POST['hotel_description'];
//             $hotel_price = $_POST['hotel_price'];
//             $room = $_POST['room'];


//             $hotel_city = $_POST['hotel_city'];

//             $req = $db->prepare("SELECT cities.id as idc FROM cities WHERE city_name=?");
//             $req->execute(array($hotel_city));
//             $city = $req->fetch();

//             if($city){
//                 $req = $db->prepare("UPDATE hotel set hotel_name=?, description=?, address=?, price=?, room=?,city=? WHERE hotel.id=?");
//                 $req->execute(array($hotel_name,$hotel_description,$hotel_adresse,$hotel_price,$room,$city['idc'],$id));
//                 header("Location: ../hotel&success=Vous avez modifier les informations avec success !");
//             }else{
//                 header("Location: ../hotel&error=Il y a eu un probleme de modification !");
//                 exit();
//             }
//         }
//     }
// }

// function editCountry(){
//     $db = dbConnect();

//     if(isset($_POST['editCountry'])){
//         if(isset($_POST['country_name']) && isset($_POST['country_id'])){
//             $country = $_POST['country_name'];
//             $country_id = $_POST['country_id'];

//             $req = $db->prepare("UPDATE countries SET country_name=? WHERE id=?");
//             $req->execute(array($country,$country_id));
//             header("Location: ./country&success=Vous avez modifiez le pays avec success !");
//         }else{
//             header("Location: ./country&error=Merci de remplire les champs demander !");
//             exit();
//         }
//     }
// }

// function editCity(){
//     $db = dbConnect();

//     if(isset($_POST['editCity'])){
//         if(isset($_POST['city_name']) && isset($_POST['country'])){
//             $city = $_POST['city_name'];
//             $country = $_POST['country'];

//             $target_dir = "public/img/thumbnail/";
//             $target_file = $target_dir . basename($_FILES["image"]["name"]);
//             $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


//             // Check if image file is a actual image or fake image
//             $check = getimagesize($_FILES["image"]["tmp_name"]);
//             if($check) {
//                 // Check if file already exists
//                 if (file_exists($target_file)) {
//                     header("Location: ./city&error=Le fichier existe déja !");
//                     exit();
//                 }
//                 // Check file size
//                 if ($_FILES["image"]["size"] > 500000) {
//                     header("Location: ./city&error=La taille du fichier est trop grande !");
//                     exit();
//                 }
                    
//                 // Allow certain file formats
//                 if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
//                     header("Location: ./city&error=Désole, que les fichiers d'extension avec JPG, JPEG, PNG et GIF qui sont autorisé!");
//                     exit();
//                 }
                    
//                 // Check if $uploadOk is set to 0 by an error
//                 if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
//                     $req = $db->prepare("INSERT INTO cities VALUES (?,?,?,?)");
//                     $req->execute(array(null,$city,$country,$target_file));
//                     header("Location: ./city&success=Vous avez ajouter une ville avec success !");
//                 }else {
//                     echo "Sorry, there was an error uploading your file.";
//                 }
//             }else {
//                 header("Location: ./city&error=Le fichier doit être une image !");
//                 exit();
//             }
//         }
//     }
// }
// // Traitement de recherche
// function searchCity(){
//     $db = dbConnect();

//     if(isset($_POST['search'])){
//         if(isset($_POST['villes'])){
//             $ville = $_POST['villes'];
//             header("Location: sejour/$ville");
//         }
//     }
// }


// // function pour la reservation d'une chambre
// function reserve(){
//     $url = $url = explode('/',$_GET['url']);
//     $db = dbConnect();


//     if(isset($_POST['reserver'])){
//         if(!isset($_SESSION['id']))
//             header("Location: ../../login");
//         if(isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['children']) && isset($_POST['adults']) && isset($_POST['rooms'])){
//             $idh = $_POST['idh'];
//             $idc = $_SESSION['id'];
//             $start_date = $_POST['start_date'];
//             $end_date = $_POST['end_date'];
//             $price = $_POST['price'];
//             $date = date("Y-m-d");

//             $datetime1 = new DateTime("$start_date");
//             $datetime2 = new DateTime("$end_date");
//             $difference = $datetime1->diff($datetime2);

//             $adults = $_POST['adults'];
//             $children = empty($_POST['children'])?$_POST['children']:0;
//             $rooms = $_POST['rooms'];
//             $room = $_POST['room'];
//             $room -= $rooms;
//             $price *= $difference->days;

//             $req = $db->prepare("INSERT INTO reservation VALUES (?,?,?,?,?,?,?,?,?,?)");
//             $req->execute(array(
//                 null,
//                 $start_date,
//                 $end_date,
//                 $price,
//                 $adults,
//                 $children,
//                 $rooms,
//                 $idc,
//                 $idh,
//                 $date
//             ));

//             $req = $db->prepare("UPDATE hotel SET room=? WHERE id=?");
//             $req->execute(array($room,$idh));

//             header("Location: ../{$url[1]}/{$url[2]}&success=Votre reservation a bien été prise en compte!");
//         }else{
//             header("Location: ../{$url[1]}/{$url[2]}&error=Meric de remplire tous les champs");
//             exit();
//         }
//     }
// }