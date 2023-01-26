const config = require('config')
const { faker } = require('@faker-js/faker');
const fs = require('fs')
const path = require('path')
let games = [];
let users = [];

for(let i = 0; i < 10; i++){
    const user = {
        username: faker.internet.userName(),
        password: faker.internet.password(),
        groups: [
            'users',
            'administrator'
        ],
        favorites: []
    };
    users.push(user)
}
const years = [
  1973, 1974, 1975, 1976, 1977, 1978,
  1979, 1980, 1981, 1982, 1983, 1984,
  1985, 1986, 1987, 1988, 1989, 1990,
  1991, 1992, 1993, 1994, 1995, 1996,
  1997, 1998, 1999, 2000, 2001, 2002,
  2003, 2004, 2005, 2006, 2007, 2008,
  2009, 2010, 2011, 2012
]
const systems = [
    'Arcade', 
    'Sega Genesis', 
    'Super Nintendo Entertainment System',
    'Nintendo Nintendo Entertainment System',
    'Sega Master System',
    'Neo Geo'
]
const manufacturers = [
    'Sega', 'Capcom', 'EA'
]

for(let i = 0; i < 25; i++){
    const game = {
        id: faker.datatype.uuid(),
        name: faker.vehicle.vehicle(),
        filename: faker.music.genre(),
        manufacturer: faker.helpers.arrayElement(manufacturers),
        system: faker.helpers.arrayElement(systems),
        year: faker.helpers.arrayElement(years),
        cloneof: 443
    }
    games.push(game)
}

console.log(users)
console.log(games)

const dir = path.join(__dirname, '/../temp')

if (!fs.existsSync(dir)){
    fs.mkdirSync(dir)
}
fs.writeFileSync(dir + '/users.json', JSON.stringify(users, null, 2))
fs.writeFileSync(dir + '/games.json', JSON.stringify(games, null, 2))

