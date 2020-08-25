<?php
    require_once("../private_html/db.class.php");

    session_start();
    
    $dbCon = new db;
    $dbCon->connectToDB();
    //
    header("Content-Type: application/json"); 
  
    $data = json_decode(file_get_contents("php://input")); 
    $idea = get_object_vars($data);
    //
    //var_dump($idea);

    if (isset($idea['id']) && isset($_SESSION['nickname']) && !isset($_GET['checkIfPublic']))
    {
        $ownerName = $dbCon->getOwnerName2($idea['id']);

        if ($_SESSION['nickname'] == $ownerName)
        {
            $dbCon->updatePost($idea['id'],$idea['title'],$idea['short'],$idea['long'],$idea['is_public']);
        }
        else
        {
            echo("Access Denied!");
        }
    }
    elseif (isset($_GET['checkIfPublic']))
    {
        $dbCon->checkIfIdeaPublic($_GET['checkIfPublic']);
    }
    elseif (isset($idea))
    {
        $ownerID = $_SESSION['id'];
        echo($dbCon->createPost($ownerID,$idea['title'],$idea['short'],$idea['long'],$idea['is_public']));
    }
    else
    {
        echo("Failed to execute task!");
    }

    $dbCon->closeConn();

?>