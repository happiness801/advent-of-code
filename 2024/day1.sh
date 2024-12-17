#!/bin/bash
# https://adventofcode.com/2024/day/1

# Example run:

FILENAME=$1

if [ -z "$FILENAME" ]; then
    FILENAME='../../advent-of-code-inputs/2024/day1.input.txt'
fi

tr -s ' ' < $FILENAME > day1.normalized.txt
cut -d ' ' -f 1 < day1.normalized.txt > day1.left.txt
cut -d ' ' -f 2 < day1.normalized.txt > day1.right.txt
sort day1.left.txt > day1.left.sorted.txt
sort day1.right.txt > day1.right.sorted.txt
paste day1.left.sorted.txt day1.right.sorted.txt > day1.sorted.txt
awk '{ sum += ($1 > $2) ? $1 - $2 : $2 - $1 } END { print sum }' < day1.sorted.txt

rm day1.left*.txt day1.right*.txt day1.sorted.txt day1.normalized.txt
