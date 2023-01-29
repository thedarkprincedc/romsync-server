const jwt = require('jsonwebtoken');
const ms = require('ms')
const _ = require('lodash')
const config = require('config');

module.exports = {
    sign,
    verify,
    decode
}

function sign(payload){
    return jwt.sign(payload, config.server.certificates.key, jwtConfig.token)
}

function verify(token, callback){
    return jwt.verify(token, config.server.certificates.cert, jwtConfig.token, callback)
}

function decode(token){
    return jwt.decode(token, config.server.certificates.cert, jwtConfig.token)
}