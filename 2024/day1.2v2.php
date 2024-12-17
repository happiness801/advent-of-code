<?php
/*// https://adventofcode.com/2024/day/1#part2

This is a more straighforward approach.
NOTE: wouldn't need to have sorted the lists as that wouldn't matter here.
But, it was already doing it *shrug*

Example run:

# Before executing the PHP script, run the shell script

./day1.2.sh '../../advent-of-code-inputs/2024/day1.input.txt' && php day1.2v2.php

//*/

$f1 = fopen("day1.left.sorted.txt", "r");
$f2 = fopen("day1.right.sorted.txt", "r");

$lefts = array();
$rights = array();
$rightCounts = array();

while ($left = fgets($f1)) {
    $lefts[] = intval($left);
}

while ($right = fgets($f2)) {
    $rights[] = intval($right);
}

$rightCounts = array_count_values($rights);

print_r($lefts);
print_r($rights);
print_r($rightCounts);

$sum = 0;

foreach ($lefts as $left) {
    if (!array_key_exists($left, $rightCounts)) {
        continue;
    }
    $sum += ($left * $rightCounts[$left]);
}

echo "Sum: $sum\n\n";

?>