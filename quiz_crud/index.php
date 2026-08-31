<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz CRUD</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz_crud.css">

</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<h1>Quiz CRUD</h1>

<!--
Form for user to input the CRUD operation he/she
wishes to perform
-->
<form id="quizCrudForm" method="GET">

<label for="crudOperation">Which CRUD operation would you like to perform?</label><br><br>
<select id="crudOperation" name="crudOperation" required>
<option value="" disabled selected>--Select the Desired CRUD Operation--</option>
<option value="Create">Create</option>
<option value="Read">Read</option>
<option value="Update">Update</option>
<option value="Delete">Delete</option>
</select>
<br>
<div id="crudError" class="error"></div>

<br>
<br>

<input type="submit" id="submit" name="submit" class="submitButtons" value="submit">

</form>

<br>
<hr>
<br>

<p id="crudSuccess">
<?php

if(isset($_GET['quizQue']))
    {
        if($_GET['quizQue'] == 'created')
            {
                echo 'Record inserted successfully.';
            }
        else if($_GET['quizQue'] == 'updated')
            {
                echo 'Record updated successfully.';
            }
        else if($_GET['quizQue'] == 'deleted')
            {
                echo 'Record deleted successfully.';
            } 
        else
            {
                echo '';
            }       
    }

?>
<p>

<br>

<?php include("../includes/footer.php"); ?>
<script src="../js/quiz_crud.js"></script>
<script>
//Extract p tag element with the id of crudSuccess
const crudSuccess = document.getElementById("crudSuccess");

//Adding event listener to clear the CRUD message in case
//user reloads the index page---------------

document.addEventListener("boforeunload", (event) => {
	
	if(crudSuccess.innerHTML.trim() !== "")
	{
		const urlParams = new URLSearchParams(window.location.search);
		if (urlParams.get("quizQue") !== "") 
		{
		const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set("quizQue", "");
        
        window.location.href = currentUrl.toString();
		}
	}
	
});
</script>
</body>

</html>