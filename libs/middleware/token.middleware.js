const {sign, verify} = require('../token.js');

const {isUrlWhitelisted} = require('../whitelist');
const config = require('config');

function TokenMiddleware(){
    return (req, res, next) => {
        const token = req.headers['x-token'] || req.cookies[config.jwt.cookieName];
        const {url, method} = req;

        if(isUrlWhitelisted(url, method)){
            return next();
        }
        if(!token){
            return res.status(401).json({ 
                error: "Token not found"
            })
        }
        verify(token, (error, user) => {
            if(error){
                if(error.name !== 'TokenExpiredError'){
                    return res.status(401)
                        .json({name: error.name, error: error.message })
                }
            }
            return next();
        })
    };
}

module.exports = {
    TokenMiddleware
};