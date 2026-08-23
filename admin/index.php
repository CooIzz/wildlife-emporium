<?php
session_start();
require_once("../includes/auth.php");
requireAdmin();
?>

<?php require_once("../includes/database.php"); ?>


<?php
$totalUsers = 0;
$statement = mysqli_prepare(
    $connection,
    "SELECT COUNT(*) AS totalUsers FROM users"
);

if ($statement) {
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    $data = mysqli_fetch_assoc($result);
    $totalUsers = $data["totalUsers"];
    mysqli_stmt_close($statement);
}
?>

<?php
$totalAdmins = 0;
$role = "admin";
$statement = mysqli_prepare(
    $connection,
    "SELECT COUNT(*) AS totalAdmins FROM users WHERE role = ?"
);

if ($statement) {
    mysqli_stmt_bind_param(
        $statement,
        "s",
        $role
    );
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    $data = mysqli_fetch_assoc($result);
    $totalAdmins = $data["totalAdmins"];
    mysqli_stmt_close($statement);
}
?>

<?php
$newUsers = 0;
$statement = mysqli_prepare(
    $connection,
    "SELECT COUNT(*) AS newUsers
    FROM users
    WHERE createdAt >= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')"
);

if ($statement) {
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    $data = mysqli_fetch_assoc($result);
    $newUsers = $data["newUsers"];
    mysqli_stmt_close($statement);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main>

<h1 class="admin-heading">Admin Panel</h1>

<div class="admin-container">


    <div class="admin-card">
        <div class="admin-card-heading">
        <h2>Animals</h2>
        <hr>
        </div>
        <div class="admin-card-data">
        <p>Total:</p>
        <p>Most Favorited:</p>
        <p>Latest:</p>
        </div>
        <div class="admin-card-footer">
            <hr>
            <button>
                Manage
            </button>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-heading">
        <h2>Articles</h2>
        <hr>
        </div>
        <div class="admin-card-data">
        <p>Total:</p>
        <p>Published:</p>
        <p>Drafts:</p>
        <p>Latest:</p>
        </div>
        <div class="admin-card-footer">
            <hr>
            <button>
                Manage
            </button>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-heading">
        <h2>Quiz</h2>
        <hr>
        </div>
        <div class="admin-card-data">
        <p>Total:</p>
        <p>Attempts:</p>
        <p>Most Popular:</p>
        </div>
        <div class="admin-card-footer">
            <hr>
            <button>
                <a href="../quiz_crud/quiz_crud.php">Manage Quiz Section</a>
            </button>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-heading">
        <h2>Accounts</h2>
        <hr>
        </div>
        <div class="admin-card-data">
        <p>Users: <?php echo $totalUsers; ?> </p>
        <p>Administrators: <?php echo $totalAdmins; ?> </p>
        <p>New Users: <?php echo $totalAdmins; ?> </p>
        </div>
        <div class="admin-card-footer">
            <hr>
            <button>
                Manage
            </button>
        </div>
    </div>

</div>

</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/script.js"></script>

</body>
</html>