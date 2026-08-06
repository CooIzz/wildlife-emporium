<?php require_once("../includes/database.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals</title>

    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/animals.css">
</head>

<body>

<?php include("../../includes/header.php"); ?>
<?php include("../../includes/navigation.php"); ?>

<main>


    <!--
    <nav class="animal-breadcrumb">
        Home > Animals > African Lion
    </nav>
    -->

    <section class="animal-header">

        <h1 class="page-title">
            African Lion
        </h1>

    </section>

    <section class="animal-overview">

        <div class="animal-image">

            <img
                src="../images/lion.jpg"
                alt="African Lion">

        </div>

        <div class="animal-summary">

            <table class="animal-information">

                <tr>
                    <th>Scientific Name</th>
                    <td>Panthera leo</td>
                </tr>

                <tr>
                    <th>Conservation Status</th>
                    <td>Vulnerable</td>
                </tr>

                <tr>
                    <th>Habitat</th>
                    <td>Savanna</td>
                </tr>

                <tr>
                    <th>Diet</th>
                    <td>Carnivore</td>
                </tr>

                <tr>
                    <th>Lifespan</th>
                    <td>10-14 years</td>
                </tr>

            </table>

        </div>

    </section>

    <section class="animal-description">

        <h2 class="section-title">
            Overview
        </h2>

        <p>
            The African lion is one of the world's largest
            members of the cat family...
        </p>

    </section>

    <section class="animal-facts">

        <h2 class="section-title">
            Interesting Facts
        </h2>

        <ul>

            <li>Lions live in prides.</li>

            <li>Female lions do most of the hunting.</li>

            <li>Lions can roar up to 8 km away.</li>

        </ul>

    </section>

    <section class="animal-gallery">

        <h2 class="section-title">
            Gallery
        </h2>

        <div class="animal-gallery-grid">

            <img src="../images/lion1.jpg">

            <img src="../images/lion2.jpg">

            <img src="../images/lion3.jpg">

        </div>

    </section>

    <section class="animal-video">

        <h2 class="section-title">
            Video
        </h2>

        <iframe 
        src="https://www.youtube.com/embed/tgbNymZ7vqY">
        </iframe>










</main>

<?php include("../../includes/footer.php"); ?>

<script src="../../js/script.js"></script>

</body>
</html>