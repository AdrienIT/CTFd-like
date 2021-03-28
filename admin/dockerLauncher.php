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

if (isset($_GET["name"]) and !empty($_GET["name"])) {
    if(isset($_GET["action"]) and !empty($_GET["action"])){
        $name = htmlspecialchars($_GET["name"]);
        $action = htmlspecialchars($_GET["action"]);

        if($action == 'start'){
            shell_exec("sudo docker start ".$name);
            header('Location: ./dockerLauncher.php');
            exit;
        }

        elseif($action == 'stop'){
            shell_exec("sudo docker stop ".$name);  
            header('Location: ./dockerLauncher.php');
            exit;
        }
        
        elseif($action == 'restart'){
            shell_exec("sudo docker restart ".$name);  
            header('Location: ./dockerLauncher.php');
            exit;
        }

    }

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
            //  $challnametmp = shell_exec("sudo docker ps -a --format 'table {{.Names}}\t{{.Status}}' | cut -f1 -d '(' | tail -n +2 | awk '{print $1}'");
            $challnametmp = shell_exec("sudo docker ps -a --format 'table {{.Names}}\t{{.Status}}' | cut -f1 -d '(' | tail -n +2 | awk '{print $1}'");
            $challstatus = shell_exec("sudo docker ps -a --format 'table {{.Names}}\t{{.Status}}' | cut -f1 -d '(' | tail -n +2 | awk '{print $2}'");
            // $challport = shell_exec("sudo docker port ctfdlike | awk -F':' '{print \$NF}'");
            $cnf = explode(PHP_EOL, $challnametmp);
            $csf = explode(PHP_EOL, $challstatus);
            // $cpf = explode(PHP_EOL, $challport);





            //  foreach($cnf as $container) 
            foreach (array_combine($cnf, $csf) as $challnametmp => $challstatus) {
              ?>
                
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $challnametmp;?></h4>
                    <h6 class="text-muted card-subtitle mb-2"><?php echo $challstatus;?></h6>
                    <?php 

                    $port = shell_exec("sudo docker port ".$challnametmp."| awk -F':' '{print \$NF}'");
                    var_dump($port);
                    if($challstatus === 'Up'){ echo("<h6>Url du lien : <a target=\"_blank\" href=\"http://146.59.150.242:\".$port.\" \">URL</a></h6>");}
                    
                    ?>

                    
                    <button><a href="dockerLauncher.php?name=<?=$challnametmp;?>&action=start">start</a></button>
                    <button><a href="dockerLauncher.php?name=<?=$challnametmp; ?>&action=stop">stop</a></button>
                    <button><a href="dockerLauncher.php?name=<?=$challnametmp; ?>&action=restart">restart</a></button>
                </div>
            </div>
            <?php } ?>

</body>

</html>