<?php

session_start();
require_once("../includes/auth.php");
requireLogin();

$user_id = $_SESSION['userID'] ?? 0;

$loginURL = '/wildlife-emporium/account/login.php';

//Securing connection to the MySQL database
include("../includes/database.php");

//SQL SELECT query
$sql = "SELECT * FROM user_score ORDER BY score DESC";
$result = mysqli_query($connection, $sql);

if(!$result)
{
	echo 'Failed to retrieve scoreboard data: ' . mysqli_error($connection);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Leaderboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz.css">
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main>
<div><h1 style="text-align: center;">Quiz Leaderboard</h1><div>

<div class="leaderboardArticle">

<div>

<p>
Welcome to the Quiz Score Leaderboard. Wish to see if you have made it into the
scoreboard? Please login before proceeding.
</p>

</div>

<div>

<button id="scoreboard_expand">Expand the scoreboard</button>

</div>

<br>
<hr>
<br>

<div>

<table id="scoreboard" class="hidden">

<thead>

<tr>

<th>Nu.</th>
<th>Username</th>
<th>Score</th>

<tr>

</thead>

<tbody>

<?php

$index = 1;

while($row = mysqli_fetch_assoc($result))
{
	$username = $row['username'] ?? "";
	$score = $row['score'] ?? 0;
	
	echo '<tr>';
	echo '<td>' . $index++ . '.</td>';
	echo '<td>' . htmlspecialchars($username) . '</td>';
	echo '<td>' . htmlspecialchars($score) . '</td>';
	echo '</tr>';
}

?>

</tbody>

</table>

</div>

</div>

</main>
<?php include("../includes/footer.php"); ?>

<script>

//Passing php variable values to javascript
const loginURL = <?php echo json_encode($loginURL); ?>;
const user_id = <?php echo json_encode($user_id); ?>;

</script>

<script src="../js/quiz_leaderboard.js"></script>

</body>

</html>