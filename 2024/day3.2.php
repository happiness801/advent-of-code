<?php
/*// https://adventofcode.com/2024/day/3#part2

Example run:

php day3.2.php < ../../advent-of-code-inputs/2024/day3.input.txt

//*/

$sum = 0;
$ignoreMode = false;

while ($instruction = fgets(STDIN)) {
    echo "$instruction\n";
    $matches = [];
    preg_match_all('/(mul\(([0-9]{1,3}),([0-9]{1,3})\)|do(?:n\'t)?\(\))/', $instruction, $matches);
    print_r($matches);
    
    for ($i = 0; $i < sizeof($matches[1]); $i++) {
        if ($matches[1][$i] == "don't()") {
            echo "Enabling ignore mode...\n";
            $ignoreMode = true;
            continue;
        } elseif ($matches[1][$i] == 'do()') {
            echo "Disabling ignore mode...\n";
            $ignoreMode = false;
            continue;
        }

        if (!$ignoreMode) $sum += $matches[2][$i] * $matches[3][$i];
        echo "\$sum += " . $matches[2][$i] . " * " . $matches[3][$i] . ";\n";
    }
}

echo "Total sum: $sum\n";

?>