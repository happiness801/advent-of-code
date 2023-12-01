/*// https://adventofcode.com/2023/day/1

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) node day1.js < ../../advent-of-code-inputs/2023/day1.input.txt
53080


//*/

const debug = process.env.debug === '1' ? console.log : () => {}
const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false }) 

let sum = 0

reader.on('line', (line) => { 
    let result = line.replaceAll(/[^0-9]/g, '')
        .replace(/([0-9])[0-9]*([0-9])/, '$1$2')
        .replace(/^([0-9])$/, '$1$1')
    let calibrationValue = parseInt(result)

    sum += calibrationValue
    
    // console.log(result)
})

reader.on('close', () => {
    console.log(sum)
})

