<?php 
//connect to wildlife emporium database
require_once("../includes/database.php"); 

//query for all articles from the articles table from latest-oldest
$query = "SELECT article_id, title, summary, image_name, image_caption, creation_at FROM articles ORDER BY creation_at DESC";

//prepare a connection to the databse to execute the query
$statement = mysqli_prepare($connection, $query);

//if the $statement accepted, execute it and get the data from table 
$articles = [];
if($statement){
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement,$id, $title,$summary, $image_name, $image_caption, $creation_at);

    while(mysqli_stmt_fetch($statement)){

    //we store each article row like associative array within $articles 
    $articles[] = [
        'article_id' => $id,
        'title' => $title,
        'summary' => $summary,
        'image_name' => $image_name,
        'image_caption' => $image_caption,
        'creation_at' => $creation_at
    ];
    }
    //close database request
    mysqli_stmt_close($statement);
}
//if there is some failure, $articles is empty, prevent wbpg crash
else{
    $articles = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/articles.css">

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>

<main>
<div class="article-frame">

<section class="article-header-container">
    <h1 class="article-header">WILDLIFE DAILY</h1>
    <div class="article-logo">
        <img src="../images/home-logo-test.svg" alt="Logo">
    </div>
</section>
<br>

<?php 
//make sure the $articles not empty first
if (!empty($articles)): 
?> 

<!--latest article at the top section -->
<?php if (isset($articles[0])): ?>    
<section class="article-sec1">
    <div class="card article-card1">
        <img src="../images/<?php echo htmlspecialchars($articles[0]['image_name']);?>"
        alt="<?php echo htmlspecialchars($articles[0]['image_caption']); ?>">
    </div>
    <div class="article-sum1">
        <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[0]['article_id']; ?>">
            <?php echo htmlspecialchars($articles[0]['title']); ?>
        </a>        
        <p><?php echo htmlspecialchars($articles[0]['summary']); ?></p>
    </div>
</section>
<?php endif; // end of if statement ?>

<?php
$total_articles = count($articles);
$i = 1; //starting from 2nd article (index is 1)
$pattern = 'A'; //different layout patterns 

//Loope layout patterns as long as there is more articles
while ($i < $total_articles):

    //Pattern A Layout Implementing
    if ($pattern === 'A'):
?>
    <!-- Pattern A has 3 alternating rows on Left, and 1 sidebar on right -->
    <section class="article-sec2">
        <div class="article-dr">
            <?php if (isset($articles[$i])): ?>
                <div class="article-textL">
                    <div class="article-sum2">
                        <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i]['article_id']; ?>">
                        <h2><?php echo htmlspecialchars($articles[$i]['title']); ?></h2>
                        </a> 
                        <p><?php echo htmlspecialchars($articles[$i]['summary']); ?></p>
                    </div>

                    <div class="card article-card2">
                        <img src="../images/<?php echo htmlspecialchars($articles[$i]['image_name']);?>"
                        alt="<?php echo htmlspecialchars($articles[$i]['image_caption']); ?>">
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($articles[$i + 1])): ?>
                <div class="article-textR">
                    <div class="card article-card2">
                        <img src="../images/<?php echo htmlspecialchars($articles[$i + 1]['image_name']);?>"
                        alt="<?php echo htmlspecialchars($articles[$i + 1]['image_caption']); ?>">
                    </div>
                        
                    <div class="article-sum2">
                        <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i + 1]['article_id']; ?>">
                        <h2><?php echo htmlspecialchars($articles[$i + 1]['title']); ?></h2>
                        </a> 
                        <p><?php echo htmlspecialchars($articles[$i + 1]['summary']); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($articles[$i + 2])): ?>
                <div class="article-textL">
                    <div class="article-sum2">
                        <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i + 2]['article_id']; ?>">
                        <h2><?php echo htmlspecialchars($articles[$i + 2]['title']); ?></h2>
                        </a> 
                        <p><?php echo htmlspecialchars($articles[$i + 2]['summary']); ?></p>
                    </div>

                    <div class="card article-card2">
                        <img src="../images/<?php echo htmlspecialchars($articles[$i + 2]['image_name']);?>"
                        alt="<?php echo htmlspecialchars($articles[$i + 2]['image_caption']); ?>">
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (isset($articles[$i + 3])): ?>
        <div class="article-sidebar">
            <div class="card article-card3">
                <img src="../images/<?php echo htmlspecialchars($articles[$i + 3]['image_name']);?>"
                alt="<?php echo htmlspecialchars($articles[$i + 3]['image_caption']); ?>"> 
            </div>
            <div class="article-sum3">
                <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i + 3]['article_id']; ?>">
                <h2><?php echo htmlspecialchars($articles[$i + 3]['title']); ?></h2>
                </a> 
                <p><?php echo htmlspecialchars($articles[$i + 3]['summary']); ?></p>
            </div>
        </div>
        <?php endif; ?>
    </section>
    <?php
    $i +=4; //update article table index to continue to next layout
    $pattern = 'B'; //switch to pattern B layout
    ?>

    <?php 
    //pattern B layout implementing
    else: 
    ?>

    <!-- Pattern B has 2 articles in sidebar on Left, and 4 rows on the right -->
    <section class="article-sec2">

        <div class="article-sidebar2">
            <?php if(isset($articles[$i])): ?>
                <div class="card article-card4">
                    <img src="../images/<?php echo htmlspecialchars($articles[$i]['image_name']);?>"
                    alt="<?php echo htmlspecialchars($articles[$i]['image_caption']); ?>">
                </div>
                <div class="article-sum3">
                    <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i]['article_id']; ?>">
                    <h2><?php echo htmlspecialchars($articles[$i]['title']); ?></h2>
                    </a> 
                    <p><?php echo htmlspecialchars($articles[$i]['summary']); ?></p>
                </div>
            <?php endif; ?>

            <?php if(isset($articles[$i + 1])): ?>
                <div class="card article-card4">
                    <img src="../images/<?php echo htmlspecialchars($articles[$i + 1]['image_name']);?>"
                    alt="<?php echo htmlspecialchars($articles[$i + 1]['image_caption']); ?>">
                </div>
                <div class="article-sum3">
                    <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i + 1]['article_id']; ?>">
                    <h2><?php echo htmlspecialchars($articles[$i + 1]['title']); ?></h2>
                    </a> 
                    <p><?php echo htmlspecialchars($articles[$i + 1]['summary']); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="article-dr">
            <?php if(isset($articles[$i + 2])): ?>
            <div class="article-textL">
                <div class="article-sum2">
                    <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i + 2]['article_id']; ?>">
                    <h2><?php echo htmlspecialchars($articles[$i + 2]['title']); ?></h2>
                    </a> 
                    <p><?php echo htmlspecialchars($articles[$i + 2]['summary']); ?></p>
                </div>    
                <div class="card article-card2">
                    <img src="../images/<?php echo htmlspecialchars($articles[$i + 2]['image_name']);?>"
                    alt="<?php echo htmlspecialchars($articles[$i + 2]['image_caption']); ?>">
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($articles[$i + 3])): ?>
            <div class="article-textR">
                <div class="card article-card2">
                    <img src="../images/<?php echo htmlspecialchars($articles[$i + 3]['image_name']);?>"
                    alt="<?php echo htmlspecialchars($articles[$i + 3]['image_caption']); ?>">
                </div>
                <div class="article-sum2">
                    <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i + 3]['article_id']; ?>">
                    <h2><?php echo htmlspecialchars($articles[$i + 3]['title']); ?></h2>
                    </a> 
                    <p><?php echo htmlspecialchars($articles[$i + 3]['summary']); ?></p>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if(isset($articles[$i + 4])): ?>
            <div class="article-textL">
                <div class="article-sum2">
                    <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i + 4]['article_id']; ?>">
                    <h2><?php echo htmlspecialchars($articles[$i + 4]['title']); ?></h2>
                    </a> 
                    <p><?php echo htmlspecialchars($articles[$i + 4]['summary']); ?></p>
                </div>    
                <div class="card article-card2">
                    <img src="../images/<?php echo htmlspecialchars($articles[$i + 4]['image_name']);?>"
                    alt="<?php echo htmlspecialchars($articles[$i + 4]['image_caption']); ?>">
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($articles[$i + 5])): ?>
            <div class="article-textR">
                <div class="card article-card2">
                    <img src="../images/<?php echo htmlspecialchars($articles[$i + 5]['image_name']);?>"
                    alt="<?php echo htmlspecialchars($articles[$i + 5]['image_caption']); ?>">
                </div>
                <div class="article-sum2">
                    <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i + 5]['article_id']; ?>">
                    <h2><?php echo htmlspecialchars($articles[$i + 5]['title']); ?></h2>
                    </a> 
                    <p><?php echo htmlspecialchars($articles[$i + 5]['summary']); ?></p>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </section>
<?php 
$i +=6; //increase index for next pattern A loop
$pattern = 'A'; //back to pattern A layout 
?>
    <?php endif; ?>
<?php endwhile; ?>

<!-- if theres additional 1 article left, it displays in its own banner, not starting another pattern loop -->
<?php if(isset($articles[$i]) && $i< $total_articles): ?>
    <section class="article-sec1">
    <div class="card article-card1">
        <img src="../images/<?php echo htmlspecialchars($articles[$i]['image_name']);?>"
        alt="<?php echo htmlspecialchars($articles[$i]['image_caption']); ?>">
    </div>
    <div class="article-sum1">
        <a href="/wildlife-emporium/articles/details.php?id=<?php echo $articles[$i]['article_id']; ?>">
            <?php echo htmlspecialchars($articles[$i]['title']); ?>
        </a>        
        <p><?php echo htmlspecialchars($articles[$i]['summary']); ?></p>
    </div>
</section>
<?php endif; ?>

<?php else: ?>
    <p>No articles available.</p>
<?php endif; ?>

</div>
</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/script.js"></script>

</body>
</html>