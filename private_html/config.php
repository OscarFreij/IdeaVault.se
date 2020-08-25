<?php
session_start();
require_once '../private_html/vendor/autoload.php';
$path = ($_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST']);

// init configuration
$clientID = '553679577116-f0ishd0td7sp4bj1rssbklt6t5q2d412.apps.googleusercontent.com';
$clientSecret = '-lRUbqPUoE2M7plVEcvvBbBI';
$redirectUri = $path.'/redirect.php';
  
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

//:: HACKY WAKY :://
//$client->setApprovalPrompt('force');

$client->prompt="select_account";
$client->setIncludeGrantedScopes(true);