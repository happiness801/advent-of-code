<?php
/*// https://adventofcode.com/2023/day/8#part2

VERSION 2 -- using LCM

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) time php day8.2v2.php < ../../advent-of-code-inputs/2023/day8.input.txt
LCM: 8245452805243


real    0m0.052s
user    0m0.052s
sys     0m0.001s

//*/

// function debug($out) { echo $out; }
 function debug($out) {}

function areWeDoneYet($nodes, $cycle_lengths) {
    return count($nodes) == count($cycle_lengths);
}

const LEFT = 'L',
      RIGHT = 'R';

$instructions = '';      
$map = [];
$nodes = [];
$steps = 0;

while ($line = fgets(STDIN)) {
    $line = trim($line);

    if (!$instructions) {
        $instructions = $line;
        continue;
    }    

    if (!$line) continue;

    $matches = [];
    if (preg_match("/([0-9A-Z]+) *= *\\(([0-9A-Z]+), *([0-9A-Z]+)\\)/", $line, $matches)) {
        $location = $matches[1];
        $left_instruction = $matches[2];
        $right_instruction = $matches[3];

        $map[$location] = [
            'L' => $left_instruction,
            'R' => $right_instruction,
        ];    

        if (substr($location, -1) == 'A') {
            array_push($nodes, $location);
        }    
    }    
}    

// print_r($instructions);
// print_r($map);
// print_r($nodes);

$instruction_pointer = 0;
$cycle_lengths = [];

// get cycle length for each node
while (!areWeDoneYet($nodes, $cycle_lengths)) {
    $steps++;
    $direction = $instructions[$instruction_pointer++];

    if ($instruction_pointer >= strlen($instructions)) $instruction_pointer = 0;

    foreach ($nodes as $key => $node) {
        $next_location = $map[$node][$direction];
        debug("Location: $node, $direction => $next_location\n");
        $nodes[$key] = $next_location;

        if (substr($next_location, -1) == 'Z' && !$cycle_lengths[$key]) {
            $cycle_lengths[$key] = $steps;
        }
    }

    debug("\n");
}

$lcm = gmp_lcm($cycle_lengths[0], $cycle_lengths[1]);

for($i = 2; $i < count($cycle_lengths); $i++) {
    $lcm = gmp_lcm($lcm, $cycle_lengths[$i]);
}

print_r($cycle_lengths);

echo "\nLCM: $lcm\n\n";

?>