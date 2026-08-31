<!DOCTYPE html>


<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temp</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz.css">
</head>

<body>

<?php

//Forming connection to MySQL database
include ("../includes/database.php");
require_once("../includes/auth.php");
requireLogin();

$sql_statement = "INSERT INTO quiz_questions (id, animal_id, difficulty, question_num, question_text, option_a, option_b, option_c, option_d, correct_ans, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($connection, $sql_statement);

if(!$stmt)
{
	die('MySQL prepare failed: ' . mysqli_error($connection));
}else
{
	mysqli_stmt_bind_param($stmt, 'iisissssssi', $id, $animal_id, $difficulty, $question_num, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_ans, $score);
?>

<form action="take.php" method="POST">
ID<br>
<input type="number" id="ID" name="ID"><br>
animalID<br>
<input type="number" id="animalID" name="animalID"><br>
difficulty<br>
<input type="text" id="difficulty" name="difficulty"><br>
question_num<br>
<input type="number" id="question_num" name="question_num"><br>
question_text<br>
<input type="text" id="question_text" name="question_text"><br>
option_a<br>
<input type="text" id="option_a" name="option_a"><br>
option_b<br>
<input type="text" id="option_b" name="option_b"><br>
option_c<br>
<input type="text" id="option_c" name="option_c"><br>
option_d<br>
<input type="text" id="option_d" name="option_d"><br>
correct_ans<br>
<input type="text" id="correct_ans" name="correct_ans"><br>

<br><br>
<button type="submit">Submit</button>

</form>

<?php

$id = $_POST['ID'];
$animal_id = $_POST['animalID'];
$difficulty = $_POST['difficulty'];
$question_num = $_POST['question_num'];
$question_text = $_POST['question_text'];
$option_a = $_POST['option_a'];
$option_b = $_POST['option_b'];
$option_c = $_POST['option_c'];
$option_d = $_POST['option_d'];
$correct_ans = $_POST['correct_ans'];

switch($difficulty)
{
    case 'easy':
        $score = 10;
        break;
    
    case 'medium':
        $score = 20;
        break;
    
    case 'difficult':
        $score = 30;
        break;
}

if (mysqli_stmt_execute($stmt)) 
{
echo "New record inserted successfully.";
} else 
{
echo "Error: " . mysqli_error($connection);
}

mysqli_stmt_close($stmt);
}


?>

</body>

</html>