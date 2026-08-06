<?php

session_start();

require_once("../includes/database.php");

$loggedIn = false;

if (isset($_SESSION["userID"])) {

    $loggedIn = true;

    $sql = "
    SELECT
        username,
        email,
        role,
        profilePicture,
        createdAt,
        lastLogin
    FROM users
    WHERE userID = ?
    ";

    $statement = mysqli_prepare($connection, $sql);

    if ($statement) {

        mysqli_stmt_bind_param(
            $statement,
            "i",
            $_SESSION["userID"]
        );

        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        $user = mysqli_fetch_assoc($result);

        mysqli_stmt_close($statement);

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile | Wildlife Emporium</title>

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

                    <img src="../images/home-logo-test.svg" alt="Wildlife Emporium Logo">

                </div>

                <h1 class="account-title">
                    My Profile
                </h1>

                <p class="account-description">
                    Manage your Wildlife Emporium account.
                </p>

                <!-- Logged Out -->

                <?php

                if (!$loggedIn) {

                    ?>

                    <div class="account-profile-guest">

                        <p class="account-profile-message">
                            You must be logged in to view your profile.
                        </p>

                        <a href="login.php" class="account-button">
                            Log In
                        </a>

                        <a href="register.php" class="account-secondary-button">
                            Create Account
                        </a>

                    </div>

                    <?php

                }

                ?>

                <!-- Logged In -->

                <?php

                if ($loggedIn) {

                    ?>

                    <div class="account-profile">

                        <div class="account-profile-avatar">

                            <img src="../images/<?php echo htmlspecialchars($user["profilePicture"]); ?>" alt="Profile Picture">
                            
                        </div>

                        <div class="account-profile-information">

                            <div class="account-profile-item">

                                <span class="account-profile-label">
                                    Username
                                </span>

                                <span class="account-profile-value">
                                    <?php echo htmlspecialchars($user["username"]); ?>
                                </span>

                            </div>

                            <div class="account-profile-item">

                                <span class="account-profile-label">
                                    Email
                                </span>

                                <span class="account-profile-value">
                                    <?php echo htmlspecialchars($user["email"]); ?>
                                </span>

                            </div>

                            <div class="account-profile-item">

                                <span class="account-profile-label">
                                    Role
                                </span>

                                <span class="account-profile-value">
                                    <?php echo htmlspecialchars($user["role"]); ?>
                                </span>

                            </div>

                            <div class="account-profile-item">

                                <span class="account-profile-label">
                                    Member Since
                                </span>

                                <span class="account-profile-value">
                                    <?php echo date("d F Y", strtotime($user["createdAt"])); ?>
                                </span>

                            </div>

                            <div class="account-profile-item">

                                <span class="account-profile-label">
                                    Last Login
                                </span>

                                <span class="account-profile-value">
                                    <?php echo date("d F Y H:i", strtotime($user["lastLogin"])); ?>
                                </span>

                            </div>

                        </div>

                        <a href="#" class="account-button">
                            Edit Profile
                        </a>

                    </div>

                </div>

                <?php

                }

                ?>

        </section>

    </main>

    <?php include("../includes/footer.php"); ?>

</body>

</html>