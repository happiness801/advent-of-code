<?php
/*// https://adventofcode.com/2024/day/5

Example run:

php day5.php < ../../advent-of-code-inputs/2024/day5.input.txt

//*/

$sum = 0;
$rules = [];
$updates = [];
$updateMode = false;

while ($line = fgets(STDIN)) {
    $line = trim($line);

    if (!$line) {
        $updateMode = true;
        continue;
    }

    if ($updateMode) {
        $result = checkValidUpdate($line, $rules);

        if ($result) {
            echo "Valid update; middle value = $result\n";
            $sum += $result;
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

}

function checkValidUpdate(&$updateLine, &$rules) {
    $pageNumbers = explode(',', $updateLine);
    echo "Checking: $updateLine\n";
    for ($a = sizeof($pageNumbers) - 1; $a >= 1; $a--) {
        $pageNumbers[$a] = intval($pageNumbers[$a]);
        for ($b = $a - 1; $b >= 0; $b--) {
            $pageNumbers[$b] = intval($pageNumbers[$b]);

            if (!array_key_exists($pageNumbers[$a], $rules)) {
                continue;
            }

            $relevantRules = $rules[$pageNumbers[$a]];

            if (is_array($relevantRules) && in_array($pageNumbers[$b], $relevantRules)) {
                echo "Uh oh! : $pageNumbers[$a] came after $pageNumbers[$b]\n";
                return false;
            }
        }
    }

    $middleKey = floor(sizeof($pageNumbers) / 2);

    return $pageNumbers[$middleKey];
}

echo "Total sum: $sum\n";

?>