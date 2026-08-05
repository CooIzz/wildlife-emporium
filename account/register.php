<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Wildlife Emporium</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/account.css">

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>

<main>

    <!-- Register -->

    <section class="account-page">

        <div class="account-card">

            <div class="account-logo">

                <img src="../images/home-logo-test.svg" alt="Wildlife Emporium Logo">

            </div>

            <h1 class="account-title">
                Create Account
            </h1>

            <p class="account-description">
                Join Wildlife Emporium to save your favourite animals, track your quiz progress and compete with other wildlife enthusiasts.
            </p>

            <!-- Registration Error -->

            <form class="account-form" action="" method="post">

                <div class="account-input-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Choose a username"
                        required
                    >

                </div>

                <div class="account-input-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email address"
                        required
                    >

                </div>

                <div class="account-input-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a password"
                        required
                    >

                </div>

                <div class="account-input-group">

                    <label for="confirm-password">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="confirm-password"
                        name="confirm-password"
                        placeholder="Confirm your password"
                        required
                    >

                </div>

                <button type="submit" class="account-button">
                    Create Account
                </button>

            </form>

            <div class="account-footer">

                <p>
                    Already have an account?
                </p>

                <a href="login.php" class="account-secondary-button">
                    Log In
                </a>

            </div>

        </div>

    </section>

</main>

<?php include("../includes/footer.php"); ?>

</body>

</html>