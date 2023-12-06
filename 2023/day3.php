<?php
/*// https://adventofcode.com/2023/day/3

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) php day3.php < ../../advent-of-code-inputs/2023/day3.input.txt
53255

//*/

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

function getPartNumbersSum($lines) {
    echo "Scanning line: $lines[1]\n";
    $part_numbers_sum = 0;

    for ($i = 0; $i < strlen($lines[1]); $i++) {
        $matches = [];
        if (preg_match("/^(\d+)/", substr($lines[1], $i), $matches)) {
            $part_number = $matches[1];
            echo "Found: " . $part_number . "\n";
            if (hasAdjacentSymbols($lines, $i, strlen($part_number))) {
                $part_numbers_sum += intval($part_number);
            }

            $i += strlen($part_number);
        }
    }

    return $part_numbers_sum;
}

function isCharASymbol($char) {
    return preg_match("/[^\d\.]/", $char);
}

function hasAdjacentSymbols($lines, $position, $length) {
    $line_length = strlen($lines[0]);

    for ($i = $position - 1; $i < ($position + $length + 1); $i++) {
        if ($i < 0 || $i >= $line_length) {
            continue;
        }

        if (isCharASymbol($lines[0][$i])) {
            echo "Symbol found on line [" . $lines[0] . "] at pos $i: " . $lines[0][$i] . "\n";
            return true;
        }
        
        if (isCharASymbol($lines[2][$i])) {
            echo "Symbol found on line [" . $lines[2] . "] at pos $i: " . $lines[2][$i] . "\n";
            return true;
        }
    }

    if ($position > 0 && isCharASymbol($lines[1][$position - 1])) {
        echo "Symbol found: " . $lines[1][$position - 1] . "\n";
        return true;
    }

    if ($position + $length < $line_length && isCharASymbol($lines[1][$position + $length])) {
        echo "Symbol found: " . $lines[1][$position + $length] . "\n";
        return true;
    }

    echo "NOT A PART NUMBER!\n";
    return false;
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
    $part_numbers_grand_total += getPartNumbersSum($lines);
}


array_push($lines, getPaddingLine($line_length));
// when done, add one more padding line and process the last line in the input
// Do we need to shift the first line off? probably?
removeFirstLine($lines);
$part_numbers_grand_total += getPartNumbersSum($lines);

echo "\n\nPart Numbers Grand Total: $part_numbers_grand_total\n\n";

?>