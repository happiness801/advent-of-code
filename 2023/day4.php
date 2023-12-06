<?php
/*// https://adventofcode.com/2023/day/4

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) php day4.php < ../../advent-of-code-inputs/2023/day4.input.txt


//*/

function debug($out) { echo $out; }
// function debug($out) {}

$total_points = 0;

while ($line = fgets(STDIN)) {
    $line = trim($line);

    $win_count = 0;
    $card_points = 0;

    $matches = [];
    if (preg_match("/Card +(\d+): (.*) \| (.*)$/", $line, $matches)) {
        $card_id = $matches[1];
        $winners_raw = $matches[2];
        $winners = preg_split("/ +/", $winners_raw);
        $pulls_raw = $matches[3];
        $pulls = preg_split("/ +/", $pulls_raw);
        $pulls = array_values(array_unique($pulls, SORT_STRING));
        
        debug("Card $card_id, winners = ($winners_raw), pulls = ($pulls_raw)\n");

        for ($i = 0; $i < count($pulls); $i++) {
            if (array_search($pulls[$i], $winners) !== false) {
                debug("Sweet! " . $pulls[$i] . " is a winner!\n");
                $win_count++;
            }
        }
    }

    if ($win_count > 0) {
        $card_points = pow(2, $win_count - 1);
        debug("Card $card_id points = $card_points\n\n");
    } else {
        debug("Card $card_id gets 0 points\n\n");
    }

    $total_points += $card_points;
}

echo "Total Points: $total_points\n\n";


?>