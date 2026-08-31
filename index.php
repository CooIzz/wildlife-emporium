<?php

require_once("includes/database.php");


// Load random featured animal

$statement = mysqli_prepare(
    $connection,
    "SELECT animalID, commonName, scientificName, class, image
     FROM animals
     ORDER BY RAND()
     LIMIT 1"
);

if (!$statement)
{
    die("Failed to load featured animal.");
}

mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);

$featuredAnimal = mysqli_fetch_assoc($result);

mysqli_stmt_close($statement);

if (!$featuredAnimal)
{
    die("No animals available.");
}


// Load latest articles for homepage preview

$articleStatement = mysqli_prepare(
    $connection,
    "SELECT article_id, title, summary, image_name, image_caption, creation_at
     FROM articles
     ORDER BY creation_at DESC
     LIMIT 6"
);

$articles = [];

if ($articleStatement)
{
    mysqli_stmt_execute($articleStatement);

    mysqli_stmt_bind_result(
        $articleStatement,
        $articleID,
        $articleTitle,
        $articleSummary,
        $articleImage,
        $articleCaption,
        $articleCreation
    );

    while (mysqli_stmt_fetch($articleStatement))
    {
        $articles[] = [
            "article_id"    => $articleID,
            "title"         => $articleTitle,
            "summary"       => $articleSummary,
            "image_name"    => $articleImage,
            "image_caption" => $articleCaption,
            "creation_at"   => $articleCreation
        ];
    }

    mysqli_stmt_close($articleStatement);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Wildlife Emporium</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">

</head>

<body>

    <?php include("includes/header.php"); ?>
    <?php include("includes/navigation.php"); ?>


    <main>

        <!-- Hero -->

        <section class="home-hero">

            <div class="home-hero-visual">

                <img
                    src="images/logo.png"
                    alt="Wildlife Emporium"
                >

            </div>


            <div class="home-hero-content">

                <p class="home-hero-label">
                    WILDLIFE EMPORIUM
                </p>

                <h1>
                    Discover. Learn. Protect.
                </h1>

                <p class="home-hero-description">
                    Explore the animals, stories, and knowledge that make our natural world extraordinary.
                </p>

                <div class="home-hero-actions">

                    <a
                        href="animals/index.php"
                        class="home-hero-primary"
                    >
                        Explore Animals
                    </a>

                    <a
                        href="quiz/index.php"
                        class="home-hero-secondary"
                    >
                        Take the Quiz
                    </a>

                </div>

            </div>

        </section>


        <!-- Featured Animal -->

        <section class="home-featured">

            <div class="home-section-heading">

                <p class="home-section-label">
                    FEATURED
                </p>

                <h2>
                    Meet an Animal
                </h2>

            </div>


            <div class="home-featured-card">

                <div class="home-featured-image">

                    <img
                        src="images/animals/<?php echo htmlspecialchars($featuredAnimal["image"], ENT_QUOTES, "UTF-8"); ?>"
                        alt="<?php echo htmlspecialchars($featuredAnimal["commonName"], ENT_QUOTES, "UTF-8"); ?>"
                    >

                </div>


                <div class="home-featured-content">

                    <p class="home-featured-class">
                        <?php echo htmlspecialchars($featuredAnimal["class"], ENT_QUOTES, "UTF-8"); ?>
                    </p>

                    <h3>
                        <?php echo htmlspecialchars($featuredAnimal["commonName"], ENT_QUOTES, "UTF-8"); ?>
                    </h3>

                    <p class="home-featured-scientific">
                        <?php echo htmlspecialchars($featuredAnimal["scientificName"], ENT_QUOTES, "UTF-8"); ?>
                    </p>

                    <p class="home-featured-description">
                        Discover the characteristics, habitat, behaviour, and conservation information about this animal in our encyclopedia.
                    </p>

                    <a
                        href="animals/details.php?animalID=<?php echo $featuredAnimal["animalID"]; ?>"
                        class="home-featured-link"
                    >
                        View Animal
                    </a>

                </div>

            </div>

        </section>


        <!-- Main Navigation -->

        <section class="home-navigation">

            <div class="home-section-heading">

                <p class="home-section-label">
                    EXPLORE
                </p>

                <h2>
                    Explore Wildlife Emporium
                </h2>

            </div>


            <div class="home-navigation-grid">

                <!-- Animal Encyclopedia -->

                <a
                    href="animals/index.php"
                    class="home-navigation-card"
                >

                    <div class="home-navigation-icon">
                        <img src="images/home/encyclopedia.svg" alt="Animal Encyclopedia">
                    </div>

                    <div class="home-navigation-content">

                        <h3>
                            Animal Encyclopedia
                        </h3>

                        <p>
                            Discover animals, their characteristics, habitats, and taxonomy.
                        </p>

                    </div>

                    <span class="home-navigation-arrow">
                        →
                    </span>

                </a>


                <!-- Wildlife Articles -->

                <a
                    href="articles/index.php"
                    class="home-navigation-card"
                >

                    <div class="home-navigation-icon">
                        <img src="images/home/articles.svg" alt="Wildlife Articles">
                    </div>

                    <div class="home-navigation-content">

                        <h3>
                            Wildlife Articles
                        </h3>

                        <p>
                            Read stories and informative articles about the natural world.
                        </p>

                    </div>

                    <span class="home-navigation-arrow">
                        →
                    </span>

                </a>


                <!-- Wildlife Quiz -->

                <a
                    href="quiz/index.php"
                    class="home-navigation-card"
                >

                    <div class="home-navigation-icon">
                        <img src="images/home/quiz.svg" alt="Wildlife Quiz">
                    </div>

                    <div class="home-navigation-content">

                        <h3>
                            Wildlife Quiz
                        </h3>

                        <p>
                            Test your knowledge and challenge yourself with wildlife quizzes.
                        </p>

                    </div>

                    <span class="home-navigation-arrow">
                        →
                    </span>

                </a>


                <!-- Account -->

                <a
                    href="account/profile.php"
                    class="home-navigation-card"
                >

                    <div class="home-navigation-icon">
                        <img src="images/home/profile.svg" alt="Your Account">
                    </div>

                    <div class="home-navigation-content">

                        <h3>
                            Your Account
                        </h3>

                        <p>
                            Manage your account and access your Wildlife Emporium profile.
                        </p>

                    </div>

                    <span class="home-navigation-arrow">
                        →
                    </span>

                </a>

            </div>

        </section>


        <!-- Latest Articles -->

        <section class="home-articles">

            <div class="home-section-heading">

                <p class="home-section-label">
                    DISCOVER
                </p>

                <h2>
                    Latest Articles
                </h2>

            </div>


            <?php if (!empty($articles)): ?>

                <div class="home-article-carousel">

                    <button
                        type="button"
                        class="home-article-previous"
                        aria-label="Previous articles"
                    >
                        ←
                    </button>


                    <div class="home-article-viewport">

                        <div class="home-article-row">

                            <?php foreach ($articles as $article): ?>

                                <article class="home-article-card">

                                    <div class="home-article-image">

                                        <img
                                            src="images/articles/<?php echo htmlspecialchars($article["image_name"], ENT_QUOTES, "UTF-8"); ?>"
                                            alt="<?php echo htmlspecialchars($article["image_caption"], ENT_QUOTES, "UTF-8"); ?>"
                                        >

                                    </div>


                                    <div class="home-article-content">

                                        <h3>
                                            <?php echo htmlspecialchars($article["title"], ENT_QUOTES, "UTF-8"); ?>
                                        </h3>

                                        <p>
                                            <?php echo htmlspecialchars($article["summary"], ENT_QUOTES, "UTF-8"); ?>
                                        </p>

                                        <a
                                            href="/wildlife-emporium/articles/details.php?id=<?php echo $article["article_id"]; ?>"
                                            class="home-article-link"
                                        >
                                            Read Article
                                        </a>

                                    </div>

                                </article>

                            <?php endforeach; ?>

                        </div>

                    </div>


                    <button
                        type="button"
                        class="home-article-next"
                        aria-label="Next articles"
                    >
                        →
                    </button>

                </div>

            <?php else: ?>

                <p class="home-articles-empty">
                    No articles available.
                </p>

            <?php endif; ?>


            <div class="home-articles-action">

                <a
                    href="articles/index.php"
                    class="home-section-button"
                >
                    Browse All Articles
                </a>

            </div>

        </section>


        <!-- Quiz -->

        <section class="home-quiz">

            <div class="home-section-heading">

                <p class="home-section-label">
                    CHALLENGE YOURSELF
                </p>

                <h2>
                    Wildlife Quiz
                </h2>

            </div>


            <div class="home-quiz-card">

                <div class="home-quiz-content">

                    <p class="home-quiz-category">
                        TEST YOUR KNOWLEDGE
                    </p>

                    <h3>
                        How well do you know the wild?
                    </h3>

                    <p>
                        Put your wildlife knowledge to the test with our curated collection of quizzes.
                        Challenge yourself, learn something new, and see how much you really know about
                        the animal kingdom.
                    </p>

                    <a
                        href="quiz/index.php"
                        class="home-quiz-link"
                    >
                        Take the Quiz
                    </a>

                </div>

            </div>

        </section>

    </main>


    <?php include("includes/footer.php"); ?>


    <script src="js/script.js"></script>
    <script src="js/home.js"></script>

</body>

</html>