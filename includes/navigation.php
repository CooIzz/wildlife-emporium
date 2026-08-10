<nav>

    <?php

    if (session_status() === PHP_SESSION_NONE) {

        session_start();

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

            <button class="navigation-account-button">

                <?php

                if (isset($_SESSION["username"])) {

                    echo htmlspecialchars($_SESSION["username"]);

                } else {

                    echo "Account";

                }

                ?>

                <?php

                if (isset($_SESSION["userID"])) {

                    ?>

                    <img class="navigation-avatar"
                        src="/wildlife-emporium/images/<?php echo htmlspecialchars($_SESSION["profilePicture"]); ?>"
                        alt="Profile Picture">

                    <?php

                } else {

                    ?>

                    <img class="navigation-avatar" src="/wildlife-emporium/images/defaultpfp.svg" alt="Profile Picture">

                    <?php

                }

                ?>

            </button>

            <div class="navigation-dropdown-menu">

                <?php

                if (isset($_SESSION["userID"])) {

                    ?>

                    <?php

                    if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {

                        ?>

                        <a href="/wildlife-emporium/admin/index.php">
                            Admin Panel
                        </a>

                        <?php

                    }

                    ?>

                    <a href="/wildlife-emporium/account/profile.php">
                        Profile
                    </a>

                    <a href="/wildlife-emporium/account/logout.php">
                        Logout
                    </a>

                    <?php

                } else {

                    ?>

                    <a href="/wildlife-emporium/account/login.php">
                        Login
                    </a>

                    <a href="/wildlife-emporium/account/register.php">
                        Register
                    </a>

                    <?php

                }

                ?>

            </div>

        </div>

    </div>

</nav>