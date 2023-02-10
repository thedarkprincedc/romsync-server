const {sign, verify} = require('../token.js');

const whitelist = require('../whitelist');
const {validateCredentials, getUserDataByUsername} = require('../controllers/authorization.controller')
const config = require('config');

function convertFromBase64String(string){
    const credentials = Buffer.from(string, "base64").toString().split(':');
    return {
        username: credentials[0],
        password: credentials[1]
    }
}

// function TokenBearerMiddleware(){
//     return async (req, res, next) => {
//         const {authorization} = req.headers;
//         const credential = authorization.split(' ')[1]
//         const {username, password} = convertFromBase64String(credential);
//         const {url, method} = req;
//         let signedToken = null;
        
//         if(credential){

//             if(!validateCredentials(username, password)){
//                 return res.status(401).json({ message: 'Authentication failed. Invalid user or password.'});
//             }
//             const user = getUserDataByUsername(username)
//             const payload = {
//                 id: user.id,
//                 username: user.username,
//                 group: user.group,
//                 favorites: user.favorites
//             };
//             signedToken = sign(payload);
//         }

//         if(whitelist.isUrlWhitelisted(url, method)){
//             return next();
//         }

//         if(!signedToken){
//             return res.sendStatus(401).json({ 
//                 error: "Token not found"
//             });
//         }

//         const token = authorization.split(' ')[1];
//         token.verify(token, accessTokenSecret, (err, user) => {
//             if (err) {
//                 return res.sendStatus(403);
//             }

//             req.user = user;
//             next();
//         });
//     };
// }
function TokenBearerMiddleware(){
    return async (req, res, next) => {
        next();
    }
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
    
        verify(signedToken, (error, user) => {
            //let user2;
            if(error){
                if(error.name !== 'TokenExpiredError'){
                    return res.status(401).json({name: error.name, error: error.message })
                }
                
                //user2 = tokenCtrl.refreshToken(req, res, true);
            }
            //req.user = user || user2
            return next();
        })
    };
}

module.exports = {
    TokenBearerMiddleware, 
    TokenCookieMiddleware
};