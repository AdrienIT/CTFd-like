<?php
require '../bdd.php';
session_start();

if (!isset($_SESSION["connected"])) {
    header('location: ../login.php');
}
$username = $_SESSION['connected'];

$querry_is_admin = $pdo->prepare('SELECT username from admin where username = :username');
$querry_is_admin->bindParam(':username',$username);
$querry_is_admin->execute();

if($querry_is_admin->rowCount() == 0 ){
    header('Location: ../login.php');
    exit;
}


?>