<?php
/*// https://adventofcode.com/2024/day/3

Example run:

php day3.php < ../../advent-of-code-inputs/2024/day3.input.txt

//*/

$sum = 0;

while ($instruction = fgets(STDIN)) {
    echo "$instruction\n";
    $matches = [];
    preg_match_all('/mul\(([0-9]{1,3}),([0-9]{1,3})\)/', $instruction, $matches);
    
    for ($i = 0; $i < sizeof($matches[1]); $i++) {
        $sum += $matches[1][$i] * $matches[2][$i];
    }
}

echo "Total sum: $sum\n";

?>