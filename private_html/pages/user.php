<?php


$dbCon = new db;
$dbCon->connectToDB();
echo "<pre>";
var_dump($user_info = $dbCon->getUserInfoNick($_GET['user']));
echo "</pre>";

echo "<br><img src='".$user_info['profile_picture']."'></img>";


?>