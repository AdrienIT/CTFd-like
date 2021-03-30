<?php
require '../bdd.php';
session_start();

if (!isset($_SESSION["users_id"])) {
    header("Location: ../login.php");
}

$query_dump_challs = $pdo->prepare('SELECT * from challenges');
$query_dump_challs->execute();
$challenges = $query_dump_challs->fetchAll();

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
                    <td><a target="_BLANK" href="chall_details.php?id=<?= $c['id'] ?>">Access to challenge</a></td>
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
