<?php

session_start();

require_once("../includes/database.php");

$id = $_GET['id'] ?? 1;


/* ---------------- LOAD ANIMAL ---------------- */

$sql = "SELECT * FROM animals WHERE id = ?";
$stmt = $connection->prepare($sql);
// Prepare the statement and bind the parameter to prevent SQL injection
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$animal = $result->fetch_assoc();

if (!$animal) {
    die("Animal not found.");
}





/* ---------------- TOGGLE FAVOURITE ---------------- */

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["toggle_favourite"])) {
    if (!isset($_SESSION["userID"])) {
        header("Location: ../account/login.php");
        exit();
    }

    $userID = $_SESSION["userID"];

    /* Check whether this favourite already exists */

    $sql = "
        SELECT id
        FROM favourites
        WHERE userID = ?
        AND animal_id = ?
    ";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param("ii", $userID, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $alreadyFavourite = $result->num_rows > 0;
    $stmt->close();


    /* Remove favourite */

    if ($alreadyFavourite) {
        $sql = "
            DELETE FROM favourites
            WHERE userID = ?
            AND animal_id = ?
        ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param(
            "ii",
            $userID,
            $id
        );
        $stmt->execute();
        $stmt->close();
    }


    /* Add favourite */

    else {
        $sql = "
            INSERT INTO favourites (userID, animal_id)
            VALUES (?, ?)
        ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $userID, $id);
        $stmt->execute();
        $stmt->close();
    }


    /* Reload the page */

    header("Location: details.php?id=" . $id);
    exit();
    
}





/* ---------------- CHECK FAVOURITE ---------------- */

$isFavourite = false;

if (isset($_SESSION["userID"])) {

    $sql = "
        SELECT id
        FROM favourites
        WHERE userID = ?
        AND animal_id = ?
    ";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "ii",
        $_SESSION["userID"],
        $id
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $isFavourite = true;
    }

    $stmt->close();
}



/* ---------------- LOAD ANIMAL FACTS ---------------- */

$fact_sql = "SELECT fact_number, fact
             FROM animal_facts
             WHERE animal_id = ?
             ORDER BY fact_number ASC";

$fact_stmt = $connection->prepare($fact_sql);
$fact_stmt->bind_param("i", $id);
$fact_stmt->execute();

$fact_result = $fact_stmt->get_result();


?>



<!-- -------------------------------------------------- -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/animals.css">
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main>


<!-- =========================================================
     ANIMAL HERO
     ========================================================= -->

<section class="animal-hero">

    <div class="animal-hero-content">

        <p class="animal-category">
            <?= htmlspecialchars($animal['tax_class']) ?>
            ·
            <?= htmlspecialchars($animal['family']) ?>
        </p>

        <h1>
            <?= htmlspecialchars($animal['common_name']) ?>
        </h1>

        <p class="animal-scientific-name">
            <?= htmlspecialchars($animal['scientific_name']) ?>
        </p>

        <div class="animal-actions">

            <form method="post" class="favorite-form">

                <button type="submit" name="toggle_favourite" class="favorite-button">
                    <?= $isFavourite ? "♥" : "♡" ?>
                    <span>Favourite</span>
                </button>

            </form>

            <div class="animal-xp">
                ⭐ 100 XP
            </div>

        </div>

    </div>


    <div class="animal-hero-image">

        <img
            src="../images/<?= htmlspecialchars($animal['main_image']) ?>"
            alt="<?= htmlspecialchars($animal['common_name']) ?>">

    </div>

</section>



<!-- =========================================================
     TAXONOMY
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        🧬 Taxonomy
    </h2>


    <div class="taxonomy">


        <div>
            <span>Kingdom</span>
            <?= htmlspecialchars($animal['kingdom']) ?>
        </div>


        <div>
            <span>Phylum</span>
            <?= htmlspecialchars($animal['phylum']) ?>
        </div>


        <div>
            <span>Class</span>
            <?= htmlspecialchars($animal['tax_class']) ?>
        </div>


        <div>
            <span>Order</span>
            <?= htmlspecialchars($animal['tax_order']) ?>
        </div>


        <div>
            <span>Family</span>
            <?= htmlspecialchars($animal['family']) ?>
        </div>


        <div>
            <span>Genus</span>
            <?= htmlspecialchars($animal['genus']) ?>
        </div>


        <div>
            <span>Species</span>
            <?= htmlspecialchars($animal['species']) ?>
        </div>

    </div>

