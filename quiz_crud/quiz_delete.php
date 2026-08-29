<?php

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        include("../includes/database.php");
        $sql = "DELETE FROM quiz_questions WHERE animal_id = ? AND difficulty = ? AND question_num = ?";
        $sql_stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($sql_stmt, 'isi', $animal_id, $difficulty, $question_num);

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
        $question_num = $_POST['queNum'];
        if(mysqli_stmt_execute($sql_stmt))
            {
                header("Location: index.php?quizQue=deleted");
                exit();
            }
        else
            {
                echo 'SQL query failed: ' . mysqli_error($connection);
            }
    }

?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Delete</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz_crud.css">

</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<h1>Quiz Delete</h1>

<strong>Please fill up following fields.</strong>

<form id="deleteForm" method="POST" action="quiz_delete.php">

<br>
<br>

<!--
The animal whose question is to be deleted
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
deleted
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
The question to be deleted
-->
<label for="queNum">Please enter the question number to be deleted:</label>
<br>
<input type="number" id="queNum" name="queNum" min="1">
<br>
<div id="queNumError" class="error"></div>

<br>
<br>

<input type="submit" id="deleteSubmit" name="deleteSubmit" class="submitButtons" value="Delete Quiz Question">

</form>

<?php include("../includes/footer.php"); ?>

<script src="../js/quiz_crud.js"></script>
</body>

</html>