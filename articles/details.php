<?php

session_start();

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

//Like Button for Articles 
$isLoggedIn = isset($_SESSION["userID"]);
$currentUserID = $isLoggedIn ? $_SESSION["userID"] : null;

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "like"){
    if($isLoggedIn){
        $checkLike = "SELECT likeID FROM article_likes WHERE articleID = ? AND userID = ?";
        $stmt = mysqli_prepare($connection,$checkLike);
        mysqli_stmt_bind_param($stmt, "ii", $article_id, $currentUserID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0){
            //Unlike, so remove record from the table
            $deleteSql = "DELETE FROM article_likes WHERE articleID = ? AND userID = ?";
            $delStmt = mysqli_prepare($connection, $deleteSql);
            mysqli_stmt_bind_param($delStmt, "ii", $article_id, $currentUserID);
            mysqli_stmt_execute($delStmt);
            mysqli_stmt_close($delStmt);
        }
        else{
            //like, add record to the table
            $insertSql = "INSERT INTO article_likes (articleID, userID) VALUES (?,?)";
            $insStmt = mysqli_prepare($connection, $insertSql);
            mysqli_stmt_bind_param($insStmt, "ii", $article_id, $currentUserID);
            mysqli_stmt_execute($insStmt);
            mysqli_stmt_close($insStmt);
        }
        mysqli_stmt_close($stmt);

        header("Location: details.php?id=" . $article_id . "#like-btn");
        exit();
    }
}

//comment section 
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "comment"){
    if($isLoggedIn){
        $commentText = trim($_POST["comment-text"] ?? "");

        if(!empty($commentText)){
            $insertComment = "INSERT INTO article_comments (articleID, userID, commentText) VALUES (?,?,?)";
            $stmt = mysqli_prepare($connection, $insertComment);
            mysqli_stmt_bind_param($stmt, "iis", $article_id, $currentUserID, $commentText);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            //prevent duplicate coments
            header("Location: details.php?id=" . $article_id . "#comment-form");
            exit();
        }
    }
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

//take total likes number from the table
$likeCount = "SELECT COUNT(*) as totalLikes FROM article_likes WHERE articleID = ?";
$stmt = mysqli_prepare($connection, $likeCount);
mysqli_stmt_bind_param($stmt, "i", $article_id);
mysqli_stmt_execute($stmt);
$likeResult = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
$totalLikes = $likeResult['totalLikes'] ?? 0;
mysqli_stmt_close($stmt);

//check if logged in user likes article 
$hasLiked = false;
if($isLoggedIn){
    $userLike = "SELECT likeID FROM article_likes WHERE articleID = ? AND userID = ?";
    $stmt = mysqli_prepare($connection, $userLike);
    mysqli_stmt_bind_param($stmt, "ii", $article_id,$currentUserID);
    mysqli_stmt_execute($stmt);
    $hasLiked = mysqli_num_rows(mysqli_stmt_get_result($stmt)) > 0;
    mysqli_stmt_close($stmt);
}

// get the comments for comment section
$commentsQuery = "SELECT article_comments.commentID, article_comments.commentText, article_comments.createdAt,
                users.username FROM article_comments
                JOIN users ON article_comments.userID = users.userID
                WHERE article_comments.articleID = ?
                ORDER BY article_comments.createdAt DESC";

$stmt = mysqli_prepare($connection, $commentsQuery);
mysqli_stmt_bind_param($stmt, "i", $article_id);
mysqli_stmt_execute($stmt);
$commentResult = mysqli_stmt_get_result($stmt);

$comments = [];
while ($row = mysqli_fetch_assoc($commentResult)){
    $comments[] = $row;
}
mysqli_stmt_close($stmt);

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
        <h1 class="article-pg-title"><?php echo htmlspecialchars($main_article['title']); ?></h1>
        <h3 class="article-pg-subheading"><?php echo htmlspecialchars($main_article['subheading']); ?></h3>
         <?php if (!empty($main_article['keywords'])): ?>
        <span class="article-keywords">
            <?php 
            $keywords_array = array_map('trim', explode(',', $main_article['keywords'])); 
            echo htmlspecialchars(implode(' | ', $keywords_array)); 
            ?>
        </span>
    <?php endif; ?>
    <br>
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

        <!-- like button -->
         <form method="POST" action="#like-btn" class="like-form">
            <input type="hidden" name="action" value="like">
            <button type="submit" id="like-btn" class="like-button <?php echo $hasLiked ? 'liked' : ''; ?>">
                ♥ <?php echo $totalLikes; ?> <?php echo ($totalLikes === 1) ? 'Like' : 'Likes'; ?>
        </button>
        </form>
    </article>

<!-- comments section -->
    <section class="comment-section">
        <h2 class="comments-title">COMMENT SECTION</h2>

        <form method="POST" action="#comment-form" class="comment-form" id="comment-form">
            <input type="hidden" name="action" value="comment">
            <textarea name="comment-text" 
            id="comment-text" 
            rows="3"
            placeholder="<?php echo $isLoggedIn ? 'Write a comment...' : 'Log in to comment...'; ?>"
            <?php echo !$isLoggedIn ? 'disabled' : '';?>
            required></textarea>

            <button type="submit" id="comment-submit-btn" class="comment-submit-btn"
            <?php echo !$isLoggedIn ? 'disabled' : ''; ?>>
            Post </button>
        </form>

        <!-- display comments -->
        <div class="comments-all">
            <?php if(empty($comments)): ?>
                <p class="no-comments">No comments yet. Be the first to comment</p>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-card">
                    <div class="comment-header">
                        <strong class="comment-author"><?php echo htmlspecialchars($comment['username']); ?></strong>
                        <span class="comment-date"><?php echo date("M j, Y \\a\\t g:i a", strtotime($comment['createdAt'])); ?></span>
                    </div>
                    <p class="comment-text"><?php echo nl2br(htmlspecialchars($comment['commentText'])); ?></p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>



</div>
<br>
<hr class="article-divider">
    <!-- suggested articles below -->
    <?php if (!empty($suggested_articles)): ?>
    <section class="suggested-articles-container">
        <h2 class="suggested-articles-title">SUGGESTED ARTICLES</h2>
        
        <div class="suggested-articles-grid">
        <?php foreach ($suggested_articles as $suggested): ?>
            <!-- Suggested Card -->
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

<script>
    const IS_LOGGED_IN = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
    </script>
<script src="../js/articles.js"></script>
<script src="../js/script.js"></script>

</body>
</html>