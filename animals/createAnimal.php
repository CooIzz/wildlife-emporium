<?php

session_start();

require_once("../includes/auth.php");
require_once("../includes/database.php");

requireAdmin();

//this section is for handling animal creation

$errorMessage = "";

$animal = [
    "commonName" => "",
    "scientificName" => "",
    "kingdom" => "",
    "phylum" => "",
    "class" => "",
    "orderName" => "",
    "family" => "",
    "genus" => "",
    "species" => "",
    "weight" => "",
    "length" => "",
    "lifespan" => "",
    "speed" => "",
    "habitat" => "",
    "distribution" => "",
    "diet" => "",
    "behaviour" => "",
    "description" => "",
    "conservationStatus" => "",
    "population" => "",
    "image" => ""
];


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


    //this section is for validating required fields

    if (
        $commonName === "" ||
        $scientificName === ""
    ) {
        $errorMessage = "Please fill in all required fields.";
    }


    //this section is for handling the image upload

    if ($errorMessage === "" && isset($_FILES["image"])) {

        if ($_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {

            if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {

                $errorMessage = "There was a problem uploading the image.";

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

                } elseif ($_FILES["image"]["size"] > 5000000) {

                    $errorMessage = "The image must be smaller than 5 MB.";

                } else {

                    $imageExtension = pathinfo(
                        $_FILES["image"]["name"],
                        PATHINFO_EXTENSION
                    );

                    $imageName = uniqid(
                        "animal_",
                        true
                    ) . "." . strtolower($imageExtension);

                    $uploadDirectory = "../images/animals/";

                    if (!is_dir($uploadDirectory)) {

                        mkdir(
                            $uploadDirectory,
                            0755,
                            true
                        );

                    }

                    $uploadPath = $uploadDirectory . $imageName;

                    if (!move_uploaded_file(
                        $_FILES["image"]["tmp_name"],
                        $uploadPath
                    )) {

                        $errorMessage = "Unable to save the image.";

                    }

                }

            }

        }

    }


    //this section is for inserting the new animal

    if ($errorMessage === "") {

        $insertQuery = "
            INSERT INTO animals
            (
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
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";


        $insertStatement = mysqli_prepare(
            $connection,
            $insertQuery
        );


        if (!$insertStatement) {

            $errorMessage = "Unable to create the animal.";

        } else {

            mysqli_stmt_bind_param(
                $insertStatement,
                "sssssssssssssssssssss",
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
                $imageName
            );


            if (mysqli_stmt_execute($insertStatement)) {

                mysqli_stmt_close($insertStatement);

                header(
                    "Location: manageAnimals.php?message=created"
                );

                exit();

            } else {

                $errorMessage = "Unable to create the animal.";

                mysqli_stmt_close($insertStatement);


                //this section is for removing the uploaded image after database failure

                if (
                    isset($uploadPath) &&
                    file_exists($uploadPath)
                ) {
                    unlink($uploadPath);
                }

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
        Create Animal | Wildlife Emporium
    </title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/createAnimal.css"
    >

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>


<main>

    <div class="create-animal-page">


        <!--this section is for the page header-->

        <section class="create-animal-header">

            <p class="create-animal-label">
                ANIMAL MANAGEMENT
            </p>

            <h1>
                Create Animal
            </h1>

            <p>
                Add a new animal to the Wildlife Emporium
                animal database.
            </p>

        </section>


        <!--this section is for the error message-->

        <?php if ($errorMessage !== ""): ?>

            <div class="create-animal-error">

                <?php echo htmlspecialchars(
                    $errorMessage,
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>

            </div>

        <?php endif; ?>


        <!--this section is for the animal form-->

        <section class="create-animal-form-container">

            <form
                method="POST"
                action="createAnimal.php"
                class="create-animal-form"
                enctype="multipart/form-data"
            >


                <!--this section is for basic animal information-->

                <div class="create-animal-section">

                    <p class="create-animal-section-label">
                        ANIMAL INFORMATION
                    </p>

                    <h2>
                        Basic Information
                    </h2>


                    <div class="create-form-group">

                        <label for="commonName">
                            Common Name
                        </label>

                        <input
                            type="text"
                            id="commonName"
                            name="commonName"
                            value="<?php echo htmlspecialchars(
                                $animal["commonName"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            required
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="scientificName">
                            Scientific Name
                        </label>

                        <input
                            type="text"
                            id="scientificName"
                            name="scientificName"
                            value="<?php echo htmlspecialchars(
                                $animal["scientificName"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            required
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="description">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                        ><?php echo htmlspecialchars(
                            $animal["description"],
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?></textarea>

                    </div>

                </div>


                <!--this section is for animal classification-->

                <div class="create-animal-section">

                    <p class="create-animal-section-label">
                        CLASSIFICATION
                    </p>

                    <h2>
                        Taxonomy
                    </h2>


                    <div class="create-form-group">

                        <label for="kingdom">
                            Kingdom
                        </label>

                        <input
                            type="text"
                            id="kingdom"
                            name="kingdom"
                            value="<?php echo htmlspecialchars(
                                $animal["kingdom"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: Animalia"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="phylum">
                            Phylum
                        </label>

                        <input
                            type="text"
                            id="phylum"
                            name="phylum"
                            value="<?php echo htmlspecialchars(
                                $animal["phylum"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: Chordata"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="class">
                            Class
                        </label>

                        <input
                            type="text"
                            id="class"
                            name="class"
                            value="<?php echo htmlspecialchars(
                                $animal["class"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: Mammalia"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="orderName">
                            Order
                        </label>

                        <input
                            type="text"
                            id="orderName"
                            name="orderName"
                            value="<?php echo htmlspecialchars(
                                $animal["orderName"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="family">
                            Family
                        </label>

                        <input
                            type="text"
                            id="family"
                            name="family"
                            value="<?php echo htmlspecialchars(
                                $animal["family"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="genus">
                            Genus
                        </label>

                        <input
                            type="text"
                            id="genus"
                            name="genus"
                            value="<?php echo htmlspecialchars(
                                $animal["genus"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="species">
                            Species
                        </label>

                        <input
                            type="text"
                            id="species"
                            name="species"
                            value="<?php echo htmlspecialchars(
                                $animal["species"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>

                </div>


                <!--this section is for physical characteristics-->

                <div class="create-animal-section">

                    <p class="create-animal-section-label">
                        PHYSICAL CHARACTERISTICS
                    </p>

                    <h2>
                        Physical Information
                    </h2>


                    <div class="create-form-group">

                        <label for="weight">
                            Weight
                        </label>

                        <input
                            type="text"
                            id="weight"
                            name="weight"
                            value="<?php echo htmlspecialchars(
                                $animal["weight"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 100 kg"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="length">
                            Length
                        </label>

                        <input
                            type="text"
                            id="length"
                            name="length"
                            value="<?php echo htmlspecialchars(
                                $animal["length"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 2.5 m"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="lifespan">
                            Lifespan
                        </label>

                        <input
                            type="text"
                            id="lifespan"
                            name="lifespan"
                            value="<?php echo htmlspecialchars(
                                $animal["lifespan"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 15-20 years"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="speed">
                            Speed
                        </label>

                        <input
                            type="text"
                            id="speed"
                            name="speed"
                            value="<?php echo htmlspecialchars(
                                $animal["speed"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 80 km/h"
                        >

                    </div>

                </div>


                <!--this section is for habitat and behaviour-->

                <div class="create-animal-section">

                    <p class="create-animal-section-label">
                        HABITAT AND BEHAVIOUR
                    </p>

                    <h2>
                        Habitat & Behaviour
                    </h2>


                    <div class="create-form-group">

                        <label for="habitat">
                            Habitat
                        </label>

                        <input
                            type="text"
                            id="habitat"
                            name="habitat"
                            value="<?php echo htmlspecialchars(
                                $animal["habitat"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="distribution">
                            Distribution
                        </label>

                        <textarea
                            id="distribution"
                            name="distribution"
                            rows="5"
                        ><?php echo htmlspecialchars(
                            $animal["distribution"],
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?></textarea>

                    </div>


                    <div class="create-form-group">

                        <label for="diet">
                            Diet
                        </label>

                        <input
                            type="text"
                            id="diet"
                            name="diet"
                            value="<?php echo htmlspecialchars(
                                $animal["diet"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="behaviour">
                            Behaviour
                        </label>

                        <textarea
                            id="behaviour"
                            name="behaviour"
                            rows="5"
                        ><?php echo htmlspecialchars(
                            $animal["behaviour"],
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?></textarea>

                    </div>

                </div>


                <!--this section is for conservation information-->

                <div class="create-animal-section">

                    <p class="create-animal-section-label">
                        CONSERVATION
                    </p>

                    <h2>
                        Conservation Information
                    </h2>


                    <div class="create-form-group">

                        <label for="conservationStatus">
                            Conservation Status
                        </label>

                        <input
                            type="text"
                            id="conservationStatus"
                            name="conservationStatus"
                            value="<?php echo htmlspecialchars(
                                $animal["conservationStatus"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: Vulnerable"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="population">
                            Population
                        </label>

                        <input
                            type="text"
                            id="population"
                            name="population"
                            value="<?php echo htmlspecialchars(
                                $animal["population"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: 5,000-7,000"
                        >

                    </div>

                </div>


                <!--this section is for animal image-->

                <div class="create-animal-section">

                    <p class="create-animal-section-label">
                        ANIMAL MEDIA
                    </p>

                    <h2>
                        Image
                    </h2>


                    <div class="create-form-group">

                        <label for="image">
                            Animal Image
                        </label>

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept=".jpg,.jpeg,.png,.gif,.webp"
                        >

                        <p class="create-form-help">
                            JPG, JPEG, PNG, GIF, or WEBP. Maximum size: 5 MB.
                        </p>

                    </div>

                </div>


                <!--this section is for the form actions-->

                <div class="create-animal-actions">

                    <a
                        href="manageAnimals.php"
                        class="create-cancel-button"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="create-save-button"
                    >
                        Create Animal
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