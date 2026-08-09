<?php

//connect to databse
require_once("../includes/database.php");

//see if article_ID in url 
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $article_id = (int)$_GET['id'];
}
else{
    //id is missing from url or its invalid then,
    exit(
        "<div class='article-return'>
        <h1>Our Apologies!</h1>
        <h2>This article page is currently not available</h2>
        <a href='articles.php'>Return to All Articles</a>
        </div>"
        );
}
//query for the main article of the pg
$query_main = "SELECT article_id, title, subheading, author,keywords, summary, content, image_name, image_caption, image_name2, image_caption2, creation_at
               FROM articles WHERE article_id = ?";

$statement_main = mysqli_prepare($connection, $query_main);
mysqli_stmt_bind_param($statement_main, "i", $article_id);
mysqli_stmt_execute($statement_main);
mysqli_stmt_bind_result($statement_main, $article_id, $title, $subheading, $author, $keywords, $summary, $content, $image_name, $image_caption,$image_name2, $image_caption2, $creation_at );

if(mysqli_stmt_fetch($statement_main)){
    $main_article = [
        'article_id' => $article_id,
        'title'      => $title,
        'subheading' => $subheading,
        'author'     => $author,
        'keywords'   => $keywords,
        'summary'    => $summary,
        'content'    => $content,
        'image_name' => $image_name,
        'image_caption' => $image_caption,
        'image_name2'=> $image_name2,
        'image_caption2' => $image_caption2,
        'creation_at' => $creation_at
    ];
}
else{
    exit(
        "<div class='article-return'>
        <h1>Our Apologies!</h1>
        <h2>This article page is currently not available</h2>
        <a href='articles.php'>Return to All Articles</a>
        </div>"
    );
}
mysqli_stmt_close($statement_main);

//get suggested articles for the bottom of article page 
$query_suggested = "SELECT article_id, title, summary, image_name, image_caption 
                    FROM articles WHERE article_id != ? ORDER BY RAND() LIMIT 3";

$statement_suggested = mysqli_prepare($connection, $query_suggested);
mysqli_stmt_bind_param($statement_suggested, "i", $article_id);
mysqli_stmt_execute($statement_suggested);
mysqli_stmt_bind_result($statement_suggested, $sugg_article_id, $sugg_title, $sugg_summary, $sugg_image_name, $sugg_image_caption);

$suggested_articles = [];
while (mysqli_stmt_fetch($statement_suggested)) {
    $suggested_articles[] = [
        'article_id'    => $sugg_article_id,
        'title'         => $sugg_title,
        'summary'       => $sugg_summary,
        'image_name'    => $sugg_image_name,
        'image_caption' => $sugg_image_caption
    ];
}
mysqli_stmt_close($statement_suggested);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($main_article['title']); ?></title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/articles.css">
</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>

<main>

<div class="article-pg-frame">

<div class="article-main-column">

    <!-- main title -->
    <header class="article-pg-header">
        <?php if (!empty($main_article['keywords'])): ?>
        <span class="article-keywords">
            <?php 
            $keywords_array = array_map('trim', explode(',', $main_article['keywords'])); 
            echo htmlspecialchars(implode(' | ', $keywords_array)); 
            ?>
        </span>
    <?php endif; ?>
        <h1 class="article-pg-title"><?php echo htmlspecialchars($main_article['title']); ?></h1>
        <h3 class="article-pg-subheading"><?php echo htmlspecialchars($main_article['subheading']); ?></h3>
        
        <div class="article-details">
            <span class="article-author"><?php echo htmlspecialchars($main_article['author']); ?></span>
           <span class="details-divider">•</span>
            <span class="article-date">Published on: <?php echo date("F j, Y", strtotime($main_article['creation_at'])); ?></span>
        </div>
    </header>

    <!-- main article image-->
    <?php if (!empty($main_article['image_name'])): ?>
    <figure class="article-pg-img1">
        <img src="../images/<?php echo htmlspecialchars($main_article['image_name']); ?>"
        alt="<?php echo htmlspecialchars($main_article['image_caption']); ?>">
        <?php if (!empty($main_article['image_caption'])): ?>
        <figcaption class="img1-caption"><?php echo htmlspecialchars($main_article['image_caption']); ?></figcaption>
        <?php endif; ?>
    </figure>
    <?php endif; ?>
<br>
    <!-- article content-->
    <article class="article-pg-content">
    <?php echo nl2br(htmlspecialchars($main_article['content'])); ?>
<br><br>
        <!-- add. image for article -->
        <?php if (!empty($main_article['image_name2'])): ?>
        <figure class="article-pg-img2">
            <img src="../images/<?php echo htmlspecialchars($main_article['image_name2']); ?>"
             alt="<?php echo htmlspecialchars($main_article['image_caption2']); ?>">
            <figcaption class="img2-caption"><?php echo htmlspecialchars($main_article['image_caption2']); ?></figcaption>
        </figure>
        <?php endif; ?>
    </article>

</div>
<br>
<hr class="article-divider">
    <!-- suggested articles below -->
    <?php if (!empty($suggested_articles)): ?>
    <section class="suggested-articles-container">
        <h2 class="suggested-articles-title">SUGGESTED ARTICLES</h2>
        
        <div class="suggested-articles-grid">
        <?php foreach ($suggested_articles as $suggested): ?>
            <!-- Suggested Card 1 -->
            <div class="suggested-card">
                <div class="suggested-card-img">
                    <img src="../images/<?php echo htmlspecialchars($suggested['image_name']); ?>"
                     alt="<?php echo htmlspecialchars($suggested['image_caption']); ?>">
                </div>
                <div class="suggested-card-body">
                    <h3><a href="details.php?id=<?php echo $suggested['article_id']; ?>">
                        <?php echo htmlspecialchars($suggested['title']); ?>
                    </a></h3>
                    <p><?php echo htmlspecialchars($suggested['summary']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</div>
</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/script.js"></script>

</body>
</html>