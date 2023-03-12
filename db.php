<?php

$db_host = "localhost";
$db_name = "moviestar";
$db_user = "root";
$db_pass = "";

$connect = new PDO("mysql:host$db_host;dbname=$db_name", $db_user, $db_pass);

$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);