<?php

session_start();

require_once("../includes/database.php");

$error = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $redirect = $_POST["redirect"] ?? $_GET["redirect"] ?? "../index.php";

    if (
        !is_string($redirect) ||
        $redirect === "" ||
        strpos($redirect, "/wildlife-emporium/") !== 0
    )
    {
        $redirect = "/wildlife-emporium/index.php";
    }

    if ($username === "")
    {
        $error = "Please enter your username.";
    }
    elseif ($password === "")
    {
        $error = "Please enter your password.";
    }

    if ($error === "")
    {
        $statement = mysqli_prepare(
            $connection,
            "SELECT userID, username, passwordHash, role, profilePicture
             FROM users
             WHERE username = ?"
        );

        if (!$statement)
        {
            $error = "Database error.";
        }
        else
        {
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);

            $result = mysqli_stmt_get_result($statement);
            $user = mysqli_fetch_assoc($result);

            mysqli_stmt_close($statement);

            if (!$user || !password_verify($password, $user["passwordHash"]))
            {
                $error = "Invalid username or password.";
            }
        }
    }

    if ($error === "")
    {
        session_regenerate_id(true);

        $_SESSION["userID"] = $user["userID"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["profilePicture"] = $user["profilePicture"];

        $statement = mysqli_prepare(
            $connection,
            "UPDATE users
             SET lastLogin = CURRENT_TIMESTAMP
             WHERE userID = ?"
        );

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

        header("Location: " . $redirect);
        exit();
    }
}

$redirect = $_GET["redirect"] ?? "/wildlife-emporium/index.php";

if (
    !is_string($redirect) ||
    $redirect === "" ||
    strpos($redirect, "/wildlife-emporium/") !== 0
)
{
    $redirect = "/wildlife-emporium/index.php";
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

    <section class="account-page">

        <div class="account-card">

            <div class="account-logo">

                <img
                    src="../images/logo.png"
                    alt="Wildlife Emporium Logo"
                >

            </div>

            <h1 class="account-title">
                Welcome Back
            </h1>

            <p class="account-description">
                Sign in to continue your Wildlife Emporium adventure.
            </p>

            <?php if ($error !== "") { ?>

                <p class="account-error" id="login-error">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?>
                </p>

            <?php } else { ?>

                <p class="account-error" id="login-error" style="display: none;"></p>

            <?php } ?>

            <form
                class="account-form"
                action=""
                method="post"
                autocomplete="on"
                id="login-form"
                novalidate
            >

                <input
                    type="hidden"
                    name="redirect"
                    value="<?php echo htmlspecialchars($redirect, ENT_QUOTES, "UTF-8"); ?>"
                >

                <div class="account-input-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter your username"
                        value="<?php echo htmlspecialchars($username, ENT_QUOTES, "UTF-8"); ?>"
                        autocomplete="username"
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
                        autocomplete="current-password"
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

                <a
                    href="register.php"
                    class="account-secondary-button"
                >
                    Create Account
                </a>

            </div>

        </div>

    </section>

</main>

<?php include("../includes/footer.php"); ?>

<script>

const loginForm = document.getElementById("login-form");
const loginError = document.getElementById("login-error");

const usernameInput = document.getElementById("username");
const passwordInput = document.getElementById("password");

loginForm.addEventListener("submit", function(event)
{

    let error = "";

    const username = usernameInput.value.trim();
    const password = passwordInput.value;

    if (username === "")
    {

        error = "Please enter your username.";

    }

    else if (password === "")
    {

        error = "Please enter your password.";

    }

    if (error !== "")
    {

        event.preventDefault();

        loginError.textContent = error;
        loginError.style.display = "block";

    }

    else
    {

        loginError.textContent = "";
        loginError.style.display = "none";

    }

});

</script>

</body>

</html>