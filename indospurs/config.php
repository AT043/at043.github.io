<?php

$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "indospurs";


$mysqli = mysqli_connect($serverName, $username, $password, $dbName);

if (!$mysqli) {
    die("Connection Failed" . mysqli_connect_error());
}

echo ("Connection succes!");