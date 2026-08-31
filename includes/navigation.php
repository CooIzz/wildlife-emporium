<nav>

    <?php

    if (session_status() === PHP_SESSION_NONE) {

        session_start();

    }

    $isLoggedIn = isset($_SESSION["userID"]);

    if (
        $isLoggedIn &&
        isset($_SESSION["profilePicture"]) &&
        $_SESSION["profilePicture"] !== "" &&
        $_SESSION["profilePicture"] !== "default-avatar.png"
    ) {

        $navigationProfilePicture =
            "/wildlife-emporium/images/account/profiles/" .
            $_SESSION["profilePicture"];

    } else {

        $navigationProfilePicture =
            "/wildlife-emporium/images/default-avatar.png";

    }

    ?>


    <div class="navigation-container">

        <ul class="navigation-links">

            <li>
                <a href="/wildlife-emporium/">
                    Home
                </a>
            </li>

            <li>
                <a href="/wildlife-emporium/animals/">
                    Animals
                </a>
            </li>

            <li>
                <a href="/wildlife-emporium/articles/">
                    Articles
                </a>
            </li>

            <li>
                <a href="/wildlife-emporium/quiz/">
                    Quiz
                </a>
            </li>

            <li>
                <a href="/wildlife-emporium/contact/">
                    Contact
                </a>
            </li>

        </ul>


        <div class="navigation-dropdown">

            <button
                class="navigation-account-button"
                type="button"
            >

                <?php

                if ($isLoggedIn && isset($_SESSION["username"])) {

                    echo htmlspecialchars(
                        $_SESSION["username"],
                        ENT_QUOTES,
                        "UTF-8"
                    );

                } else {

                    echo "Account";

                }

                ?>


                <img
                    class="navigation-avatar"
                    src="<?php echo htmlspecialchars(
                        $navigationProfilePicture,
                        ENT_QUOTES,
                        "UTF-8"
                    ); ?>"
                    alt="Profile Picture"
                >

            </button>


            <div class="navigation-dropdown-menu">

                <?php if ($isLoggedIn): ?>

                    <?php if (
                        isset($_SESSION["role"]) &&
                        $_SESSION["role"] === "admin"
                    ): ?>

                        <a href="/wildlife-emporium/admin/index.php">
                            Admin Panel
                        </a>

                    <?php endif; ?>


                    <a href="/wildlife-emporium/account/profile.php">
                        Profile
                    </a>

                    <a href="/wildlife-emporium/account/logout.php">
                        Logout
                    </a>


                <?php else: ?>

                    <a href="/wildlife-emporium/account/login.php">
                        Login
                    </a>

                    <a href="/wildlife-emporium/account/register.php">
                        Register
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</nav>