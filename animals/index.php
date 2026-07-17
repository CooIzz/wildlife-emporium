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

<!--
    <p> Search for animals in the database using the search bar above.
        You can enter the name of the animal or any related keywords to find relevant information.</p>

    <p> Search for your favourite animal and learn more about it.
        Our database contains a wide variety of animals, from domestic pets to exotic wildlife!</p>

    

-->



    <section class="animal-search">

        <h2>Find Your Favourite Animal</h2>

        <form action="/action_page.php">
            <input type="text" placeholder="Search animals..." class="animal-search_bar">
        </form>

    </section>

    <section class="animal-filters">

        <button>All</button>
        <button>Mammals</button>
        <button>Birds</button>
        <button>Reptiles</button>
        <button>Marine</button>

    </section>

    <section class="animal-grid">
        
        <a href="animal_biographies/index.php?id=tiger" class="animal-card">
            <img src="tiger.jpg" alt="Tiger">
            <h3>Tiger</h3>
            <p>Mammal</p>
        </a>


        <a href="animal_biographies/index.php?id=orangutan" class="animal-card">
            <img src="orangutan.jpg" alt="Orangutan">
            <h3>Orangutan</h3>
            <p>Primate</p>
        </a>

        <article class="animal-card">
            <img src="penguin.jpg" alt="Penguin">
            <h3>Penguin</h3>
            <p>Bird</p>
        </article>

        <article class="animal-card">
            <img src="elephant.jpg" alt="Elephant">
            <h3>Elephant</h3>
            <p>Mammal</p>
        </article>

        <article class="animal-card">
            <img src="big_elephant.jpg" alt="Big Elephant">
            <h3>Big Elephant</h3>
            <p>Mammal</p>
        </article>

        <article class="animal-card">
            <img src="small_elephant.jpg" alt="Small Elephant">
            <h3>Small Elephant</h3>
            <p>Mammal</p>
        </article>

        <article class="animal-card">
            <img src="medium_elephant.jpg" alt="Medium Elephant">
            <h3>Medium Elephant</h3>
            <p>Mammal</p>
        </article>

    </section>

    <p> 🏆 Favorite Animals Collected</p>
    <p> 🌟 XP for viewing animals</p>
    <p> ❤️ "Favorite" button on each animal</p>
    <p> 🎖️ Badges like Bird Lover, Big Cat Fan, or Marine Explorer</p>
    <p> 📊 Progress: "You've discovered 18 of 50 animals."
    <p> ---- </p>
    <p> https://www.pokemon.com/us/pokedex </p>


</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/script.js"></script>

</body>
</html>