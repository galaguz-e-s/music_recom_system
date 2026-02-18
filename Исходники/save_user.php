<?php
session_start();

require "bd.php";
$login = $_POST["login"];
$password = $_POST["password"];

$sql = "INSERT INTO users (login, password) VALUES ('$login', '$password')";
if($mysqli->query($sql)){
    $_SESSION ["login"] = $login;
    header("Location: sign_in.php");
    exit;
} 
else {
	header("Location: sign_up.php");
    exit;
}


?>