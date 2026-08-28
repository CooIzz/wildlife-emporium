<?php

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        include("../includes/database.php");
        $sql = "SELECT question_num, question_text, option_a, option_b, option_c, option_d FROM quiz_questions WHERE animal_id=? AND difficulty=? AND question_num=? ORDER BY question_num ASC LIMIT ?";
        $sql_stmt = mysqli_prepare($connection, $sql);

        if($sql_stmt === false)
            {
                die("SQL query preparation failed: " . mysqli_error($connection));
            }
        mysqli_stmt_bind_param($sql_stmt, 'isii', $animal_id, $difficulty, $firstQue, $numOfQue);

        $animal = $_POST['animal'];
        $difficulty = $_POST['difficulty'];
        $numOfQue = $_POST['numOfQue'];
        $firstQue = $_POST['firstQue'];

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
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Questions Display</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/quiz_crud.css">

</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<div id="titleAndDifficulty">
<h1>Animal: <?php echo $animal; ?></h1>
<h2>Difficulty Level: <?php echo $difficulty; ?></h2>
</div>

<?php
        if(mysqli_stmt_execute($sql_stmt))
            {
                $questions = mysqli_stmt_get_result($sql_stmt);
                if(mysqli_num_rows($questions) > 0)
                    {
                       foreach($questions as $question)
                       {
                            echo $question['question_num'] . '. ' . $question['question_text'];
                            echo '<br>';
                            echo 'Option A: ' . $question['option_a'];
                            echo '<br>';
                            echo 'Option B: ' . $question['option_b'];
                            echo '<br>';
                            echo 'Option C: ' . $question['option_c'];
                            echo '<br>';
                            echo 'Option D: ' . $question['option_d'];
                            echo '<br><br><br>';

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

<p>Wish to go back to the Admin Quiz Management Page?<a href="index.php">Click Here.</a></p>

<?php include("../includes/footer.php"); ?>

<script src="../js/quiz_crud.js"></script>
</body>

</html>