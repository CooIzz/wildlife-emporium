<?php

session_start();

require_once("../includes/database.php");

$error = "";
$username = "";
$email = "";
$password = "";
$confirmPassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    $username = trim($_POST["username"] ?? "");

    $email = trim($_POST["email"] ?? "");

    $password = $_POST["password"] ?? "";

    $confirmPassword = $_POST["confirm-password"] ?? "";


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


    if (empty($error))
    {

        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

    }


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

                <img src="../images/logo.png" alt="Wildlife Emporium Logo">

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

                <p class="account-error" id="register-error">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?>
                </p>

            <?php

            }
            else
            {

            ?>

                <p class="account-error" id="register-error" style="display: none;"></p>

            <?php

            }

            ?>

            <form class="account-form" action="" method="post" autocomplete="on" id="register-form" novalidate>

                <div class="account-input-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Choose a username"
                        value="<?php echo htmlspecialchars($username, ENT_QUOTES, "UTF-8"); ?>"
                        autocomplete="username"
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
                        value="<?php echo htmlspecialchars($email, ENT_QUOTES, "UTF-8"); ?>"
                        autocomplete="email"
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
                        autocomplete="new-password"
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
                        autocomplete="new-password"
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

<script>

const registerForm = document.getElementById("register-form");
const registerError = document.getElementById("register-error");

const usernameInput = document.getElementById("username");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const confirmPasswordInput = document.getElementById("confirm-password");

registerForm.addEventListener("submit", function(event)
{

    let error = "";

    const username = usernameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    if (username === "")
    {

        error = "Please enter a username.";

    }

    else if (email === "")
    {

        error = "Please enter an email address.";

    }

    else if (!isValidEmail(email))
    {

        error = "Please enter a valid email address.";

    }

    else if (password === "")
    {

        error = "Please enter a password.";

    }

    else if (password.length < 8)
    {

        error = "Password must be at least 8 characters long.";

    }

    else if (password !== confirmPassword)
    {

        error = "Passwords do not match.";

    }

    if (error !== "")
    {

        event.preventDefault();

        registerError.textContent = error;
        registerError.style.display = "block";

    }

    else
    {

        registerError.textContent = "";
        registerError.style.display = "none";

    }

});


function isValidEmail(email)
{

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    return emailPattern.test(email);

}

</script>

</body>

</html>