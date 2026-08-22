<?php

session_start();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Create</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz_crud.css">

</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<form id="createForm" method="POST" action="javascript:void(0)">

<strong>Please fill up following fields.<strong>

<br>
<br>

<label for="animal">Animal:</label>
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

<label for="quizQuestion">Question:</label>
<br>
<textarea id="quizQuestion" name="quizQuestion" placeholder="Please enter the quiz question here"></textarea>
<br>
<div id="queError" class="error"></div>

<br>
<br>

Answer Choices:

<label for="optionA">Option A:</label>
<br>
<input type="text" id="optionA" name="optionA">
<br>
<div id="aError" class="error"></div>

<br>
<br>

<label for="optionB">Option B:</label>
<br>
<input type="text" id="optionB" name="optionB">
<br>
<div id="bError" class="error"></div>

<br>
<br>

<label for="optionC">Option C:</label>
<br>
<input type="text" id="optionC" name="optionC">
<br>
<div id="cError" class="error"></div>

<br>
<br>

<label for="optionD">Option D:</label>
<br>
<input type="text" id="optionD" name="optionD">
<br>
<div id="dError" class="error"></div>

<br>
<br>

<label for="cor_ans">Correct Answer:</label>
<br>
<select id="cor_ans" name="cor_ans">
<option value="Select the Correct Answer" disabled selected>--Select the Correct Answer--</option>
<option value="optionA">Option A</option>
<option value="optionB">Option B</option>
<option value="optionC">Option C</option>
<option value="optionD">Option D</option>
</select>
<br>
<div id="corAnsError" class="error"></div>

<br>
<br>

<input type="submit" id="createSubmit" name="createSubmit" value="Create Quiz Question">

</form>

<?php include("../includes/footer.php"); ?>

<script src="../js/quiz_crud.js"></script>
</body>

</html>