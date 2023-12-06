<?php
/*// https://adventofcode.com/2023/day/3#part2

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) php day3.2.php < ../../advent-of-code-inputs/2023/day3.input.txt
87287096

//*/

function debug($out) { echo $out; }
// function debug($out) {}

$lines = [];
$line_number = 0;

function getPaddingLine($length) {
    return str_repeat('.', $length - 1);
}

function removeFirstLine(&$lines) {
    // pop first line off
    if (count($lines) > 3) {
        array_shift($lines);
    }
}

function getPartNumbersOnLines($lines) {
    $part_numbers = [];

    for ($x = 0; $x < count($lines); $x++) {
        for ($i = 0; $i < strlen($lines[$x]); $i++) {
            $matches = [];
    
            if (preg_match("/^(\d+)/", substr($lines[$x], $i), $matches)) {
                $part_number = $matches[1];
                array_push($part_numbers, array('part_number' => $part_number, 'position' => $i));
    
                debug("Found part number $part_number at position $i\n");
    
                $i += strlen($part_number);
            }
        }
    }

    return $part_numbers;
}

function getAdjacentPartNumbers($part_numbers, $target) {
    $adjacent = [];

    for ($i = 0; $i < count($part_numbers); $i++) {
        $part_number = $part_numbers[$i]['part_number'];
        $position = $part_numbers[$i]['position'];

        if ($position > $target + 1 || $position + strlen($part_number) < $target) {
            continue;
        }

        debug("* at $target, adjacent: $part_number at $position\n");
        array_push($adjacent, intval($part_number));
    }

    return $adjacent;
}

function getGearRatiosSum($lines) {
    debug("Scanning line: $lines[1]\n");
    $gear_ratios_sum = 0;

    for ($i = 0; $i < strlen($lines[1]); $i++) {
        $matches = [];
        if (preg_match("/^(\*)/", substr($lines[1], $i), $matches)) {
            $star = $matches[1];
            debug("Found: " . $star . " at $i\n");
            $gear_ratios_sum += getGearRatio($lines, $i);
            $i += strlen($star);
        }
    }

    return $gear_ratios_sum;
}

function isCharANumber($char) {
    return preg_match("/[\d]/", $char);
}

function getGearRatio($lines, $position) {
    $line_length = strlen($lines[0]);
    $num_of_adjacent_parts = 0;

    $part_numbers = getPartNumbersOnLines($lines);
    $adjacent_part_numbers = getAdjacentPartNumbers($part_numbers, $position);

    if (count($adjacent_part_numbers) == 2) {
        return $adjacent_part_numbers[0] * $adjacent_part_numbers[1];
    }

    debug("NOT A GEAR!\n");
    return 0;
}

$part_numbers_grand_total = 0;
$line_length = 0;

while ($line = fgets(STDIN)) {
    $line_number++;
    $line = trim($line);

    if (!$line_length) $line_length = strlen($line);

    array_push($lines, $line);

    // Add a first padding line for first line
    if (count($lines) == 1) {
        array_unshift($lines, getPaddingLine($line_length));
        continue;
    }
    
    removeFirstLine($lines);
    $part_numbers_grand_total += getGearRatiosSum($lines);
}


array_push($lines, getPaddingLine($line_length));
// when done, add one more padding line and process the last line in the input
// Do we need to shift the first line off? probably?
removeFirstLine($lines);
$part_numbers_grand_total += getGearRatiosSum($lines);

debug("\n\nPart Numbers Grand Total: $part_numbers_grand_total\n\n");

?>