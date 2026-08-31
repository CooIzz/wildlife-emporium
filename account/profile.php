<?php

session_start();

require_once("../includes/database.php");
require_once("../includes/auth.php");
require_once("../includes/xp.php");

requireLogin();

$userID = $_SESSION["userID"];

$errorMessage = "";
$successMessage = "";


// --------------------------------------------------
// Retrieve current user
// --------------------------------------------------

$userQuery = "
    SELECT
        username,
        email,
        passwordHash,
        role,
        profilePicture,
        createdAt,
        lastLogin
    FROM users
    WHERE userID = ?
";

$userStatement = mysqli_prepare(
    $connection,
    $userQuery
);

if (!$userStatement) {
    exit("Unable to load the profile.");
}

mysqli_stmt_bind_param(
    $userStatement,
    "i",
    $userID
);

mysqli_stmt_execute($userStatement);

mysqli_stmt_bind_result(
    $userStatement,
    $username,
    $email,
    $passwordHash,
    $role,
    $profilePicture,
    $createdAt,
    $lastLogin
);

if (!mysqli_stmt_fetch($userStatement)) {

    mysqli_stmt_close($userStatement);

    exit("Unable to load the profile.");
}

mysqli_stmt_close($userStatement);


// --------------------------------------------------
// Retrieve XP progress
// --------------------------------------------------

$xpProgress = getXPProgress($userID);

if ($xpProgress === false) {
    exit("Unable to load XP information.");
}


