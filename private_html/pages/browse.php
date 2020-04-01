<?php

require_once("../private_html/db.class.php");

$dbCon = new db;
$dbCon->connectToDB();
echo('<div class="Ideas">');

$data = $dbCon->getPosts();

echo("</div>");