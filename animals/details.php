<?php

session_start();

require_once("../includes/database.php");

$animalID = filter_input(INPUT_GET,"animalID",FILTER_VALIDATE_INT);

if ($animalID === false || $animalID === null)
{
    die("Invalid animal.");
}

$statement = mysqli_prepare($connection,"SELECT animalID,commonName,scientificName,kingdom,phylum,class,orderName,family,genus,species,weight,length,lifespan,speed,habitat,distribution,diet,behaviour,description,conservationStatus,population,image FROM animals WHERE animalID = ?");

if (!$statement)
{
    die("Failed to load animal.");
}

mysqli_stmt_bind_param($statement,"i",$animalID);
mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);
$animal = mysqli_fetch_assoc($result);

mysqli_stmt_close($statement);

if (!$animal)
{
    die("Animal not found.");
}

$isFavourite = false;

if (isset($_SESSION["userID"]))
{
    $userID = $_SESSION["userID"];

    $statement = mysqli_prepare($connection,"SELECT favouriteID FROM favourites WHERE userID = ? AND animalID = ?");

    if ($statement)
    {
        mysqli_stmt_bind_param($statement,"ii",$userID,$animalID);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0)
        {
            $isFavourite = true;
        }

        mysqli_stmt_close($statement);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title><?php echo htmlspecialchars($animal["commonName"]); ?> | Animal Encyclopedia</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/animal-details.css">

</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main class="animal-details">

    <section class="animal-detail-header">

        <div class="animal-detail-image">

            <img src="../images/animals/<?php echo htmlspecialchars($animal["image"]); ?>" alt="<?php echo htmlspecialchars($animal["commonName"]); ?>">

        </div>

        <div class="animal-detail-heading">

            <p class="animal-detail-class">
                <?php echo htmlspecialchars($animal["class"]); ?>
            </p>

            <h1><?php echo htmlspecialchars($animal["commonName"]); ?></h1>

            <p class="animal-detail-scientific">
                <?php echo htmlspecialchars($animal["scientificName"]); ?>
            </p>

            <form method="POST" action="favourites.php" class="animal-card-favourite">

                <input type="hidden" name="animalID" value="<?php echo $animal["animalID"]; ?>">

                <button type="submit" aria-label="<?php echo $isFavourite ? "Remove " : "Add "; ?><?php echo htmlspecialchars($animal["commonName"],ENT_QUOTES,"UTF-8"); ?><?php echo $isFavourite ? " from favourites" : " to favourites"; ?>">

                    <img src="../images/animals/<?php echo $isFavourite ? "favourite-filled.png" : "favourite-empty.png"; ?>" alt="">

                </button>

            </form>

        </div>

    </section>

    <section class="animal-detail-section animal-about">

        <h2>About</h2>

        <p><?php echo nl2br(htmlspecialchars($animal["description"])); ?></p>

    </section>

    <section class="animal-detail-section">

        <h2>Physical Statistics</h2>

        <div class="animal-statistics">

            <div>
                <span>Weight</span>
                <p><?php echo htmlspecialchars($animal["weight"]); ?></p>
            </div>

            <div>
                <span>Length</span>
                <p><?php echo htmlspecialchars($animal["length"]); ?></p>
            </div>

            <div>
                <span>Lifespan</span>
                <p><?php echo htmlspecialchars($animal["lifespan"]); ?></p>
            </div>

            <div>
                <span>Speed</span>
                <p><?php echo htmlspecialchars($animal["speed"]); ?></p>
            </div>

        </div>

    </section>

    <section class="animal-detail-section">

        <h2>Taxonomy</h2>

        <div class="animal-taxonomy-tree">

            <div class="animal-taxonomy-level">

                <span>Kingdom</span>

                <p><?php echo htmlspecialchars($animal["kingdom"]); ?></p>

            </div>

            <div class="animal-taxonomy-level">

                <span>Phylum</span>

                <p><?php echo htmlspecialchars($animal["phylum"]); ?></p>

            </div>

            <div class="animal-taxonomy-level">

                <span>Class</span>

                <p><?php echo htmlspecialchars($animal["class"]); ?></p>

            </div>

            <div class="animal-taxonomy-level">

                <span>Order</span>

                <p><?php echo htmlspecialchars($animal["orderName"]); ?></p>

            </div>

            <div class="animal-taxonomy-level">

                <span>Family</span>

                <p><?php echo htmlspecialchars($animal["family"]); ?></p>

            </div>

            <div class="animal-taxonomy-level">

                <span>Genus</span>

                <p><?php echo htmlspecialchars($animal["genus"]); ?></p>

            </div>

            <div class="animal-taxonomy-level">

                <span>Species</span>

                <p><?php echo htmlspecialchars($animal["species"]); ?></p>

            </div>

        </div>

    </section>

    <section class="animal-detail-section">

        <h2>Habitat & Distribution</h2>

        <div class="animal-information">

            <div>

                <span>Habitat</span>

                <p><?php echo htmlspecialchars($animal["habitat"]); ?></p>

            </div>

            <div>

                <span>Distribution</span>

                <p><?php echo nl2br(htmlspecialchars($animal["distribution"])); ?></p>

            </div>

        </div>

    </section>

    <section class="animal-detail-section">

        <h2>Diet & Behaviour</h2>

        <div class="animal-information">

            <div>

                <span>Diet</span>

                <p><?php echo htmlspecialchars($animal["diet"]); ?></p>

            </div>

            <div>

                <span>Behaviour</span>

                <p><?php echo nl2br(htmlspecialchars($animal["behaviour"])); ?></p>

            </div>

        </div>

    </section>

    <section class="animal-detail-section">

        <h2>Conservation</h2>

        <div class="animal-statistics">

            <div>

                <span>Conservation Status</span>

                <p><?php echo htmlspecialchars($animal["conservationStatus"]); ?></p>

            </div>

            <div>

                <span>Estimated Population</span>

                <p><?php echo htmlspecialchars($animal["population"]); ?></p>

            </div>

        </div>

    </section>

    <div class="animal-detail-back">

        <a href="index.php">
            ← Back to Animal Encyclopedia
        </a>

    </div>

</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/favourites.js"></script>
<script src="../js/script.js"></script>

</body>

</html>