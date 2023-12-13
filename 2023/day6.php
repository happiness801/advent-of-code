<?php
/*// https://adventofcode.com/2023/day/6

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) time php day6.php < ../../advent-of-code-inputs/2023/day6.input.txt
Total: 2344708


real    0m0.026s
user    0m0.008s
sys     0m0.018s

//*/

function debug($out) { echo $out; }
// function debug($out) {}

$race_data = [];

function countWaysToWin($record_time, $record_distance) {
    $count = 0;

    debug("Ways to win: Time: $record_time, Distance: $record_distance...\n");

    for ($hold_time = 0; $hold_time < $record_time; $hold_time++) {
        $speed = $hold_time;
        $remaining_time = $record_time - $hold_time;
        $race_distance = ($speed * $remaining_time);

        debug("Speed: $speed, Remaining Time: $remaining_time, Distance: $race_distance");

        if ($race_distance > $record_distance) {
            $count++;
            debug("✅");
        } else {
            debug("❌");
        }

        debug("\n");
    }

    debug("Found $count ways to win\n\n");

    return $count;
}

while ($line = fgets(STDIN)) {
    $line = trim($line);

    if (!$line) continue; // skip blank lines

    $matches = [];
    if (preg_match("/^(Time|Distance): *([0-9 ]+)$/", $line, $matches)) {
        $data_type = $matches[1];
        $race_data[$data_type] = preg_split("/\s+/", $matches[2]);
    }
}

$total = 1;

for ($i = 0; $i < count($race_data['Time']); $i++) {
    $ways_to_win = countWaysToWin($race_data['Time'][$i], $race_data['Distance'][$i]);

    $total *= $ways_to_win;
}

echo "Total: $total\n\n";


?>