<?php

session_start();

// Initialize data view array variable safely
$read_results = [];
$crudInput = "";

if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        require("../includes/database.php");
                
        $crudInput = $_POST['crudInput'] ?? "";
		
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
        $queNum = $_POST['queNum'] ?? 0;
        $quizQuestion = $_POST['quizQuestion'] ?? "";
        $optionA = $_POST['optionA'] ?? "";
		$optionB = $_POST['optionB'] ?? "";
		$optionC = $_POST['optionC'] ?? "";
		$optionD = $_POST['optionD'] ?? "";
		$cor_ans = $_POST['cor_ans'] ?? "";
        
        switch($difficulty)
        {
            case "easy":
                $score = 10;
                break;
            
            case "medium":
                $score = 20;
                break;

            case "difficult":
                $score = 30;
                break;

            default:
				$score = 0;
                break;
        }

        $numOfQue = $_POST['numOfQue'] ?? 1;
        $firstQue = $_POST['firstQue'] ?? 1;

        switch($crudInput)
        {
            case "Create":
                $sql = "INSERT INTO quiz_questions (id, animal_id, difficulty, question_num, question_text, option_a, option_b, option_c, option_d, correct_ans, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $sql_stmt = mysqli_prepare($connection, $sql);

                if($sql_stmt === false)
                    {
                        die('SQL query preparation failed: ' . mysqli_error($connection));
                    }
                mysqli_stmt_bind_param($sql_stmt, 'iisissssssi', $queNum, $animal_id, $difficulty, $queNum, $quizQuestion, $optionA, $optionB, $optionC, $optionD, $cor_ans, $score);
                break;

            case "Read":
                $sql = "SELECT question_num, question_text, option_a, option_b, option_c, option_d, correct_ans FROM quiz_questions WHERE animal_id=? AND difficulty=? AND question_num>=? ORDER BY question_num ASC LIMIT ?";
                $sql_stmt = mysqli_prepare($connection, $sql);
                if($sql_stmt === false)
                    {
                        die("SQL query preparation failed: " . mysqli_error($connection));
                    }
                mysqli_stmt_bind_param($sql_stmt, 'isii', $animal_id, $difficulty, $firstQue, $numOfQue);
                break;

            case "Update":
                $sql = "UPDATE quiz_questions SET question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_ans = ? WHERE animal_id = ? AND difficulty = ? AND question_num = ?";
                $sql_stmt = mysqli_prepare($connection, $sql);
                if($sql_stmt === false)
                    {
                        die("SQL query preparation failed: " . mysqli_error($connection));
                    }
                mysqli_stmt_bind_param($sql_stmt, 'ssssssisi', $quizQuestion, $optionA, $optionB, $optionC, $optionD, $cor_ans, $animal_id, $difficulty, $queNum);
                break;

            case "Delete":
                $sql = "DELETE FROM quiz_questions WHERE animal_id = ? AND difficulty = ? AND question_num = ?";
                $sql_stmt = mysqli_prepare($connection, $sql);
                if($sql_stmt === false)
                    {
                        die("SQL query preparation failed: " . mysqli_error($connection));
                    }
                mysqli_stmt_bind_param($sql_stmt, 'isi', $animal_id, $difficulty, $queNum);
                break;

            default:
                exit("Invalid Action Requested.");
        }        

        if(mysqli_stmt_execute($sql_stmt))
            {
                if($crudInput === "Create")
                    {
                        header("Location: manageQuiz.php?quizQue=created");
                        exit();
                    }                
                else if($crudInput === "Update")
                    {
                        header("Location: manageQuiz.php?quizQue=updated");
                        exit();
                    }
                else if($crudInput === "Delete")
                    {
                        header("Location: manageQuiz.php?quizQue=deleted");
                        exit();
                    }
				else if($crudInput === "Read")
                    {
						// Fetch records into a storage buffer to display down inside the HTML
                        $result_set = mysqli_stmt_get_result($sql_stmt);
                        while ($row = mysqli_fetch_assoc($result_set)) {
						$read_results[] = $row;
						}
                    }
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


<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temp</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz_crud.css">
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>
<main>
<!-- Main Wrapper Container Area -->
<div class="contentAlignment">
<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $crudInput === "Read")
	{
		echo '<h1>' . 'Displaying Requested Quiz Records' . '</h1>';
		echo '<h2>Animal: ' . $animal . '</h2>';
		echo '<h2>Difficulty Level: ' . $difficulty . '</h2>';
		echo '<hr><br>';
		if(!empty($read_results))
		{
			echo '<div class="quizDisplaySection">';
			foreach ($read_results as $question)
			{	
				echo '<div class="quizSelectedItems">';
				echo '<strong>' . htmlspecialchars($question['question_num']) . '. </strong>';				
				echo htmlspecialchars($question['question_text']);
				echo '<br><br>';
				echo '<ol type="A">';
				echo '<li>' . htmlspecialchars($question['option_a']) . '</li>';
				echo '<li>' . htmlspecialchars($question['option_b']) . '</li>';
				echo '<li>' . htmlspecialchars($question['option_c']) . '</li>';
				echo '<li>' . htmlspecialchars($question['option_d']) . '</li>';
				echo '</ol>';
                echo '<br>';
                echo '<p>Correct Answer: <strong>' . htmlspecialchars($question['correct_ans']) . '</strong><p>';
				echo '</div>';
				echo '<br>';
			}
			echo '</div>';
			
			echo '<strong>Wish to go back to the manageQuiz page?<a class="links" href="manageQuiz.php">Click here</a></strong>';
		}
		else
		{
			echo '<p>No records found matching those filtering parameters.</p>';
		}
	}else
	{
		//Dynamic JS Generation Target Placeholder Form 
		echo '<form id="crudForm" name="crudForm" method="POST"></form>';
	}		

?>
</div>
</main>
<script src="../js/quiz_crud_form.js"></script>
<script src="../js/quiz_crud_validate.js"></script>
<?php include("../includes/footer.php"); ?>
</body>

</html>