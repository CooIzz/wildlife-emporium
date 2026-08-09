<?php require_once("../includes/database.php"); ?>
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
            MAMMAL · FELIDAE
        </p>

        <h1>African Lion</h1>

        <p class="animal-scientific-name">
            Panthera leo
        </p>

        <div class="animal-actions">

            <button class="favorite-button">
                ♡ <span>Favourite</span>
            </button>

            <div class="animal-xp">
                ⭐ 100 XP
            </div>

        </div>

    </div>


    <div class="animal-hero-image">

        <img
            src="../images/lion.jpg"
            alt="African Lion">

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
                150–250 kg
            </strong>

        </div>


        <div class="quick-fact">

            <span class="fact-icon">📏</span>

            <span class="fact-label">
                Length
            </span>

            <strong>
                2.4–3.3 m
            </strong>

        </div>


        <div class="quick-fact">

            <span class="fact-icon">⏳</span>

            <span class="fact-label">
                Lifespan
            </span>

            <strong>
                10–14 years
            </strong>

        </div>


        <div class="quick-fact">

            <span class="fact-icon">🏃</span>

            <span class="fact-label">
                Top Speed
            </span>

            <strong>
                ~80 km/h
            </strong>

        </div>

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
            <strong>Animalia</strong>
        </div>


        <div>
            <span>Phylum</span>
            <strong>Chordata</strong>
        </div>


        <div>
            <span>Class</span>
            <strong>Mammalia</strong>
        </div>


        <div>
            <span>Order</span>
            <strong>Carnivora</strong>
        </div>


        <div>
            <span>Family</span>
            <strong>Felidae</strong>
        </div>


        <div>
            <span>Genus</span>
            <strong>Panthera</strong>
        </div>


        <div>
            <span>Species</span>
            <strong>Panthera leo</strong>
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

        <p>
            The African lion is one of the world's largest members
            of the cat family. Unlike most other big cats, lions
            are highly social animals that live together in groups
            known as prides.
        </p>

        <p>
            Lions are powerful predators that play an important role
            in their ecosystems. They primarily hunt large herbivores
            and often cooperate with other members of their pride
            when hunting.
        </p>

        <p>
            Although lions once occupied much of Africa, their range
            has declined considerably due to habitat loss, declining
            prey populations and conflict with humans.
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
                    Savanna & Grassland
                </strong>

            </div>


            <div class="habitat-item">

                <span class="habitat-label">
                    Climate
                </span>

                <strong>
                    Tropical & Subtropical
                </strong>

            </div>


            <div class="habitat-item">

                <span class="habitat-label">
                    Habitat
                </span>

                <strong>
                    Savanna, Grassland & Woodland
                </strong>

            </div>


            <div class="habitat-item habitat-range">

                <span class="habitat-label">
                    Geographic Range
                </span>

                <p>
                    Primarily found in sub-Saharan Africa,
                    with populations occurring in countries
                    including Kenya, Tanzania, Botswana and
                    South Africa.
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
                Carnivore
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
                Mostly nocturnal
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
                Prides
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

        <p>
            Lions are primarily carnivorous predators. They hunt a
            variety of large mammals, including zebras, wildebeest,
            antelope and buffalo. Hunting is often cooperative,
            particularly among lionesses within a pride.
        </p>

        <p>
            Lions tend to be more active during cooler periods of
            the day. Their social behaviour is unusual among cats,
            with related females often forming the stable core of
            a pride.
        </p>

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
                Year-round
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
                ~110 days
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
                1–4 cubs
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
                Raised within the pride
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

            <strong class="conservation-status-value">
                VULNERABLE
            </strong>

            <span class="conservation-trend">
                ↓ Population declining
            </span>

        </div>


        <div class="conservation-stat">

            <span class="conservation-label">
                Estimated Wild Population
            </span>

            <strong class="population-value">
                ~20,000–25,000
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

        <p>
            African lion populations have declined significantly
            across much of their historical range. Conservation
            efforts focus on protecting remaining habitat, maintaining
            healthy prey populations and reducing conflict between
            lions and local communities.
        </p>

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

        <div class="fun-fact">

            <span class="fun-fact-number">
                01
            </span>

            <p>
                Lions are the only big cats that regularly live
                in large social groups.
            </p>

        </div>


        <div class="fun-fact">

            <span class="fun-fact-number">
                02
            </span>

            <p>
                A lion's roar can be heard from several kilometres
                away under suitable conditions.
            </p>

        </div>


        <div class="fun-fact">

            <span class="fun-fact-number">
                03
            </span>

            <p>
                Lion cubs are born with spots that usually fade
                as they grow older.
            </p>

        </div>


        <div class="fun-fact">

            <span class="fun-fact-number">
                04
            </span>

            <p>
                Female lions usually do most of the hunting for
                their pride.
            </p>

        </div>

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