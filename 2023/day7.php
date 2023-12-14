<?php
/*// https://adventofcode.com/2023/day/7

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) time php day7.php < ../../advent-of-code-inputs/2023/day7.input.txt

Total Winnings: 253910319


real    0m0.073s
user    0m0.032s
sys     0m0.042s

//*/

function debug($out) { echo $out; }
// function debug($out) {}

$hands = [];

$cards = [2, 3, 4, 5, 6, 7, 8, 9, 'T', 'J', 'Q', 'K', 'A'];

$hand_types = [
    'five-of-a-kind' => [
        'value' => 7000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{4}/", $hand)) {
                debug("Five of a Kind! $hand\n");
                return true;
            }

            return false;
        }
    ],
    'four-of-a-kind' => [
        'value' => 6000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{3}/", $hand)) {
                debug("Four of a Kind! $hand\n");
                return true;
            }

            return false;
        }
    ],
    'full-house' => [
        'value' => 5000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{2}(.)\g{2}{1}/", $hand) || preg_match("/(.)\g{1}{1}(.)\g{2}{2}/", $hand)) {
                debug("Full House! $hand\n");
                return true;
            }
            
            return false;
        }
    ],
    'three-of-a-kind' => [
        'value' => 4000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{2}/", $hand)) {
                debug("Three of a Kind! $hand\n");
                return true;
            }
            
            return false;
        }
    ],
    'two-pair' => [
        'value' => 3000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{1}.?(.)\g{2}{1}/", $hand)) {
                debug("Two Pair! $hand\n");
                return true;
            }
            
            return false;
        }
    ],
    'one-pair' => [
        'value' => 2000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{1}/", $hand)) {
                debug("One Pair! $hand\n");
                return true;
            }
            
            return false;
        }
    ],
    'high-card' => [
        'value' => 1000000,
        'test' => function($hand) {
            return true;
        }
    ],
];

function getSortedHand($hand) {
    $cards = str_split($hand);
    sort($cards);
    $hand = implode('', $cards);
    //debug("Sorted hand: $hand\n");
    return $hand;
}

function getHandStrength($hand) {
    global $cards;

    $hand = strrev($hand); // reverse the hand so highest "power" is the first card, etc.

    $value = 0;

    for ($i = 0; $i < strlen($hand); $i++) {
        $place_value = pow(count($cards), $i) * array_search($hand[$i], $cards);
        $value += $place_value;
    }

    return $value;
}

function getHandValue($hand) {
    global $hand_types;
    $value = 0;

    foreach ($hand_types as $type => $details) {
        if ($details['test'](getSortedHand($hand))) {
            $value = $details['value'];
            break;
        }
    }

    $value += getHandStrength($hand);

    return $value;
}

while ($line = fgets(STDIN)) {
    $line = trim($line);

    if (!$line) continue; // skip blank lines

    $input = preg_split("/\s+/", $line);

    $hand = $input[0];
    $bid = $input[1];
    
    $value = getHandValue($hand);

    $hands[$value] = ['hand' => $hand, 'bid' => $bid];

    debug("Hand: $hand, Bid: $bid, Value: $value\n\n");
}

$all_values = array_keys($hands);
sort($all_values);

for ($i = 0; $i < count($all_values); $i++) {
    $hands[$all_values[$i]]['rank'] = $i + 1;
}

$total_winnings = 0;

foreach ($hands as $hand) {
    $total_winnings += $hand['rank'] * $hand['bid'];
}

echo "\n\nTotal Winnings: $total_winnings\n\n";

?>