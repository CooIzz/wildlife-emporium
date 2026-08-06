<?php

session_start();

require_once("../includes/database.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* ---------------- FORM DATA ---------------- */

    $username = trim($_POST["username"]);

    $password = $_POST["password"];



    /* ---------------- FORM VALIDATION ---------------- */

    if (empty($username)) {

        $error = "Please enter your username.";

    } elseif (empty($password)) {

        $error = "Please enter your password.";

    }

        /* ---------------- GET USER ---------------- */

    if (empty($error))
    {

        $sql = "
        SELECT
            userID,
            username,
            passwordHash,
            role,
            profilePicture
        FROM users
        WHERE username = ?
        ";

        $statement = mysqli_prepare($connection, $sql);

        if ($statement)
        {

            mysqli_stmt_bind_param(
                $statement,
                "s",
                $username
            );

            mysqli_stmt_execute($statement);

            $result = mysqli_stmt_get_result($statement);

            $user = mysqli_fetch_assoc($result);

            mysqli_stmt_close($statement);

        }

        else
        {

            $error = "Database error.";

        }

    }

        /* ---------------- USER EXISTS ---------------- */

    if (empty($error))
    {

        if (!$user)
        {

            $error = "Invalid username or password.";

        }

    }

        /* ---------------- VERIFY PASSWORD ---------------- */

    if (empty($error))
    {

        if (!password_verify($password, $user["passwordHash"]))
        {

            $error = "Invalid username or password.";

        }

    }

        /* ---------------- LOGIN USER ---------------- */

    if (empty($error))
    {

        $_SESSION["userID"] = $user["userID"];

        $_SESSION["username"] = $user["username"];

        $_SESSION["role"] = $user["role"];

        $_SESSION["profilePicture"] = $user["profilePicture"];

    }

        /* ---------------- UPDATE LAST LOGIN ---------------- */

    if (empty($error))
    {

        $sql = "
        UPDATE users
        SET lastLogin = CURRENT_TIMESTAMP
        WHERE userID = ?
        ";

        $statement = mysqli_prepare($connection, $sql);

        if ($statement)
        {

            mysqli_stmt_bind_param(
                $statement,
                "i",
                $_SESSION["userID"]
            );

            mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);

        }

    }

        /* ---------------- REDIRECT ---------------- */

    if (empty($error))
    {

        header("Location: ../index.php");

        exit();

    }
}

?>


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

                <?php

                if (!empty($error)) {

                    ?>

                    <p class="account-error">

                        <?php echo $error; ?>

                    </p>

                    <?php

                }

                ?>
                <form class="account-form" action="" method="post">

                    <div class="account-input-group">

                        <label for="username">
                            Username
                        </label>

                        <input type="text" id="username" name="username" placeholder="Enter your username" required>

                    </div>

                    <div class="account-input-group">

                        <label for="password">
                            Password
                        </label>

                        <input type="password" id="password" name="password" placeholder="Enter your password" required>

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