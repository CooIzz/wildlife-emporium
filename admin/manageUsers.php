<?php

//connect to wildlife emporium database
session_start();

require_once("../includes/auth.php");
require_once("../includes/database.php");
require_once("../includes/xp.php");

requireAdmin();


//this section is for managing users

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]))
{

    $action = $_POST["action"];

    $userID = filter_input(
        INPUT_POST,
        "userID",
        FILTER_VALIDATE_INT
    );


    if ($userID === false || $userID === null)
    {

        $message = "Invalid user.";
        $messageType = "error";

    }


    //this section is for deleting a user

    elseif ($action === "deleteUser")
    {

        $deleteQuery = "
            DELETE FROM users
            WHERE userID = ?
        ";


        $statement = mysqli_prepare(
            $connection,
            $deleteQuery
        );


        if ($statement)
        {

            mysqli_stmt_bind_param(
                $statement,
                "i",
                $userID
            );

            $success = mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);


            if ($success)
            {

                $message = "User account deleted successfully.";
                $messageType = "success";

            }
            else
            {

                $message = "Failed to delete user account.";
                $messageType = "error";

            }

        }
        else
        {

            $message = "Failed to prepare user deletion.";
            $messageType = "error";

        }

    }


    //this section is for changing a user's XP level

    elseif ($action === "editLevel")
    {

        $newLevel = filter_input(
            INPUT_POST,
            "level",
            FILTER_VALIDATE_INT
        );


        if (
            $newLevel === false ||
            $newLevel < 1 ||
            $newLevel > $maxLevel
        )
        {

            $message = "Invalid level.";
            $messageType = "error";

        }
        else
        {

            $newXP = getXPForLevel($newLevel);


            $updateQuery = "
                UPDATE users
                SET xp = ?
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
                    "ii",
                    $newXP,
                    $userID
                );

                $success = mysqli_stmt_execute($statement);

                mysqli_stmt_close($statement);


                if ($success)
                {

                    $message = "User level updated successfully.";
                    $messageType = "success";

                }
                else
                {

                    $message = "Failed to update user level.";
                    $messageType = "error";

                }

            }
            else
            {

                $message = "Failed to prepare level update.";
                $messageType = "error";

            }

        }

    }


    //this section is for resetting a user's XP

    elseif ($action === "resetStats")
    {

        $newXP = 0;


        $updateQuery = "
            UPDATE users
            SET xp = ?
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
                "ii",
                $newXP,
                $userID
            );

            $success = mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);


            if ($success)
            {

                $message = "User XP and level have been reset.";
                $messageType = "success";

            }
            else
            {

                $message = "Failed to reset user XP.";
                $messageType = "error";

            }

        }
        else
        {

            $message = "Failed to prepare XP reset.";
            $messageType = "error";

        }

    }

}


//this section is for retrieving all users

$usersQuery = "
    SELECT
        userID,
        username,
        email,
        role,
        xp
    FROM users
    ORDER BY username ASC
";


$statement = mysqli_prepare(
    $connection,
    $usersQuery
);


$users = [];


