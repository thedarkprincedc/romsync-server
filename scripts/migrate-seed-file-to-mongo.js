const mongoose = require('mongoose');
const Users =  require('../libs/models/users.model')
const Games =  require('../libs/models/games.model')
const seedUsers = require('../temp/users.json')
const seedGames = require('../temp/games.json');
const config = require('config')

console.log(config)

mongoose.set('strictQuery', config.mongodb.strictQuery || false);
mongoose.connect(config.mongodb.database, config.mongodb.options)
    .then(() => console.log('Mongo connection open!!'))
    .catch((error) => console.log(error))

async function seedDB(){
    await Users.deleteMany({});
    await Users.insertMany(seedUsers)
    await Games.deleteMany({})
    await Games.insertMany(seedGames)
};

seedDB().then(()=>{
    mongoose.connection.close()
})