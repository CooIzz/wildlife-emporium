<?php

//Forming connection to MySQL database
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
				
				//Start a new session to temporarily store the answered questions
				//because header() redirect loses all of $_POST data
				session_start();
				
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
				
				[
					'question_num' => $question['id'],
					'question_text' => $question['question_text'],
					'option_a' => $question['option_a'],
					'option_b' => $question['option_b'],
					'option_c' => $question['option_c'],
					'option_d' => $question['option_d'],
					'correct_ans' => $question['correct_ans'],
					'submitted_ans' => $answer,
					'is_correct' => $question['correct_ans'] === $answer,
				
				]
				
				];				
			}			
			
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

</body>

</html>