/*// https://adventofcode.com/2022/day/2

A B C = ROCK, PAPER, SCISSORS
X Y Z = ROCK, PAPER, SCISSORS
0 1 2 = Score for playing
0 3 6 = Score for LOSS, TIE, WIN

//*/

const ROCK = 'ROCK', PAPER = 'PAPER', SCISSORS = 'SCISSORS'
const LOSS = 'LOSS', TIE = 'TIE', WIN = 'WIN'

const elfMap = { 'A': ROCK, 'B': PAPER, 'C': SCISSORS }
const myMap = { 'X': ROCK, 'Y': PAPER, 'Z': SCISSORS }
const toWin = { ROCK: SCISSORS, SCISSORS: PAPER, PAPER: ROCK }
const scoreForPlay = { ROCK: 1, PAPER: 2, SCISSORS: 3 }
const scoreForResult = { LOSS: 0, TIE: 3, WIN: 6 }

let getResult = (me, them) => {
    if (me === them) { return TIE }
    else if (toWin[me] === them) { return WIN }
    else { return LOSS }
}

let getScore = (me, result) => {
    console.log('scoreForPlay = %i for %s', scoreForPlay[me], me)
    console.log('scoreForResult = %i for %s', scoreForResult[result], result)
    return scoreForPlay[me] + scoreForResult[result]
}

// loop on inputs...

let input = 'C Z'
let me = myMap[input[2]], them = elfMap[input[0]]
let result = getResult(me, them)
let score = getScore(me, result)

console.log('They play %s, I play %s', me, them)
console.log('Result: %s, Score: %i', result, score)
