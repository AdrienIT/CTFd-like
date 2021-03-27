<?php
require './bdd.php';

if (isset($_POST['home'])){
	header('Location: index.php');
}


if(isset($_POST['create'])){
    if(empty($_POST['username']) or empty($_POST['password_1']) or empty($_POST["password_2"]) or empty($_POST["email"])) {
        echo "<script type='text/javascript'>alert('veuillez remplir tout les champs');</script>";
    }
    else{
    
        $username = htmlspecialchars($_POST["username"]);
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password_1"]);
        $password_test = htmlspecialchars($_POST['password_2']);
    
    
        $query_verif_user = $pdo->prepare("SELECT username from users where username = ?");
        $query_verif_user->execute([$username]);
    
        $query_verif_user_is_not_admin = $pdo->prepare("SELECT username from admin where username = ?");
        $query_verif_user_is_not_admin->execute([$username]);
    
        $query_verif_user_admin = $pdo->prepare("SELECT username from admin where username = ?");
        $query_verif_user_admin->execute([$username]);
    
    
        
        $query_verif_mail = $pdo->prepare("SELECT email from users where email = ?");
        $query_verif_mail->execute([$email]);
    
    
        if ($password !== $password_test) {
            echo "<script type='text/javascript'>alert('les deux mot de passes ne correspondent pas');</script>";
        }
    
        elseif ($query_verif_user-> rowCount() > 0 && $query_verif_user_is_not_admin-> rowCount() >0){
            echo "<script type='text/javascript'>alert('l utilisateur existe déjà');</script>";
            
        }
        elseif ($query_verif_mail->rowCount()>0){
            echo "<script type='text/javascript'>alert('cette email est déjà utilisé');</script>";
        
        }
        
        else {
            $token = bin2hex(random_bytes(12));
    
            $to = $email;
            $subject = "véfication de compte";
            $body = "http://localhost:8080/ctfd/verifToken.php?token=$token";
            $headers = "From: <ctfdlike@gmail.com>" . "\r\n";
            mail($to, $subject, $body, $headers);
    
            $password = password_hash($password,PASSWORD_BCRYPT);
            $query_add = $pdo->prepare("INSERT INTO users (username, email, password, token) VALUES(:username, :email, :password ,:token)");
            $query_add->bindparam(":username", $username);
            $query_add->bindparam(":email", $email);
            $query_add->bindparam(":password", $password);
            $query_add->bindparam(":token", $token);
            $query_add->execute();
            header('Location: ./login.php');
            exit;
        }
    }

}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Form-Select---Full-Date---Month-Day-Year.css">
    <link rel="stylesheet" href="assets/css/Google-Style-Login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/Login-Box-En.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/Search-Input-responsive.css">
    <link rel="stylesheet" href="assets/css/Dark-NavBar-1.css">
    <link rel="stylesheet" href="assets/css/Dark-NavBar-2.css">
    <link rel="stylesheet" href="assets/css/Dark-NavBar.css">

 
</head>

<body>
<nav class="navbar navbar-light navbar-expand-md sticky-top border rounded float-none navigation-clean-button" style="height: 80px;background-color: #37434d;color: #ffffff;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php" style="filter: blur(0px);width: 182px;margin: -18px;">
        <img src="./assets/img/shoulder_img.png" />   L&#39;Epaule</a>
        <button class="navbar-toggler" data-toggle="collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="float-left float-md-right mt-5 mt-md-0 search-area">
            <i class="fas fa-search float-left search-icon"></i>
            <input class="float-left float-sm-right custom-search-input" type="search" placeholder="Type to filter by address" style="padding: 00x;height: 35px;width: 1123px;" />
        </div>
        <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;width: 80;margin: 0;" href="login.php">
        <i class="fa fa-sign-in" style="height: -5px;width: 13px;padding: 4px;"></i>  
          Login
    </a>
</div>
</nav>
    <div class="register-photo">
        <div class="form-container"></div>
    </div>
    <div class="register-photo">
        <div class="form-container">
            <form method="post">
                <h2 class="text-center"><strong>Créer</strong> un compte</h2>
				<div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
                <div class="form-group"><input class="form-control" type="text" name="username" placeholder="username"></div>
                <div class="form-group"><input class="form-control" type="password" name="password_1" placeholder="Password"></div>
                <div class="form-group"><input class="form-control" type="password" name="password_2" placeholder="Password (repeat)"></div>
      
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="create">Création du compte</button></div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>
