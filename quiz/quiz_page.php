<?php
session_start();
require_once("../includes/auth.php");
requireLogin();

//Forming connection to the MySQL Database
include("../includes/database.php");

//Get URL parameters

$animal_id = isset($_GET['animal_id']) ? (int)$_GET['animal_id'] : 0;
$difficulty = isset($_GET['difficulty']) ? trim($_GET['difficulty']) : "";

//Validate URL parameters

$allowed_difficulties = ['easy', 'medium', 'difficult'];

if($animal_id < 1 || $animal_id > 10 || !in_array($difficulty, $allowed_difficulties))
{
	header("Location: ./index.php");
    exit();
}

//Fetch Animal Info

$chosen_animal = "SELECT * FROM quiz_animals WHERE id=$animal_id";
$result = mysqli_query($connection, $chosen_animal);
$animal = mysqli_fetch_assoc($result);

if(empty($animal))
{
	header("Location: ./index.php");
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($animal['animal_name'])?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz.css">

</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>


<main>

<?php


echo '<div class="mainAnimals">';
echo '<img src="' . $animal['image_path'] . '" alt="' . $animal['image_alt'] . '">';
echo '</div>';
echo '<br>';
echo '<h1>' . $animal['animal_name'] . '</h1>';
echo '<hr>';
echo '<br>';


//Fetch questions based on chosen topic and difficulty level
$chosen_questions = "SELECT * FROM quiz_questions WHERE animal_id=$animal_id AND difficulty='$difficulty' ORDER BY question_num ASC";
$questions_result = mysqli_query($connection, $chosen_questions);

if(isset($_SESSION['quiz_error']) && isset($_SESSION['quiz_post']))
{
	echo '<p id="quiz_error">' . $_SESSION['quiz_error'] . '</p>';
	unset($_SESSION['quiz_error']);
	unset($_SESSION['quiz_post']);
	
}
switch($difficulty)
{
	case 'easy':
		echo '<p class="difficultySpanner">You have chosen the easy level to test your knowledge on ' . $animal['animal_name'] . '</p>';
		break;

	case 'medium':
		echo '<p class="difficultySpanner">You have chosen the medium level to test your knowledge on ' . $animal['animal_name'] . '</p>';
		break;

	case 'difficult':
		echo '<p class="difficultySpanner">You have chosen the difficult level to test your knowledge on ' . $animal['animal_name'] . '</p>';
		break;

	default:
		break;
}

//Setting up the form for the questions
echo '<form method="POST" action="results.php">';
echo '<fieldset>';

//Hidden fields for results.php to check answers
echo '<input type="hidden" name="animal_id" value="' . $animal_id . '">';
echo '<input type="hidden" name="difficulty" value="' . $difficulty . '">';

//Deciding on legend for form based on difficulty level chosen
switch($difficulty)
{
	case 'easy':
		echo '<legend>Easy Level</legend>';
		break;
	
	case 'medium':
		echo '<legend>Medium Level</legend>';
		break;
	default:
		echo '<legend>Difficult Level</legend>';
		break;
}

echo '<ol>';

if(mysqli_num_rows($questions_result) > 0)
{
	while($row = mysqli_fetch_assoc($questions_result))
	{
		echo '<li> ' . $row['question_text'];
		echo '<br>';

		echo '<div>';		
		echo '<input type="radio" name="' . $row['id'] . '" id="' . $row['option_a'] . '" value="A">';
		echo '<label for="' . $row['option_a'] . '">' . $row['option_a'] . '</label>';
		echo '<br>';
		
		echo '<input type="radio" name="' . $row['id'] . '" id="' . $row['option_b'] . '" value="B">';
		echo '<label for="' . $row['option_b'] . '">' . $row['option_b'] . '</label>';
		echo '<br>';
		
		echo '<input type="radio" name="' . $row['id'] . '" id="' . $row['option_c'] . '" value="C">';
		echo '<label for="' . $row['option_c'] . '">' . $row['option_c'] . '</label>';
		echo '<br>';
		
		echo '<input type="radio" name="' . $row['id'] . '" id="' . $row['option_d'] . '" value="D">';
		echo '<label for="' . $row['option_d'] . '">' . $row['option_d'] . '</label>';
		
		echo '</div>';
		echo '</li>';
		echo '<br>';
	}
	
}

echo '</ol>';

echo '<div class="quizSubmitButton">';
echo '<button id ="quizSubmitButton" type="submit">Submit Quiz</button>';
echo '</div>';

echo '</fieldset>';
echo '</form>';

echo '<br>';
?>

</main>

<?php include("../includes/footer.php"); ?>
<script src="../js/script.js"></script>

<script src="../js/quiz.js"></script>
<?php mysqli_close($connection); ?>
</body>

</html>