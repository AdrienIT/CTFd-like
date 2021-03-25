<?php
require './bdd.php';

if(!empty($_GET['token'])){
    $tokenURL = $_GET['token'];

    $queryGetToken = $pdo->prepare("SELECT token FROM users WHERE token = :tokenURL");
    $queryGetToken->bindParam(':tokenURL',$tokenURL);
    $queryGetToken->execute();
    $tokenCheck = $queryGetToken->fetch();

    if ($queryGetToken->rowCount() > 0){
        $querryVerifAccount = $pdo->prepare("UPDATE users SET token = 0 , isVerified = true WHERE token = :tokenURL");
        $querryVerifAccount->bindparam(":tokenURL", $tokenURL);
        $querryVerifAccount->execute();
        header('Location: ./login.php');

    }
    else {
        echo "<script type='text/javascript'>alert('votre token n'est pas valide');</script>";
    }

}

?>