/*// https://adventofcode.com/2022/day/1

Each line = # of calories per item
Elves' items separated by blank

Example run:

kevin@SURFACEPRO7:~/dev/advent-of-code/2022$ (main) node day1 < ../../advent-of-code-inputs/2022/day1.input.txt
71300

//*/

const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false }) 

let i = 0, c = 0, max = 0

let summarize = () => {
    max = (c > max) ? c : max
    i++
    c = 0
}

reader.on('line', (row) => { 
    if (row === '') {
        summarize()
        return
    }

    c += parseInt(row)
})

reader.on('close', () => {
    summarize()
    console.log(max)
})


