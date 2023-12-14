<?php
/*// https://adventofcode.com/2023/day/8

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) time php day8.php < ../../advent-of-code-inputs/2023/day8.input.txt

Steps: 12599


real    0m0.076s
user    0m0.029s
sys     0m0.048s
//*/

function debug($out) { echo $out; }
// function debug($out) {}

const START_LOCATION = 'AAA',
      TARGET_LOCATION = 'ZZZ',
      LEFT = 'L',
      RIGHT = 'R';

$instructions = '';
$map = [];
$steps = 0;

while ($line = fgets(STDIN)) {
    $line = trim($line);

    if (!$instructions) {
        $instructions = $line;
        continue;
    }

    if (!$line) continue;

    $matches = [];
    if (preg_match("/([A-Z]+) *= *\\(([A-Z]+), *([A-Z]+)\\)/", $line, $matches)) {
        $location = $matches[1];
        $left_instruction = $matches[2];
        $right_instruction = $matches[3];

        $map[$location] = [
            'L' => $left_instruction,
            'R' => $right_instruction,
        ];
    }
}

$location = START_LOCATION;
$instruction_pointer = 0;

while ($location != TARGET_LOCATION) {
    $steps++;
    $direction = $instructions[$instruction_pointer++];

    if ($instruction_pointer >= strlen($instructions)) $instruction_pointer = 0;

    $next_location = $map[$location][$direction];
    debug("Location: $location, $direction => $next_location\n");
    $location = $next_location;
}

echo "\n\nSteps: $steps\n\n";

?>