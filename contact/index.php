<?php

session_start();


//connect to wildlife emporium database
require_once("../includes/database.php");
require_once("../includes/auth.php");


//require user to be logged in
requireLogin();

$userID = $_SESSION["userID"];

$errors = [];
$success = "";

$username = "";
$email = "";

$enquiryType = "";
$subject = "";
$message = "";


// --------------------------------------------------
// Retrieve logged-in user's account information
// --------------------------------------------------

$userQuery = "
    SELECT
        username,
        email
    FROM users
    WHERE userID = ?
";


$userStatement = mysqli_prepare(
    $connection,
    $userQuery
);


if (!$userStatement)
{
    exit("Unable to load your account information.");
}


mysqli_stmt_bind_param(
    $userStatement,
    "i",
    $userID
);


mysqli_stmt_execute($userStatement);


mysqli_stmt_bind_result(
    $userStatement,
    $username,
    $email
);


if (!mysqli_stmt_fetch($userStatement))
{
    mysqli_stmt_close($userStatement);

    exit("Unable to load your account information.");
}


mysqli_stmt_close($userStatement);


// --------------------------------------------------
// Handle contact form submission
// --------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] === "POST")
{

    // Get submitted values

    $enquiryType = trim($_POST["enquiryType"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");


    // --------------------------------------------------
    // Validate enquiry type
    // --------------------------------------------------

    if ($enquiryType === "")
    {
        $errors["enquiryType"] =
            "Please select an enquiry type.";
    }


    // --------------------------------------------------
    // Validate subject
    // --------------------------------------------------

    if ($subject === "")
    {
        $errors["subject"] =
            "Subject is required.";
    }


    // --------------------------------------------------
    // Validate message
    // --------------------------------------------------

    if ($message === "")
    {
        $errors["message"] =
            "Message is required.";
    }


    // --------------------------------------------------
    // Save valid form submission
    // --------------------------------------------------

    if (empty($errors))
    {

        $messageQuery = "
            INSERT INTO contact_messages
            (
                userID,
                enquiryType,
                subject,
                message
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?
            )
        ";


        $messageStatement = mysqli_prepare(
            $connection,
            $messageQuery
        );


        if (!$messageStatement)
        {
            $errors["database"] =
                "Database error: " .
                mysqli_error($connection);
        }
        else
        {

            mysqli_stmt_bind_param(
                $messageStatement,
                "isss",
                $userID,
                $enquiryType,
                $subject,
                $message
            );


            if (mysqli_stmt_execute($messageStatement))
            {

                $success =
                    "Your message has been submitted successfully.";


                // Clear form fields after successful submission

                $enquiryType = "";
                $subject = "";
                $message = "";

            }
            else
            {

                $errors["database"] =
                    "Database error: " .
                    mysqli_stmt_error($messageStatement);

            }


            mysqli_stmt_close($messageStatement);

        }

    }

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
        Contact | Wildlife Emporium
    </title>


    <link
        rel="stylesheet"
        href="../css/style.css"
    >


    <link
        rel="stylesheet"
        href="../css/contact.css"
    >

</head>


<body>


    <?php include("../includes/header.php"); ?>

    <?php include("../includes/navigation.php"); ?>


    <main class="contact-page">


        <!-- Contact Introduction -->

        <section class="contact-hero">

            <p class="contact-hero-label">
                CONTACT US
            </p>


            <h1>
                Get in Touch
            </h1>


            <p class="contact-hero-description">
                Have a question, suggestion or feedback about
                Wildlife Emporium? Send us a message and we
                will be happy to hear from you.
            </p>

        </section>


        <!-- Contact Information and Form -->

        <section class="contact-main">


            <!-- Contact Information -->

            <div class="contact-information-card">

                <p class="contact-section-label">
                    YOUR ACCOUNT
                </p>


                <h2>
                    Contact Information
                </h2>


                <p class="contact-information-description">
                    Your account information is automatically
                    used when you contact Wildlife Emporium.
                </p>


                <div class="contact-information-item">

                    <h3>
                        Username
                    </h3>


                    <p>
                        <?php echo htmlspecialchars(
                            $username,
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?>
                    </p>

                </div>


                <div class="contact-information-item">

                    <h3>
                        Email
                    </h3>


                    <p>
                        <?php echo htmlspecialchars(
                            $email,
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?>
                    </p>

                </div>

            </div>


            <!-- Contact Form -->

            <div class="contact-form-card">

                <p class="contact-section-label">
                    SEND A MESSAGE
                </p>


                <h2>
                    Contact Us
                </h2>


                <!-- Database Error -->

                <?php if (isset($errors["database"])) { ?>

                    <div class="contact-form-error">

                        <?php echo htmlspecialchars(
                            $errors["database"],
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?>

                    </div>

                <?php } ?>


                <!-- Contact Form -->

                <?php include("_form.php"); ?>

            </div>

        </section>


        <!-- Location -->

        <section class="contact-location">


            <div class="contact-section-heading">

                <p class="contact-section-label">
                    FIND US
                </p>


                <h2>
                    Our Location
                </h2>


                <p>
                    Visit us at Universiti Tunku Abdul Rahman,
                    Kampar Campus, Perak, Malaysia.
                </p>

            </div>


            <div class="contact-map">

                <iframe
                    src="https://www.google.com/maps?q=Universiti+Tunku+Abdul+Rahman+Kampar+Campus&output=embed"
                    width="100%"
                    height="400"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                >
                </iframe>

            </div>

        </section>


    </main>


    <?php include("../includes/footer.php"); ?>


    <script src="../js/script.js"></script>


    <?php if ($success !== "") { ?>

        <script>

            alert(
                "<?php echo htmlspecialchars(
                    $success,
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>"
            );

        </script>

    <?php } ?>


</body>

</html>