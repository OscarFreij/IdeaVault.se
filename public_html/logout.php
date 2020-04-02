<?php
    require_once '../private_html/config.php';
    unset($_SESSION['access_token']);
    $client->revokeToken();
    session_destroy();
    
    $path = ($_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST']);
    header('Location: '.$path); 
    exit();


?>