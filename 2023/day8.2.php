<?php
/*// https://adventofcode.com/2023/day/8#part2

VERSION 1 - brute forcing it... yikes.

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) time php day8.2.php < ../../advent-of-code-inputs/2023/day8.input.txt



//*/

// function debug($out) { echo $out; }
 function debug($out) {}

function areWeDoneYet($nodes) {
    foreach ($nodes as $node) {
        if (substr($node, -1) != 'Z') return false;
    }
    
    return true;
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

while (!areWeDoneYet($nodes)) {
    $steps++;
    $direction = $instructions[$instruction_pointer++];

    if ($instruction_pointer >= strlen($instructions)) $instruction_pointer = 0;

    foreach ($nodes as $key => $node) {
        $next_location = $map[$node][$direction];
        debug("Location: $node, $direction => $next_location\n");
        $nodes[$key] = $next_location;
    }

    debug("\n");
}

echo "\n\nSteps: $steps\n\n";

?>