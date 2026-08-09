<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz.css">
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main>
<div><h1>Quiz Domain</h1></div>

<!--
Introduction to the quiz section of the website
-->
<p>
    Welcome to the quiz section of this website. Here, you will be tested on the profound knowledge
    you have accumulated throughout your journey of learning everything there is to know about 
    the Wildlife. Are you brave enough to accept this challenge and earn your place among the Wildlife 
    experts? 
</p>

<br>
<hr>
<br>

<!--
Alerting users to login/register before partaking in
the quiz
-->
<p style="text-align: center;">
    <strong>If you wish to partake in our quiz, please login(or register for newcomers) before proceeding.</strong>
</p>

<br>

<article>

<!--
Displaying the topics available for users to quiz
themselves on
-->

<?php

//Forming connection to the MySQL Database
include("../includes/database.php");

$animal_query = "SELECT * FROM quiz_animals ORDER BY topic_num ASC";
$animal_result = mysqli_query($connection, $animal_query);

if(!$animal_result)
{
	echo mysqli_error($connection);
}

echo "<section>";

if(mysqli_num_rows($animal_result) > 0)
{
	while($row = mysqli_fetch_assoc($animal_result))
	{
		echo '<div id="' . $row['topic_id'] . '" class="QuizTopic">';
		echo '<a href="javascript:void(0)" id="' . $row['js_id'] . '">';
		echo '<img src="' . $row['image_path'] . '" alt="' . $row['image_alt'] . '" class="animal">';
		echo '<p>' . $row['topic_id'] . $row['animal_name'] . '</p>';
		echo '</a>';
		echo '</div>';
	}
}

echo "</section>";

?>

</article>

</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/script.js"></script>
<script src="../js/quiz.js"></script>

</body>
</html>