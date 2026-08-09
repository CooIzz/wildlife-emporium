<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz.css">

</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>


<main>

<?php

include("../includes/database.php");

require("index.php");

//Get and validate URL parameters

$animal_id = isset($_GET['animal_id']) ? (int)$_GET['animal_id'] : 0;
$difficulty = isset($_GET['difficulty']) ? trim($_GET['difficulty']) : "";

//Fetch Animal Info


?>

<main>

<?php include("../includes/footer.php"); ?>

</body>

</html>