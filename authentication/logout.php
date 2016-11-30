<?php
    session_start();
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    $_SESSION['message']="You're now logged out";
    header("location: ../index.php");
?>