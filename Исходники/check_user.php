<?php
session_start();

require "bd.php";
$login = $_POST["login"];
$password = $_POST["password"];
$sql = "SELECT * FROM users";
if($arr = $mysqli->query($sql)){
	$flag = false;
	
	foreach($arr as $user_id){
		if(($user_id["login"] == $login) and ($user_id["password"] == $password)){
			$flag = true;
			$_SESSION ["id"] = $user_id["id"];
			$_SESSION ["login"] = $user_id["login"];
			header("Location: index.php");
			exit;
		}
	}
	
	if(!$flag) {
		header("Location: sign_in.php");
		exit;
	}
    
} else{
    echo "Ошибка: " . $mysqli->error;
    }
//header("Location: index.php")
?>