<?php

session_start();

require_once("../includes/database.php");


// Require login for AJAX request

if (!isset($_SESSION["userID"]))
{
    http_response_code(401);
    echo "login";
    exit();
}


$userID = $_SESSION["userID"];
$animalID = filter_input(INPUT_POST,"animalID",FILTER_VALIDATE_INT);


// Validate animal ID

if ($animalID === false || $animalID === null)
{
    http_response_code(400);
    echo "Invalid animal.";
    exit();
}


// Check that the animal exists

$statement = mysqli_prepare(
    $connection,
    "SELECT animalID
     FROM animals
     WHERE animalID = ?"
);

if (!$statement)
{
    http_response_code(500);
    echo "Failed to validate animal.";
    exit();
}

mysqli_stmt_bind_param($statement,"i",$animalID);
mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);
$animalExists = mysqli_num_rows($result) > 0;

mysqli_stmt_close($statement);

if (!$animalExists)
{
    http_response_code(404);
    echo "Animal not found.";
    exit();
}


// Check whether the animal is already favourited

$statement = mysqli_prepare(
    $connection,
    "SELECT favouriteID
     FROM favourites
     WHERE userID = ? AND animalID = ?"
);

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


// Add or remove favourite

if ($isFavourite)
{
    $statement = mysqli_prepare(
        $connection,
        "DELETE FROM favourites
         WHERE userID = ? AND animalID = ?"
    );

    if (!$statement)
    {
        http_response_code(500);
        echo "Failed to remove favourite.";
        exit();
    }

    mysqli_stmt_bind_param($statement,"ii",$userID,$animalID);
    mysqli_stmt_execute($statement);

    if (mysqli_stmt_affected_rows($statement) !== 1)
    {
        mysqli_stmt_close($statement);

        http_response_code(500);
        echo "Failed to remove favourite.";
        exit();
    }

    mysqli_stmt_close($statement);

    echo "removed";
}
else
{
    $statement = mysqli_prepare(
        $connection,
        "INSERT INTO favourites (userID,animalID)
         VALUES (?,?)"
    );

    if (!$statement)
    {
        http_response_code(500);
        echo "Failed to add favourite.";
        exit();
    }

    mysqli_stmt_bind_param($statement,"ii",$userID,$animalID);
    mysqli_stmt_execute($statement);

    if (mysqli_stmt_affected_rows($statement) !== 1)
    {
        mysqli_stmt_close($statement);

        http_response_code(500);
        echo "Failed to add favourite.";
        exit();
    }

    mysqli_stmt_close($statement);

    echo "added";
}

exit();