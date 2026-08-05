<?php

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

?>