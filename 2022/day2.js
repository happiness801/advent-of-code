/*// https://adventofcode.com/2022/day/2

A B C = ROCK, PAPER, SCISSORS (elf)
X Y Z = ROCK, PAPER, SCISSORS (me)
0 1 2 = Score for playing
0 3 6 = Score for LOSS, TIE, WIN

Run example:

kevin@SURFACEPRO7:~/dev/advent-of-code/2022$ (main) node day2 < ../../advent-of-code-inputs/2022/day2.input.txt
11603

//*/

const debug = process.env.debug === '1' ? console.log : () => {}
const ROCK = 'ROCK', PAPER = 'PAPER', SCISSORS = 'SCISSORS'
const LOSS = 'LOSS', TIE = 'TIE', WIN = 'WIN'

const elfMap = { 'A': ROCK, 'B': PAPER, 'C': SCISSORS }
const myMap = { 'X': ROCK, 'Y': PAPER, 'Z': SCISSORS }
const toWin = { ROCK: SCISSORS, SCISSORS: PAPER, PAPER: ROCK }
const scoreForPlay = { ROCK: 1, PAPER: 2, SCISSORS: 3 }
const scoreForResult = { LOSS: 0, TIE: 3, WIN: 6 }
let myScore = 0

let getResult = (me, them) => {
    if (me === them) { return TIE }
    else if (toWin[me] === them) { return WIN }
    else { return LOSS }
}

let getScore = (me, result) => {
    debug('scoreForPlay = %i for %s', scoreForPlay[me], me)
    debug('scoreForResult = %i for %s', scoreForResult[result], result)
    return scoreForPlay[me] + scoreForResult[result]
}

const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false })

reader.on('line', (input) => {
    // TODO: loop on inputs...
    let me = myMap[input[2]], them = elfMap[input[0]]
    debug('Elf plays %s, I play %s', them, me)
    let result = getResult(me, them)
    let score = getScore(me, result)
    debug('Result: %s, Score: %i', result, score)

    myScore += score
})

reader.on('close', () => {
    debug('done')
    // output result
    console.log(myScore)
})
