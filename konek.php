<?php
$hostname = "localhost";
$user = "root";
$password = "";
$db_name = "admin";

$kon = mysqli_connect($hostname,$user,$password,$db_name) or die(mysqli_error($kon));