// --------------------------------------------------
// Handle profile updates
// --------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $newUsername = trim($_POST["username"] ?? "");
    $newEmail = trim($_POST["email"] ?? "");

    $currentPassword = $_POST["currentPassword"] ?? "";
    $newPassword = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirmPassword"] ?? "";

    $newProfilePicture = $profilePicture;
    $newProfilePicturePath = "";


    // --------------------------------------------------
    // Validate username
    // --------------------------------------------------

    if ($newUsername === "") {

        $errorMessage = "Username is required.";

    } elseif (
        strlen($newUsername) < 3 ||
        strlen($newUsername) > 30
    ) {

        $errorMessage =
            "Username must be between 3 and 30 characters.";

    } elseif (
        !preg_match(
            "/^[a-zA-Z0-9_]+$/",
            $newUsername
        )
    ) {

        $errorMessage =
            "Username can only contain letters, numbers, and underscores.";
    }


    // --------------------------------------------------
    // Validate email
    // --------------------------------------------------

    if (
        $errorMessage === "" &&
        !filter_var(
            $newEmail,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        $errorMessage =
            "Please enter a valid email address.";
    }


    // --------------------------------------------------
    // Check username availability
    // --------------------------------------------------

    if ($errorMessage === "") {

        $usernameQuery = "
            SELECT userID
            FROM users
            WHERE username = ?
            AND userID != ?
        ";

        $usernameStatement = mysqli_prepare(
            $connection,
            $usernameQuery
        );

        if (!$usernameStatement) {

            $errorMessage =
                "Unable to validate the username.";

        } else {

            mysqli_stmt_bind_param(
                $usernameStatement,
                "si",
                $newUsername,
                $userID
            );

            mysqli_stmt_execute($usernameStatement);
            mysqli_stmt_store_result($usernameStatement);

            if (
                mysqli_stmt_num_rows(
                    $usernameStatement
                ) > 0
            ) {

                $errorMessage =
                    "That username is already in use.";
            }

            mysqli_stmt_close($usernameStatement);
        }
    }


    // --------------------------------------------------
    // Check email availability
    // --------------------------------------------------

    if ($errorMessage === "") {

        $emailQuery = "
            SELECT userID
            FROM users
            WHERE email = ?
            AND userID != ?
        ";

        $emailStatement = mysqli_prepare(
            $connection,
            $emailQuery
        );

        if (!$emailStatement) {

            $errorMessage =
                "Unable to validate the email address.";

        } else {

            mysqli_stmt_bind_param(
                $emailStatement,
                "si",
                $newEmail,
                $userID
            );

            mysqli_stmt_execute($emailStatement);
            mysqli_stmt_store_result($emailStatement);

            if (
                mysqli_stmt_num_rows(
                    $emailStatement
                ) > 0
            ) {

                $errorMessage =
                    "That email address is already in use.";
            }

            mysqli_stmt_close($emailStatement);
        }
    }


    // --------------------------------------------------
    // Validate password change
    // --------------------------------------------------

    if (
        $errorMessage === "" &&
        (
            $newPassword !== "" ||
            $confirmPassword !== ""
        )
    ) {

        if ($currentPassword === "") {

            $errorMessage =
                "Please enter your current password before changing your password.";

        } elseif (
            !password_verify(
                $currentPassword,
                $passwordHash
            )
        ) {

            $errorMessage =
                "The current password is incorrect.";

        } elseif (strlen($newPassword) < 8) {

            $errorMessage =
                "New password must be at least 8 characters long.";

        } elseif (strlen($newPassword) > 72) {

            $errorMessage =
                "New password must not be longer than 72 characters.";

        } elseif ($newPassword !== $confirmPassword) {

            $errorMessage =
                "The new passwords do not match.";
        }
    }


    // --------------------------------------------------
    // Validate profile picture
    // --------------------------------------------------

    if (
        $errorMessage === "" &&
        isset($_FILES["profilePicture"]) &&
        $_FILES["profilePicture"]["error"] !== UPLOAD_ERR_NO_FILE
    ) {

        if (
            $_FILES["profilePicture"]["error"] !==
            UPLOAD_ERR_OK
        ) {

            $errorMessage =
                "Unable to upload the profile picture.";

        } elseif (
            $_FILES["profilePicture"]["size"] >
            5 * 1024 * 1024
        ) {

            $errorMessage =
                "Profile picture must be smaller than 5 MB.";

        } else {

            $imageInformation = getimagesize(
                $_FILES["profilePicture"]["tmp_name"]
            );

            if ($imageInformation === false) {

                $errorMessage =
                    "Please upload a valid image.";

            } else {

                $allowedTypes = [
                    IMAGETYPE_JPEG,
                    IMAGETYPE_PNG,
                    IMAGETYPE_GIF,
                    IMAGETYPE_WEBP
                ];

                if (
                    !in_array(
                        $imageInformation[2],
                        $allowedTypes,
                        true
                    )
                ) {

                    $errorMessage =
                        "Only JPG, PNG, GIF, and WEBP images are allowed.";
                }
            }
        }
    }


    // --------------------------------------------------
    // Prepare profile update
    // --------------------------------------------------

    if ($errorMessage === "") {

        $updateFields = "
            username = ?,
            email = ?
        ";

        $updatePassword = false;
        $newPasswordHash = "";


        // --------------------------------------------------
        // Create new password hash
        // --------------------------------------------------

        if ($newPassword !== "") {

            $newPasswordHash = password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );

            if ($newPasswordHash === false) {

                $errorMessage =
                    "Unable to update the password.";

            } else {

                $updateFields .= ",
                    passwordHash = ?
                ";

                $updatePassword = true;
            }
        }


        // --------------------------------------------------
        // Prepare new profile picture
        // --------------------------------------------------

        if (
            $errorMessage === "" &&
            isset($_FILES["profilePicture"]) &&
            $_FILES["profilePicture"]["error"] ===
            UPLOAD_ERR_OK
        ) {

            $fileExtension = strtolower(
                pathinfo(
                    $_FILES["profilePicture"]["name"],
                    PATHINFO_EXTENSION
                )
            );

            $newProfilePicture = uniqid(
                "profile_",
                true
            ) . "." . $fileExtension;

            $newProfilePicturePath =
                "../images/" . $newProfilePicture;

            $updateFields .= ",
                profilePicture = ?
            ";
        }
    }


    // --------------------------------------------------
    // Execute profile update
    // --------------------------------------------------

    if ($errorMessage === "") {

        $updateQuery = "
            UPDATE users
            SET
                $updateFields
            WHERE userID = ?
        ";

        $updateStatement = mysqli_prepare(
            $connection,
            $updateQuery
        );

        if (!$updateStatement) {

            $errorMessage =
                "Unable to update your profile.";

        } else {

            if (
                $updatePassword &&
                $newProfilePicturePath !== ""
            ) {

                mysqli_stmt_bind_param(
                    $updateStatement,
                    "ssssi",
                    $newUsername,
                    $newEmail,
                    $newPasswordHash,
                    $newProfilePicture,
                    $userID
                );

            } elseif ($updatePassword) {

                mysqli_stmt_bind_param(
                    $updateStatement,
                    "sssi",
                    $newUsername,
                    $newEmail,
                    $newPasswordHash,
                    $userID
                );

            } elseif (
                $newProfilePicturePath !== ""
            ) {

                mysqli_stmt_bind_param(
                    $updateStatement,
                    "sssi",
                    $newUsername,
                    $newEmail,
                    $newProfilePicture,
                    $userID
                );

            } else {

                mysqli_stmt_bind_param(
                    $updateStatement,
                    "ssi",
                    $newUsername,
                    $newEmail,
                    $userID
                );
            }


            // --------------------------------------------------
            // Save uploaded profile picture first
            // --------------------------------------------------

            if (
                $newProfilePicturePath !== "" &&
                !move_uploaded_file(
                    $_FILES["profilePicture"]["tmp_name"],
                    $newProfilePicturePath
                )
            ) {

                $errorMessage =
                    "Unable to save the profile picture.";

                mysqli_stmt_close($updateStatement);

            } elseif (
                mysqli_stmt_execute($updateStatement)
            ) {

                mysqli_stmt_close($updateStatement);


                // --------------------------------------------------
                // Remove old profile picture
                // --------------------------------------------------

                if (
                    $newProfilePicture !== $profilePicture &&
                    $profilePicture !== "default-avatar.png" &&
                    file_exists(
                        "../images/" . $profilePicture
                    )
                ) {

                    unlink(
                        "../images/" . $profilePicture
                    );
                }


                header(
                    "Location: profile.php?message=updated"
                );

                exit();

            } else {

                $errorMessage =
                    "Unable to update your profile.";

                mysqli_stmt_close($updateStatement);
            }
        }
    }


    // --------------------------------------------------
    // Preserve submitted values after validation failure
    // --------------------------------------------------

    $username = $newUsername;
    $email = $newEmail;
}


