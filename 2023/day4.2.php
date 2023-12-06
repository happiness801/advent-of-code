<?php
/*// https://adventofcode.com/2023/day/4#part2

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) php day4.2.php < ../../advent-of-code-inputs/2023/day4.input.txt


//*/

//function debug($out) { echo $out; }
function debug($out) {}

function registerWins(&$cards, $card_id, $win_count) {
    debug("Register wins: $card_id had $win_count wins...\n");
    $copies_by_id = &$GLOBALS['copies_by_id'];
    
    for ($i = 1; $i <= $win_count; $i++) {
        $target_id = $card_id + $i;
        if (!$cards[$target_id]) break;
        debug("Creating a copy of card $target_id\n");
        $copies_by_id[$target_id]++;
        //debug("There are now " . $copies_by_id[$target_id] . " copies of card $target_id\n");
    }
}

$total_cards = 0;
$cards = [];
$copies_by_id = [];

while ($line = fgets(STDIN)) {
    $line = trim($line);

    $matches = [];
    if (preg_match("/Card +(\d+): (.*) \| (.*)$/", $line, $matches)) {
        $card_id = $matches[1];
        $winners_raw = $matches[2];
        $winners = preg_split("/ +/", $winners_raw);
        $pulls_raw = $matches[3];
        $pulls = preg_split("/ +/", $pulls_raw);
        $pulls = array_values(array_unique($pulls, SORT_STRING));
        
        $cards[$card_id] = array(
            "raw" => $line,
            "winners" => $winners,
            "pulls" => $pulls,
        );

        $copies_by_id[$card_id] = 1;
    }
}

foreach ($cards as $card_id => $card) {
    $pulls = $card['pulls'];
    $winners = $card['winners'];
    $win_count = 0;

    for ($i = 0; $i < count($pulls); $i++) {
        if (array_search($pulls[$i], $winners) !== false) {
            //debug("Sweet! " . $pulls[$i] . " is a winner!\n");
            $win_count++;
        }
    }

    debug("Card $card_id has " . $copies_by_id[$card_id] . " copies.\n");

    if ($win_count > 0) {
        debug("Card $card_id wins = $win_count\n\n");
    } else {
        debug("Card $card_id has 0 wins\n\n");
    }

    for ($i = 0; $i < $copies_by_id[$card_id]; $i++) {
        registerWins($cards, $card_id, $win_count);
    }
}

$total_cards = array_sum($copies_by_id);


echo "Total Cards: $total_cards\n\n";


?>