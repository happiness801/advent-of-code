<?php
/*// https://adventofcode.com/2024/day/5#part2

Example run:

php day5.2.php < ../../advent-of-code-inputs/2024/day5.input.txt

//*/

$sum = 0;
$rules = [];
$updates = [];
$updateMode = false;

while ($line = fgets(STDIN)) {
    $line = trim($line);
    $needsFix = false;

    if (!$line) {
        $updateMode = true;
        continue;
    }

    if ($updateMode) {
        $pages = explode(',', $line);

        while ($swap = getInvalidPageIndex($pages, $rules)) {
            $needsFix = true;
            echo "Update needs to be fixed... Swapping indexes " . $swap[0] . " and " . $swap[1] . "\n";
            swapPages($swap, $pages);
        }
    } else {
        $matches = [];
        preg_match('/([0-9]+)\|([0-9]+)/', $line, $matches);

        $matches[1] = intval($matches[1]);
        $matches[2] = intval($matches[2]);

        if (!array_key_exists($matches[1], $rules)) {
            $rules[$matches[1]] = [];
        }

        $rules[$matches[1]][] = $matches[2];
    }

    if ($needsFix) {
        $middleIndex = intval(sizeof($pages) / 2);
        $sum += $pages[$middleIndex];
    }
}

function getInvalidPageIndex(&$pages, &$rules) {
    echo "Checking: " . implode(',', $pages) . "\n";
    for ($a = sizeof($pages) - 1; $a >= 1; $a--) {
        $pages[$a] = intval($pages[$a]);
        for ($b = $a - 1; $b >= 0; $b--) {
            $pages[$b] = intval($pages[$b]);

            if (!array_key_exists($pages[$a], $rules)) {
                continue;
            }

            $relevantRules = $rules[$pages[$a]];

            if (is_array($relevantRules) && in_array($pages[$b], $relevantRules)) {
                return [$a, $b];
            }
        }
    }

    return false;
}

function swapPages(&$swap, &$pages) {
    [$a, $b] = $swap;
    $temp = $pages[$a];
    $pages[$a] = $pages[$b];
    $pages[$b] = $temp;
}

echo "Total sum: $sum\n";

?>