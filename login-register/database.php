<?php

$hostname = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login_reg";
$conn = mysqli_connect($hostname, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong");


}
