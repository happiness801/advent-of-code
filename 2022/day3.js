/*// https://adventofcode.com/2022/day/3

Tested to see if any lines contain more than one duplicate type:

    debug=1 node day3 < ../../advent-of-code-inputs/2022/day3.inputs.txt | grep "Line" | uniq | cut -d ' ' -f 2 | uniq -c
    (then examined output)

Example run:

kevin@SURFACEPRO7:~/dev/advent-of-code/2022$ (main) node day3 < ../../advent-of-code-inputs/2022/day3.inputs.txt
7766

//*/

const debug = process.env.debug === '1' ? console.log : () => {}
const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false }) 

let priorityByChar = {}
let lastOccurrence = {}

for (let x = 97; x < 123; x++) {
    let priority = x - 96
    let char = String.fromCharCode(x)
    priorityByChar[char] = priority
    lastOccurrence[char] = 0
}

for (let x = 65; x < 91; x++) {
    let priority = x - 38
    let char = String.fromCharCode(x)
    priorityByChar[char] = priority
    lastOccurrence[char] = 0
}

debug(priorityByChar)
debug(lastOccurrence)

let l = 0, sumOfPriorities = 0

let findDupes = (contents) => {
    let len = contents.length, half = len / 2
    debug(contents)
    
    for (let x = 0; x < len; x++) {
        let char = contents[x]
        if (x < half) lastOccurrence[char] = l
        else if (lastOccurrence[char] === l) {
            debug('Line %i, Duplicate found: %s, Priority: %i', l, char, priorityByChar[char])
            sumOfPriorities += priorityByChar[char]
            break; // we just identify the priority once per line
        }
    }
}

reader.on('line', (line) => { 
    ++l // increment # of line we're on
    findDupes(line)
})

reader.on('close', () => {
    console.log(sumOfPriorities)
})


