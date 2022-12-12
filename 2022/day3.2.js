/*// https://adventofcode.com/2022/day/3

Example run:

kgwynn@CHGGZRQBK3:~/dev/advent-of-code/2022$ (main) node day3.2 < ../../advent-of-code-inputs/2022/day3.inputs.txt
ERROR: Failed to find a badge for group #101
2415

//*/

const debug = process.env.debug === '1' ? console.log : () => {}
const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false }) 

let priorityByChar = {}
let groupSize = 3, badgeIdentified = Math.pow(2, groupSize) - 1    //  0b111 === 7 

// Initialize priority map
for (let x = 97; x < 123; x++) {
    let priority = x - 96
    let char = String.fromCharCode(x)
    priorityByChar[char] = priority
}

for (let x = 65; x < 91; x++) {
    let priority = x - 38
    let char = String.fromCharCode(x)
    priorityByChar[char] = priority
}

debug(priorityByChar)

// i = iteration; g = group number
let i= 0, g = 1, sumOfPriorities = 0, groupItems = {}, groupBadge = ''

// When we're done with a group
let concludeGroup = () => {
    let groupBadgePriority = 0

    if (groupBadge === '') {
        console.error('ERROR: Failed to find a badge for group #%i', g)
    } else {
        groupBadgePriority = priorityByChar[groupBadge]
    }

    sumOfPriorities += groupBadgePriority

    debug('Finalizing group #%i; badge = %s; priority = %i', g, groupBadge, groupBadgePriority)
    
    // Reset
    groupItems = {}, groupBadge = ''
    ++g
}

let scan = (contents) => {
    let len = contents.length
    debug(contents)
    
    for (let x = 0; x < len; x++) {
        let char = contents[x]
        // Adds 1 for Elf 0 in group, 2 for Elf 1, 4 for Elf 2, etc.
        groupItems[char] |= Math.pow(2, i % groupSize)
        if (groupItems[char] === badgeIdentified) {
            groupBadge = char
            debug('Found badge! %s', groupBadge)
            break
        }
    }
}

reader.on('line', (line) => { 
    scan(line)
    ++i

    if (i > 0 && i % groupSize === 0) concludeGroup()
})

reader.on('close', () => {
    concludeGroup()
    console.log(sumOfPriorities)
})


