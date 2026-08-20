<?php

session_start();

require_once("../includes/auth.php");
requireAdmin();

require_once("../includes/xp.php");

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $xpBaseInput = filter_input(INPUT_POST,"xpBase",FILTER_VALIDATE_INT);
    $xpPowerInput = filter_input(INPUT_POST,"xpPower",FILTER_VALIDATE_FLOAT);
    $maxLevelInput = filter_input(INPUT_POST,"maxLevel",FILTER_VALIDATE_INT);

    if (
        $xpBaseInput === false ||
        $xpPowerInput === false ||
        $maxLevelInput === false
    )
    {
        $message = "Please enter valid values.";
        $messageType = "error";
    }
    elseif (
        $xpBaseInput < 10 ||
        $xpBaseInput > 500 ||
        $xpPowerInput < 1 ||
        $xpPowerInput > 3 ||
        $maxLevelInput < 10 ||
        $maxLevelInput > 200
    )
    {
        $message = "One or more values are outside the allowed range.";
        $messageType = "error";
    }
    else
    {
        $statement = mysqli_prepare(
            $connection,
            "UPDATE xp_config
            SET xpBase = ?,
                xpPower = ?,
                maxLevel = ?
            WHERE configID = 1"
        );

        if ($statement)
        {
            mysqli_stmt_bind_param(
                $statement,
                "idi",
                $xpBaseInput,
                $xpPowerInput,
                $maxLevelInput
            );

            $success = mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);

            if ($success)
            {
                $message = "XP configuration updated.";
                $messageType = "success";

                $xpBase = $xpBaseInput;
                $xpPower = $xpPowerInput;
                $maxLevel = $maxLevelInput;
            }
            else
            {
                $message = "Failed to update XP configuration.";
                $messageType = "error";
            }
        }
        else
        {
            $message = "Failed to prepare configuration update.";
            $messageType = "error";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage XP</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/manage-xp.css">
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navigation.php"); ?>

<main class="xp-management">

    <h1>Manage XP</h1>

    <?php if ($message !== "") { ?>

        <div class="xp-message <?php echo htmlspecialchars($messageType); ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php } ?>

    <section class="xp-curve-section">

        <div class="xp-section-heading">

            <div>
                <h2>XP Curve</h2>
                <p>
                    Preview the progression curve and adjust its parameters below.
                </p>
            </div>

        </div>

        <div class="xp-info-card">

            <h2>Preview Statistics</h2>

            <div class="xp-info">

                <div>
                    <span>Level 10</span>
                    <strong id="level10XP">-</strong>
                </div>

                <div>
                    <span>Level 50</span>
                    <strong id="level50XP">-</strong>
                </div>

                <div>
                    <span>Level 100</span>
                    <strong id="level100XP">-</strong>
                </div>

            </div>

        </div>

        <div class="xp-chart-container">

            <canvas id="xpCurve"></canvas>

            <div id="xpTooltip" class="xp-tooltip"></div>

        </div>

    </section>

    <section class="xp-configuration">

        <div class="xp-info-card">

            <h2>Curve Configuration</h2>

            <p>
                Drag the controls to preview changes to the XP curve.
                Changes are only saved when you click Save Configuration.
            </p>

            <form method="POST" id="xpConfigForm">

                <div class="xp-slider">

                    <div class="xp-slider-heading">

                        <label for="xpBase">
                            Base XP
                        </label>

                        <span id="xpBaseValue">
                            <?php echo htmlspecialchars($xpBase); ?>
                        </span>

                    </div>

                    <input
                        type="range"
                        id="xpBase"
                        name="xpBase"
                        min="10"
                        max="500"
                        step="10"
                        value="<?php echo htmlspecialchars($xpBase); ?>"
                    >

                </div>

                <div class="xp-slider">

                    <div class="xp-slider-heading">

                        <label for="xpPower">
                            Power
                        </label>

                        <span id="xpPowerValue">
                            <?php echo number_format($xpPower,2); ?>
                        </span>

                    </div>

                    <input
                        type="range"
                        id="xpPower"
                        name="xpPower"
                        min="1"
                        max="3"
                        step="0.01"
                        value="<?php echo htmlspecialchars($xpPower); ?>"
                    >

                </div>

                <div class="xp-slider">

                    <div class="xp-slider-heading">

                        <label for="maxLevel">
                            Maximum Level
                        </label>

                        <span id="maxLevelValue">
                            <?php echo htmlspecialchars($maxLevel); ?>
                        </span>

                    </div>

                    <input
                        type="range"
                        id="maxLevel"
                        name="maxLevel"
                        min="10"
                        max="200"
                        step="1"
                        value="<?php echo htmlspecialchars($maxLevel); ?>"
                    >

                </div>

                <button type="submit">
                    Save Configuration
                </button>

            </form>

        </div>

    </section>

</main>

<?php include("../includes/footer.php"); ?>

<script src="../js/xp-curve.js"></script>
<script src="../js/script.js"></script>

</body>
</html>