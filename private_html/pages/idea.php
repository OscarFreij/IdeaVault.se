<div>
    <div id="info_box" class="post">
<?php

$dbCon = new db;
$dbCon->connectToDB();

$stdObject = $dbCon->getPost($_GET['idea'],$_SESSION['id']);

$idea = get_object_vars($stdObject);
if (!isset($_GET['edit']))
{
    $title = urldecode(base64_decode($idea['title']));
    $short = urldecode(base64_decode($idea['short_description']));
    echo('<p id="title" class="title">'.$title.'</p><br>');
    echo('<p id="short_description" class="shortDescription">'.$short.'</p><br>');
    echo("<p class='author'>Author: ".$idea['author']."</p><br>");
    echo("<p class='followers'>Followers: ".$idea['followers']."</p><br>");
    echo("<div class='dateTimeBox'>");
    echo("<p class='creationDateTime'>Created: ".$idea['creation_dateTime']."</p><br>");
    echo("<p class='editDateTime'>Edited: ".$idea['edit_dateTime']."</p><br>");
    echo("</div>");
}
elseif ($_GET['edit'] == "false")
{
    $title = urldecode(base64_decode($idea['title']));
    $short = urldecode(base64_decode($idea['short_description']));
    echo('<p id="title" class="title">'.$title.'</p><br>');
    echo('<p id="short_description" class="shortDescription">'.$short.'</p><br>');
    echo("<p class='author'>Author: ".$idea['author']."</p><br>");
    echo("<p class='followers'>Followers: ".$idea['followers']."</p><br>");
    echo("<div class='dateTimeBox'>");
    echo("<p class='creationDateTime'>Created: ".$idea['creation_dateTime']."</p><br>");
    echo("<p class='editDateTime'>Edited: ".$idea['edit_dateTime']."</p><br>");
    echo("</div>");
}
elseif ($_GET['edit'] == "true")
{
    $title = urldecode(base64_decode($idea['title']));
    $short = urldecode(base64_decode($idea['short_description']));
    echo('<input id="title" value="'.$title.'"><br>');
    echo('<input id="short_description" value="'.$short.'"><br>');
    if ($idea['is_public'])
    {
        echo('<p>Idea is public: <input type="checkbox" name="is_public" id="is_public" checked="'.$idea['is_public'].'"></p>');
    }
    else
    {
        echo('<p>Idea is public: <input type="checkbox" name="is_public" id="is_public"></p>');
    }
}
else
{

}




?>
<div id="container">
    <p>Description</p>
    <div id="editor_container">

    </div>
</div>

    </div>
    <div id="button_panel">
        
        <?php
            if ($dbCon->checkIfFollow($_SESSION['id'],"Idea",$idea['id']) && (!isset($_GET['edit'])||$_GET['edit'] == "false"))
            {
                echo("<button id='followBTN' onclick='toggleFollow()' class='btn btn-primary'>".'Following Idea'."</button>");
            }
            elseif (!isset($_GET['edit'])||$_GET['edit'] == "false")
            {
                echo("<button id='followBTN' onclick='toggleFollow()' class='btn btn-primary'>".'Follow Idea'."</button>");
            }

            if ($idea['author'] == $_SESSION['nickname'])
            {
                if (!isset($_GET['edit']) || $_GET['edit'] == "false")
                {
                    echo("<a id='editBTN' class='btn btn-primary' href='?idea=".$idea['id']."&edit=true'>Edit Idea</a>");
                }
                elseif ($_GET['edit'] == "true")
                {
                    echo("<button id='saveBTN' class='btn btn-success' onclick='saveContent()'>".'Save'."</button>");
                    echo("<a id='exitBTN' class='btn btn-danger' href='?idea=".$idea['id']."'>".'Exit'."</a>");
                    echo("<button id='delBTN' class='btn btn-danger' onclick='deletePost()'>".'Remove Idea'."</button>");
                }
                
            }

            
            $dbCon->closeConn();
        ?>

    </div>
</div>