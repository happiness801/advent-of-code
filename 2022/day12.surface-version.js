/*// https://adventofcode.com/2022/day/12

NOTE: Need to fix infinite looping... how to not go where you've been before? :(

    - Map is 159x41



Example run:

//*/

const debug = process.env.debug === '1' ? console.log : () => {}
const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false }) 

let charToElevation = {}, maxClimb = 1, 
    x = -1, y = -1,
    minX = 0, minY = 0, maxX = 0, maxY = 0, 
    goalX = -1, goalY = -1, stepsToGoal = 999999
const NORTH = 0, EAST = 1, SOUTH = 2, WEST = 3, MAXSTEPS = 10000, START = 'S', GOAL = 'E', CODE_OFFSET = 33, SEPARATOR = ' '

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

let scanTargets = (line) => {
    if (x === -1) { x = line.indexOf(START); y = map.length - 1 }
    if (goalX === -1) { goalX = line.indexOf(GOAL); goalY = map.length - 1 }
}

let map = [], i = 0, path = ''

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

    if (++i > MAXSTEPS) {
        debug('Aborting...')
        return
    }

    // Try north
    
    // Try east
    
    // Try south
    
    // Tri west
    
}

let smartMove = (from, x, y, path) => {
    let xDiff = goalX - x, yDiff = goalY - y
    let steps = []

    if (xDiff > 0 && Math.abs(xDiff) > Math.abs(yDiff))
}

let goNorth = (from, x, y, path) => { if (from !== NORTH && y > minY && charToElevation[map[y-1][x]] <= maxStep) step(path, x, (y - 1), SOUTH) }
let goEast = (from, x, y, path) => { if (from !== EAST && x < maxX && charToElevation[map[y][x+1]] <= maxStep) step(path, (x + 1), y, WEST) } 
let goSouth = (from, x, y, path) => { if (from !== SOUTH && y < maxY && charToElevation[map[y+1][x]] <= maxStep) step(path, x, (y + 1), NORTH) }
let goWest = (from, x, y, path) => { if (from !== WEST && x > minX && charToElevation[map[y][x-1]] <= maxStep) step(path, (x - 1), y, EAST) }

reader.on('line', (line) => { 
    map[i++] = line
    scanTargets(line)
})

reader.on('close', () => {
    debug(printableMap())
    debug('Start: %i, %i', x, y)
    debug('Goal: %i, %i', goalX, goalY)
    
    maxY = map.length - 1
    maxX = map[0].length - 1
    
    // Do logic now... 
    step(path, x, y)
    
    debug('Total iterations: %i', i)
    console.log(stepsToGoal)
})
