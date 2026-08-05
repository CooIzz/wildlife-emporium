<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Wildlife Emporium</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/account.css">

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>

<main>

    <!-- Login -->

    <section class="account-page">

        <div class="account-card">

            <div class="account-logo">
                <img src="../images/home-logo-test.svg" alt="Wildlife Emporium Logo">
            </div>

            <h1 class="account-title">
                Welcome Back
            </h1>

            <p class="account-description">
                Sign in to continue your Wildlife Emporium adventure.
            </p>

            <!-- Login Error -->

            <form class="account-form" action="" method="post">

                <div class="account-input-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter your username"
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
                        placeholder="Enter your password"
                        required
                    >

                </div>

                <button type="submit" class="account-button">
                    Log In
                </button>

            </form>

            <div class="account-footer">

                <p>
                    Don't have an account?
                </p>

                <a href="register.php" class="account-secondary-button">
                    Create Account
                </a>

            </div>

        </div>

    </section>

</main>

<?php include("../includes/footer.php"); ?>

</body>

</html>