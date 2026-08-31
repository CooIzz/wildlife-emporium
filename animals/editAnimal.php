<?php

session_start();

require_once("../includes/auth.php");
require_once("../includes/database.php");

requireAdmin();

//this section is for checking the animal ID

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    exit(
        "<div class='animal-return'>
            <h1>Our Apologies!</h1>
            <h2>This animal could not be found.</h2>
            <a href='manageAnimals.php'>Return to Manage Animals</a>
        </div>"
    );
}

$animalID = (int)$_GET["id"];

//this section is for retrieving the animal

$query = "
    SELECT
        animalID,
        commonName,
        scientificName,
        kingdom,
        phylum,
        class,
        orderName,
        family,
        genus,
        species,
        weight,
        length,
        lifespan,
        speed,
        habitat,
        distribution,
        diet,
        behaviour,
        description,
        conservationStatus,
        population,
        image
    FROM animals
    WHERE animalID = ?
";

$statement = mysqli_prepare(
    $connection,
    $query
);

if (!$statement) {
    exit("Unable to load the animal.");
}

mysqli_stmt_bind_param(
    $statement,
    "i",
    $animalID
);

mysqli_stmt_execute($statement);

mysqli_stmt_bind_result(
    $statement,
    $databaseAnimalID,
    $commonName,
    $scientificName,
    $kingdom,
    $phylum,
    $class,
    $orderName,
    $family,
    $genus,
    $species,
    $weight,
    $length,
    $lifespan,
    $speed,
    $habitat,
    $distribution,
    $diet,
    $behaviour,
    $description,
    $conservationStatus,
    $population,
    $image
);

if (!mysqli_stmt_fetch($statement)) {

    mysqli_stmt_close($statement);

    exit(
        "<div class='animal-return'>
            <h1>Animal Not Found</h1>
            <h2>The requested animal does not exist.</h2>
            <a href='manageAnimals.php'>Return to Manage Animals</a>
        </div>"
    );
}

mysqli_stmt_close($statement);

//this section is for storing the original animal values

$animal = [
    "animalID" => $databaseAnimalID,
    "commonName" => $commonName,
    "scientificName" => $scientificName,
    "kingdom" => $kingdom,
    "phylum" => $phylum,
    "class" => $class,
    "orderName" => $orderName,
    "family" => $family,
    "genus" => $genus,
    "species" => $species,
    "weight" => $weight,
    "length" => $length,
    "lifespan" => $lifespan,
    "speed" => $speed,
    "habitat" => $habitat,
    "distribution" => $distribution,
    "diet" => $diet,
    "behaviour" => $behaviour,
    "description" => $description,
    "conservationStatus" => $conservationStatus,
    "population" => $population,
    "image" => $image
];

