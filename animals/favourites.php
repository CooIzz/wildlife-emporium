<?php

session_start();

require_once("../includes/database.php");
require_once("../includes/auth.php");

requireLogin();

$userID = $_SESSION["userID"];
$animalID = filter_input(INPUT_POST,"animalID",FILTER_VALIDATE_INT);

if ($animalID === false || $animalID === null)
{
    http_response_code(400);
    echo "Invalid animal.";
    exit();
}

$statement = mysqli_prepare($connection,"SELECT favouriteID FROM favourites WHERE userID = ? AND animalID = ?");

if (!$statement)
{
    http_response_code(500);
    echo "Failed to check favourite.";
    exit();
}

mysqli_stmt_bind_param($statement,"ii",$userID,$animalID);
mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);
$isFavourite = mysqli_num_rows($result) > 0;

mysqli_stmt_close($statement);

if ($isFavourite)
{
    $statement = mysqli_prepare($connection,"DELETE FROM favourites WHERE userID = ? AND animalID = ?");

    if (!$statement)
    {
        http_response_code(500);
        echo "Failed to remove favourite.";
        exit();
    }

    mysqli_stmt_bind_param($statement,"ii",$userID,$animalID);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    echo "removed";
}
else
{
    $statement = mysqli_prepare($connection,"INSERT INTO favourites (userID,animalID) VALUES (?,?)");

    if (!$statement)
    {
        http_response_code(500);
        echo "Failed to add favourite.";
        exit();
    }

    mysqli_stmt_bind_param($statement,"ii",$userID,$animalID);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    echo "added";
}

exit();