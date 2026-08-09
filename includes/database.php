<?php

// This file_exists check is for Jason's and Bavan's local computer SQL running on port 3308.
// Jason and Bavan will use the local file database.local.php that specifies port 3308 instead,
// without changing the code here in database.php.
// If you are using the default port 3306,
// just use database.php normally.

if (file_exists(__DIR__ . '/database.local.php')) {
    include_once __DIR__ . '/database.local.php';
} else {

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "wildlife_emporium";

    $connection = mysqli_connect(
        $host,
        $username,
        $password,
        $database
    );

    if (!$connection)
    {
        die("Database connection failed: " . mysqli_connect_error());
    }

    mysqli_set_charset($connection, "utf8mb4");

}

?>