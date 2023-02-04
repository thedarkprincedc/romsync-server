const config = require('config');

const whitelist = [
    {url: '/api/login(.*)'},
    {url: '/api/register'}
]

function getWhitelistByRegex(whitelist, url){
    const existInWhitelist = whitelist.map( (value) => new RegExp(value.url+'$'))
        .findIndex((v) => v.test(url))
    return existInWhitelist !== -1;
}

function isUrlWhitelisted(url, method){

    // console.log('>>%s',/${url}/.test('/api/login'))
    // //console.log('isUrlWhitelisted: %s', url,)
    // const found = whitelist.find((value) => value.url == url) || null
    // console.log(getWhitelistByRegex(whitelist, url))
    //console.log('isUrlWhitelisted: %s, %s --%s', url,found, (found) ? true : false)
    ///return (found) ? true : false;
    return getWhitelistByRegex(whitelist, url)
}

module.exports = {
    isUrlWhitelisted
}