if ($statement)
{

    mysqli_stmt_execute($statement);


    mysqli_stmt_bind_result(
        $statement,
        $userID,
        $username,
        $email,
        $role,
        $xp
    );


    while (mysqli_stmt_fetch($statement))
    {

        $users[] = [
            "userID" => $userID,
            "username" => $username,
            "email" => $email,
            "role" => $role,
            "xp" => $xp
        ];

    }


    mysqli_stmt_close($statement);

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

    <title>Manage Users | Wildlife Emporium</title>


    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/manageUsers.css"
    >

</head>


<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>


<main>

    <div class="manage-users-page">


        <!--this section is for the page header-->

        <section class="manage-users-header">

            <p class="manage-users-label">
                ADMINISTRATION
            </p>

            <h1>
                Manage Users
            </h1>

            <p>
                Manage user accounts and XP progression.
            </p>

        </section>


        <!--this section is for the existing users-->

        <section
            class="existing-users"
            id="existing-users"
        >

            <div class="existing-users-header">

                <div>

                    <p class="management-section-label">
                        USER MANAGEMENT
                    </p>

                    <h2>
                        Existing Users
                    </h2>

                </div>

                <p>
                    Edit account details or delete users.
                </p>

            </div>


            <!--this section is for the user table-->

            <div class="users-table-container">

                <table class="users-table">

                    <thead>

                        <tr>

                            <th>
                                User
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                XP / Level
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if (!empty($users)): ?>


                            <!--this section is for displaying existing users-->

                            <?php foreach ($users as $user): ?>

                                <?php

                                $userXP = (int) $user["xp"];

                                $userLevel = calculateLevel($userXP);

                                ?>


                                <tr>


                                    <!--this section is for user information-->

                                    <td class="user-information">

                                        <strong>

                                            <?php echo htmlspecialchars(
                                                $user["username"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>

                                        </strong>

                                        <span>

                                            ID <?php echo (int) $user["userID"]; ?>

                                        </span>

                                    </td>


                                    <!--this section is for user email-->

                                    <td class="user-email">

                                        <?php echo htmlspecialchars(
                                            $user["email"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <!--this section is for displaying the user role-->

                                    <td class="user-role">

                                        <?php echo htmlspecialchars(
                                            $user["role"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <!--this section is for XP information-->

                                    <td class="user-xp">

                                        <strong>

                                            <?php echo number_format($userXP); ?> XP

                                        </strong>

                                        <span>

                                            Level <?php echo $userLevel; ?>

                                        </span>

                                    </td>


                                    <!--this section is for user actions-->

                                    <td class="user-actions">


                                        <!--this section is for editing user details-->

                                        <a
                                            href="editUser.php?userID=<?php echo (int) $user["userID"]; ?>"
                                            class="user-action-edit"
                                        >
                                            Edit
                                        </a>


                                        <!--this section is for deleting a user-->

                                        <form
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to permanently delete this user?');"
                                        >

                                            <input
                                                type="hidden"
                                                name="action"
                                                value="deleteUser"
                                            >

                                            <input
                                                type="hidden"
                                                name="userID"
                                                value="<?php echo (int) $user["userID"]; ?>"
                                            >


                                            <button
                                                type="submit"
                                                class="user-action-delete"
                                            >
                                                Delete
                                            </button>

                                        </form>


                                    </td>

                                </tr>


                            <?php endforeach; ?>


                        <?php else: ?>


                            <!--this section is for when there are no users-->

                            <tr>

                                <td
                                    colspan="5"
                                    class="no-users"
                                >

                                    <p>
                                        No users available.
                                    </p>

                                </td>

                            </tr>


                        <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </section>


        <!--this section is for managing user XP-->

        <section class="manage-xp">

            <div class="manage-xp-header">

                <div>

                    <p class="management-section-label">
                        XP MANAGEMENT
                    </p>

                    <h2>
                        Manage XP
                    </h2>

                </div>

                <p>
                    Set a user's level or reset their XP.
                </p>

            </div>


            <div class="xp-table-container">

                <table class="xp-table">

                    <thead>

                        <tr>

                            <th>
                                User
                            </th>

                            <th>
                                Current XP / Level
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($users)): ?>


                            <?php foreach ($users as $user): ?>

                                <?php

                                $userXP = (int) $user["xp"];

                                $userLevel = calculateLevel($userXP);

                                ?>


                                <tr>


                                    <!--this section is for the XP user information-->

                                    <td class="xp-user">

                                        <strong>

                                            <?php echo htmlspecialchars(
                                                $user["username"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>

                                        </strong>

                                        <span>

                                            ID <?php echo (int) $user["userID"]; ?>

                                        </span>

                                    </td>


                                    <!--this section is for the current XP and level-->

                                    <td class="xp-current">

                                        <strong>

                                            <?php echo number_format($userXP); ?> XP

                                        </strong>

                                        <span>

                                            Level <?php echo $userLevel; ?>

                                        </span>

                                    </td>


                                    <!--this section is for XP actions-->

                                    <td class="xp-actions">


                                        <!--this section is for changing the user's level-->

                                        <form method="POST">

                                            <input
                                                type="hidden"
                                                name="action"
                                                value="editLevel"
                                            >

                                            <input
                                                type="hidden"
                                                name="userID"
                                                value="<?php echo (int) $user["userID"]; ?>"
                                            >


                                            <select name="level">

                                                <?php for (
                                                    $level = 1;
                                                    $level <= $maxLevel;
                                                    $level++
                                                ): ?>

                                                    <option
                                                        value="<?php echo $level; ?>"
                                                        <?php echo $level === $userLevel ? "selected" : ""; ?>
                                                    >
                                                        Level <?php echo $level; ?>
                                                    </option>

                                                <?php endfor; ?>

                                            </select>


                                            <button
                                                type="submit"
                                                class="xp-action-set"
                                            >
                                                Set Level
                                            </button>

                                        </form>


                                        <!--this section is for resetting the user's XP-->

                                        <form
                                            method="POST"
                                            onsubmit="return confirm('Reset this user to Level 1?');"
                                        >

                                            <input
                                                type="hidden"
                                                name="action"
                                                value="resetStats"
                                            >

                                            <input
                                                type="hidden"
                                                name="userID"
                                                value="<?php echo (int) $user["userID"]; ?>"
                                            >


                                            <button
                                                type="submit"
                                                class="xp-action-reset"
                                            >
                                                Reset XP
                                            </button>

                                        </form>


                                    </td>

                                </tr>


                            <?php endforeach; ?>


                        <?php else: ?>


                            <tr>

                                <td
                                    colspan="3"
                                    class="no-users"
                                >

                                    <p>
                                        No users available.
                                    </p>

                                </td>

                            </tr>


                        <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </section>


    </div>

</main>


<?php include("../includes/footer.php"); ?>


<script src="../js/script.js"></script>


</body>

</html>