</section>




<!-- =========================================================
     QUICK FACTS
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        Quick Facts
    </h2>

    <div class="quick-facts">

        <div class="quick-fact">

            <span class="fact-icon">⚖️</span>

            <span class="fact-label">
                Weight
            </span>

            <strong>
                <?= htmlspecialchars($animal['weight_min']) .
                "–" . htmlspecialchars($animal['weight_max']) ?> kg
            </strong>

        </div>


        <div class="quick-fact">

            <span class="fact-icon">📏</span>

            <span class="fact-label">
                Length
            </span>

            <strong>
                <?= htmlspecialchars($animal['length_min']) .
                "–" . htmlspecialchars($animal['length_max']) ?> m
            </strong>

        </div>


        <div class="quick-fact">

            <span class="fact-icon">⏳</span>

            <span class="fact-label">
                Lifespan
            </span>

            <strong>
                <?= htmlspecialchars($animal['lifespan_min']) .
                "–" . htmlspecialchars($animal['lifespan_max']) ?> years
            </strong>

        </div>


        <div class="quick-fact">

            <span class="fact-icon">🏃</span>

            <span class="fact-label">
                Top Speed
            </span>

            <strong>
                ~<?= htmlspecialchars($animal['max_speed']) ?> km/h
            </strong>

        </div>

    </div>

</section>




<!-- =========================================================
     ABOUT
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        📖 About the African Lion
    </h2>

    <div class="animal-prose">

        <!-- to allow line breaks in the description, we can use nl2br() to convert newlines to <br> tags -->
        <p>
            <?= nl2br(htmlspecialchars($animal['description'])) ?>
        </p>

    </div>

</section>



<!-- =========================================================
     HABITAT & RANGE
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        🌍 Habitat & Range
    </h2>


    <div class="habitat-layout">


        <div class="habitat-map">

            <div class="map-placeholder">
                MAP OF AFRICA
            </div>

        </div>


        <div class="habitat-information">

            <div class="habitat-item">

                <span class="habitat-label">
                    Biome
                </span>

                <strong>
                    <?= htmlspecialchars($animal['biome']) ?>
                </strong>

            </div>


            <div class="habitat-item">

                <span class="habitat-label">
                    Climate
                </span>

                <strong>
                    <?= htmlspecialchars($animal['climate']) ?>
                </strong>

            </div>


            <div class="habitat-item">

                <span class="habitat-label">
                    Habitat
                </span>

                <strong>
                    <?= htmlspecialchars($animal['habitat']) ?>
                </strong>

            </div>


            <div class="habitat-item habitat-range">

                <span class="habitat-label">
                    Geographic Range
                </span>

                <p>
                    <?= htmlspecialchars($animal['geographic_range']) ?>
                </p>

            </div>


            <div class="location-tags">

                <span>Kenya</span>
                <span>Tanzania</span>
                <span>Botswana</span>
                <span>South Africa</span>

            </div>

        </div>

    </div>

</section>



<!-- =========================================================
     DIET & BEHAVIOUR
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        🍖 Diet & Behaviour
    </h2>


    <div class="behaviour-grid">


        <div class="info-card">

            <span class="info-card-icon">
                🍖
            </span>

            <h3>
                Diet
            </h3>

            <p>
                <?= htmlspecialchars($animal['diet']) ?>
            </p>

        </div>


        <div class="info-card">

            <span class="info-card-icon">
                🌙
            </span>

            <h3>
                Activity
            </h3>

            <p>
                <?= htmlspecialchars($animal['activity']) ?>
            </p>

        </div>


        <div class="info-card">

            <span class="info-card-icon">
                👥
            </span>

            <h3>
                Social Structure
            </h3>

            <p>
                <?= htmlspecialchars($animal['social_structure']) ?>
            </p>

        </div>


        <div class="info-card">

            <span class="info-card-icon">
                🦓
            </span>

            <h3>
                Common Prey
            </h3>

            <p>
                Zebra, wildebeest & antelope
            </p>

        </div>

    </div>


    <div class="animal-prose behaviour-prose">

        <?= nl2br(htmlspecialchars($animal['behaviour_description'])) ?>

    </div>

