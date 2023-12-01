/*// https://adventofcode.com/2023/day/1#part2

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2023$ (main) node day1.2.js < ../../advent-of-code-inputs/2023/day1.input.txt
53255


//*/

const debug = process.env.debug === '1' ? console.log : () => {}
const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false }) 

let reverseString = function(string) {
    return string.split('').reverse().join('')
}

let reverseMap = function(map) {
    let newMap = {}
    for (let [key, value] of Object.entries(map)) {
        newMap[reverseString(key)] = value
    }
    return newMap
}

let sum = 0

let map = { one:1, two:2, three:3, four:4, five:5, six:6, seven:7, eight:8, nine:9 }
let mapBackward = reverseMap(map)
//console.log(map)
//console.log(mapBackward)
let search = /(one|two|three|four|five|six|seven|eight|nine)/
let searchBackward = /(enin|thgie|neves|xis|evif|ruof|eerht|owt|eno)/

reader.on('line', (line) => { 
    let match
    if (match = line.match(search)) {
        //console.log(`match = ${match[1]}`)
        line = line.replace(match[1], `${map[match[1]]}${match[1]}`)
        //console.log(line)
    }
    
    line = reverseString(line)
    //console.log(line)
    
    if (match = line.match(searchBackward)) {
        //console.log(`match = ${match[1]}`)
        line = line.replace(match[1], `${mapBackward[match[1]]}${match[1]}`)
        //console.log(line)
    }

    line = reverseString(line)

    //console.log(line)

    let result = line.replaceAll(/[^0-9]/g, '')
        .replace(/([0-9])[0-9]*([0-9])/, '$1$2')
        .replace(/^([0-9])$/, '$1$1')
    console.log(`${line} = ${result}`)
    
    let calibrationValue = parseInt(result)
    sum += calibrationValue
    
})

reader.on('close', () => {
    console.log(sum)
})

