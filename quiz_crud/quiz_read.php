<?php 

session_start();

?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Read</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz_crud.css">

</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<h1>Quiz Display</h1>

<strong>Please fill up following fields.<strong>

<form id="readForm" method="POST" action="quiz_que_display.php">

<br>
<br>

<!--
The animal from which the quiz questions are 
to be displayed
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
The difficulty level of the quiz questions to be
selected from to be displayed
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
The number of questions to be displayed
-->
<label for="numOfQue">Please enter the number of questions you wish to view:</label>
<br>
<input type="number" id="numOfQue" name="numOfQue">
<br>
<div id="numOfQueError" class="error"></div>

<br>
<br>

<!--
The first quiz question to be selected
-->
<label for="firstQue">Please enter the number of first question to be displayed:</label>
<br>
<input type="number" id="firstQue" name="firstQue">
<br>
<div id="firstQueError" class="error"></div>

<br>
<br>

<input type="submit" id="readSubmit" name="readSubmit" class="submitButtons" value="Display Quiz Question">

</form>

<br>
<br>



<?php include("../includes/footer.php"); ?>

<script src="../js/quiz_crud.js"></script>
</body>

</html>