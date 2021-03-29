<?php
if (isset($_COOKIE["user_cookie"])) {
    setcookie("user_cookie", "connected", time() - 86400, "/", "localhost", TRUE, TRUE);
}
if (isset($_COOKIE["admin_cookie"])) {
    setcookie("admin_cookie", "connected", time() - 86400, "/", "localhost", TRUE, TRUE);
}
header('Location: ./index.php');
