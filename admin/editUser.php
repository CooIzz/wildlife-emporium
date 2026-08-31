<?php

//connect to wildlife emporium database
session_start();

require_once("../includes/auth.php");
require_once("../includes/database.php");

requireAdmin();


//this section is for getting the user ID

$userID = filter_input(
    INPUT_GET,
    "userID",
    FILTER_VALIDATE_INT
);

if ($userID === false || $userID === null)
{
    header("Location: manageUsers.php");
    exit;
}


//this section is for storing the user details

$username = "";
$email = "";
$role = "";


//this section is for retrieving the selected user

$userQuery = "
    SELECT
        username,
        email,
        role
    FROM users
    WHERE userID = ?
";

$statement = mysqli_prepare(
    $connection,
    $userQuery
);

if ($statement)
{
    mysqli_stmt_bind_param(
        $statement,
        "i",
        $userID
    );

    mysqli_stmt_execute($statement);

    mysqli_stmt_bind_result(
        $statement,
        $username,
        $email,
        $role
    );

    if (!mysqli_stmt_fetch($statement))
    {
        mysqli_stmt_close($statement);

        header("Location: manageUsers.php");
        exit;
    }

    mysqli_stmt_close($statement);
}
else
{
    header("Location: manageUsers.php");
    exit;
}


//this section is for updating the user details

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["action"]) &&
    $_POST["action"] === "updateUser"
)
{
    $newUsername = trim($_POST["username"] ?? "");
    $newEmail = trim($_POST["email"] ?? "");


    //this section is for validating the username and email

    if ($newUsername === "" || $newEmail === "")
    {
        $message = "Username and email are required.";
        $messageType = "error";
    }
    elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL))
    {
        $message = "Invalid email address.";
        $messageType = "error";
    }
    else
    {
        //this section is for updating the user

        $updateQuery = "
            UPDATE users
            SET
                username = ?,
                email = ?
            WHERE userID = ?
        ";

        $statement = mysqli_prepare(
            $connection,
            $updateQuery
        );

        if ($statement)
        {
            mysqli_stmt_bind_param(
                $statement,
                "ssi",
                $newUsername,
                $newEmail,
                $userID
            );

            $success = mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);


            if ($success)
            {
                $username = $newUsername;
                $email = $newEmail;

                $message = "User details updated successfully.";
                $messageType = "success";
            }
            else
            {
                $message = "Failed to update user details.";
                $messageType = "error";
            }
        }
        else
        {
            $message = "Failed to prepare user update.";
            $messageType = "error";
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

    <title>Edit User | Wildlife Emporium</title>


    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/manageUsers.css"
    >

    <link
        rel="stylesheet"
        href="../css/editUser.css"
    >

</head>


<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>


<main>

    <div class="edit-user-page">


        <!--this section is for the page header-->

        <section class="manage-users-header">

            <p class="manage-users-label">
                ADMINISTRATION
            </p>

            <h1>
                Edit User
            </h1>

            <p>
                Edit the account details for this user.
            </p>

        </section>


        <!--this section is for the edit user form-->

        <section class="edit-user-section">


            <div class="edit-user-header">

                <div>

                    <p class="management-section-label">
                        USER MANAGEMENT
                    </p>

                    <h2>
                        Edit User Details
                    </h2>

                </div>

                <p>
                    Update the username or email address.
                </p>

            </div>


            <!--this section is for displaying messages-->

            <?php if (isset($message)): ?>

                <div class="user-message <?php echo htmlspecialchars(
                    $messageType,
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>">

                    <?php echo htmlspecialchars(
                        $message,
                        ENT_QUOTES,
                        "UTF-8"
                    ); ?>

                </div>

            <?php endif; ?>


            <!--this section is for the user form-->

            <div class="edit-user-form-container">

                <form method="POST">

                    <input
                        type="hidden"
                        name="action"
                        value="updateUser"
                    >

                    <input
                        type="hidden"
                        name="userID"
                        value="<?php echo (int) $userID; ?>"
                    >


                    <!--this section is for the username-->

                    <div class="edit-user-field">

                        <label for="username">
                            Username
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="<?php echo htmlspecialchars(
                                $username,
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            maxlength="30"
                            required
                        >

                    </div>


                    <!--this section is for the email-->

                    <div class="edit-user-field">

                        <label for="email">
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars(
                                $email,
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            maxlength="255"
                            required
                        >

                    </div>


                    <!--this section is for the user role-->

                    <div class="edit-user-field">

                        <label for="role">
                            Role
                        </label>

                        <input
                            type="text"
                            id="role"
                            value="<?php echo htmlspecialchars(
                                $role,
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            disabled
                        >

                    </div>


                    <!--this section is for the form actions-->

                    <div class="edit-user-actions">

                        <a
                            href="manageUsers.php"
                            class="user-action-cancel"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="user-action-save"
                        >
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>


        </section>


    </div>

</main>


<?php include("../includes/footer.php"); ?>


<script src="../js/script.js"></script>


</body>

</html>