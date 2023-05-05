<?php
session_start();
require('controller/frontend.php');

$url = '';
if(isset($_GET['url'])){
    $url = explode('/',$_GET['url']);
}

if($url == ''){
    header("Location: home");
}else if($url[0] == 'home'){
    if(count($url) > 1){header("Location: ../{$url[0]}"); return;}
    homePage();
}else if($url[0] == 'profile'){
    if(!isset($_SESSION['user_id'])){header("Location: home"); return;}
    if(count($url) > 1){header("Location: ../{$url[0]}"); return;}
    profilePage();
}else if($url[0] == 'login'){
    if(isset($_SESSION['user_id'])){header("Location: home"); return;}
    if(count($url) > 1){header("Location: ../{$url[0]}"); return;}
    loginPage();
}else if($url[0] == 'signup'){
    if(isset($_SESSION['user_id'])){header("Location: home"); return;}
    if(count($url) > 1){header("Location: ../{$url[0]}"); return;}
    signUpPage();
}else if($url[0] == 'signout'){
    session_destroy();
    header("Location: home");
}else{
    header("Location: 404");
}