<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Wildlife Emporium</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">

</head>

<body>

<?php include("includes/header.php"); ?>

<?php include("includes/navigation.php"); ?>

<main>

    <!-- Login -->

    <section class="login">

        <h1 class="login-title">
            Login
        </h1>

        <p class="login-description">
            Sign in to access your account, save your favourite animals and participate in quizzes.
        </p>

        <form class="login-form" action="#" method="post">

            <div class="login-field">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                >

            </div>

            <div class="login-field">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

            </div>

            <button type="submit" class="login-button">
                Login
            </button>

        </form>

        <p class="login-register">

            Don't have an account?

            <a href="register.php">
                Register here
            </a>

        </p>

    </section>

</main>

<?php include("includes/footer.php"); ?>

</body>

</html>