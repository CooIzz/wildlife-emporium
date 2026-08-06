<?php require_once("../includes/database.php"); ?>
<!DOCTYPE html>
<?php



$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    /* ---------------- FORM DATA ---------------- */

    $username = trim($_POST["username"]);

    $email = trim($_POST["email"]);

    $password = $_POST["password"];

    $confirmPassword = $_POST["confirm-password"];



    /* ---------------- FORM VALIDATION ---------------- */

    if (empty($username))
    {

        $error = "Please enter a username.";

    }

    elseif (empty($email))
    {

        $error = "Please enter an email address.";

    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {

        $error = "Please enter a valid email address.";

    }

    elseif (empty($password))
    {

        $error = "Please enter a password.";

    }

    elseif (strlen($password) < 8)
    {

        $error = "Password must be at least 8 characters long.";

    }

    elseif ($password != $confirmPassword)
    {

        $error = "Passwords do not match.";

    }



    /* ---------------- USERNAME CHECK ---------------- */

    if (empty($error))
    {

        $sql = "
        SELECT userID
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

            mysqli_stmt_store_result($statement);

            if (mysqli_stmt_num_rows($statement) > 0)
            {

                $error = "Username already exists.";

            }

            mysqli_stmt_close($statement);

        }

        else
        {

            $error = "Database error.";

        }

    }



    /* ---------------- EMAIL CHECK ---------------- */

    if (empty($error))
    {

        $sql = "
        SELECT userID
        FROM users
        WHERE email = ?
        ";

        $statement = mysqli_prepare($connection, $sql);

        if ($statement)
        {

            mysqli_stmt_bind_param(
                $statement,
                "s",
                $email
            );

            mysqli_stmt_execute($statement);

            mysqli_stmt_store_result($statement);

            if (mysqli_stmt_num_rows($statement) > 0)
            {

                $error = "An account with this email already exists.";

            }

            mysqli_stmt_close($statement);

        }

        else
        {

            $error = "Database error.";

        }

    }



    /* ---------------- PASSWORD HASH ---------------- */

    if (empty($error))
    {

        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

    }



    /* ---------------- CREATE ACCOUNT ---------------- */

    if (empty($error))
    {

        $sql = "
        INSERT INTO users
        (
            username,
            email,
            passwordHash
        )
        VALUES
        (
            ?, ?, ?
        )
        ";

        $statement = mysqli_prepare($connection, $sql);

        if ($statement)
        {

            mysqli_stmt_bind_param(
                $statement,
                "sss",
                $username,
                $email,
                $passwordHash
            );

            if (mysqli_stmt_execute($statement))
            {

                mysqli_stmt_close($statement);

                header("Location: login.php");

                exit();

            }

            else
            {

                $error = "Failed to create account.";

                mysqli_stmt_close($statement);

            }

        }

        else
        {

            $error = "Database error.";

        }

    }

}

?>
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

            <?php

            if (!empty($error))
            {

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

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Choose a username"
                        value="<?php echo isset($username) ? htmlspecialchars($username) : ""; ?>"
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
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ""; ?>"
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