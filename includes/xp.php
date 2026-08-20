<?php

require_once(__DIR__ . "/database.php");

// Load XP configuration

$statement = mysqli_prepare(
    $connection,
    "SELECT xpBase,xpPower,maxLevel
    FROM xp_config
    WHERE configID = 1"
);

if (!$statement)
{
    die("Failed to load XP configuration.");
}

mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);
$config = mysqli_fetch_assoc($result);

mysqli_stmt_close($statement);

if (!$config)
{
    die("XP configuration was not found.");
}

$xpBase = (int) $config["xpBase"];
$xpPower = (float) $config["xpPower"];
$maxLevel = (int) $config["maxLevel"];

// Calculate XP required for a level

function getXPForLevel($level)
{
    global $xpBase,$xpPower,$maxLevel;

    if ($level <= 1)
    {
        return 0;
    }

    if ($level > $maxLevel)
    {
        $level = $maxLevel;
    }

    return (int) round($xpBase * pow($level - 1,$xpPower));
}

// Calculate level from XP

function calculateLevel($xp)
{
    global $maxLevel;

    $level = 1;

    for ($i = 2; $i <= $maxLevel; $i++)
    {
        if ($xp < getXPForLevel($i))
        {
            break;
        }

        $level = $i;
    }

    return $level;
}

// Get user's XP

function getUserXP($userID)
{
    global $connection;

    $statement = mysqli_prepare($connection,"SELECT xp FROM users WHERE userID = ?");

    if (!$statement)
    {
        return false;
    }

    mysqli_stmt_bind_param($statement,"i",$userID);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $data = mysqli_fetch_assoc($result);

    mysqli_stmt_close($statement);

    if (!$data)
    {
        return false;
    }

    return (int) $data["xp"];
}

// Get user's level

function getUserLevel($userID)
{
    $xp = getUserXP($userID);

    if ($xp === false)
    {
        return false;
    }

    return calculateLevel($xp);
}

// Give XP to a user

function awardXP($userID,$amount,$reason)
{
    global $connection;

    if (!is_numeric($amount) || $amount <= 0)
    {
        return [
            "success" => false,
            "message" => "Invalid XP amount."
        ];
    }

    $amount = (int) $amount;

    $oldXP = getUserXP($userID);

    if ($oldXP === false)
    {
        return [
            "success" => false,
            "message" => "User not found."
        ];
    }

    $oldLevel = calculateLevel($oldXP);
    $newXP = $oldXP + $amount;

    $statement = mysqli_prepare($connection,"UPDATE users SET xp = ? WHERE userID = ?");

    if (!$statement)
    {
        return [
            "success" => false,
            "message" => "Failed to update XP."
        ];
    }

    mysqli_stmt_bind_param($statement,"ii",$newXP,$userID);
    $success = mysqli_stmt_execute($statement);

    mysqli_stmt_close($statement);

    if (!$success)
    {
        return [
            "success" => false,
            "message" => "Failed to update XP."
        ];
    }

    $statement = mysqli_prepare($connection,"INSERT INTO xp_history (userID,amount,reason) VALUES (?,?,?)");

    if (!$statement)
    {
        return [
            "success" => false,
            "message" => "XP was updated but history could not be recorded."
        ];
    }

    mysqli_stmt_bind_param($statement,"iis",$userID,$amount,$reason);
    mysqli_stmt_execute($statement);

    mysqli_stmt_close($statement);

    $newLevel = calculateLevel($newXP);

    return [
        "success" => true,
        "oldXP" => $oldXP,
        "newXP" => $newXP,
        "oldLevel" => $oldLevel,
        "newLevel" => $newLevel,
        "levelUp" => $newLevel > $oldLevel
    ];
}

// Remove XP from a user

function removeXP($userID,$amount,$reason)
{
    global $connection;

    if (!is_numeric($amount) || $amount <= 0)
    {
        return [
            "success" => false,
            "message" => "Invalid XP amount."
        ];
    }

    $amount = (int) $amount;

    $oldXP = getUserXP($userID);

    if ($oldXP === false)
    {
        return [
            "success" => false,
            "message" => "User not found."
        ];
    }

    $oldLevel = calculateLevel($oldXP);
    $newXP = max(0,$oldXP - $amount);
    $actualAmountRemoved = $oldXP - $newXP;

    if ($actualAmountRemoved <= 0)
    {
        return [
            "success" => false,
            "message" => "User has no XP to remove."
        ];
    }

    $statement = mysqli_prepare($connection,"UPDATE users SET xp = ? WHERE userID = ?");

    if (!$statement)
    {
        return [
            "success" => false,
            "message" => "Failed to update XP."
        ];
    }

    mysqli_stmt_bind_param($statement,"ii",$newXP,$userID);
    $success = mysqli_stmt_execute($statement);

    mysqli_stmt_close($statement);

    if (!$success)
    {
        return [
            "success" => false,
            "message" => "Failed to update XP."
        ];
    }

    $historyAmount = -$actualAmountRemoved;

    $statement = mysqli_prepare($connection,"INSERT INTO xp_history (userID,amount,reason) VALUES (?,?,?)");

    if (!$statement)
    {
        return [
            "success" => false,
            "message" => "XP was updated but history could not be recorded."
        ];
    }

    mysqli_stmt_bind_param($statement,"iis",$userID,$historyAmount,$reason);
    mysqli_stmt_execute($statement);

    mysqli_stmt_close($statement);

    $newLevel = calculateLevel($newXP);

    return [
        "success" => true,
        "oldXP" => $oldXP,
        "newXP" => $newXP,
        "oldLevel" => $oldLevel,
        "newLevel" => $newLevel,
        "levelDown" => $newLevel < $oldLevel
    ];
}

// Get user's XP progress

function getXPProgress($userID)
{
    global $maxLevel;

    $xp = getUserXP($userID);

    if ($xp === false)
    {
        return false;
    }

    $level = calculateLevel($xp);

    if ($level >= $maxLevel)
    {
        return [
            "level" => $level,
            "currentXP" => $xp,
            "currentLevelXP" => getXPForLevel($level),
            "nextLevelXP" => getXPForLevel($level),
            "progressXP" => $xp - getXPForLevel($level),
            "requiredXP" => 0,
            "percentage" => 100,
            "maxLevel" => true
        ];
    }

    $currentLevelXP = getXPForLevel($level);
    $nextLevelXP = getXPForLevel($level + 1);
    $progressXP = $xp - $currentLevelXP;
    $requiredXP = $nextLevelXP - $currentLevelXP;
    $percentage = ($progressXP / $requiredXP) * 100;

    return [
        "level" => $level,
        "currentXP" => $xp,
        "currentLevelXP" => $currentLevelXP,
        "nextLevelXP" => $nextLevelXP,
        "progressXP" => $progressXP,
        "requiredXP" => $requiredXP,
        "percentage" => round($percentage,2),
        "maxLevel" => false
    ];
}

// Get user's XP history

function getXPHistory($userID)
{
    global $connection;

    $statement = mysqli_prepare($connection,"SELECT amount,reason,createdAt FROM xp_history WHERE userID = ? ORDER BY createdAt DESC");

    if (!$statement)
    {
        return false;
    }

    mysqli_stmt_bind_param($statement,"i",$userID);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $history = [];

    while ($data = mysqli_fetch_assoc($result))
    {
        $history[] = $data;
    }

    mysqli_stmt_close($statement);

    return $history;
}

?>