// --------------------------------------------------
// Display update message
// --------------------------------------------------

if (
    isset($_GET["message"]) &&
    $_GET["message"] === "updated"
) {

    $successMessage =
        "Your profile has been updated successfully.";
}


// --------------------------------------------------
// Retrieve favourite animals
// --------------------------------------------------

$favouriteAnimals = [];

$favouriteQuery = "
    SELECT
        a.animalID,
        a.commonName,
        a.scientificName,
        a.kingdom,
        a.phylum,
        a.class,
        a.orderName,
        a.family,
        a.genus,
        a.species,
        a.image
    FROM favourites f
    INNER JOIN animals a
        ON f.animalID = a.animalID
    WHERE f.userID = ?
    ORDER BY a.commonName ASC
";

$favouriteStatement = mysqli_prepare(
    $connection,
    $favouriteQuery
);

if (!$favouriteStatement) {
    exit("Unable to load favourite animals.");
}

mysqli_stmt_bind_param(
    $favouriteStatement,
    "i",
    $userID
);

mysqli_stmt_execute($favouriteStatement);

$favouriteResult = mysqli_stmt_get_result(
    $favouriteStatement
);

while (
    $animal = mysqli_fetch_assoc(
        $favouriteResult
    )
) {

    $favouriteAnimals[] = $animal;
}

