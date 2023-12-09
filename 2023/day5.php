<?php
/*// https://adventofcode.com/2023/day/5

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) php day5.php < ../../advent-of-code-inputs/2023/day5.input.txt
Lowest Location: 31599214


real    0m0.027s
user    0m0.013s
sys     0m0.013s

//*/

function debug($out) { echo $out; }
// function debug($out) {}

function getMatch(&$map, $target) {
    foreach ($map as $set) {
        $min = $set['source_range_start'];
        $max = $min +  $set['range_length'];

        if ($target >= $min && $target < $max) {
            $offset = $set['destination_range_start'] - $set['source_range_start'];
            debug("Found! $target between $min and $max, offset = $offset, returning " . ($target + $offset) . "\n");
            return $target + $offset;
        }
    }

    return $target;
}

$seeds = [];
$map = [];
$map_type = '';
$map_types = [
    'seed-to-soil',
    'soil-to-fertilizer',
    'fertilizer-to-water',
    'water-to-light',
    'light-to-temperature',
    'temperature-to-humidity',
    'humidity-to-location',
];

while ($line = fgets(STDIN)) {
    $line = trim($line);

    if (!$line) continue; // skip blank lines

    $matches = [];
    if (preg_match("/^seeds: *([\d ]+)/", $line, $matches)) {
        $seeds = preg_split("/ +/", $matches[1]);
    }
    else if (preg_match("/^([\w\-]+) *map:/", $line, $matches)) {
        $map_type = $matches[1];
        debug("Gathering info for $map_type...\n");
        $map[$map_type] = [];
    }
    else if (preg_match("/^(\d+) +(\d+) +(\d+)/", $line, $matches)) {
        $set = array(
            'destination_range_start' => intval($matches[1]),
            'source_range_start' => intval($matches[2]),
            'range_length' => intval($matches[3])
        );

        array_push($map[$map_type], $set);
    }
}


$lowest_location = 9999999999;

foreach ($seeds as $seed) {
    $target = intval($seed);
    foreach ($map_types as $map_type) {
        $result = getMatch($map[$map_type], $target);
        debug("Seed $seed: $map_type: Got $result for $target\n");
        $target = $result;
    }

    $lowest_location = ($result < $lowest_location) ? $result : $lowest_location;
    debug("Location: $result\n");
}

echo "Lowest Location: $lowest_location\n\n";

?>