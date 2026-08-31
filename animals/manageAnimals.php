<?php

//connect to wildlife emporium database
require_once("../includes/auth.php");
require_once("../includes/database.php");

requireAdmin();


//this section is for deleting an animal

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["deleteAnimal"]))
{

    $animalID = filter_input(
        INPUT_POST,
        "animalID",
        FILTER_VALIDATE_INT
    );


    if ($animalID !== false && $animalID !== null)
    {

        $deleteQuery = "
            DELETE FROM animals
            WHERE animalID = ?
        ";


        $statement = mysqli_prepare(
            $connection,
            $deleteQuery
        );


        if ($statement)
        {

            mysqli_stmt_bind_param(
                $statement,
                "i",
                $animalID
            );

            mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);

        }

    }


    //redirect after deletion to prevent duplicate submission
    header("Location: manageAnimals.php");
    exit();

}


//this section is for retrieving all animals

$animalsQuery = "
    SELECT
        animalID,
        commonName,
        scientificName,
        conservationStatus,
        habitat
    FROM animals
    ORDER BY commonName ASC
";


$statement = mysqli_prepare(
    $connection,
    $animalsQuery
);


$animals = [];


if ($statement)
{

    mysqli_stmt_execute($statement);


    mysqli_stmt_bind_result(
        $statement,
        $animalID,
        $commonName,
        $scientificName,
        $conservationStatus,
        $habitat
    );


    while (mysqli_stmt_fetch($statement))
    {

        $animals[] = [
            "animalID" => $animalID,
            "commonName" => $commonName,
            "scientificName" => $scientificName,
            "conservationStatus" => $conservationStatus,
            "habitat" => $habitat
        ];

    }


    mysqli_stmt_close($statement);

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

    <title>Manage Animals | Wildlife Emporium</title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/manageAnimals.css"
    >

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>


<main>

    <div class="manage-animals-page">


        <!--this section is for the page header-->

        <section class="manage-animals-header">

            <p class="manage-animals-label">
                ADMINISTRATION
            </p>

            <h1>
                Manage Animals
            </h1>

            <p>
                Create, edit, and delete animals listed in
                Wildlife Emporium.
            </p>

        </section>


        <!--this section is for the existing animals-->

        <section
            class="existing-animals"
            id="existing-animals"
        >

            <div class="existing-animals-header">

                <div>

                    <p class="management-section-label">
                        ANIMAL LIBRARY
                    </p>

                    <h2>
                        Existing Animals
                    </h2>

                </div>

                <p>
                    Select an animal to edit or delete it.
                </p>

            </div>


            <!--this section is for the animal table-->

            <div class="animals-table-container">

                <table class="animals-table">

                    <thead>

                        <tr>

                            <th>
                                Animal
                            </th>

                            <th>
                                Scientific Name
                            </th>

                            <th>
                                Conservation Status
                            </th>

                            <th>
                                Habitat
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <!--this section is for creating a new animal-->

                        <tr class="create-animal-row">

                            <td colspan="5">

                                <a
                                    href="createAnimal.php"
                                    class="create-animal-button"
                                >
                                    + Add New Animal
                                </a>

                            </td>

                        </tr>


                        <?php if (!empty($animals)): ?>


                            <!--this section is for displaying existing animals-->

                            <?php foreach ($animals as $animal): ?>

                                <tr>

                                    <td class="animal-name">

                                        <?php echo htmlspecialchars(
                                            $animal["commonName"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <td class="animal-scientific-name">

                                        <?php echo htmlspecialchars(
                                            $animal["scientificName"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <td class="animal-status">

                                        <?php echo htmlspecialchars(
                                            $animal["conservationStatus"] ?? "Not specified",
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <td class="animal-habitat">

                                        <?php echo htmlspecialchars(
                                            $animal["habitat"] ?? "Not specified",
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <td class="animal-actions">


                                        <!--this section is for editing an animal-->

                                        <a
                                            href="editAnimal.php?id=<?php echo (int)$animal["animalID"]; ?>"
                                            class="animal-action-edit"
                                        >
                                            Edit
                                        </a>


                                        <!--this section is for deleting an animal-->

                                        <form
                                            method="POST"
                                            action="manageAnimals.php"
                                            onsubmit="return confirm('Are you sure you want to delete this animal?');"
                                        >

                                            <input
                                                type="hidden"
                                                name="animalID"
                                                value="<?php echo (int)$animal["animalID"]; ?>"
                                            >

                                            <button
                                                type="submit"
                                                name="deleteAnimal"
                                                class="animal-action-delete"
                                            >
                                                Delete
                                            </button>

                                        </form>


                                    </td>

                                </tr>

                            <?php endforeach; ?>


                        <?php else: ?>


                            <!--this section is for when there are no animals-->

                            <tr>

                                <td
                                    colspan="5"
                                    class="no-animals"
                                >

                                    <p>
                                        No animals available.
                                    </p>

                                </td>

                            </tr>


                        <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </section>

    </div>

</main>


<?php include("../includes/footer.php"); ?>


<script src="../js/script.js"></script>


</body>

</html>