<?php
/*// https://adventofcode.com/2024/day/4

Example run:

php day4.php < ../../advent-of-code-inputs/2024/day4.input.txt

//*/

$count = 0;
$matchesFound = []; // row, column, direction
$lineNumber = 0;
$rowOffset = 0;
$lineBuffer = [];
const DIRECTIONS = [
    [[0, 0], [-1,  0], [-2,  0], [-3,  0]], // up
    [[0, 0], [-1,  1], [-2,  2], [-3,  3]], // up-right
    [[0, 0], [0,   1], [0,   2], [0,   3]], // right
    [[0, 0], [1,   1], [2,   2], [3,   3]], // down-right
    [[0, 0], [1,   0], [2,   0], [3,   0]], // down
    [[0, 0], [1,  -1], [2,  -2], [3,  -3]], // down-left
    [[0, 0], [0,  -1], [0,  -2], [0,  -3]], // left
    [[0, 0], [-1, -1], [-2, -2], [-3, -3]], // up-left
];

error_reporting(E_ERROR);

while ($line = fgets(STDIN)) {
    $lineNumber++;
    $lineBuffer[] = $line;

    if (sizeof($lineBuffer) < 4) {
        continue;
    } 

    if (sizeof($lineBuffer) > 4) {
        $rowOffset++;
        array_shift($lineBuffer);
    }

    print_r($lineBuffer);
    checkMatch($lineBuffer, $count, $rowOffset, $matchesFound);
}

function checkMatch(&$lineBuffer, &$count, &$rowOffset, &$matchesFound) {
    for ($row = 0; $row < sizeof($lineBuffer); $row++) {
        for ($column = 0; $column < strlen($lineBuffer[$row]); $column++) {
            foreach (DIRECTIONS as $directionKey => $direction) {
                $actualRow = $row + $rowOffset;
                $index = "$actualRow-$column-$directionKey";

                
                if (!$matchesFound[$index] && isMatch($lineBuffer, $row, $column, $direction)) {
                    $count++;
                    
                    echo "Match found at $actualRow, $column, $directionKey \n";
                    $matchesFound[$index] = true;
                }
            }
        }
    }
}

function isMatch($lineBuffer, $row, $column, $positions) {
    $targetString = '';
    
    foreach ($positions as $offset) {
        $y = $row + $offset[0];
        $x = $column + $offset[1];

        if ($y < 0 || $y >= sizeof($lineBuffer) || $x < 0 || $x >= strlen($lineBuffer[$y])) {
            return false;
        }

        $targetString .= $lineBuffer[$y][$x];
    }

    return $targetString == 'XMAS';
}

echo "Total count: $count\n";
?>