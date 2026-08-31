<?php

session_start();

require_once("../includes/auth.php");
requireAdmin();

require_once("../includes/database.php");

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
                    Manage the content and enquiries of Wildlife Emporium.
                </p>

            </section>


            <!--this section is for the management cards-->

            <section class="admin-container">


                <!--this section is for animal management-->

                <div class="admin-card">

                    <div class="admin-card-content">

                        <p class="admin-card-label">
                            CONTENT MANAGEMENT
                        </p>

                        <h2>
                            Animals
                        </h2>

                        <p>
                            Add, edit and manage the animals available
                            in the Wildlife Emporium.
                        </p>

                    </div>


                    <div class="admin-card-footer">

                        <a
                            href="../animals/manageAnimals.php"
                            class="admin-manage-button"
                        >
                            Manage Animals
                        </a>

                    </div>

                </div>


                <!--this section is for article management-->

                <div class="admin-card">

                    <div class="admin-card-content">

                        <p class="admin-card-label">
                            CONTENT MANAGEMENT
                        </p>

                        <h2>
                            Articles
                        </h2>

                        <p>
                            Create, edit and manage wildlife articles
                            published on the website.
                        </p>

                    </div>


                    <div class="admin-card-footer">

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

                    <div class="admin-card-content">

                        <p class="admin-card-label">
                            QUIZ MANAGEMENT
                        </p>

                        <h2>
                            Quiz
                        </h2>

                        <p>
                            Create, edit and manage the wildlife quiz
                            questions and content.
                        </p>

                    </div>


                    <div class="admin-card-footer">

                        <a
                            href="../quiz_crud/index.php"
                            class="admin-manage-button"
                        >
                            Manage Quiz
                        </a>

                    </div>

                </div>


                <!--this section is for contact enquiry management-->

                <div class="admin-card">

                    <div class="admin-card-content">

                        <p class="admin-card-label">
                            CONTACT MANAGEMENT
                        </p>

                        <h2>
                            Enquiries
                        </h2>

                        <p>
                            View and manage enquiries submitted
                            through the Contact Us page.
                        </p>

                    </div>


                    <div class="admin-card-footer">

                        <a
                            href="../contact/manageEnquiries.php"
                            class="admin-manage-button"
                        >
                            Manage Enquiries
                        </a>

                    </div>

                </div>


                <!--this section is for user management-->

                <div class="admin-card">

                    <div class="admin-card-content">

                        <p class="admin-card-label">
                            USER MANAGEMENT
                        </p>

                        <h2>
                            Users
                        </h2>

                        <p>
                            Edit and manage registered user accounts
                            and their XP progression.
                        </p>

                    </div>


                    <div class="admin-card-footer">

                        <a
                            href="../admin/manageUsers.php"
                            class="admin-manage-button"
                        >
                            Manage Users
                        </a>

                    </div>

                </div>


            </section>

        </div>

    </main>


    <?php include("../includes/footer.php"); ?>


    <script src="../js/script.js"></script>


</body>

</html>