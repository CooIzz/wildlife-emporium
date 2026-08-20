<?php

// Require user to be logged in

function requireLogin()
{

    if (!isset($_SESSION["userID"])) {

        header("Location: /wildlife-emporium/account/login.php");
    
        exit();

    }

}


// Require user to be an admin

function requireAdmin()
{

    if (!isset($_SESSION["userID"])) {

        header("Location: /wildlife-emporium/account/login.php");

        exit();

    }

    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {

        header("Location: /wildlife-emporium/account/profile.php");

        exit();

    }

}

?>