<?php
    require_once("../private_html/db.class.php");

    session_start();

    $dbCon = new db;
    $dbCon->connectToDB();
    
    $numberOfIdeas = $dbCon->getPostAmount(true);

    //echo $numberOfIdeas;
    if (isset($_GET["LastPostLimit"]) && isset($_GET["AmountToLoad"]))
    {
        //echo $numberOfIdeas;
        echo($dbCon->getPosts($_GET['LastPostLimit'],$_GET["AmountToLoad"]));
    }
    else
    {
        echo($_SESSION['nickname']);
    }

    $dbCon->closeConn();

?>