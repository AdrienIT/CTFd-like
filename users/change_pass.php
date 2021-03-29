<?php
require_once('sendmail/class.phpmailer.php');
require '../function/connexion_test.php';
if (!isset($_COOKIE["user_cookie"])) {
    header('Location: ../login.php');
}

require '../bdd.php';


$username = $_SESSION['connected'];

?>

<form method="post">

    <input type="password" name="old_pass" placeholder="mot de passe actuel">

    <input type="password" name="new_pass" placeholder="nouveau mot de passe">

    <input type="password" name="new_pass_verif" placeholder="comfirmation nouveau mot de passe">

    <button type="submit">changer le mot de passe</button>
</form>


<?php

if (isset($_POST["old_pass"]) && isset($_POST["new_pass"]) && isset($_POST["new_pass_verif"])) {

    $old_pass = htmlspecialchars(md5($_POST['old_pass']));
    $new_pass = htmlspecialchars(md5($_POST['new_pass']));
    $new_pass_verif = htmlspecialchars(md5($_POST['new_pass_verif']));



    $query_verif_old_pass = $pdo->prepare("SELECT password from users where password = :password");
    $query_verif_old_pass->bindParam(':password', $old_pass);
    $query_verif_old_pass->execute();

    if (!isset($_POST["old_pass"]) && !isset($_POST["new_pass"]) && !isset($_POST["new_pass_vérif"])) {
        echo "<script type='text/javascript'>alert('veuillez remplir les champs');</script>";
    }

    if ($query_verif_old_pass->rowCount() == 0) {
        echo "<script type='text/javascript'>alert('votre ancien mot de passe ne correspond pas');</script>";
    }

    if ($new_pass !== $new_pass_verif) {
        echo "<script type='text/javascript'>alert('les deux mot de passes ne correspondent pas');</script>";
    } else {


        $querry_change_info = $pdo->prepare("UPDATE users SET password = :password WHERE password = :old_pass");
        $querry_change_info->bindparam(":password", $new_pass);
        $querry_change_info->bindparam(":old_pass", $old_pass);
        $querry_change_info->execute();
        echo "<script type='text/javascript'>alert('changement éffectué');</script>";
        header('Location: profile_users.php');
    }
}


?>
