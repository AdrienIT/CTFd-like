<?php
setcookie($cookie_user, $cookie_value, time(time() - 3600));
setcookie($cookie_admin, $cookie_value, time(time() - 3600));
header('Location: index.php');
