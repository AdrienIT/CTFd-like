<?php
require '../bdd.php';
session_start();

if (!isset($_SESSION["connected"])) {
    header('location: ../login.php');
}

$username = $_SESSION['connected'];


$querry_get_info = $pdo->prepare("SELECT email FROM users WHERE username = :username");
$querry_get_info->bindParam(':username', $username);
$querry_get_info->execute();
$email = $querry_get_info->fetch();

$querry_get_totp = $pdo->prepare("SELECT is_totp FROM users WHERE username = :username");
$querry_get_totp->bindParam(':username', $username);
$querry_get_totp->execute();
$is_totp = implode($querry_get_totp->fetch());

$querry_get_id = $pdo->prepare('SELECT users_id from users where username = :username');
$querry_get_id->bindParam(':username', $username);
$querry_get_id->execute();
$user_id = implode($querry_get_id->fetch());

$query_is_poster = $pdo->prepare("SELECT * from post where author = :username");
$query_is_poster->bindParam(':username', $username);
$query_is_poster->execute();

$query_is_createur = $pdo->prepare('SELECT * FROM createur_details WHERE users_id = :users_id');
$query_is_createur->BindParam(':users_id', $user_id);
$query_is_createur->execute();


$set_totp = 'oui';
$del_totp = 'non';

if (isset($_POST['change_pass'])) {
    header('Location: change_pass.php');
}

if (isset($_POST['manage_content'])) {

    header('Location: ../subs/users_manage_subs.php');
}

if (isset($_POST['sup_compte'])) {
    header('Location: sup_compte.php');
}

if (isset($_POST['totp'])) {
    $query_add_totp = $pdo->prepare("UPDATE users SET is_totp = :new_totp WHERE username = :username");
    $query_add_totp->bindParam(':new_totp', $set_totp);
    $query_add_totp->bindParam(':username', $username);
    $query_add_totp->execute();

    $user_mail = implode($email);
    $query_add_token = $pdo->prepare("INSERT INTO totp (email) VALUES (:email)");
    $query_add_token->bindParam(':email', $user_mail);
    $query_add_token->execute();


    header("Refresh:0");
    exit;

    echo "<script type='text/javascript'>alert('le double authantification est maitenant activé');</script>";
}

if (isset($_POST['no_totp'])) {
    $query_del_totp = $pdo->prepare("UPDATE users SET is_totp = :set_totp WHERE username = :username");
    $query_del_totp->bindParam(':set_totp', $del_totp);
    $query_del_totp->bindParam(':username', $username);
    $query_del_totp->execute();

    $user_mail = implode($email);
    $query_del_token = $pdo->prepare("DELETE FROM totp WHERE email = :email");
    $query_del_token->bindParam(':email', $user_mail);
    $query_del_token->execute();
    header("Refresh:0");
    exit;
    echo "<script type='text/javascript'>alert('le double authantification est maitenant désactivé');</script>";
}




?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Profile</title>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
        <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="../assets/css/Profile-Edit-Form-1.css">
        <link rel="stylesheet" href="../assets/css/Profile-Edit-Form.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/Dark-NavBar-1.css">
        <link rel="stylesheet" href="../assets/css/Dark-NavBar-2.css">
        <link rel="stylesheet" href="../assets/css/Dark-NavBar.css">
        <link rel="stylesheet" href="../assets/css/Search-Input-responsive.css">
    </head>

    <body>

        <nav class="navbar navbar-light navbar-expand-md sticky-top border rounded float-none navigation-clean-button"
            style="height: 80px;background-color: #37434d;color: #ffffff;">
            <div class="container-fluid"><a class="navbar-brand" href="home_users.php"
                    style="filter: blur(0px);width: 182px;margin: -18px;">
                    &nbsp;CTFD_Like</a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="../logout.php">
                    <i class="fa fa-sign-in" style="height: -5px;width: 13px;padding: 4px;"></i>
                    &nbsp; LogOut</a>
        </nav>
        <div class="container profile profile-view" id="profile">
            <div class="col-md-8">
                <h1>Profil</h1>
                <hr>
                <div class="form-row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group"><label>Username</label></div>
                        <p><?= $username ?></p>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group"><label>Email</label></div>
                        <p><?= implode($email) ?></p>
                    </div>
                </div>
                <hr>
                <div class="form-row">

                    <div class="col-md-12 content-right">
                        <form action="profile_users.php" method="post">
                            <button class="btn btn-primary form-btn" name="manage_content">Gérer votre contenu</button>
                            <?php if ($is_totp === 'non') {
                            echo ("<button class='btn btn-primary form-btn' name='totp'>TOTP ON</button>");
                        } else {
                            echo ("<button class='btn btn-primary form-btn' name='no_totp'>TOTP OFF</button>");
                        } ?>
                            <button class="btn btn-primary form-btn" name="sup_compte">DELETE le compte</button>
                            <button class="btn btn-primary form-btn" name="change_pass">changer de MDP</button>
                        </form>
                    </div>


                </div>
            </div>


        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/bs-init.js"></script>
        <!-- <script src="assets/js/Profile-Edit-Form.js"></script> -->
    </body>

</html>
