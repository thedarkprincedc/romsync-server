const figlet = require('figlet')
const package = require('../package.json')

function showBanner(){
    const bannerName = figlet.textSync(package.name);
   
    console.log('%s\nVersion: %s', bannerName, package.version)
    console.log('Mode: %s', process.env.NODE_ENV)
}

module.exports = {
    showBanner
};