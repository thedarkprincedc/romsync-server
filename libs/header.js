const figlet = require('figlet')
const package = require('../package.json')
const config = require('config')

function onServerStarted(server){
    const secure = server.host || false
    const secureText = (secure) ? 'https' : 'http';
   
    console.log('%s', figlet.textSync(package.name))
    console.log('Version: %s', package.version)
    console.log('Mode: %s', process.env.NODE_ENV || 'development')
    console.log(`Server listening on port %s! Go to %s://localhost:%s/`, server.port, secureText, server.port)
}

module.exports = {
    onServerStarted
};