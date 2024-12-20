<?php
/*// https://adventofcode.com/2024/day/2

Example run:

# Before executing the PHP script, run the shell script

php day2.php < ../../advent-of-code-inputs/2024/day2.input.txt

//*/

$safeReportsCount = 0;

while ($report = fgets(STDIN)) {
    $report =  trim($report);
    $levels = preg_split('/\s+/', $report);
    $direction = null;
    $distance = 0;
    $previousDirection = null;
    $previousLevel = null;
    $isSafe = true;

    echo "=====================\nNew Report: $report\n=================\n\n";
    
    foreach ($levels as $level) {
        $level = intval($level);

        if ($previousLevel === null) {
            $previousLevel = $level;
            continue;
        }
        
        if ($level > $previousLevel) {
            $direction = 'up';
        } elseif ($level < $previousLevel) {
            $direction = 'down';
        } else {
            $direction = 'same';
        }

        if ($previousDirection === null) {
            $previousDirection = $direction;
        }

        if ($previousDirection != $direction) {
            echo "Direction change; unsafe report\n";
            $isSafe = false;
            break;
        }

        $distance = abs($level - $previousLevel);

        if ($distance < 1 || $distance > 3) {
            echo "Distance invalid ($distance); unsafe report\n";
            $isSafe = false;
            break;
        }
        
        echo "Level: $level, Previous: $previousLevel, Direction: $direction\n";
        
        $previousLevel = $level;
        $previousDirection = $direction;
    }

    if ($isSafe) {
        $safeReportsCount++;
        echo "Safe report!\n";
    }
}

echo "Count of safe reports: $safeReportsCount\n";

?>