<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact | Wildlife Emporium</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/contact.css">

</head>

<body>

<?php include("../includes/header.php"); ?>
<?php require_once("../includes/database.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main>

    <!-- Contact -->

    <section class="contact">

        <h1 class="contact-title">
            Contact Wildlife Emporium
        </h1>

        <p class="contact-description">
            Have a question, suggestion or feedback? We'd love to hear from you.
        </p>

    </section>



    <!-- Contact Information -->

    <section class="contact-information">

        <div class="contact-information-card">

            <h2>
                Contact Information
            </h2>

            <div class="contact-information-item">

                <h3>
                    Email
                </h3>

                <p>
                    support@wildlifeemporium.com
                </p>

            </div>

            <div class="contact-information-item">

                <h3>
                    Phone
                </h3>

                <p>
                    +60 12-345 6789
                </p>

            </div>

            <div class="contact-information-item">

                <h3>
                    Address
                </h3>

                <p>
                    Universiti Tunku Abdul Rahman<br>
                    Kampar Campus<br>
                    Perak, Malaysia
                </p>

            </div>

        </div>



        <!-- Contact Form -->

        <div class="contact-form-card">

            <h2>
                Send Us a Message
            </h2>

            <form class="contact-form" action="" method="post">

                <div class="contact-input-group">

                    <label for="name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        required
                    >

                </div>

                <div class="contact-input-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                    >

                </div>

                <div class="contact-input-group">

                    <label for="subject">
                        Subject
                    </label>

                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        required
                    >

                </div>

                <div class="contact-input-group">

                    <label for="message">
                        Message
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                    ></textarea>

                </div>

                <button type="submit" class="contact-button">

                    Send Message

                </button>

            </form>

        </div>

    </section>



    <!-- Social Media -->

    <section class="contact-social">

        <h2>
            Follow Wildlife Emporium
        </h2>

        <div class="contact-social-links">

            <a href="#">
                Facebook
            </a>

            <a href="#">
                Instagram
            </a>

            <a href="#">
                X
            </a>

            <a href="#">
                YouTube
            </a>

        </div>

    </section>



    <!-- Location -->

    <section class="contact-location">

        <h2>
            Our Location
        </h2>

        <div class="contact-map">

            <!-- Google Maps Embed -->

        </div>

    </section>

</main>

<?php include("../includes/footer.php"); ?>

</body>

</html>