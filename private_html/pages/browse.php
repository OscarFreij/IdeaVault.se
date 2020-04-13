<?php

$dbCon = new db;
$dbCon->connectToDB();

$numberOfIdeas = $dbCon->getPostAmount(true);

$dbCon->closeConn();

if(!isset($_GET['pagenr']))
{
    $pagenr = 1;
}
else
{
    $pagenr = $_GET['pagenr'];
}

if($numberOfIdeas % 10 > 0)
{
    $maxPageNumber = 1+($numberOfIdeas-($numberOfIdeas % 10))/10;
}
else
{
    $maxPageNumber = ($numberOfIdeas-($numberOfIdeas % 10))/10;    
}

$nextBTN = "";
$previousBTN = "";

if ($pagenr == $maxPageNumber)
{
    $nextBTN = "disabled";
}
if ($pagenr == 1)
{
    $previousBTN = "disabled";
}

echo('<div class="Ideas">');



echo('<div id="bottom"></div>');
echo("</div>");
?>
<div class="container">
    <div class="btn-group btn-group-justified">
        <a class="btn-group" href="http://ideavault.se/?page=browseIdeas&pagenr=1">
            <button class="btn btn-primary" <?=$previousBTN?>>|&lt;</button>
        </a>
        <a class="btn-group" href="http://ideavault.se/?page=browseIdeas&pagenr=<?=$pagenr-1?>">
            <button class="btn btn-primary" <?=$previousBTN?>>&lt;</button>
        </a>
        <div class="btn-group">
            <input type="number" style="text-align: center;" class="form-control col-xs-1" placeholder="NR" value="<?=$pagenr?>">
        </div>
        <a class="btn-group" href="http://ideavault.se/?page=browseIdeas&pagenr=<?=$pagenr+1?>">
            <button class="btn btn-primary" <?=$nextBTN?>>&gt;</button>
        </a>
        <a class="btn-group" href="http://ideavault.se/?page=browseIdeas&pagenr=<?=$maxPageNumber?>">
            <button class="btn btn-primary" <?=$nextBTN?>>&gt;|</button>
        </a>
    </div>
</div>
