<?php
session_start();
require_once("../includes/auth.php");
requireLogin();
require_once("../includes/xp.php");

//Forming connection to the MySQL database
include ("../includes/database.php");

//Checking the type of HTTP request sent
if($_SERVER["REQUEST_METHOD"] !== "POST")
{
	header("Location: ./index.php");
    exit();
} else
{
	//Retrive the hidden fields
	$animal_id = isset($_POST['animal_id']) ? (int)$_POST['animal_id'] : 0;
	$difficulty = isset($_POST['difficulty']) ? trim($_POST['difficulty']) : "";
	
	//Validating the hidden fields
	$allowed_difficulties = ["easy", "medium", "difficult"];
	if($animal_id < 1 || $animal_id > 10 || !in_array($difficulty, $allowed_difficulties))
	{
		header("Location: ./index.php");
		exit();
	}
	
	//Fetch animal info from MySQL database
	$animal_query = "SELECT * FROM quiz_animals WHERE id=$animal_id";
	$animal_result = mysqli_query($connection, $animal_query);
	$animal = mysqli_fetch_assoc($animal_result);
	
	if(empty($animal)) {
    header("Location: ./index.php");
    exit();	
	}
	
	//Fetching correct answers from the database
	$animal_questions = "SELECT * FROM quiz_questions WHERE animal_id=$animal_id AND difficulty='$difficulty'";
	$animal_questions_result = mysqli_query($connection, $animal_questions);
	
	//Validating the answers
	$unanswered = [];
	$questions = [];
	if(mysqli_num_rows($animal_questions_result) > 0)
	{
		while($row = mysqli_fetch_assoc($animal_questions_result))
		{
			$questions[] = $row;
		
			//In $_POST superglobal, the name of the question(which is $row['id'])
			//in this case) is stored as the key while its value is the user's answers
			//to the corresponding question
			if(!isset($_POST[$row['id']]) || empty($_POST[$row['id']]))
			{
				$unanswered[] = $row['question_num'];
			}
							
		}
		
		if(!empty($unanswered))
		{
			$unanswered_list = implode(', ', $unanswered);
									
			//To store the error message
			$_SESSION['quiz_error'] = "Please answer all questions before submitting. Unanswered: Q$unanswered_list";
		
			//To store the answered questions
			$_SESSION['quiz_post'] = $_POST;
			header("Location: quiz_page.php?animal_id=$animal_id&difficulty=$difficulty");
			exit();
		}
		
		//Evaluate the answers
		$score = 0;
		$num_of_q = count($questions);
		$results_detail = [];
		
		foreach($questions as $question)
		{
			$answer = $_POST[$question['id']] ?? "";
		
			if($question['correct_ans'] === $answer)
			{
				$score = $score + $question['score'];
			}
		
			//Storing the results of all evaluations in an array
			//of arrays of Resource Objects
			$results_detail[] = [			
		
				'question_num' => $question['id'],
				'question_text' => $question['question_text'],
				'option_a' => $question['option_a'],
				'option_b' => $question['option_b'],
				'option_c' => $question['option_c'],
				'option_d' => $question['option_d'],
				'correct_ans' => $question['correct_ans'],
				'submitted_ans' => $answer,
				'is_correct' => $question['correct_ans'] === $answer,
						
			];			
		}		

		// --------------------------------------------------
		// This section is for granting EXP for completing the quiz
		// --------------------------------------------------

		$userID = $_SESSION['userID'];

		if($difficulty === "easy")
		{
			$xpReward = 10;
		}
		elseif($difficulty === "medium")
		{
			$xpReward = 20;
		}
		else
		{
			$xpReward = 30;
		}

		awardXP(
			$userID,
			$xpReward,
			"Completed $difficulty quiz"
		);

		// --------------------------------------------------
		// End of EXP granting section
		// --------------------------------------------------
	
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz.css">
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main>

<!--
To display the animal's image and the animal's text in case 
the image fails to load
-->
<div class="mainAnimals">
<img src="<?= $animal['image_path']?>" alt="<?= $animal['image_alt']?>">
<br>
<h1><?= $animal['animal_name']?></h1>
<hr>
<br>
</div>

<div id="outer_display">

<?php

//Printing the current results in a proper format
foreach($results_detail as $result_detail)
{
	echo '<div class="result_display">';
	
	echo '<section>';
	
	echo '<p>' . $result_detail['question_num']. ' ' . $result_detail['question_text'] . '</p>';
	echo '<br>';
	echo '<p>Answer Choices</p>';
	echo '<br>';
	echo '<ol>';
	
	echo '<li>' . $result_detail['option_a'] . '</li>';
	echo '<li>' . $result_detail['option_b'] . '</li>';
	echo '<li>' . $result_detail['option_c'] . '</li>';
	echo '<li>' . $result_detail['option_d'] . '</li>';
	
	echo '</ol>';
	
	echo '<p>Correct Answer: ' . $result_detail['correct_ans'] . '</p>';
	echo '<p>Submitted Answer: ' . $result_detail['submitted_ans'] . '</p>';
	
	if($result_detail['is_correct'])
	{
		echo '<p style="color: green; font-weight: 900">' . '✅ Correct' . '</p>';
	} else
	{
		echo '<p style="color: red; font-weight: 900">' . '❌ Wrong' . '</p>';
	}
	
	echo '</section>';
	
	echo '</div>';
}

//Displaying the user's score
echo '<p>Total Score: ' . $score . '</p>';

$userID = $_SESSION['userID'];
$user_score_query = "SELECT * FROM user_score WHERE userID = $userID";
$user_score_attempt = mysqli_query($connection, $user_score_query);

if(mysqli_num_rows($user_score_attempt) === 0)
{
    $insert_query = "INSERT INTO user_score (userID, score) VALUES ($userID, 0)";
    mysqli_query($connection, $insert_query);
    $updated_score = $score;
} else {
    $user_score_result = mysqli_fetch_assoc($user_score_attempt);
    $updated_score = $score + $user_score_result['score'];
}

$user_score_update = "UPDATE user_score SET score = $updated_score WHERE userID = $userID";
mysqli_query($connection, $user_score_update);

?>

</div>

</main>


<?php include("../includes/footer.php"); ?>
<script src="../js/script.js"></script>

<?php mysqli_close($connection); ?>
</body>

</html>