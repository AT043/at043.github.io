<?php

$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "bacabuku";


$con = mysqli_connect($serverName, $username, $password, $dbName);

if (!$con) {
    die("Connection Failed" . mysqli_connect_error());
}