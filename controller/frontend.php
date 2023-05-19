<?php

require('model/frontend.php');
// PARTIE ADMINISTRATION
function panelPage(){
    $url = $url = explode('/',$_GET['url']);
    $users = getNumUsers();
    $views = getViews();
    $categories = getAllCategories();
    require("view/panel/panel.php");
}
function panelMembresPage(){
    $url = $url = explode('/',$_GET['url']);
    // Get the current page number from the URL or any other source
    $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;

    // Set the number of records per page
    $recordsPerPage = 5;

    // Get the records for the current page
    $users = getRecordsUsers($pageNumber, $recordsPerPage);
    
    // Assuming you have the total number of records available
    $x = getNumUsers();
    $totalRecords = $x['total'];

    // Calculate the total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);


    require("view/panel/membres.php");
}

// PARTIE DES MEMBRES
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
    addView();
    $categories = getAllCategories();
    //$postes = getAllCampaigns();
    $recordsPerPage = 4;
    $postes = getRecordsCampaigns(1, $recordsPerPage);
    require("view/home.php");
}
function campaignPage(){
    addView();
    $poste = getCampaign($_GET['campaign_id']);
    $nbDonation = numDonationsOfCampaign($_GET['campaign_id']);
    $nbDonation = $nbDonation->fetch();
    $donators = whoDonate($_GET['campaign_id']);
    $donators = $donators->fetchAll();
    require("view/campaign.php");
}
function campaignsPage(){
    addView();
    $categories = getAllCategories()->fetchAll();
    $postes = getAllCampaigns();
    require("view/campaigns.php");
}
function profilePage(){
    addView();
    sysModifyProfile();
    $postes = getProfilePostes();
    
    require("view/profile.php");
}
function createPage(){
    $categories = getAllCategories();
    addCampaign();
    require("view/create.php");
}
function donationPage(){
    addView();
    addDonation();
    $poste = getCampaign($_GET['campaign_id']);
    if($poste->rowCount() == 0) header("Location: campaigns");
    $poste = $poste->fetchAll();
    require("view/donation.php");
}