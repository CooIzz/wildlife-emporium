<?php

session_start();

require_once("../includes/auth.php");
requireAdmin();

require_once("../includes/xp.php");

$message = "";
$messageType = "";

// Edit user's level

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]))
{
    $action = $_POST["action"];
    $userID = filter_input(INPUT_POST,"userID",FILTER_VALIDATE_INT);

    if ($userID === false || $userID === null)
    {
        $message = "Invalid user.";
        $messageType = "error";
    }
    elseif ($action === "editLevel")
    {
        $newLevel = filter_input(INPUT_POST,"level",FILTER_VALIDATE_INT);

        if ($newLevel === false || $newLevel < 1 || $newLevel > $maxLevel)
        {
            $message = "Invalid level.";
            $messageType = "error";
        }
        else
        {
            $newXP = getXPForLevel($newLevel);

            $statement = mysqli_prepare(
                $connection,
                "UPDATE users SET xp = ? WHERE userID = ?"
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
    elseif ($action === "resetStats")
    {
        $newXP = 0;

        $statement = mysqli_prepare(
            $connection,
            "UPDATE users SET xp = ? WHERE userID = ?"
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
                $message = "Failed to reset user stats.";
                $messageType = "error";
            }
        }
        else
        {
            $message = "Failed to prepare reset.";
            $messageType = "error";
        }
    }
}

// Get all users

$users = [];

$statement = mysqli_prepare(
    $connection,
    "SELECT userID,username,xp
    FROM users
    ORDER BY username ASC"
);

if ($statement)
{
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($data = mysqli_fetch_assoc($result))
    {
        $users[] = $data;
    }

    mysqli_stmt_close($statement);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage XP Users</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/manage-xp-users.css">
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main class="xp-users-management">

    <h1>Manage XP Users</h1>

    <?php if ($message !== "") { ?>

        <div class="xp-users-message <?php echo htmlspecialchars($messageType); ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php } ?>

    <section class="xp-users-card">

        <div class="xp-users-heading">

            <div>
                <h2>User XP</h2>
                <p>
                    View and manage user levels.
                </p>
            </div>

            <div class="xp-users-max-level">
                Maximum Level:
                <strong><?php echo $maxLevel; ?></strong>
            </div>

        </div>

        <div class="xp-users-table-container">

            <table class="xp-users-table">

                <thead>

                    <tr>
                        <th>User</th>
                        <th>XP</th>
                        <th>Level</th>
                        <th>Actions</th>
                    </tr>

                </thead>

                <tbody>

                <?php if (count($users) === 0) { ?>

                    <tr>
                        <td colspan="4">
                            No users found.
                        </td>
                    </tr>

                <?php } ?>

                <?php foreach ($users as $user) { ?>

                    <?php
                    $userXP = (int) $user["xp"];
                    $userLevel = calculateLevel($userXP);
                    ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($user["username"]); ?>
                        </td>

                        <td>
                            <?php echo number_format($userXP); ?> XP
                        </td>

                        <td>
                            Level <?php echo $userLevel; ?>
                        </td>

                        <td>

                            <div class="xp-user-actions">

                                <form method="POST">

                                    <input
                                        type="hidden"
                                        name="action"
                                        value="editLevel"
                                    >

                                    <input
                                        type="hidden"
                                        name="userID"
                                        value="<?php echo $user["userID"]; ?>"
                                    >

                                    <select name="level">

                                        <?php for ($level = 1; $level <= $maxLevel; $level++) { ?>

                                            <option
                                                value="<?php echo $level; ?>"
                                                <?php echo $level === $userLevel ? "selected" : ""; ?>
                                            >
                                                Level <?php echo $level; ?>
                                            </option>

                                        <?php } ?>

                                    </select>

                                    <button type="submit">
                                        Edit Level
                                    </button>

                                </form>

                                <form method="POST">

                                    <input
                                        type="hidden"
                                        name="action"
                                        value="resetStats"
                                    >

                                    <input
                                        type="hidden"
                                        name="userID"
                                        value="<?php echo $user["userID"]; ?>"
                                    >

                                    <button
                                        type="submit"
                                        onclick="return confirm('Reset this user to Level 1?');"
                                    >
                                        Reset
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </section>

</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/script.js"></script>

</body>
</html>