mysqli_stmt_close($favouriteStatement);

$favouriteCount = count($favouriteAnimals);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        My Profile | Wildlife Emporium
    </title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/animals.css"
    >

    <link
        rel="stylesheet"
        href="../css/profile.css"
    >

</head>


<body>

    <?php include("../includes/header.php"); ?>

    <?php include("../includes/navigation.php"); ?>


    <main>

        <div class="profile-page">

            <div class="profile-card">


                <!-- Page heading -->

                <div class="profile-logo">

                    <img
                        src="../images/logo.png"
                        alt="Wildlife Emporium Logo"
                    >

                </div>


                <h1 class="profile-title">
                    My Profile
                </h1>


                <p class="profile-description">
                    Manage your Wildlife Emporium account,
                    experience, and favourite animals.
                </p>


                <!-- Messages -->

                <?php if ($errorMessage !== ""): ?>

                    <div
                        class="profile-message profile-error"
                        id="profile-error"
                    >

                        <?php echo htmlspecialchars(
                            $errorMessage,
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?>

                    </div>

                <?php else: ?>

                    <div
                        class="profile-message profile-error"
                        id="profile-error"
                        style="display: none;"
                    ></div>

                <?php endif; ?>


                <?php if ($successMessage !== ""): ?>

                    <div class="profile-message profile-success">

                        <?php echo htmlspecialchars(
                            $successMessage,
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?>

                    </div>

                <?php endif; ?>


                <!-- Experience -->

                <section
                    class="profile-section profile-experience"
                >

                    <p class="profile-section-label">
                        EXPERIENCE
                    </p>

                    <h2>
                        Level & Experience
                    </h2>


                    <div class="profile-xp-header">

                        <div class="profile-xp-level">

                            <span class="profile-xp-label">
                                CURRENT LEVEL
                            </span>

                            <strong>
                                Level
                                <?php echo (int) $xpProgress["level"]; ?>
                            </strong>

                        </div>


                        <div class="profile-xp-total">

                            <span class="profile-xp-label">
                                TOTAL EXPERIENCE
                            </span>

                            <strong>
                                <?php echo number_format(
                                    $xpProgress["currentXP"]
                                ); ?>
                                XP
                            </strong>

                        </div>

                    </div>


                    <div class="profile-xp-progress">

                        <div class="profile-xp-progress-info">

                            <?php if ($xpProgress["maxLevel"]): ?>

                                <span>
                                    Maximum Level
                                </span>

                                <span>
                                    <?php echo number_format(
                                        $xpProgress["currentXP"]
                                    ); ?>
                                    XP
                                </span>

                            <?php else: ?>

                                <span>
                                    <?php echo number_format(
                                        $xpProgress["progressXP"]
                                    ); ?>
                                    /
                                    <?php echo number_format(
                                        $xpProgress["requiredXP"]
                                    ); ?>
                                    XP
                                </span>

                                <span>
                                    <?php echo number_format(
                                        $xpProgress["percentage"],
                                        0
                                    ); ?>%
                                </span>

                            <?php endif; ?>

                        </div>


                        <div class="profile-xp-bar">

                            <div
                                class="profile-xp-fill"
                                style="width: <?php echo min(
                                    100,
                                    max(
                                        0,
                                        $xpProgress["percentage"]
                                    )
                                ); ?>%;"
                            ></div>

                        </div>


                        <div class="profile-xp-progress-footer">

                            <?php if ($xpProgress["maxLevel"]): ?>

                                <span>
                                    Maximum level reached
                                </span>

                            <?php else: ?>

                                <span>
                                    <?php echo number_format(
                                        $xpProgress["currentLevelXP"]
                                    ); ?>
                                    XP
                                </span>

                                <span>
                                    Level
                                    <?php echo (int) (
                                        $xpProgress["level"] + 1
                                    ); ?>:
                                    <?php echo number_format(
                                        $xpProgress["nextLevelXP"]
                                    ); ?>
                                    XP
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="profile-xp-summary">

                        <?php if ($xpProgress["maxLevel"]): ?>

                            <p>
                                You have reached the maximum level
                                available in Wildlife Emporium.
                            </p>

                        <?php else: ?>

                            <p>
                                You need
                                <strong>
                                    <?php echo number_format(
                                        $xpProgress["requiredXP"] -
                                        $xpProgress["progressXP"]
                                    ); ?>
                                    XP
                                </strong>
                                more to reach Level
                                <strong>
                                    <?php echo (int) (
                                        $xpProgress["level"] + 1
                                    ); ?>
                                </strong>.
                            </p>

                        <?php endif; ?>

                    </div>

                </section>


                <!-- Favourite animals -->

                <section
                    class="profile-section profile-favourites"
                >

                    <p class="profile-section-label">
                        FAVOURITES
                    </p>

                    <h2>
                        Favourite Animals
                    </h2>


                    <?php if ($favouriteCount > 0): ?>

                        <p class="profile-favourites-description">
                            <?php echo $favouriteCount; ?>
                            favourite
                            <?php echo $favouriteCount === 1
                                ? "animal"
                                : "animals"; ?>
                            in your collection.
                        </p>


                        <div class="profile-favourites-grid">

                            <?php foreach (
                                $favouriteAnimals as $animal
                            ): ?>

                                <div
                                    class="animal-card profile-favourite-card"
                                >

                                    <div class="animal-card-inner">


                                        <!-- Animal card front -->

                                        <div class="animal-card-front">

                                            <div class="animal-card-image">

                                                <img
                                                    src="../images/animals/<?php echo htmlspecialchars(
                                                        $animal["image"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>"
                                                    alt="<?php echo htmlspecialchars(
                                                        $animal["commonName"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>"
                                                >

                                            </div>


                                            <div class="animal-card-content">

                                                <p class="animal-card-class">

                                                    <?php echo htmlspecialchars(
                                                        $animal["class"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </p>


                                                <h3>

                                                    <?php echo htmlspecialchars(
                                                        $animal["commonName"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </h3>


                                                <p class="animal-card-scientific">

                                                    <?php echo htmlspecialchars(
                                                        $animal["scientificName"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </p>

                                            </div>

                                        </div>


                                        <!-- Animal card back -->

                                        <div class="animal-card-back">

                                            <h3>

                                                <?php echo htmlspecialchars(
                                                    $animal["commonName"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>

                                            </h3>


                                            <div class="animal-card-details">

                                                <p>

                                                    <span>
                                                        Kingdom
                                                    </span>

                                                    <?php echo htmlspecialchars(
                                                        $animal["kingdom"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </p>


                                                <p>

                                                    <span>
                                                        Phylum
                                                    </span>

                                                    <?php echo htmlspecialchars(
                                                        $animal["phylum"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </p>


                                                <p>

                                                    <span>
                                                        Class
                                                    </span>

                                                    <?php echo htmlspecialchars(
                                                        $animal["class"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </p>


                                                <p>

                                                    <span>
                                                        Order
                                                    </span>

                                                    <?php echo htmlspecialchars(
                                                        $animal["orderName"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </p>


                                                <p>

                                                    <span>
                                                        Family
                                                    </span>

                                                    <?php echo htmlspecialchars(
                                                        $animal["family"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </p>


                                                <p>

                                                    <span>
                                                        Genus
                                                    </span>

                                                    <?php echo htmlspecialchars(
                                                        $animal["genus"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </p>


                                                <p>

                                                    <span>
                                                        Species
                                                    </span>

                                                    <?php echo htmlspecialchars(
                                                        $animal["species"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>

                                                </p>

                                            </div>


                                            <a
                                                href="../animals/details.php?animalID=<?php echo (int) $animal["animalID"]; ?>"
                                                class="animal-card-button"
                                            >
                                                View Details
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>


                    <?php else: ?>

                        <div class="profile-favourites-empty">

                            <h3>
                                No Favourite Animals
                            </h3>

                            <p>
                                You have not added any animals to your
                                favourites yet.
                            </p>

                            <a href="../animals/index.php">
                                Explore Animals
                            </a>

                        </div>

                    <?php endif; ?>

                </section>


                <!-- Account settings -->

                <section
                    class="profile-section profile-settings"
                >

                    <p class="profile-section-label">
                        ACCOUNT SETTINGS
                    </p>

                    <h2>
                        Edit Profile
                    </h2>


                    <div class="profile-account">


                        <!-- Profile picture -->

                        <div class="profile-avatar">

                            <img
                                src="../images/<?php echo htmlspecialchars(
                                    $profilePicture,
                                    ENT_QUOTES,
                                    "UTF-8"
                                ); ?>"
                                alt="Profile Picture"
                            >

                        </div>


                        <!-- Profile form -->

                        <form
                            class="profile-form"
                            action="profile.php"
                            method="POST"
                            enctype="multipart/form-data"
                            id="profile-form"
                            novalidate
                        >


                            <div class="profile-input-group">

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
                                    minlength="3"
                                    maxlength="30"
                                    required
                                >

                                <p class="profile-form-help">
                                    3 to 30 characters.
                                    Letters, numbers, and underscores only.
                                </p>

                            </div>


                            <div class="profile-input-group">

                                <label for="email">
                                    Email Address
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


                            <div class="profile-input-group">

                                <label for="profilePicture">
                                    Profile Picture
                                </label>

                                <input
                                    type="file"
                                    id="profilePicture"
                                    name="profilePicture"
                                    accept=".jpg,.jpeg,.png,.gif,.webp"
                                >

                                <p class="profile-form-help">
                                    JPG, PNG, GIF, or WEBP.
                                    Maximum file size: 5 MB.
                                </p>

                            </div>


                            <div class="profile-input-group">

                                <label for="currentPassword">
                                    Current Password
                                </label>

                                <input
                                    type="password"
                                    id="currentPassword"
                                    name="currentPassword"
                                    placeholder="Required when changing your password"
                                    autocomplete="current-password"
                                >

                            </div>


                            <div class="profile-input-group">

                                <label for="password">
                                    New Password
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Leave blank to keep current password"
                                    minlength="8"
                                    maxlength="72"
                                    autocomplete="new-password"
                                >

                                <p class="profile-form-help">
                                    Password must be between
                                    8 and 72 characters.
                                </p>

                            </div>


                            <div class="profile-input-group">

                                <label for="confirmPassword">
                                    Confirm New Password
                                </label>

                                <input
                                    type="password"
                                    id="confirmPassword"
                                    name="confirmPassword"
                                    placeholder="Confirm your new password"
                                    autocomplete="new-password"
                                >

                            </div>


                            <!-- Account information -->

                            <div class="profile-information">

                                <div class="profile-information-item">

                                    <span class="profile-information-label">
                                        Role
                                    </span>

                                    <span class="profile-information-value">

                                        <?php echo htmlspecialchars(
                                            $role,
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </span>

                                </div>


                                <div class="profile-information-item">

                                    <span class="profile-information-label">
                                        Member Since
                                    </span>

                                    <span class="profile-information-value">

                                        <?php echo date(
                                            "d F Y",
                                            strtotime($createdAt)
                                        ); ?>

                                    </span>

                                </div>


                                <div class="profile-information-item">

                                    <span class="profile-information-label">
                                        Last Login
                                    </span>

                                    <span class="profile-information-value">

                                        <?php if (!empty($lastLogin)): ?>

                                            <?php echo date(
                                                "d F Y H:i",
                                                strtotime($lastLogin)
                                            ); ?>

                                        <?php else: ?>

                                            No login recorded

                                        <?php endif; ?>

                                    </span>

                                </div>

                            </div>


                            <button
                                type="submit"
                                class="profile-button"
                            >
                                Save Changes
                            </button>


                        </form>

                    </div>

                </section>


            </div>

        </div>

    </main>


    <?php include("../includes/footer.php"); ?>


    <!-- Animal card flip functionality -->

    <script src="../js/animals-flip.js"></script>


    <!-- Profile validation -->

    <script>

    const profileForm = document.getElementById("profile-form");
    const profileError = document.getElementById("profile-error");

    const usernameInput = document.getElementById("username");
    const emailInput = document.getElementById("email");

    const profilePictureInput =
        document.getElementById("profilePicture");

    const currentPasswordInput =
        document.getElementById("currentPassword");

    const newPasswordInput =
        document.getElementById("password");

    const confirmPasswordInput =
        document.getElementById("confirmPassword");


    profileForm.addEventListener("submit", function(event)
    {

        let error = "";

        const username = usernameInput.value.trim();
        const email = emailInput.value.trim();

        const currentPassword =
            currentPasswordInput.value;

        const newPassword =
            newPasswordInput.value;

        const confirmPassword =
            confirmPasswordInput.value;


        // --------------------------------------------------
        // Username validation
        // --------------------------------------------------

        if (username === "")
        {

            error = "Username is required.";

        }

        else if (
            username.length < 3 ||
            username.length > 30
        )
        {

            error =
                "Username must be between 3 and 30 characters.";

        }

        else if (!/^[a-zA-Z0-9_]+$/.test(username))
        {

            error =
                "Username can only contain letters, numbers, and underscores.";

        }


        // --------------------------------------------------
        // Email validation
        // --------------------------------------------------

        else if (email === "")
        {

            error =
                "Please enter an email address.";

        }

        else
        {

            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(email))
            {

                error =
                    "Please enter a valid email address.";

            }

        }


        // --------------------------------------------------
        // Password validation
        // --------------------------------------------------

        if (error === "")
        {

            if (
                newPassword !== "" ||
                confirmPassword !== ""
            )
            {

                if (currentPassword === "")
                {

                    error =
                        "Please enter your current password before changing your password.";

                }

                else if (newPassword.length < 8)
                {

                    error =
                        "New password must be at least 8 characters long.";

                }

                else if (newPassword.length > 72)
                {

                    error =
                        "New password must not be longer than 72 characters.";

                }

                else if (
                    newPassword !== confirmPassword
                )
                {

                    error =
                        "The new passwords do not match.";

                }

            }

        }


        // --------------------------------------------------
        // Profile picture validation
        // --------------------------------------------------

        if (
            error === "" &&
            profilePictureInput.files.length > 0
        )
        {

            const file =
                profilePictureInput.files[0];

            const maxFileSize =
                5 * 1024 * 1024;

            const allowedExtensions = [
                "jpg",
                "jpeg",
                "png",
                "gif",
                "webp"
            ];

            const fileName =
                file.name.toLowerCase();

            const fileExtension =
                fileName.split(".").pop();


            if (file.size > maxFileSize)
            {

                error =
                    "Profile picture must be smaller than 5 MB.";

            }

            else if (
                !allowedExtensions.includes(
                    fileExtension
                )
            )
            {

                error =
                    "Only JPG, PNG, GIF, and WEBP images are allowed.";

            }

        }


        // --------------------------------------------------
        // Display validation result
        // --------------------------------------------------

        if (error !== "")
        {

            event.preventDefault();

            profileError.textContent = error;
            profileError.style.display = "block";

            profileError.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });

        }

        else
        {

            profileError.textContent = "";
            profileError.style.display = "none";

        }

    });

    </script>

</body>

</html>