//this section is for updating the animal

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //this section is for retrieving submitted values

    $commonName = trim($_POST["commonName"] ?? "");
    $scientificName = trim($_POST["scientificName"] ?? "");
    $kingdom = trim($_POST["kingdom"] ?? "");
    $phylum = trim($_POST["phylum"] ?? "");
    $class = trim($_POST["class"] ?? "");
    $orderName = trim($_POST["orderName"] ?? "");
    $family = trim($_POST["family"] ?? "");
    $genus = trim($_POST["genus"] ?? "");
    $species = trim($_POST["species"] ?? "");
    $weight = trim($_POST["weight"] ?? "");
    $length = trim($_POST["length"] ?? "");
    $lifespan = trim($_POST["lifespan"] ?? "");
    $speed = trim($_POST["speed"] ?? "");
    $habitat = trim($_POST["habitat"] ?? "");
    $distribution = trim($_POST["distribution"] ?? "");
    $diet = trim($_POST["diet"] ?? "");
    $behaviour = trim($_POST["behaviour"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $conservationStatus = trim($_POST["conservationStatus"] ?? "");
    $population = trim($_POST["population"] ?? "");

    $imageName = $animal["image"];

    //this section is for validating required fields

    if (
        $commonName === "" ||
        $scientificName === ""
    ) {
        $errorMessage = "Please fill in all required fields.";
    }

    //this section is for handling the uploaded image

    if (
        $errorMessage === "" &&
        isset($_FILES["image"]) &&
        $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE
    ) {

        if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {

            $errorMessage = "Unable to upload the image.";

        } else {

            $allowedTypes = [
                "image/jpeg",
                "image/png",
                "image/gif",
                "image/webp"
            ];

            $imageType = mime_content_type(
                $_FILES["image"]["tmp_name"]
            );

            if (!in_array($imageType, $allowedTypes)) {

                $errorMessage = "Please upload a valid image file.";

            } else {

                $imageExtension = pathinfo(
                    $_FILES["image"]["name"],
                    PATHINFO_EXTENSION
                );

                $imageName = uniqid("animal_", true) . "." . $imageExtension;

                $imageFolder = "../images/animals/";

                if (!is_dir($imageFolder)) {
                    mkdir($imageFolder, 0777, true);
                }

                $imagePath = $imageFolder . $imageName;

                if (!move_uploaded_file(
                    $_FILES["image"]["tmp_name"],
                    $imagePath
                )) {
                    $errorMessage = "Unable to save the uploaded image.";
                }

            }

        }

    }

    //this section is for updating the database

    if ($errorMessage === "") {

        $updateQuery = "
            UPDATE animals
            SET
                commonName = ?,
                scientificName = ?,
                kingdom = ?,
                phylum = ?,
                class = ?,
                orderName = ?,
                family = ?,
                genus = ?,
                species = ?,
                weight = ?,
                length = ?,
                lifespan = ?,
                speed = ?,
                habitat = ?,
                distribution = ?,
                diet = ?,
                behaviour = ?,
                description = ?,
                conservationStatus = ?,
                population = ?,
                image = ?
            WHERE animalID = ?
        ";

        $updateStatement = mysqli_prepare(
            $connection,
            $updateQuery
        );

        if (!$updateStatement) {

            $errorMessage = "Unable to update the animal.";

        } else {

            mysqli_stmt_bind_param(
                $updateStatement,
                "sssssssssssssssssssssi",
                $commonName,
                $scientificName,
                $kingdom,
                $phylum,
                $class,
                $orderName,
                $family,
                $genus,
                $species,
                $weight,
                $length,
                $lifespan,
                $speed,
                $habitat,
                $distribution,
                $diet,
                $behaviour,
                $description,
                $conservationStatus,
                $population,
                $imageName,
                $animalID
            );

            if (mysqli_stmt_execute($updateStatement)) {

                mysqli_stmt_close($updateStatement);

                header(
                    "Location: manageAnimals.php?message=updated"
                );

                exit();

            } else {

                $errorMessage = "Unable to update the animal.";

                mysqli_stmt_close($updateStatement);

            }

        }

    }

    //this section is for keeping submitted values after validation failure

    $animal["commonName"] = $commonName;
    $animal["scientificName"] = $scientificName;
    $animal["kingdom"] = $kingdom;
    $animal["phylum"] = $phylum;
    $animal["class"] = $class;
    $animal["orderName"] = $orderName;
    $animal["family"] = $family;
    $animal["genus"] = $genus;
    $animal["species"] = $species;
    $animal["weight"] = $weight;
    $animal["length"] = $length;
    $animal["lifespan"] = $lifespan;
    $animal["speed"] = $speed;
    $animal["habitat"] = $habitat;
    $animal["distribution"] = $distribution;
    $animal["diet"] = $diet;
    $animal["behaviour"] = $behaviour;
    $animal["description"] = $description;
    $animal["conservationStatus"] = $conservationStatus;
    $animal["population"] = $population;
    $animal["image"] = $imageName;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Edit Animal | Wildlife Emporium
    </title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/editAnimal.css"
    >

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>


<main>

    <div class="edit-animal-page">


        <!--this section is for the page header-->

        <section class="edit-animal-header">

            <p class="edit-animal-label">
                ANIMAL MANAGEMENT
            </p>

            <h1>
                Edit Animal
            </h1>

            <p>
                Update the information for this animal in
                the Wildlife Emporium database.
            </p>

        </section>


        <!--this section is for the error message-->

        <?php if ($errorMessage !== ""): ?>

            <div class="edit-animal-error">

                <?php echo htmlspecialchars(
                    $errorMessage,
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>

            </div>

        <?php endif; ?>


        <!--this section is for the animal form-->

        <section class="edit-animal-form-container">

            <form
                method="POST"
                action="editAnimal.php?id=<?php echo $animalID; ?>"
                class="edit-animal-form"
                enctype="multipart/form-data"
            >


                <!--this section is for basic animal information-->

                <div class="edit-animal-section">

                    <p class="edit-animal-section-label">
                        ANIMAL INFORMATION
                    </p>

                    <h2>
                        Basic Information
                    </h2>


                    <div class="edit-form-group">

                        <label for="commonName">
                            Common Name
                        </label>

                        <input
                            type="text"
                            id="commonName"
                            name="commonName"
                            value="<?php echo htmlspecialchars(
                                $animal["commonName"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            required
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="scientificName">
                            Scientific Name
                        </label>

                        <input
                            type="text"
                            id="scientificName"
                            name="scientificName"
                            value="<?php echo htmlspecialchars(
                                $animal["scientificName"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            required
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="description">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                        ><?php echo htmlspecialchars(
                            $animal["description"] ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?></textarea>

                    </div>

                </div>


                <!--this section is for animal classification-->

                <div class="edit-animal-section">

                    <p class="edit-animal-section-label">
                        CLASSIFICATION
                    </p>

                    <h2>
                        Taxonomy
                    </h2>


                    <div class="edit-form-group">

                        <label for="kingdom">
                            Kingdom
                        </label>

                        <input
                            type="text"
                            id="kingdom"
                            name="kingdom"
                            value="<?php echo htmlspecialchars(
                                $animal["kingdom"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: Animalia"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="phylum">
                            Phylum
                        </label>

                        <input
                            type="text"
                            id="phylum"
                            name="phylum"
                            value="<?php echo htmlspecialchars(
                                $animal["phylum"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: Chordata"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="class">
                            Class
                        </label>

                        <input
                            type="text"
                            id="class"
                            name="class"
                            value="<?php echo htmlspecialchars(
                                $animal["class"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: Mammalia"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="orderName">
                            Order
                        </label>

                        <input
                            type="text"
                            id="orderName"
                            name="orderName"
                            value="<?php echo htmlspecialchars(
                                $animal["orderName"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="family">
                            Family
                        </label>

                        <input
                            type="text"
                            id="family"
                            name="family"
                            value="<?php echo htmlspecialchars(
                                $animal["family"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="genus">
                            Genus
                        </label>

                        <input
                            type="text"
                            id="genus"
                            name="genus"
                            value="<?php echo htmlspecialchars(
                                $animal["genus"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="species">
                            Species
                        </label>

                        <input
                            type="text"
                            id="species"
                            name="species"
                            value="<?php echo htmlspecialchars(
                                $animal["species"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>

                </div>


                <!--this section is for physical characteristics-->

                <div class="edit-animal-section">

                    <p class="edit-animal-section-label">
                        PHYSICAL CHARACTERISTICS
                    </p>

                    <h2>
                        Physical Information
                    </h2>


                    <div class="edit-form-group">

                        <label for="weight">
                            Weight
                        </label>

                        <input
                            type="text"
                            id="weight"
                            name="weight"
                            value="<?php echo htmlspecialchars(
                                $animal["weight"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 100 kg"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="length">
                            Length
                        </label>

                        <input
                            type="text"
                            id="length"
                            name="length"
                            value="<?php echo htmlspecialchars(
                                $animal["length"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 2.5 m"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="lifespan">
                            Lifespan
                        </label>

                        <input
                            type="text"
                            id="lifespan"
                            name="lifespan"
                            value="<?php echo htmlspecialchars(
                                $animal["lifespan"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 15-20 years"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="speed">
                            Speed
                        </label>

                        <input
                            type="text"
                            id="speed"
                            name="speed"
                            value="<?php echo htmlspecialchars(
                                $animal["speed"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 80 km/h"
                        >

                    </div>

                </div>


                <!--this section is for habitat and behaviour-->

                <div class="edit-animal-section">

                    <p class="edit-animal-section-label">
                        HABITAT AND BEHAVIOUR
                    </p>

                    <h2>
                        Habitat & Behaviour
                    </h2>


                    <div class="edit-form-group">

                        <label for="habitat">
                            Habitat
                        </label>

                        <input
                            type="text"
                            id="habitat"
                            name="habitat"
                            value="<?php echo htmlspecialchars(
                                $animal["habitat"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="distribution">
                            Distribution
                        </label>

                        <textarea
                            id="distribution"
                            name="distribution"
                            rows="5"
                        ><?php echo htmlspecialchars(
                            $animal["distribution"] ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?></textarea>

                    </div>


                    <div class="edit-form-group">

                        <label for="diet">
                            Diet
                        </label>

                        <input
                            type="text"
                            id="diet"
                            name="diet"
                            value="<?php echo htmlspecialchars(
                                $animal["diet"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="behaviour">
                            Behaviour
                        </label>

                        <textarea
                            id="behaviour"
                            name="behaviour"
                            rows="5"
                        ><?php echo htmlspecialchars(
                            $animal["behaviour"] ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?></textarea>

                    </div>

                </div>


                <!--this section is for conservation information-->

                <div class="edit-animal-section">

                    <p class="edit-animal-section-label">
                        CONSERVATION
                    </p>

                    <h2>
                        Conservation Information
                    </h2>


                    <div class="edit-form-group">

                        <label for="conservationStatus">
                            Conservation Status
                        </label>

                        <input
                            type="text"
                            id="conservationStatus"
                            name="conservationStatus"
                            value="<?php echo htmlspecialchars(
                                $animal["conservationStatus"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: Vulnerable"
                        >

                    </div>


                    <div class="edit-form-group">

                        <label for="population">
                            Population
                        </label>

                        <input
                            type="text"
                            id="population"
                            name="population"
                            value="<?php echo htmlspecialchars(
                                $animal["population"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 5,000-7,000"
                        >

                    </div>

                </div>


                <!--this section is for animal image-->

                <div class="edit-animal-section">

                    <p class="edit-animal-section-label">
                        ANIMAL MEDIA
                    </p>

                    <h2>
                        Image
                    </h2>


                    <?php if (!empty($animal["image"])): ?>

                        <div class="edit-form-group">

                            <label>
                                Current Image
                            </label>

                            <img
                                src="../images/animals/<?php echo htmlspecialchars(
                                    $animal["image"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ); ?>"
                                alt="<?php echo htmlspecialchars(
                                    $animal["commonName"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ); ?>"
                                style="max-width: 250px; border-radius: 8px;"
                            >

                        </div>

                    <?php endif; ?>


                    <div class="edit-form-group">

                        <label for="image">
                            Upload New Image
                        </label>

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/jpeg,image/png,image/gif,image/webp"
                        >

                        <p class="edit-form-help">
                            Leave this empty to keep the current image.
                        </p>

                    </div>

                </div>


                <!--this section is for the form actions-->

                <div class="edit-animal-actions">

                    <a
                        href="manageAnimals.php"
                        class="edit-cancel-button"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="edit-save-button"
                    >
                        Save Changes
                    </button>

                </div>

            </form>

        </section>

    </div>

</main>


<?php include("../includes/footer.php"); ?>


<script src="../js/script.js"></script>


</body>

</html>