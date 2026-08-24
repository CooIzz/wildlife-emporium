<?php

session_start();

require_once("../includes/database.php");
require_once("../includes/auth.php");

//this section requires the user to be logged in
requireLogin();

$currentUserID = (int)$_SESSION["userID"];

//this section defines the current donation campaign goal
//this will later be replaced with the admin-controlled goal
$donationGoal = 100000;

//this section handles donation submission
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $donationAmount = filter_input(
        INPUT_POST,
        "donationAmount",
        FILTER_VALIDATE_INT
    );

    //this section validates the donation amount
    if (
        $donationAmount === false ||
        $donationAmount === null ||
        $donationAmount < 1 ||
        $donationAmount > 10000
    )
    {
        $_SESSION["donationMessage"] =
            "Please select a valid donation amount between RM1 and RM10,000.";

        $_SESSION["donationMessageType"] = "error";

        header("Location: index.php");
        exit();
    }

    //this section inserts the donation into the database
    $insertDonation = "
        INSERT INTO donations (userID, amount)
        VALUES (?, ?)
    ";

    $statement = mysqli_prepare($connection, $insertDonation);

    if (!$statement)
    {
        $_SESSION["donationMessage"] =
            "Unable to process your donation at this time.";

        $_SESSION["donationMessageType"] = "error";

        header("Location: index.php");
        exit();
    }

    $donationAmountDecimal = (float)$donationAmount;

    mysqli_stmt_bind_param(
        $statement,
        "id",
        $currentUserID,
        $donationAmountDecimal
    );

    if (mysqli_stmt_execute($statement))
    {
        $_SESSION["donationMessage"] =
            "Thank you for your donation of RM" .
            number_format($donationAmount, 0) .
            ".";

        $_SESSION["donationMessageType"] = "success";
    }
    else
    {
        $_SESSION["donationMessage"] =
            "Unable to process your donation at this time.";

        $_SESSION["donationMessageType"] = "error";
    }

    mysqli_stmt_close($statement);

    //this section prevents duplicate donations when the page is refreshed
    header("Location: index.php");
    exit();
}

//this section retrieves the donation result message
$donationMessage = $_SESSION["donationMessage"] ?? "";
$donationMessageType = $_SESSION["donationMessageType"] ?? "";

unset($_SESSION["donationMessage"]);
unset($_SESSION["donationMessageType"]);

//this section calculates the total donations
$totalDonations = 0;

$totalQuery = "
    SELECT COALESCE(SUM(amount), 0)
    FROM donations
";

$totalStatement = mysqli_prepare($connection, $totalQuery);

if ($totalStatement)
{
    mysqli_stmt_execute($totalStatement);

    mysqli_stmt_bind_result(
        $totalStatement,
        $totalDonations
    );

    mysqli_stmt_fetch($totalStatement);
    mysqli_stmt_close($totalStatement);
}

$totalDonations = (float)$totalDonations;

//this section calculates campaign progress
$progressPercentage = 0;

if ($donationGoal > 0)
{
    $progressPercentage =
        ($totalDonations / $donationGoal) * 100;
}

$progressPercentage = min($progressPercentage, 100);

//this section formats values for display
$displayTotal = number_format($totalDonations, 0);
$displayGoal = number_format($donationGoal, 0);
$displayPercentage = number_format($progressPercentage, 1);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Donations | Wildlife Emporium</title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/donations.css"
    >

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>

