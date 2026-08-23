<?php

session_start();

require_once("../includes/database.php");
require_once("../includes/auth.php");

requireLogin();

$search = trim($_GET["search"] ?? "");
$class = trim($_GET["class"] ?? "");

$animals = [];


// Load animals

$sql = "SELECT animalID,commonName,scientificName,kingdom,phylum,class,orderName,family,genus,species,weight,length,lifespan,speed,habitat,diet,conservationStatus,image FROM animals";

$conditions = [];
$parameters = [];
$types = "";

if ($search !== "")
{
    $conditions[] = "(commonName LIKE ? OR scientificName LIKE ?)";

    $searchValue = "%" . $search . "%";

    $parameters[] = $searchValue;
    $parameters[] = $searchValue;

    $types .= "ss";
}

if ($class !== "")
{
    $conditions[] = "class = ?";

    $parameters[] = $class;

    $types .= "s";
}

if (!empty($conditions))
{
    $sql .= " WHERE " . implode(" AND ",$conditions);
}

$sql .= " ORDER BY commonName ASC";

$statement = mysqli_prepare($connection,$sql);

if (!$statement)
{
    die("Failed to load animals.");
}

if (!empty($parameters))
{
    mysqli_stmt_bind_param($statement,$types,...$parameters);
}

mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);

while ($animal = mysqli_fetch_assoc($result))
{
    $animals[] = $animal;
}

mysqli_stmt_close($statement);


// Load user's favourites

$favourites = [];

if (isset($_SESSION["userID"]))
{
    $userID = $_SESSION["userID"];

    $statement = mysqli_prepare(
        $connection,
        "SELECT animalID FROM favourites WHERE userID = ?"
    );

    if ($statement)
    {
        mysqli_stmt_bind_param($statement,"i",$userID);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        while ($data = mysqli_fetch_assoc($result))
        {
            $favourites[] = $data["animalID"];
        }

        mysqli_stmt_close($statement);
    }
}


// Load available animal classes

$classes = [];

$statement = mysqli_prepare(
    $connection,
    "SELECT DISTINCT class
     FROM animals
     WHERE class IS NOT NULL AND class != ''
     ORDER BY class ASC"
);

if (!$statement)
{
    die("Failed to load animal classes.");
}

mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);

while ($data = mysqli_fetch_assoc($result))
{
    $classes[] = $data["class"];
}

mysqli_stmt_close($statement);

$animalCount = count($animals);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Animal Encyclopedia</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/animals.css">

