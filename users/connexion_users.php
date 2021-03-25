<?php
require '../bdd.php';
require '../function/connexion_test.php';


if (isset ($_POST["connexion"])){
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars(md5($_POST["password"]));
}

$query_verif = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$query_verif->execute([$username,$password]);

if (is_connected()){
    header('Location: ./home_demandeur.php');
}

if (!empty($_POST['username']) && !empty($_POST['password'])){
    if ($query_verif->rowCount()>0){
        session_start();
        $_SESSION['connected'] = $username;
        header('Location: ./home_demandeur.php');
        exit;

    }
    elseif ($query_verif->rowCount() == 0){
        echo "<script type='text/javascript'>alert(l identifiant et le mot de passe ne correspondent pas);</script>";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
        <input type="username" placeholder="username" name ="username">
        <input type="password"placeholder="password" name="password">
        <button action="submit" name="connexion">se connecter</button>
    </form>
</body>
</html>