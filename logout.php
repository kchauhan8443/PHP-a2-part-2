<?php

session_start();

session_unset($_SESSION["id"]);

session_unset($_SESSION["email"]);

session_destroy();

header("Location:login.php")


?>