</section>



<!-- =========================================================
     REPRODUCTION & LIFE CYCLE
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        🍼 Reproduction & Life Cycle
    </h2>


    <div class="life-cycle-grid">

        <div class="life-cycle-item">

            <span class="life-cycle-icon">
                ❤️
            </span>

            <span class="life-cycle-label">
                Breeding
            </span>

            <strong>
                <?= htmlspecialchars($animal['breeding']) ?>
            </strong>

        </div>


        <div class="life-cycle-item">

            <span class="life-cycle-icon">
                ⏱️
            </span>

            <span class="life-cycle-label">
                Gestation
            </span>

            <strong>
                <?= htmlspecialchars($animal['gestation']) ?>
            </strong>

        </div>


        <div class="life-cycle-item">

            <span class="life-cycle-icon">
                🐾
            </span>

            <span class="life-cycle-label">
                Litter Size
            </span>

            <strong>
                <?= htmlspecialchars($animal['litter_size']) ?>
            </strong>

        </div>


        <div class="life-cycle-item">

            <span class="life-cycle-icon">
                👶
            </span>

            <span class="life-cycle-label">
                Young
            </span>

            <strong>
                <?= htmlspecialchars($animal['young']) ?>
            </strong>

        </div>

    </div>


    <div class="animal-prose">

        <p>
            Lionesses can give birth throughout the year. Cubs are
            born blind and remain hidden for the first several weeks
            of life. Lionesses within a pride may cooperate in caring
            for and nursing one another's cubs.
        </p>

    </div>

</section>



<!-- =========================================================
     POPULATION & CONSERVATION
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        📊 Population & Conservation
    </h2>


    <!-- Status + population -->

    <div class="conservation-overview">


        <div class="conservation-stat">

            <span class="conservation-label">
                Conservation Status
            </span>

            <strong>
                <?= htmlspecialchars($animal['conservation_status']) ?>
            </strong>

            <span class="conservation-trend">
                <?= htmlspecialchars($animal['population_trend']) ?>
            </span>

        </div>


        <div class="conservation-stat">

            <span class="conservation-label">
                Estimated Wild Population
            </span>

            <strong class="population-value">
                <?= htmlspecialchars($animal['population']) ?>
            </strong>

            <span class="population-note">
                Estimated individuals remaining
            </span>

        </div>

    </div>


    <!-- Threats -->

    <div class="threats">

        <h3>
            Major Threats
        </h3>


        <div class="threat-list">

            <div class="threat-item">
                <span>🌿</span>
                Habitat loss
            </div>


            <div class="threat-item">
                <span>🏘️</span>
                Human-wildlife conflict
            </div>


            <div class="threat-item">
                <span>🦓</span>
                Declining prey populations
            </div>

        </div>

    </div>


    <!-- Explanation -->

    <div class="animal-prose conservation-prose">

        <?= nl2br(htmlspecialchars($animal['conservation_description'])) ?>

    </div>

</section>



<!-- =========================================================
     FUN FACTS
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        💡 Fun Facts
    </h2>


    <div class="fun-facts-list">

        <?php while ($fact = $fact_result->fetch_assoc()): ?>

            <div class="fun-fact">

                <span class="fun-fact-number">
                    <?= str_pad($fact['fact_number'], 2, '0', STR_PAD_LEFT) ?>
                </span>

                <p>
                    <?= htmlspecialchars($fact['fact']) ?>
                </p>

            </div>

        <?php endwhile; ?>

    </div>

</section>



