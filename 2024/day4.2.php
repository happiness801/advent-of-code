<?php
/*// https://adventofcode.com/2024/day/4#part2

Example run:

php day4.2.php < ../../advent-of-code-inputs/2024/day4.input.txt

//*/

$count = 0;
$lineNumber = 0;
$rowOffset = 0;
$lineBuffer = [];
const VALID_STRINGS = ['MMASS', 'MSAMS', 'SSAMM', 'SMASM'];

error_reporting(E_ERROR);

while ($line = fgets(STDIN)) {
    $lineNumber++;
    $lineBuffer[] = trim($line);

    if (sizeof($lineBuffer) < 3) {
        continue;
    } 

    if (sizeof($lineBuffer) > 3) {
        $rowOffset++;
        array_shift($lineBuffer);
    }

    print_r($lineBuffer);
    checkMatch($lineBuffer, $count, $rowOffset);
}

function checkMatch(&$lineBuffer, &$count, &$rowOffset) {
    for ($column = 1; $column < strlen($lineBuffer[1]) - 1; $column++) {
        if ($lineBuffer[1][$column] != 'A') {
            continue;
        }

        $actualRow = $row + $rowOffset;
        $stringToCheck = $lineBuffer[0][$column - 1] 
            . $lineBuffer[0][$column + 1] 
            . $lineBuffer[1][$column] 
            . $lineBuffer[2][$column - 1] 
            . $lineBuffer[2][$column + 1];
                         
        if (isMatch($stringToCheck)) {
            $count++;
            
            echo "Match found at $actualRow, $column, $directionKey \n";
        }
    }
}

function isMatch($stringToCheck) {
    echo "Checking $stringToCheck\n";

    return in_array($stringToCheck, VALID_STRINGS);
}

echo "Total count: $count\n";
?>