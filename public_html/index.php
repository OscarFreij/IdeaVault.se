<?php

require_once '../private_html/vendor/autoload.php';

require_once '../private_html/config.php';

require_once("../private_html/db.class.php");


if(isset($_GET['page']))
{
    $activePage = $_GET['page'];
}
else
{
    $activePage = "home";
}

    $headinclude = (
    '
    <script src="static/ext/bootstrap/js/jquery-3.4.1.min.js"></script>
    <script src="static/ext/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="static/ext/bootstrap/css/bootstrap.css">
    '
);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IdeaVault</title>

    <?php
    // including head links!
    echo($headinclude);
    ?>

    <link rel="stylesheet" href="static/css/master.css">

    <?php
    if ($activePage == "" || strpos($activePage, 'home') !== false)
    {

    }
    elseif (strpos($activePage, 'browseIdeas') !== false)
    {
        echo('<link rel="stylesheet" href="static/css/browse.css">');
        echo('<script src="static/js/browser.js"></script>');
    }
    elseif (strpos($activePage, 'postIdea') !== false)
    {

    }
    else
    {
        
    }
    ?>
    
    <link rel="stylesheet" href="static/ext/quill/css/quill.core.css">
    <link rel="stylesheet" href="static/ext/quill/css/quill.snow.css">
    <link rel="stylesheet" href="static/ext/quill/css/quill.bubble.css">

    <script src="static/ext/quill/js/quill.core.js"></script>
    <script src="static/ext/quill/js/quill.js"></script>
    <script src="static/ext/quill/js/quill.min.js"></script>

</head>
<body>

<?php
if (!isset($_GET['user']) && !isset($_GET['idea']))
{
    if ($activePage == "" || strpos($activePage, 'home') !== false)
    {
        $isActive = array("active","","","");
        // including Navbar!
        require("../private_html/modules/navbar.php");
        require("../private_html/pages/home.php");
    }
    elseif (strpos($activePage, 'browseIdeas') !== false)
    {
        $isActive = array("","active","","");
        // including Navbar!
        require("../private_html/modules/navbar.php");
        require("../private_html/pages/browse.php");
    }
    elseif (strpos($activePage, 'postIdea') !== false)
    {
        $isActive = array("","","active","");
        // including Navbar!
        require("../private_html/modules/navbar.php");
        require("../private_html/pages/postIdea.php");
    }
    else
    {
        // including Navbar!
        require("../private_html/modules/navbar.php");
        require("../private_html/pages/404.php");
        //echo("Error: Page dose not exist!");
    }
}
else if (isset($_GET['user']) && !isset($_GET['idea']))
{
    if($_GET['user'] == $_SESSION['nickname'])
    {
        $isActive = array("","","","active");
    }
    else
    {
        $isActive = array("","","","");
    }

    // Chack if user exists
    /*
    if($_GET['user'] Exists in)
    {
        require("../private_html/modules/navbar.php");
        require("../private_html/pages/user.php");
    }
    else
    {
        require("../private_html/modules/navbar.php");
        require("../private_html/pages/404.php");
    }
    */

    // TEMP //

    // TODO: Make this work //
    require("../private_html/modules/navbar.php");
    require("../private_html/pages/user.php");
}
else if (!isset($_GET['user']) && isset($_GET['idea']))
{
    require("../private_html/modules/navbar.php");
    require("../private_html/pages/idea.php");
}
else
{
    echo("WARNING INVALID URL!");
    require("../private_html/modules/navbar.php");
    require("../private_html/pages/404.php");
}

/*
 * https://base64.guru/developers/php/examples/encode-image
 */

// Define local path or URL of our image
$img_file = 'kyoani.jpg';

// Load file contents into variable
$bin = file_get_contents($img_file);

// Encode contents to Base64
$b64 = base64_encode($bin);

// Show the Base64 value
echo ("<!--".$b64."-->");

?>


</body>
</html>
