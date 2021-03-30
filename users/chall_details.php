<?php
require '../bdd.php';
session_start();

if (!isset($_SESSION["users_id"])) {
    header("Location: ../login.php");
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    //echo '<h1>'.$id.'</h1>';
}


$query_get_chall_infos = $pdo->prepare('SELECT * FROM challenges WHERE id = :id');
$query_get_chall_infos->bindParam(':id', $id);
$query_get_chall_infos->execute();
$challenges = $query_get_chall_infos->fetchAll();

$get_flag = $pdo->prepare('SELECT flag FROM challenges WHERE id = :id');
$get_flag->bindParam(':id', $id);
$get_flag->execute();
$flag = $get_flag->fetch();


if (isset($_POST['submit'])) {
    $flaguser = $_POST['flag'];
    if ($flaguser = $flag) {
        echo "<script type='text/javascript'>alert('GOOD JOB');</script>";
        //header('location: challenges.php');
    } else {
        echo "<script type='text/javascript'>alert('Not the good flag');</script>";
    }
}




//var_dump($challenges);

?>

<!doctype html>

<html lang="fr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Home</title>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
        <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
        <link rel="stylesheet" href="../assets/css/Card-Group1-Shadow.css">
        <link rel="stylesheet" href="../assets/css/Dark-NavBar-1.css">
        <link rel="stylesheet" href="../assets/css/Dark-NavBar-2.css">
        <link rel="stylesheet" href="../assets/css/Dark-NavBar.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="../assets/css/Search-Input-responsive.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/Article-List.css">
        <link rel="stylesheet" href="../assets/css/project-card.css">
        <link rel="stylesheet" href="../assets/css/Card-Deck.css">
    </head>

    <body>
        <nav class="navbar navbar-light navbar-expand-md sticky-top border rounded float-none navigation-clean-button"
            style="height: 80px;background-color: #37434d;color: #ffffff;">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php" style="filter: blur(0px);width: 182px;margin: -18px;">
                    &nbsp;CTFD_Like
                </a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="team.php">
                    <i class="fa fa-user" style="height: -5px;width: 13px;padding: 4px;"></i>Team</a>

                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="challenges.php">
                    <i class="fa fa-file-code-o" style="height: -5px;width: 18px;padding: 4px;"></i>Challenges</a>

                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;width: 80;margin: 0;"
                    href="profile_users.php">
                    <i class="fa fa-address-card" style="height: -5px;width: 13px;padding: 4px;"></i> &nbsp; Profile</a>

                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;width: 80;margin: 0;"
                    href="../logout.php">
                    <i class="fa fa-sign-in" style="height: -5px;width: 13px;padding: 4px;"></i>&nbsp; LogOut</a>
            </div>
        </nav>
        <center>
            <tbody>
                <?php foreach($challenges as $c) { ?>
                <tr>
                    <td><p>Name : <?= $c['name'] ?></p></td>
                    <td><p>Categorie : <?= $c['categorie'] ?></p></td>
                    <td><p>Description : <?= $c['description'] ?></p></td>
                    <?php if($c['data'] !== NULL) echo"<td><p>Data : ". $c['data'];". </p></td>" ?>
                    <?php if($c['hint'] !== NULL) echo"<td><p>Hint : ". $c['hint'];". </p></td>" ?>
                    <form method="post" action=""> <input name="flag" type="text" placeholder="flag"> <br> <br> <button name="submit">FLAG!</button> </form>
                    <br>
                </tr>
                <?php }?>
            </tbody>
        </center>
    </body>
</html>



<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-init.js"></script>
</body>

</html>