<main>

    <div class="donations-page">

        <!--this section displays the donation page header-->
        <section class="donations-header">

            <p class="donations-label">
                SUPPORT WILDLIFE
            </p>

            <h1>
                Make a Difference
            </h1>

            <p class="donations-description">
                Your contribution helps support wildlife
                conservation, education, and protection efforts.
            </p>

        </section>

        <!--this section displays the current donation campaign-->
        <section class="donations-goal">

            <div class="donations-goal-header">

                <div>

                    <p class="donations-section-label">
                        CURRENT CAMPAIGN
                    </p>

                    <h2>
                        Wildlife Conservation Fund
                    </h2>

                </div>

                <div class="donations-goal-amount">

                    <span class="donations-raised">
                        RM<?php echo $displayTotal; ?>
                    </span>

                    <span class="donations-goal-total">
                        / RM<?php echo $displayGoal; ?>
                    </span>

                </div>

            </div>

            <!--this section displays the campaign progress bar-->
            <div class="donations-progress">

                <div
                    class="donations-progress-fill"
                    style="width: <?php echo $progressPercentage; ?>%;"
                ></div>

            </div>

            <div class="donations-progress-details">

                <span>
                    RM<?php echo $displayTotal; ?> raised
                </span>

                <span>
                    <?php echo $displayPercentage; ?>% of goal
                </span>

            </div>

        </section>

        <!--this section handles donation amount selection-->
        <section class="donations-selector">

            <div class="donations-section-heading">

                <p class="donations-section-label">
                    YOUR CONTRIBUTION
                </p>

                <h2>
                    Choose Your Donation
                </h2>

                <p>
                    Select the amount you would like to contribute.
                </p>

            </div>

            <!--this section displays the selected donation amount-->
            <div class="donations-selected-amount">

                <span class="donations-currency">
                    RM
                </span>

                <span
                    class="donations-amount"
                    id="donationAmount"
                >
                    0
                </span>

            </div>

            <!--this section contains the donation form and slider-->
            <form
                method="POST"
                action="index.php"
                id="donationForm"
            >

                <div class="donations-slider-container">

                    <div class="donations-slider-wrapper">

                        <input
                            type="range"
                            id="donationSlider"
                            name="donationAmount"
                            class="donations-slider"
                            min="0"
                            max="10000"
                            step="1"
                            value="0"
                        >

                    </div>

                    <!--this section displays the major slider values-->
                    <div class="donations-slider-labels">

                        <span>RM0</span>
                        <span>RM1k</span>
                        <span>RM2k</span>
                        <span>RM3k</span>
                        <span>RM4k</span>
                        <span>RM5k</span>
                        <span>RM6k</span>
                        <span>RM7k</span>
                        <span>RM8k</span>
                        <span>RM9k</span>
                        <span>RM10k</span>

                    </div>

                </div>

                <!--this section displays slider limits-->
                <div class="donations-slider-info">

                    <span>
                        Minimum: RM1
                    </span>

                    <span>
                        Maximum: RM10,000
                    </span>

                </div>

                <!--this section contains the donation button-->
                <div class="donations-action">

                    <button
                        type="submit"
                        class="donations-button"
                        id="donateButton"
                    >
                        Donate RM<span id="buttonAmount">0</span>
                    </button>

                </div>

            </form>

            <!--this section displays the donation result message-->
            <?php if (!empty($donationMessage)): ?>

                <div
                    class="donations-message donations-message-<?php echo htmlspecialchars(
                        $donationMessageType,
                        ENT_QUOTES,
                        "UTF-8"
                    ); ?>"
                >
                    <?php echo htmlspecialchars(
                        $donationMessage,
                        ENT_QUOTES,
                        "UTF-8"
                    ); ?>
                </div>

            <?php endif; ?>

        </section>

        <!--this section provides information about donations-->
        <section class="donations-information">

            <div class="donations-information-card">

                <h3>
                    Support Conservation
                </h3>

                <p>
                    Help contribute towards protecting wildlife
                    and preserving natural habitats.
                </p>

            </div>

            <div class="donations-information-card">

                <h3>
                    Every Contribution Matters
                </h3>

                <p>
                    Whether you contribute a small or large amount,
                    every donation helps support our conservation goals.
                </p>

            </div>

            <div class="donations-information-card">

                <h3>
                    Earn Experience
                </h3>

                <p>
                    Donations will later contribute towards your
                    Wildlife Emporium experience and profile progression.
                </p>

            </div>

        </section>

    </div>

</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/donations.js"></script>
<script src="../js/script.js"></script>

</body>
</html>