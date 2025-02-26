<?php
/*// https://adventofcode.com/2024/day/6#part2

Example run:

IDEA: if we ever return to the STARTING spot, facing the SAME DIRECTION, we can stop,
    because we will never leave the board.

php day6.2.php < ../../advent-of-code-inputs/2024/day6.input.txt

//*/

const GUARD_MARKER = '^';
const VISITED_MARKER = 'X';
const OBSTACLE = '#';
const DIRECTION_UP = '^';
const DIRECTION_RIGHT = '>';
const DIRECTION_DOWN = 'v';
const DIRECTION_LEFT = '<';
const DIRECTIONS = [DIRECTION_UP, DIRECTION_RIGHT, DIRECTION_DOWN, DIRECTION_LEFT];
$map = [];
$currentRow = 0;
$guardInitialRow = null;
$guardInitialColumn = null;
$distinctPositions = 0;
$turnCounter = 0;

while ($line = fgets(STDIN)) {
    $line = trim($line);
    $map[] = $line;

    $guardPosition = strpos($line, GUARD_MARKER);

    if ($guardPosition !== false) {
        $guardInitialColumn = $guardPosition;
        $guardInitialRow = $currentRow;
    }

    $currentRow++;
}

$currentRow = $guardInitialRow;
$currentColumn = $guardInitialColumn;

// Process guard movement
do {
    $currentDirection = DIRECTIONS[$turnCounter % 4];

    // detectCollision() detects collision and increments turn counter, 
    // but does not move the guard, so we only increment $distinctPositions
    // if there was no collision
    if (!detectCollision($currentRow, $currentColumn)) {
        if (outOfBounds($currentRow, $currentColumn)) {
            break;
        }
        
        if ($map[$currentRow][$currentColumn] !== VISITED_MARKER) {
            $map[$currentRow][$currentColumn] = VISITED_MARKER;
            $distinctPositions++;
        }
    }
} while (true);

function detectCollision($row, $column) {
    global $map, $turnCounter, $currentColumn, $currentRow; // ew. I know. I'm sorry.

    $currentDirection = DIRECTIONS[$turnCounter % 4];

    if ($currentDirection === DIRECTION_UP) {
        $row--;
    } elseif ($currentDirection === DIRECTION_RIGHT) {
        $column++;
    } elseif ($currentDirection === DIRECTION_DOWN) {
        $row++;
    } elseif ($currentDirection === DIRECTION_LEFT) {
        $column--;
    }

    // If we did not hit an obstacle, update positions
    if ($map[$row][$column] !== OBSTACLE) {
        $currentRow = $row;
        $currentColumn = $column;
        return;
    }

    // If we did hit an obstacle, we need to change direction
    $turnCounter++;
}

function outOfBounds($row, $column) {
    global $map; 

    if ($row < 0 || $column < 0 || $row >= count($map) || $column >= strlen($map[0])) {
        return true;
    }

    return false;
}

print_r($map);

echo "Guard initial position = ($guardInitialColumn, $guardInitialRow)\n";
echo "Distinct positions = $distinctPositions\n";

?>