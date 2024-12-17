<?php
/*// https://adventofcode.com/2024/day/1#part2

NOTE: Was trying to be fancy and use minimal disk IO and memory,
but never got this working!! see v2

Example run:

# Before executing the PHP script, run the shell script

./day1.2.sh '../../advent-of-code-inputs/2024/day1.input.txt'
php day1.2.php

//*/

$f1 = fopen("day1.left.sorted.txt", "r");
$f2 = fopen("day1.right.sorted.txt", "r");
$sum = 0;
$right = intval(fgets($f2));
$previousLeft = null;
$previousMultiplier = null;

while ($left = fgets($f1)) {

    $left = intval($left);
    $multiplier = 0;
    
    echo "{$left} vs. {$right} \n";
    
    if ($left == $previousLeft) {
        echo "(Left is same) Adding ($left * $previousMultiplier) = " . ($left * $previousMultiplier) . "\n";
        $sum += ($left * $previousMultiplier);
        continue;
    }
    
    echo '($right == $left) = ' . ($right == $left) . "\n";

    while ($right == $left) {
        $multiplier++;
        $right = intval(fgets($f2));
        echo "Inner: {$left} vs. {$right} \n";
    }

    while (!$multiplier && $left > $right) {
        $right = intval(fgets($f2));
        echo "Advancing right pointer... $right\n";
    }

    echo "Adding ($left * $multiplier) = " . ($left * $multiplier) . "\n";
    $previousLeft = $left;
    $previousMultiplier = $multiplier;

    $sum += ($left * $multiplier);
}

echo "Sum: $sum\n\n";

?>