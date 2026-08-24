<?php

session_start();

require_once("../includes/auth.php");
requireAdmin();

require_once("../includes/database.php");


//this section is for retrieving total users

$totalUsers = 0;

$statement = mysqli_prepare(
    $connection,
    "SELECT COUNT(*) AS totalUsers FROM users"
);

if ($statement) {

    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    $data = mysqli_fetch_assoc($result);

    $totalUsers = $data["totalUsers"];

    mysqli_stmt_close($statement);
}


//this section is for retrieving total administrators

$totalAdmins = 0;

$role = "admin";

$statement = mysqli_prepare(
    $connection,
    "SELECT COUNT(*) AS totalAdmins
     FROM users
     WHERE role = ?"
);

if ($statement) {

    mysqli_stmt_bind_param(
        $statement,
        "s",
        $role
    );

    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    $data = mysqli_fetch_assoc($result);

    $totalAdmins = $data["totalAdmins"];

    mysqli_stmt_close($statement);
}


//this section is for retrieving new users this month

$newUsers = 0;

$statement = mysqli_prepare(
    $connection,
    "SELECT COUNT(*) AS newUsers
     FROM users
     WHERE createdAt >= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')"
);

if ($statement) {

    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    $data = mysqli_fetch_assoc($result);

    $newUsers = $data["newUsers"];

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

    <title>
        Admin Panel | Wildlife Emporium
    </title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/admin.css"
    >

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>


<main>

    <!--this section is for the admin panel-->

    <div class="admin-page">

        <!--this section is for the page header-->

        <section class="admin-header">

            <p class="admin-label">
                ADMINISTRATION
            </p>

            <h1>
                Admin Panel
            </h1>

            <p>
                Manage the content and users of Wildlife Emporium.
            </p>

        </section>


        <!--this section is for the management cards-->

        <section class="admin-container">


            <!--this section is for animal management-->

            <div class="admin-card">

                <div class="admin-card-heading">

                    <h2>
                        Animals
                    </h2>

                    <hr>

                </div>


                <div class="admin-card-data">

                    <p>
                        Total:
                    </p>

                    <p>
                        Most Favorited:
                    </p>

                    <p>
                        Latest:
                    </p>

                </div>


                <div class="admin-card-footer">

                    <hr>

                    <!--this button is temporarily disabled-->

                    <button
                        type="button"
                        class="admin-manage-button admin-manage-disabled"
                        disabled
                    >
                        Manage Animals
                    </button>

                </div>

            </div>


            <!--this section is for article management-->

            <div class="admin-card">

                <div class="admin-card-heading">

                    <h2>
                        Articles
                    </h2>

                    <hr>

                </div>


                <div class="admin-card-data">

                    <p>
                        Total:
                    </p>

                    <p>
                        Published:
                    </p>

                    <p>
                        Drafts:
                    </p>

                    <p>
                        Latest:
                    </p>

                </div>


                <div class="admin-card-footer">

                    <hr>

                    <a
                        href="../articles/manageArticles.php"
                        class="admin-manage-button"
                    >
                        Manage Articles
                    </a>

                </div>

            </div>


            <!--this section is for quiz management-->

            <div class="admin-card">

                <div class="admin-card-heading">

                    <h2>
                        Quiz
                    </h2>

                    <hr>

                </div>


                <div class="admin-card-data">

                    <p>
                        Total:
                    </p>

                    <p>
                        Attempts:
                    </p>

                    <p>
                        Most Popular:
                    </p>

                </div>


                <div class="admin-card-footer">

                    <hr>

                    <a
                        href="../quiz_crud/quiz_crud.php"
                        class="admin-manage-button"
                    >
                        Manage Quiz
                    </a>

                </div>

            </div>


            <!--this section is for account management-->

            <div class="admin-card">

                <div class="admin-card-heading">

                    <h2>
                        Accounts
                    </h2>

                    <hr>

                </div>


                <div class="admin-card-data">

                    <p>
                        Users:
                        <?php echo $totalUsers; ?>
                    </p>

                    <p>
                        Administrators:
                        <?php echo $totalAdmins; ?>
                    </p>

                    <p>
                        New Users:
                        <?php echo $newUsers; ?>
                    </p>

                </div>


                <div class="admin-card-footer">

                    <hr>

                    <!--this button is temporarily disabled-->

                    <button
                        type="button"
                        class="admin-manage-button admin-manage-disabled"
                        disabled
                    >
                        Manage Accounts
                    </button>

                </div>

            </div>


        </section>

    </div>

</main>


<?php include("../includes/footer.php"); ?>


<script src="../js/script.js"></script>


</body>

</html>