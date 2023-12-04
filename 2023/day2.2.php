<?php
/*// https://adventofcode.com/2023/day/2#part2

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) php day2.2.php < ../../advent-of-code-inputs/2023/day2.input.txt
53255

//*/

function parsePull(&$totals, $pull) {
    $parts = array();
    preg_match_all("/(?:(\d+) (\w+),?)/", $pull, $parts);
    //echo "PARSING: "; print_r($parts);
    for($i = 0; $i < count($parts[1]); $i++) {
        $count = intval($parts[1][$i]);
        $color = $parts[2][$i];
        if ($count > $totals[$color]) {
            $totals[$color] = $count;
        }
    }
}

function getPower($totals) {
    echo "getPower:";
    print_r($totals);
    $power = 0;
    foreach ($totals as $color => $max) {
        if ($max == 0) {
            return 0;
        }

        if ($power == 0) {
            $power = $max;
        } else {
            $power *= $max;
        }

    }

    return $power;
}

const LIMITS_FOR_COLOR = array("red" => 12, "green" => 13, "blue" => 14);

$sum_of_powers = 0;

while ($line = fgets(STDIN)) {
    $max_for_color = array("red" => 0, "blue" => 0, "green" => 0);
    $parts = array();
    preg_match("/Game (\d+): (.*)/", $line, $parts);
    [$all, $id, $pulls] = $parts;
    $id = intval($id);
    $pulls = explode('; ', $pulls);

    foreach($pulls as $pull) {
        // echo "PULL!: ";
        // print_r($pull);
        // echo "\n\n";
        parsePull($max_for_color, $pull);
    }

    //print_r($parts);
    //print_r($all);
    //print_r($id);
    // echo "PULLS:";
    // print_r($pulls);
    // echo "\n\n";
    // echo "max_for_color:";
    echo "Checking game ID $id:\n";
    $power = getPower($max_for_color);

    echo "Power = $power\n\n";
    $sum_of_powers += $power;
    //print_r($max_for_color);
}

echo "Sum of Powers: $sum_of_powers\n\n";

?>