<?php
require '../bdd.php';

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
}

$ip=shell_exec('curl ifconfig.me');

//$ip = getHostByName($_SERVER['REMOTE_ADDR']);

if (isset($_GET["name"]) and !empty($_GET["name"])) {
    if (isset($_GET["action"]) and !empty($_GET["action"])) {
        $name = htmlspecialchars($_GET["name"]);
        $action = htmlspecialchars($_GET["action"]);

        if ($action == 'start') {
            shell_exec("sudo docker start " . $name);
            header('Location: ./dockerLauncher.php');
            exit;
        } elseif ($action == 'stop') {
            shell_exec("sudo docker stop " . $name);
            header('Location: ./dockerLauncher.php');
            exit;
        } elseif ($action == 'restart') {
            shell_exec("sudo docker restart " . $name);
            header('Location: ./dockerLauncher.php');
            exit;
        } elseif ($action == 'remove') {
            shell_exec("sudo docker stop " . $name);
            shell_exec("sudo docker rm -f " . $name);
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
        <title>Launcher</title>
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
                    <i class="fa fa-sign-in" style="height: -5px;width: 13px;padding: 4px;"></i>
                    &nbsp; LogOut
                </a>
        </nav>


        <?php

    $challnametmp = shell_exec("sudo docker ps -a --format 'table {{.Names}}\t{{.Status}}' | cut -f1 -d '(' |  awk '{print $1}' | tail -n +2");
    $challstatus = shell_exec("sudo docker ps -a --format 'table {{.Names}}\t{{.Status}}' | cut -f1 -d '(' |  awk '{print $2}' |tail -n +2");


    $cnf = array_reverse(explode(PHP_EOL, $challnametmp));
    $csf = array_reverse(explode(PHP_EOL, $challstatus));


    foreach (array_combine(array_slice($cnf, 1), array_slice($csf, 1)) as $challnametmp => $challstatus) {
    ?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $challnametmp; ?></h4>

                <h6 class="text-muted card-subtitle mb-2"><?php echo $challstatus; ?></h6>

                <?php
                $port = shell_exec("sudo docker port " . $challnametmp . "| awk -F':' '{print \$NF}'");
                if ($challstatus === 'Up') {
                    echo ("<h6>Url du lien : <a target=\"_blank\" href=\"http://$ip:$port \">URL</a></h6>");
                }
                ?>


                <button><a href="dockerLauncher.php?name=<?= $challnametmp; ?>&action=start">start</a></button>
                <button><a href="dockerLauncher.php?name=<?= $challnametmp; ?>&action=stop">stop</a></button>
                <button><a href="dockerLauncher.php?name=<?= $challnametmp; ?>&action=restart">restart</a></button>
                <?php if ($challstatus !== 'Up') {
                    echo ("<button><a href=\"dockerLauncher.php?name=$challnametmp&action=remove\">remove</a></button>");
                } ?>




            </div>
        </div>
        <?php } ?>

    </body>

</html>
