<?php
require '../bdd.php';

if (!isset($_COOKIE["admin_cookie"])) {
    header('location: ../loginPhp.php');
}

if (isset($_POST['change_pass'])) {
    header('Location: ./changePass.php');
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
                    style="filter: blur(0px);width: 182px;margin: -18px;">&nbsp;CTFD_Like</a>

                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="../logout.php">
                    <i class="fa fa-sign-in" style="height: -5px;width: 23px;padding: 4px;"></i>
                    &nbsp; LogOut</a>
        </nav>
        <div class="container profile profile-view" id="profile">
            <div class="col-md-8">
                <h1>Profil</h1>
                <hr>
                <div class="form-row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group"><label>Username : <p><?= $username ?></p></label></div>
                    </div>
                </div>


                <hr>
                <div class="form-row">

                    <div class="col-md-12 content-right">
                        <form action="profileAdmin.php" method="post">
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
