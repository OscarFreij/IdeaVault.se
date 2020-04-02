<?php
session_start();
require_once '../private_html/vendor/autoload.php';
$path = ($_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST']);

// init configuration
$clientID = '';
$clientSecret = '';
$redirectUri = $path.'/redirect.php';
  
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");