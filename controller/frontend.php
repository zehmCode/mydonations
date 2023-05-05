<?php

require('model/frontend.php');

function loginPage(){
    addView();
    sysLogin();
    require("view/login.php");
}
function signUpPage(){
    addView();
    sysSignup();
    require("view/signup.php");
}
function homePage(){
    // ajout de vue
    addView();
    //searchCity();
    //affichage des donnes
    //$cities = getCities();
    //$hotelsCities = getHotelCities();
    require("view/home.php");
}
function profilePage(){
    addView();
    sysModifyProfile();
    $postes = getProfilePostes();
    
    require("view/profile.php");
}
// function sejourPage(){
//     $url = $url = explode('/',$_GET['url']);
//     // ajout de vue
//     addView();

//     // affichage des donnees
//     if(count($url) >= 2){
//         $name = $url[1];
//         $hotelsFromCity = getHotelsFromCity($name);
//     }
//     $hotelsCities = getHotelCities();

//     require("view/sejour.php");
// }

// function hotelPage(){
//     $url = $url = explode('/',$_GET['url']);
//     addView();
//     reserve();

//     //affichage des donnee
//     if(count($url) > 2){
//         $id = intval($url[2]);
//         $hotel = getHotel($id)->fetch();
//         $photos = getPhotos($id)->fetchAll();
//     }

//     require("view/hotel.php");
// }

// function panelPage(){
//     $url = $url = explode('/',$_GET['url']);
//     // system d'ajout
//     addView();
//     addCountry();
//     addCity();
//     addHotel();
//     addRoom();

//     // system de modification
//     editCountry();
//     //editCity();

    
//     // affichage des donnees
//     $countries = getCountries();
//     $cities = getCities();
//     $hotels = getHotels();
//     $rooms = getRooms();
//     $reservations = getReservations();
//     if(count($url) > 2){
//         $id = intval($url[2]);
//         editHotel($id);
//         $hotel = getHotel($id)->fetch();
//     }
        

//     //  stats pour le dashboard
//     $countMember = countMember()->fetch();
//     $countCountry = countCountry()->fetch();
//     $countCity = countCity()->fetch();
//     $countHotel = countHotel()->fetch();
//     $countView = countViews()->fetch();
//     $countReservation = countReservation()->fetch();

//     require("view/panel.php");
// }