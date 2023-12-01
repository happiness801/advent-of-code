/*// https://adventofcode.com/2022/day/12

NOTE: Need to fix infinite looping... how to not go where you've been before? :(

    - Map is 159x41



Example run:

//*/

const debug = process.env.debug === '1' ? console.log : () => {}
const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false }) 

let charToElevation = {}, maxClimb = 1, minX = 0, minY = 0, maxX = 0, maxY = 0, stepsToGoal = 9999999
const NORTH = 0, EAST = 1, SOUTH = 2, WEST = 3, MAXLOOPS = 1000000000, START = 'S', GOAL = 'E', CODE_OFFSET = 33, SEPARATOR = ' '

// Initialize priority map
for (let x = 97; x < 123; x++) {
    let elevation = x - 96
    let char = String.fromCharCode(x)
    charToElevation[char] = elevation
}

charToElevation['S'] = charToElevation['a']
charToElevation['E'] = charToElevation['z']

// FOR TESTING!
//charToElevation['E'] = 0

debug(charToElevation)

let toCode = (x, y) => {
    return code = String.fromCharCode(x + CODE_OFFSET) + String.fromCharCode(y + CODE_OFFSET) + SEPARATOR
}

let printableMap = () => {
    let printable = ''
    for (let row = 0; row < map.length; row++) {
        printable += map[row] + '\n'
    }
    return printable
}

let map = [], i = 0, x = 0, y = 0, path = ''

let step = (path, x, y, from) => {
    let currentElevation = charToElevation[map[y][x]]
    let maxStep = (currentElevation + maxClimb)
    let pointCode = toCode(x, y)

    if(path.indexOf(pointCode) !== -1) {
        return
    }

    debug('Path so far: %s', path)
    debug('Position %i, %i, elevation %s (%i)', x, y, map[y][x], currentElevation)

    if (map[y][x] === GOAL) {
        let steps = path.length / 3
        console.log('!!!GOAL!!! Path: %s, Steps: %i', path, steps)
        if (steps < stepsToGoal) {
            stepsToGoal = steps
            debug('New shortest path: %i steps', steps)
        }
        return
    }

    path += pointCode

    ///
    if (++i > MAXLOOPS) {
        debug('Aborting...')
        return
    }
    //*/

    // Try north
    if (from !== NORTH && y > minY && charToElevation[map[y-1][x]] <= maxStep) step(path, x, (y - 1), SOUTH)
    // Try east
    if (from !== EAST && x < maxX && charToElevation[map[y][x+1]] <= maxStep) step(path, (x + 1), y, WEST)
    // Try south
    if (from !== SOUTH && y < maxY && charToElevation[map[y+1][x]] <= maxStep) step(path, x, (y + 1), NORTH)
    // Tri west
    if (from !== WEST && x > minX && charToElevation[map[y][x-1]] <= maxStep) step(path, (x - 1), y, EAST)
}

reader.on('line', (line) => { 
    map.push(line)
})

reader.on('close', () => {
    debug(printableMap())
    
    maxY = map.length - 1
    maxX = map[0].length - 1
    const MAX_STEPS_TO_GOAL = (maxX + 1) * (maxY + 1)
    stepsToGoal = MAX_STEPS_TO_GOAL
    
    // Do logic now... 
    step(path, x, y)
    
    console.log('Total iterations: %i', i)

    if (stepsToGoal === MAX_STEPS_TO_GOAL) {
        console.log('No solution found, MAX_STEPS_TO_GOAL: %i', MAX_STEPS_TO_GOAL)
    } else {
        console.log(stepsToGoal)
    }
})


