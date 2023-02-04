const jwt = require('jsonwebtoken');
const ms = require('ms')
const _ = require('lodash')
const config = require('config');

module.exports = {
    sign,
    verify,
    decode,
    isInCookieMode,
    isInSessionMode
}

function sign(payload){
    return jwt.sign(payload, config.server.certificates.privateKey, config.jwt.options)
}

function verify(token, callback){
    return jwt.verify(token, config.server.certificates.key, config.jwt.options, callback)
}

function decode(token){
    return jwt.decode(token, config.server.certificates.key, config.jwt.options)
}

function isInCookieMode(){
    return config.jwt.mode == 'cookie';
}

function isInSessionMode(){
    return config.jwt.mode == 'session';
}