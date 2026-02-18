<?php
session_start();

require "bd.php";
$songID = $_GET['songID'];
$action = $_GET['action'];

$sql = "INSERT INTO user_actions VALUES (DEFAULT, " . htmlspecialchars($_SESSION['id']) . ", " . htmlspecialchars($songID) . ", '" . htmlspecialchars($action) . "', DEFAULT);";

echo $sql;

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->close();

?>