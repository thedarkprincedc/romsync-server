const mongoose = require('mongoose');
const config = require('config');

// tells mongoose to use ES6 implementation of promises
mongoose.Promise = global.Promise;

mongoose.connect(config.mongodb.database, config.mongodb.options);
  
mongoose.connection
    .once('open', () => console.log('Connected! %s', config.mongo.database))
    .on('error', (error) => console.warn('Error: %s', error));

module.exports = mongoose;