/*// https://adventofcode.com/2022/day/1

Each line = # of calories per item
Elves' items separated by blank

Example run:

kevin@SURFACEPRO7:~/dev/advent-of-code/2022$ (main) node day1.2 < ../../advent-of-code-inputs/2022/day1.input.txt
209691

//*/

const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false }) 

let i = 0, c = 0, tops = [0, 0, 0]

let summarize = () => {
    checkTops(c)
    i++
    c = 0
}

let checkTops = (c) => {
    for (let x = 0; x < 3; x++) {
        if (c > tops[x]) {
            tops.splice(x, 0, c)
            tops = tops.slice(0, 3)
            return;
        }
    }
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
    let sum = tops.reduce((acc, cv) => acc + cv, 0 )
    console.log(sum)
})