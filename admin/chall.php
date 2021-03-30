<?php
require '../bdd.php';

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
}

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']); //required
    $categorie = htmlspecialchars($_POST['categorie']);//required
    $description =htmlspecialchars($_POST['description']);//required
    $data = htmlspecialchars($_POST['data']);
    $hint =htmlspecialchars($_POST['hint']);
    if($data == "") {
        $data = NULL;
    }
    if($hint == "") {
        $hint = NULL;
    }
    //var_dump($data, $hint);
    $flag =htmlspecialchars($_POST['flag']);//required

    $query_add_chall = $pdo->prepare("INSERT INTO challenges(name,categorie,description,data,hint,flag) VALUES(:name, :categorie, :description, :data, :hint, :flag)");
    $query_add_chall->bindParam(":name", $name);
    $query_add_chall->bindParam(":categorie", $categorie);
    $query_add_chall->bindParam(":description", $description);
    $query_add_chall->bindParam(":data", $data);
    $query_add_chall->bindParam(":hint", $hint);
    $query_add_chall->bindParam(":flag", $flag);
    $query_add_chall->execute();

}

?>

<!doctype html>

<html lang="fr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Admin Home</title>
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
                <a class="navbar-brand" href="index.php" style="filter: blur(0px);width: 182px;margin: -18px;">&nbsp;CTFD_Like</a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="../users/team.php">
                    <i class="fa fa-user" style="height: -5px;width: 13px;padding: 4px;"></i>Team</a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="./dockerLauncher.php">
                    <i class="fa fa-file-code-o" style="height: -5px;width: 18px;padding: 4px;"></i>Dashboard</a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="./chall.php">
                    <i class="fa fa-file-code-o" style="height: -5px;width: 18px;padding: 4px;"></i>New challenge</a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;width: 80;margin: 0;"href="./profile.php">
                    <i class="fa fa-address-card" style="height: -5px;width: 13px;padding: 4px;"></i> &nbsp; Profile</a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;width: 80;margin: 0;" href="../logout.php">
                    <i class="fa fa-sign-in" style="height: -5px;width: 13px;padding: 4px;"></i>&nbsp; LogOut</a>
            </div>
        </nav>
        <center>
            <a href="dockerLauncher.php"><button>Dashboard</button></a>
            <a href="../docker.php"><button>New Docker</button></a>
            <h3>Please create a new docker instance before create a challenge</h3>
            <form action="" method="post">
                <input name="name" type="text" placeholder="Name" required> <br>
                <input name="categorie" type="text" placeholder="Categorie" required> <br>
                <input name="description" type="text" placeholder="Description" required> <br>
                <input name="data" type="text" placeholder="Url challenge"> <br>
                <input name="hint" type="text" placeholder="Hint"> <br>
                <input name="flag" type="text" placeholder="Flag" required> <br>
                <button name="submit">Create</button>
            </form>
        </center>

    </body>
</html>
