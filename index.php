<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wildlife Emporium</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>

<?php include("includes/header.php"); ?>

<?php include("includes/navigation.php"); ?>

<main>

    <!-- Introduction -->

    <section class="home-introduction">

        <div class="home-logo">
            <img src="images/home-logo-test.svg" alt="Wildlife Emporium Logo">
        </div>

        <h1 class="home-title">
            Wildlife Emporium
        </h1>

        <p class="home-description">
            Welcome to Wildlife Emporium, an interactive learning environment! Learn through our expansive encyclopedia and articles, or challenge yourself and others with our specially curated quizzes.
        </p>

    </section>



    <!-- Featured Animal -->

    <section class="home-featured-animal">

        <div class="home-featured-animal-image">
            <img src="images/tiger.png" alt="Featured Tiger">
        </div>

        <div class="home-featured-animal-content">

            <h2>Featured Animal</h2>

            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>

            <a href="#">
                Learn More
            </a>

        </div>

    </section>



    <!-- Encyclopedia -->

    <section class="home-encyclopedia">

        <h2>Explore Wildlife</h2>

        <div class="home-encyclopedia-image">
            <img src="https://thumbs.dreamstime.com/b/generated-image-380998003.jpg" alt="Wildlife Encyclopedia">
        </div>

        <p class="home-section-description">
            View our vast documentation of animals through our encyclopedia.
        </p>

        <a href="#" class="home-navigation-card">

            <div class="home-encyclopedia-icon">
                <img src="images/home-book-test2.svg" alt="Animal Encyclopedia Icon">
            </div>

            <h3>Animal Encyclopedia</h3>

        </a>

    </section>



    <!-- Latest Articles -->

    <section class="home-articles">

        <h2>Latest Articles</h2>

        <p class="home-section-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>

        <div class="home-card-row">

            <article class="home-article-card">

                <div class="home-article-image">
                    Image
                </div>

                <h3>Article Title</h3>

                <p>
                    Short article preview...
                </p>

            </article>

            <article class="home-article-card">

                <div class="home-article-image">
                    Image
                </div>

                <h3>Article Title</h3>

                <p>
                    Short article preview...
                </p>

            </article>

            <article class="home-article-card">

                <div class="home-article-image">
                    Image
                </div>

                <h3>Article Title</h3>

                <p>
                    Short article preview...
                </p>

            </article>

        </div>

        <a href="#" class="home-navigation-card">

            <div class="home-articles-icon">
                <img src="images/newspaper2.svg">
            </div>

            <h3>Browse Articles</h3>

        </a>

    </section>



    <!-- Wildlife Quiz -->

    <section class="home-quiz">

        <h2>Wildlife Quiz</h2>

        <p class="home-section-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>

        <div class="home-leaderboard">

            <h3>Leaderboard</h3>

            <div class="home-leaderboard-content">
                Leaderboard
            </div>

        </div>

        <div class="home-quiz-card">

            <a href="#" class="home-quiz-button">

                <div class="home-quiz-icon">
                    <img src="images/test67.svg">
                </div>

                <h3>Take the Quiz</h3>

            </a>

        </div>

    </section>

</main>













<?php include("includes/footer.php"); ?>

<script src="js/script.js"></script>

</body>
</html>