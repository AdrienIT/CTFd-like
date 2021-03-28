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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>L'épaule</title>
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

    <nav class="navbar navbar-light navbar-expand-md sticky-top border rounded float-none navigation-clean-button" style="height: 80px;background-color: #37434d;color: #ffffff;">
        <div class="container-fluid"><a class="navbar-brand" href="home_users.php" style="filter: blur(0px);width: 182px;margin: -18px;">&nbsp;<img data-bs-hover-animate="bounce" src="../assets/img/shoulder_img.png">&nbsp; &nbsp;L'Epaule</a>

            <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="../logout.php">
            <i class="fa fa-sign-in" style="height: -5px;width: 13px;padding: 4px;"></i>
            &nbsp; LogOut</a>
    </nav>


        <?php
            // $challnametmp = shell_exec("sudo docker ps -a --format 'table {{.Names}}\t{{.Status}}' | cut -f1 -d '('");
            // $challnametmp = shell_exec("sudo docker ps -a --format 'table {{.Names}}' | cut -f1 -d '('");
            // $challstatus = shell_exec("sudo docker ps -a --format 'table {{.Status}}' | cut -f1 -d '('");
            $cnf = explode(PHP_EOL, $challnametmp);
            // $csf = explode(PHP_EOL, $challstatus);

            $challnametmp = array(shell_exec("sudo docker ps -a --format 'table {{.Names}}' | cut -f1 -d '('"););
            $challstatus = array(shell_exec("sudo docker ps -a --format 'table {{.Status}}' | cut -f1 -d '('"););

}

            // foreach(array_slice($cnf, 1) as $container) 
            foreach($challnametmp as $key => $value) {
                echo "Code is: " . $challnametmp[$key] . " - " . "and Name: " . $challstatus[$key] . "<br>";{
                ?>
                
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $container;?></h4>
                    <h6 class="text-muted card-subtitle mb-2"></h6>
                    <button class="btn btn-primary active text-center d-block pull-right" type="button" style="height: 61px;background-color: rgb(0,105,217);"><a href="dockerAction.php?start=<?= $$challnametmp[$key];$challstatus[$key]; ?>">start</a></button>
                    <button class="btn btn-primary active text-center d-block pull-right" type="button" style="height: 61px;background-color: rgb(0,105,217);"><a href="dockerAction.php?stop=<?= $container; ?>">stop</a></button>
                </div>
            </div>
            <?php } ?>

</body>

</html>