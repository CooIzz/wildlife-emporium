<?php

/* begin the session and load the database*/

session_start();

require_once("../includes/database.php");


/* check if user is logged in since they have to be logged in to continue*/

$loggedIn = false;

if (isset($_SESSION["userID"])) {

    $loggedIn = true;

}


/* if they are logged in gather user info from db */

if ($loggedIn) {

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


        <!-- PROFILE -->

        <section class="account-page">


            <div class="account-card">


                <!-- =========================================
                     LOGO
                     ========================================= -->

                <div class="account-logo">

                    <img src="../images/home-logo-test.svg" alt="Wildlife Emporium Logo">

                </div>


                <!-- =========================================
                     PAGE TITLE
                     ========================================= -->

                <h1 class="account-title">
                    My Profile
                </h1>


                <p class="account-description">
                    Manage your Wildlife Emporium account.
                </p>


                <!-- =================================================
                     LOGGED OUT
                     ================================================= -->

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


                <!-- =================================================
                     LOGGED IN
                     ================================================= -->

                <?php

                if ($loggedIn) {

                    ?>

                    <div class="account-profile">


                        <!-- =========================================
                             PROFILE PICTURE
                             ========================================= -->

                        <div class="account-profile-avatar">

                            <img src="../images/<?php echo htmlspecialchars($user["profilePicture"]); ?>"
                            alt="Profile Picture"
                            >

                        </div>


                        <!-- =========================================
                             EDIT PROFILE FORM
                             ========================================= -->

                        <form class="account-form" action="" method="post" enctype="multipart/form-data">


                            <!-- =====================================
                                 USERNAME
                                 ===================================== -->

                            <div class="account-input-group">

                                <label for="username">
                                    Username
                                </label>

                                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user["username"]); ?>"
                                required
                                >

                            </div>


                            <!-- =====================================
                                 EMAIL
                                 ===================================== -->

                            <div class="account-input-group">

                                <label for="email">
                                    Email Address
                                </label>

                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>"
                                required
                                >

                            </div>


                            <!-- =====================================
                                 PROFILE PICTURE
                                 ===================================== -->

                            <div class="account-input-group">

                                <label for="profilePicture">
                                    Profile Picture
                                </label>

                                <input type="file" id="profilePicture" name="profilePicture" accept="image/*">

                            </div>


                            <!-- =====================================
                                 PASSWORD
                                 ===================================== -->

                            <div class="account-input-group">

                                <label for="password">
                                    New Password
                                </label>

                                <input type="password" id="password" name="password"
                                    placeholder="Leave blank to keep current password">

                            </div>


                            <!-- =====================================
                                 CONFIRM PASSWORD
                                 ===================================== -->

                            <div class="account-input-group">

                                <label for="confirm-password">
                                    Confirm New Password
                                </label>

                                <input type="password" id="confirm-password" name="confirm-password"
                                    placeholder="Confirm your new password">

                            </div>


                            <!-- =====================================
                                 ACCOUNT INFORMATION
                                 These are displayed only.
                                 They should NOT be editable.
                                 ===================================== -->

                            <div class="account-profile-information">


                                <!-- ROLE -->

                                <div class="account-profile-item">

                                    <span class="account-profile-label">
                                        Role
                                    </span>

                                    <span class="account-profile-value">
                                        <?php
                                        echo htmlspecialchars($user["role"]);
                                        ?>
                                    </span>

                                </div>


                                <!-- MEMBER SINCE -->

                                <div class="account-profile-item">

                                    <span class="account-profile-label">
                                        Member Since
                                    </span>

                                    <span class="account-profile-value">
                                        <?php
                                        echo date(
                                            "d F Y",
                                            strtotime($user["createdAt"])
                                        );
                                        ?>
                                    </span>

                                </div>


                                <!-- LAST LOGIN -->

                                <div class="account-profile-item">

                                    <span class="account-profile-label">
                                        Last Login
                                    </span>

                                    <span class="account-profile-value">

                                        <?php

                                        if (!empty($user["lastLogin"])) {

                                            echo date(
                                                "d F Y H:i",
                                                strtotime($user["lastLogin"])
                                            );

                                        } else {

                                            echo "No login recorded";

                                        }

                                        ?>

                                    </span>

                                </div>


                            </div>


                            <!-- =====================================
                                 SAVE BUTTON
                                 ===================================== -->

                            <button type="submit" class="account-button">
                                Save Changes
                            </button>


                        </form>


                    </div>

                    <?php

                }

                ?>


            </div>


        </section>


    </main>


    <!-- =====================================================
         FOOTER
         ===================================================== -->

    <?php include("../includes/footer.php"); ?>


</body>

</html>