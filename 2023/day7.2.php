<?php
/*// https://adventofcode.com/2023/day/7#part2

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) time php day7.2.php < ../../advent-of-code-inputs/2023/day7.input.txt

Total Winnings: 253910319


real    0m0.073s
user    0m0.032s
sys     0m0.042s

//*/

function debug($out) { echo $out; }
// function debug($out) {}

$hands = [];

$cards = ['J', 2, 3, 4, 5, 6, 7, 8, 9, 'T', 'Q', 'K', 'A'];

const FIVE_OF_A_KIND  = 'five-of-a-kind',
      FOUR_OF_A_KIND  = 'four-of-a-kind',
      FULL_HOUSE      = 'full-house',
      THREE_OF_A_KIND = 'three-of-a-kind',
      TWO_PAIR        = 'two-pair',
      ONE_PAIR        = 'one-pair',
      HIGH_CARD       = 'high-card';


$hand_types = [
    FIVE_OF_A_KIND => [
        'value' => 7000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{4}/", $hand)) {
                debug("Five of a Kind! $hand\n");
                return true;
            }

            return false;
        }
    ],
    FOUR_OF_A_KIND => [
        'value' => 6000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{3}/", $hand)) {
                debug("Four of a Kind! $hand\n");
                return true;
            }

            return false;
        }
    ],
    FULL_HOUSE => [
        'value' => 5000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{2}(.)\g{2}{1}/", $hand) || preg_match("/(.)\g{1}{1}(.)\g{2}{2}/", $hand)) {
                debug("Full House! $hand\n");
                return true;
            }
            
            return false;
        }
    ],
    THREE_OF_A_KIND => [
        'value' => 4000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{2}/", $hand)) {
                debug("Three of a Kind! $hand\n");
                return true;
            }
            
            return false;
        }
    ],
    TWO_PAIR => [
        'value' => 3000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{1}.?(.)\g{2}{1}/", $hand)) {
                debug("Two Pair! $hand\n");
                return true;
            }
            
            return false;
        }
    ],
    ONE_PAIR => [
        'value' => 2000000,
        'test' => function($hand) {
            if (preg_match("/(.)\g{1}{1}/", $hand)) {
                debug("One Pair! $hand\n");
                return true;
            }
            
            return false;
        }
    ],
    HIGH_CARD => [
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
        $place_value = pow(count($cards) + 1, $i) * (array_search($hand[$i], $cards) + 1);
        $value += $place_value;
    }

    return $value;
}

function getHandValueWithWilds($type, $wilds_count) {
    global $hand_types;

    if ($wilds_count == 0) return $hand_types[$type]['value'];

    // cases where wilds upgrade the hand type
    switch(true) {
        case ($type == FOUR_OF_A_KIND && $wilds_count >= 1):  return $hand_types[FIVE_OF_A_KIND]['value'];
        case ($type == THREE_OF_A_KIND && $wilds_count == 2): return $hand_types[FIVE_OF_A_KIND]['value'];
        case ($type == ONE_PAIR && $wilds_count == 3):        return $hand_types[FIVE_OF_A_KIND]['value'];
        case ($wilds_count >= 4):                             return $hand_types[FIVE_OF_A_KIND]['value'];
        case ($type == THREE_OF_A_KIND && $wilds_count == 1): return $hand_types[FOUR_OF_A_KIND]['value'];
        case ($type == ONE_PAIR && $wilds_count == 2):        return $hand_types[FOUR_OF_A_KIND]['value'];
        case ($wilds_count >= 3):                             return $hand_types[FOUR_OF_A_KIND]['value'];
        case ($type == TWO_PAIR && $wilds_count == 1):        return $hand_types[FULL_HOUSE]['value'];
        case ($type == ONE_PAIR && $wilds_count == 1):        return $hand_types[THREE_OF_A_KIND]['value'];
        case ($wilds_count >= 2):                             return $hand_types[THREE_OF_A_KIND]['value'];
        case ($type == HIGH_CARD && $wilds_count == 1):       return $hand_types[ONE_PAIR]['value'];
    }
}

function getHandValue($hand) {
    global $hand_types;
    $value = 0;

    foreach ($hand_types as $type => $details) {
        $sorted_hand = preg_replace("/(J+)/", '', getSortedHand($hand));
        $wilds_count = 5 - strlen($sorted_hand);
        
        if ($details['test']($sorted_hand)) {
            $value = getHandValueWithWilds($type, $wilds_count);
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
    debug("Rank " . $hands[$all_values[$i]]['rank'] . ": " . $hands[$all_values[$i]]['hand'] . "\n");
}

$total_winnings = 0;

foreach ($hands as $hand) {
    $total_winnings += $hand['rank'] * $hand['bid'];
}

echo "\n\nTotal Winnings: $total_winnings\n\n";

?>