<?php

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST' )
{
	include("../includes/database.php");
	
	$sql = "UPDATE quiz_questions SET question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_ans = ? WHERE animal_id = ? AND difficulty = ? AND question_num = ?";
	$sql_stmt = mysqli_prepare($connection, $sql);
	mysqli_stmt_bind_param($sql_stmt, 'ssssssisi', $updatedQuizQue, $optionA, $optionB, $optionC, $optionD, $cor_ans, $animal_id, $difficulty, $queNum);
	
	$animal = $_POST['animal'];

        switch($animal)
        {
            case "African Lion":
                $animal_id = 1;
                break;
            
            case "Orang Utan":
                $animal_id = 2;
                break;
            
            case "Penguin":
                $animal_id = 3;
                break;

            case "Tiger":
                $animal_id = 4;
                break;

            case "Giant Panda":
                $animal_id = 5;
                break;

            case "Raccoon":
                $animal_id = 6;
                break;

            case "Snow Leopard":
                $animal_id = 7;
                break;

            case "Polar Bear":
                $animal_id = 8;
                break;

            case "Lynx":
                $animal_id = 9;
                break;

            default:
                $animal_id = 10;
                break;
        }
		
		$difficulty = $_POST['difficulty'];
		$queNum = $_POST['queNum'];
		$updatedQuizQue = $_POST['updatedQuizQue'];
		$optionA = $_POST['optionA'];
		$optionB = $_POST['optionB'];
		$optionC = $_POST['optionC'];
		$optionD = $_POST['optionD'];
		$cor_ans = $_POST['cor_ans'];
		
		if(mysqli_stmt_execute($sql_stmt))
		{
			header("Location: index.php?quizQue=updated");
			exit();
		}
		else
		{
			echo 'SQL query failed: ' . mysqli_error($connection);
		}
		
		mysqli_stmt_close($sql_stmt);
		mysqli_close($connection);
		
}

?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Update</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz_crud.css">

</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>
<h1>Quiz Update</h1>

<strong>Please fill up following fields.</strong>

<form id="updateForm" method="POST" action="quiz_update.php">

<br>
<br>

<!--
The animal whose question is to be updated
-->
<label for="animal">Animal Choice:</label>
<br>
<select id="animal" name="animal">
<option value="Select the Animal of Your Choice" disabled selected>--Select the Animal of Your Choice--</option>
<option value="African Lion">African Lion</option>
<option value="Orang Utan">Orang Utan</option>
<option value="Penguin">Penguin</option>
<option value="Tiger">Tiger</option>
<option value="Giant Panda">Giant Panda</option>
<option value="Raccoon">Raccoon</option>
<option value="Snow Leopard">Snow Leopard</option>
<option value="Polar Bear">Polar Bear</option>
<option value="Lynx">Lynx</option>
<option value="Cheetah">Cheetah</option>
</select>
<br>
<div id="animalError" class="error"></div>

<br>
<br>

<!--
The difficulty level of the quiz question to be
updated
-->
<label for="difficulty">Difficulty Level:</label>
<br>
<select id="difficulty" name="difficulty">
<option value="Select the Difficulty Level" disabled selected>--Select the Difficulty Level--</option>
<option value="easy">easy</option>
<option value="medium">medium</option>
<option value="difficult">difficult</option>
</select>
<br>
<div id="difficultyError" class="error"></div>

<br>
<br>

<!--
The question to be updated
-->
<label for="queNum">Please enter the question number to be updated:</label>
<br>
<input type="number" id="queNum" name="queNum" min="1">
<br>
<div id="queNumError" class="error"></div>

<br>
<br>

<!--
The updated quiz question
-->

<label for="updatedQuizQue">Please enter the updated question text:</label>
<br>
<textarea id="updatedQuizQue" name="updatedQuizQue" placeholder="Please enter the updated question text here."></textarea>
<br>
<div id="updatedQuizQueError" class="error"></div>

<br>
<br>

Answer Choices:

<br>
<br>


<!--
Option A answer to the updated question
-->
<label for="optionA">Option A:</label>
<br>
<input type="text" id="optionA" name="optionA">
<br>
<div id="aError" class="error"></div>

<br>
<br>

<!--
Option B answer to the updated question
-->
<label for="optionB">Option B:</label>
<br>
<input type="text" id="optionB" name="optionB">
<br>
<div id="bError" class="error"></div>

<br>
<br>

<!--
Option C answer to the updated question
-->
<label for="optionC">Option C:</label>
<br>
<input type="text" id="optionC" name="optionC">
<br>
<div id="cError" class="error"></div>

<br>
<br>

<!--
Option D answer to the updated question
-->
<label for="optionD">Option D:</label>
<br>
<input type="text" id="optionD" name="optionD">
<br>
<div id="dError" class="error"></div>

<br>
<br>

<!--
Correct answer among the 4 options provided
-->
<label for="cor_ans">Correct Answer:</label>
<br>
<select id="cor_ans" name="cor_ans">
<option value="Select the Correct Answer" disabled selected>--Select the Correct Answer--</option>
<option value="A">Option A</option>
<option value="B">Option B</option>
<option value="C">Option C</option>
<option value="D">Option D</option>
</select>
<br>
<div id="corAnsError" class="error"></div>

<br>
<br>

<input type="submit" id="updateSubmit" class="submitButtons" value="Update Quiz Question">

</form>

<?php include("../includes/footer.php"); ?>

<script src="../js/quiz_crud.js"></script>
</body>

</html>