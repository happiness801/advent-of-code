/*// https://adventofcode.com/2022/day/12

NOTE: Need to fix infinite looping... how to not go where you've been before? :(

Example run:

//*/

const debug = process.env.debug === '1' ? console.log : () => {}
const fs = require('fs'), rl = require('readline')
const reader = rl.createInterface({ input: process.stdin, output: process.stdout, terminal: false }) 

let charToElevation = {}, maxClimb = 1, minX = 0, minY = 0, maxX = 0, maxY = 0
const NORTH = 0, EAST = 1, SOUTH = 2, WEST = 3, MAXSTEPS = 10000, START = 'S', GOAL = 'E'

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

    debug('Path so far: %s', path)
    debug('Position %i, %i, elevation %s (%i)', x, y, map[y][x], currentElevation)

    if (map[y][x] === GOAL) {
        console.log('!!!GOAL!!! Path: %s, Steps: %i', path, path.length)
        return
    }

    if (++i > MAXSTEPS) {
        debug('Aborting...')
        return
    }

    // Try north
    if (from !== NORTH && y > minY && charToElevation[map[y-1][x]] <= maxStep) step(path + '^', x, (y - 1), SOUTH)
    // Try east
    if (from !== EAST && x < maxX && charToElevation[map[y][x+1]] <= maxStep) step(path + '>', (x + 1), y, WEST)
    // Try south
    if (from !== SOUTH && y < maxY && charToElevation[map[y+1][x]] <= maxStep) step(path + 'V', x, (y + 1), NORTH)
    // Tri west
    if (from !== WEST && x > minX && charToElevation[map[y][x-1]] <= maxStep) step(path + '<', (x - 1), y, EAST)
}

reader.on('line', (line) => { 
    map[i++] = line
})

reader.on('close', () => {
    debug(printableMap())

    maxY = map.length - 1
    maxX = map[0].length - 1
    
    // Do logic now... 
    step(path, x, y)
})



