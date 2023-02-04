const token = require('../token');
const config = require('config');
const whitelist = require('../whitelist');

function TokenBearerMiddleware(){
    return (req, res, next) => {
        const signedToken =  req.headers['x-token'];
        const {url, method} = req;
        
        if(whitelist.isUrlWhitelisted(url, method)){
            return next();
        }

        if(!signedToken){
            return res.sendStatus(401).json({ 
                error: "Token not found"
            });
        }

        const token = authorization.split(' ')[1];
        token.verify(token, accessTokenSecret, (err, user) => {
            if (err) {
                return res.sendStatus(403);
            }

            req.user = user;
            next();
        });
    };
}

function TokenCookieMiddleware(){
    return (req, res, next) => {
        const signedToken = req.cookies[config.jwt.cookieName];
        const {url, method} = req;

        if(whitelist.isUrlWhitelisted(url, method)){
            return next();
        }

        if(!signedToken){
            return res.status(401).json({ 
                error: "Token not found"
            })
        }
    
        token.verify(signedToken, (error, user) => {
            let user2;
            if(error){
                if(error.name !== 'TokenExpiredError'){
                    return res.status(401).json({name: error.name, error: error.message })
                }
                
                user2 = tokenCtrl.refreshToken(req, res, true);
            }
            req.user = user || user2
            return next();
        })
    };
}

module.exports = {
    TokenBearerMiddleware, 
    TokenCookieMiddleware
};