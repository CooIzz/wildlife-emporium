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
    <title>Quiz CRUD</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz.css">

</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<h1>Quiz CRUD</h1>

<form id="quizCrudForm" method="POST" action="javascript:void(0)">

<label for="crudOption">Which CRUD operation would you like to perform?</label><br>
<select id="crudOption" name="crudOption" required>
<option value="Select the Desired CRUD Operation" disabled selected>--Select the Desired CRUD Operation--</option>
<option value="Create">Create</option>
<option value="Read">Read</option>
<option value="Update">Update</option>
<option value="Delete">Delete</option>
</select>
<br>
<div id="crudError" class="error"></div>

<br>

<input type="submit" id="submit" name="submit" value="submit">

</form>


<?php include("../includes/footer.php"); ?>
<script src="../js/quiz_crud.js"></script>
</body>

</html>