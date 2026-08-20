<?php

require_once("includes/xp.php");

echo "<h1>XP Curve Test</h1>";

echo "<table border='1'>";
echo "<tr>";
echo "<th>Level</th>";
echo "<th>Total XP Required</th>";
echo "<th>XP From Previous Level</th>";
echo "</tr>";

for ($level = 1; $level <= $maxLevel; $level++) 
{
    $currentXP = getXPForLevel($level);

    if ($level == 1) 
    {
        $previousXP = 0;
    }
    else 
    {
        $previousXP = getXPForLevel($level - 1);
    }

    $xpDifference = $currentXP - $previousXP;

    echo "<tr>";
    echo "<td>" . $level . "</td>";
    echo "<td>" . number_format($currentXP) . "</td>";
    echo "<td>" . number_format($xpDifference) . "</td>";
    echo "</tr>";
}

echo "</table>";

?>