<!-- =========================================================
     SIZE COMPARISON
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        📏 Size Comparison
    </h2>


    <div class="size-comparison">


        <div class="size-animal">

            <div class="size-person">
                🧍
            </div>

            <strong>
                Human
            </strong>

            <span>
                ~1.7 m
            </span>

        </div>


        <div class="size-animal lion-size-animal">

            <div class="size-lion">
                🦁
            </div>

            <strong>
                African Lion
            </strong>

            <span>
                Up to ~1.2 m at shoulder
            </span>

        </div>

    </div>

</section>






<!-- =========================================================
     GALLERY
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        📸 Gallery
    </h2>


    <div class="animal-gallery">

        <img
            src="../images/lion1.jpg"
            alt="African Lion">

        <img
            src="../images/lion2.jpg"
            alt="African Lion">

        <img
            src="../images/lion3.jpg"
            alt="African Lion">

    </div>

</section>



<!-- =========================================================
     ANIMAL SOUND
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        🔊 Hear the Animal
    </h2>


    <div class="audio-player-placeholder">

        <span class="audio-play">
            ▶
        </span>

        <div class="audio-bar">
            <div class="audio-progress"></div>
        </div>

        <span>
            🔊
        </span>

    </div>

</section>



<!-- =========================================================
     VIDEO
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        🎥 Video
    </h2>


    <div class="video-container">

        <iframe
            src="https://www.youtube.com/embed/tgbNymZ7vqY"
            title="African Lion video"
            allowfullscreen>
        </iframe>

    </div>

</section>



<!-- =========================================================
     RELATED ANIMALS
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        🐾 Related Animals
    </h2>


    <div class="related-animals">


        <a href="#">

            <img
                src="../images/tiger.jpg"
                alt="Tiger">

            <strong>
                Tiger
            </strong>

        </a>


        <a href="#">

            <img
                src="../images/leopard.jpg"
                alt="Leopard">

            <strong>
                Leopard
            </strong>

        </a>


        <a href="#">

            <img
                src="../images/jaguar.jpg"
                alt="Jaguar">

            <strong>
                Jaguar
            </strong>

        </a>

    </div>

</section>



<!-- =========================================================
     QUIZ
     ========================================================= -->

<section class="animal-section">

    <div class="quiz-prompt">

        <div class="quiz-icon">
            🧠
        </div>

        <div class="quiz-content">

            <h2>
                Test Your Knowledge
            </h2>

            <p>
                Think you've learned enough about the African Lion?
                Put your knowledge to the test!
            </p>

            <a href="../quiz/quiz.php" class="quiz-button">
                Take the Quiz →
            </a>

        </div>

    </div>

</section>



<!-- =========================================================
     PROGRESS
     ========================================================= -->

<section class="animal-section">

    <h2 class="section-title">
        🏆 Your Progress
    </h2>


    <div class="progress-card">

        <div>
            ✓ Viewed
        </div>

        <div>
            ❤️ Favourited
        </div>

        <div>
            ⭐ +100 XP
        </div>

    </div>

</section>



<!-- =========================================================
     ANIMAL LAB — LATER
     
     Deliberately left out for now.
     
     When you eventually implement it, this can become:
     
     <section class="animal-section">
         ...
     </section>
     
     and the JavaScript experiment can be plugged in here.
     ========================================================= -->


</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/script.js"></script>

</body>
</html>


<!--
$sql = "SELECT * FROM animals";
$result = $conn->query($sql);

while ($animal = $result->fetch_assoc()) {
?>

    <article class="animal-card">

        <a href="details.php?id=<?php echo $animal['animal_id']; ?>">

            <img src="<?php echo $animal['image']; ?>"
                 alt="<?php echo $animal['name']; ?>">

            <h3><?php echo $animal['name']; ?></h3>

            <p><?php echo $animal['category']; ?></p>

        </a>

        <form method="POST" action="favourite.php">

            <input type="hidden"
                   name="animal_id"
                   value="<?php echo $animal['animal_id']; ?>">

            <button type="submit" class="favourite-button">
                ♡
            </button>

        </form>

    </article>

-->