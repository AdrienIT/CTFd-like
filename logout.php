<?php
session_start();
session_unset();
unset($_SESSION['connected']);
session_destroy();
header('Location: index.php');
?>