</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main class="animals-page">

    <!-- Search -->

    <form method="GET" class="animal-search">

        <div class="animal-search-input">

            <input
                type="text"
                name="search"
                value="<?php echo htmlspecialchars($search,ENT_QUOTES,"UTF-8"); ?>"
                placeholder="Search by common or scientific name..."
            >

            <button type="submit">Search</button>

        </div>

        <?php if ($search !== "") { ?>

            <a href="index.php" class="clear-search">Clear</a>

        <?php } ?>

    </form>


    <!-- Animal filters -->

    <div class="animal-filters">

        <?php

        $allUrl = "index.php";

        if ($search !== "")
        {
            $allUrl .= "?" . http_build_query(["search" => $search]);
        }

        ?>

        <a
            href="<?php echo htmlspecialchars($allUrl,ENT_QUOTES,"UTF-8"); ?>"
            class="<?php echo $class === "" ? "active" : ""; ?>"
        >
            All
        </a>

        <?php foreach ($classes as $animalClass) { ?>

            <?php

            $filterParameters = ["class" => $animalClass];

            if ($search !== "")
            {
                $filterParameters["search"] = $search;
            }

            $filterUrl = "index.php?" . http_build_query($filterParameters);

            ?>

            <a
                href="<?php echo htmlspecialchars($filterUrl,ENT_QUOTES,"UTF-8"); ?>"
                class="<?php echo $class === $animalClass ? "active" : ""; ?>"
            >
                <?php echo htmlspecialchars($animalClass,ENT_QUOTES,"UTF-8"); ?>
            </a>

        <?php } ?>

    </div>


    <!-- Results heading -->

    <div class="animals-results-heading">

        <div>

            <h2>Explore Animals</h2>

            <p>
                <?php echo $animalCount; ?>
                animal<?php echo $animalCount === 1 ? "" : "s"; ?>
                found
            </p>

        </div>

    </div>


    <!-- Animal cards -->

    <?php if ($animalCount > 0) { ?>

        <div class="animal-grid">

            <?php foreach ($animals as $animal) { ?>

                <?php $isFavourite = in_array($animal["animalID"],$favourites); ?>

                <div class="animal-card">

                    <div class="animal-card-inner">

                        <div class="animal-card-front">

                            <div class="animal-card-image">

                                <img
                                    src="../images/animals/<?php echo htmlspecialchars($animal["image"],ENT_QUOTES,"UTF-8"); ?>"
                                    alt="<?php echo htmlspecialchars($animal["commonName"],ENT_QUOTES,"UTF-8"); ?>"
                                >

                            </div>

                            <div class="animal-card-content">

                                <p class="animal-card-class">
                                    <?php echo htmlspecialchars($animal["class"],ENT_QUOTES,"UTF-8"); ?>
                                </p>

                                <h3>
                                    <?php echo htmlspecialchars($animal["commonName"],ENT_QUOTES,"UTF-8"); ?>
                                </h3>

                                <p class="animal-card-scientific">
                                    <?php echo htmlspecialchars($animal["scientificName"],ENT_QUOTES,"UTF-8"); ?>
                                </p>

                            </div>

                        </div>


                        <div class="animal-card-back">

                            <h3>
                                <?php echo htmlspecialchars($animal["commonName"],ENT_QUOTES,"UTF-8"); ?>
                            </h3>

                            <div class="animal-card-details">

                                <p>
                                    <span>Kingdom</span>
                                    <?php echo htmlspecialchars($animal["kingdom"],ENT_QUOTES,"UTF-8"); ?>
                                </p>

                                <p>
                                    <span>Phylum</span>
                                    <?php echo htmlspecialchars($animal["phylum"],ENT_QUOTES,"UTF-8"); ?>
                                </p>

                                <p>
                                    <span>Class</span>
                                    <?php echo htmlspecialchars($animal["class"],ENT_QUOTES,"UTF-8"); ?>
                                </p>

                                <p>
                                    <span>Order</span>
                                    <?php echo htmlspecialchars($animal["orderName"],ENT_QUOTES,"UTF-8"); ?>
                                </p>

                                <p>
                                    <span>Family</span>
                                    <?php echo htmlspecialchars($animal["family"],ENT_QUOTES,"UTF-8"); ?>
                                </p>

                                <p>
                                    <span>Genus</span>
                                    <?php echo htmlspecialchars($animal["genus"],ENT_QUOTES,"UTF-8"); ?>
                                </p>

                                <p>
                                    <span>Species</span>
                                    <?php echo htmlspecialchars($animal["species"],ENT_QUOTES,"UTF-8"); ?>
                                </p>

                            </div>

                            <a
                                href="details.php?animalID=<?php echo $animal["animalID"]; ?>"
                                class="animal-card-button"
                            >
                                View Details
                            </a>

                        </div>

                    </div>


                    <!-- Favourite -->

                    <form
                        method="POST"
                        action="favourites.php"
                        class="animal-card-favourite"
                    >

                        <input
                            type="hidden"
                            name="animalID"
                            value="<?php echo $animal["animalID"]; ?>"
                        >

                        <button
                            type="submit"
                            aria-label="<?php echo $isFavourite ? "Remove " : "Add "; ?><?php echo htmlspecialchars($animal["commonName"],ENT_QUOTES,"UTF-8"); ?><?php echo $isFavourite ? " from favourites" : " to favourites"; ?>"
                        >

                            <img
                                src="../images/animals/<?php echo $isFavourite ? "favourite-filled.png" : "favourite-empty.png"; ?>"
                                alt=""
                            >

                        </button>

                    </form>

                </div>

            <?php } ?>

        </div>

    <?php } else { ?>

        <!-- No results -->

        <div class="animals-empty">

            <h2>No animals found</h2>

            <p>Try a different search term or category.</p>

            <a href="index.php">View all animals</a>

        </div>

    <?php } ?>

</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/animals-flip.js"></script>
<script src="../js/favourites.js"></script>
<script src="../js/script.js"></script>

</body>

</html>