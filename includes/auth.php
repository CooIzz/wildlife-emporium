<?php

// Require user to be logged in

function requireLogin()
{
    if (!isset($_SESSION["userID"]))
    {
        $currentPage = $_SERVER["REQUEST_URI"];

        header(
            "Location: /wildlife-emporium/account/login.php?redirect="
            . urlencode($currentPage)
        );

        exit();
    }
}


// Require user to be an admin

function requireAdmin()
{
    if (!isset($_SESSION["userID"]))
    {
        $currentPage = $_SERVER["REQUEST_URI"];

        header(
            "Location: /wildlife-emporium/account/login.php?redirect="
            . urlencode($currentPage)
        );

        exit();
    }

    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin")
    {
        header("Location: /wildlife-emporium/account/profile.php");
        exit();
    }
}

?>