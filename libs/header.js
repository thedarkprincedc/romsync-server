const figlet = require('figlet')
const package = require('../package.json')

function showBanner(){
    const bannerName = figlet.textSync(package.name);
    console.log('%s\nVersion: %s', bannerName, package.version)
}

module.exports = {
    showBanner
};