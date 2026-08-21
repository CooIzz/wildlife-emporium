<?php

session_start();

include_once("../includes/auth.php");

//requireAdmin();

?>
<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Update</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz.css">

</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<h1>Quiz Update</h1>

<form id="quizUpdateForm" method="POST" action="quiz_update.php">

<label for="crudOption">Which CRUD operation would you like to perform?</label><br>
<select id="crudOption" name="crudOption" required>
<option value="Select the Desired CRUD Operation" disabled selected>--Select the Desired CRUD Operation--</option>
<option value="Create">Create</option>
<option value="Read">Read</option>
<option value="Update">Update</option>
<option value="Delete">Delete</option>
</select>

<br>
<br>

If you wish to insert new questions into the quiz section, then please fill up the following fields

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
<br>

<label for="quizQuestion">Question:</label>
<br>
<textarea id="quizQuestion" name="quizQuestion" placeholder="Please enter the quiz question here"></textarea>

<br>
<br>

Answer Choices:

<label for="optionA">Option A:</label>
<br>
<input type="text" id="optionA" name="optionA">

<br>
<br>

<label for="optionB">Option B:</label>
<br>
<input type="text" id="optionB" name="optionB">

<br>
<br>

<label for="optionC">Option C:</label>
<br>
<input type="text" id="optionC" name="optionC">

<br>
<br>

<label for="optionD">Option D:</label>
<br>
<input type="text" id="optionD" name="optionD">

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
<br>

<input type="submit" id="submit" name="submit" value="submit">

</form>


<?php include("../includes/footer.php"); ?>
<script src="../js/quiz_update.js"></script>
</body>

</html>