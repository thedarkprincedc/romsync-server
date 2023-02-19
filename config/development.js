const fs = require('fs');

const options = {
    server: {
        port: process.env.ROMSYNC_PORT || 3000,
        certificates: {
            key: fs.readFileSync('./certs/publicKey.pem'),
            privateKey: fs.readFileSync('./certs/privateKey.pem'),
            certificate: fs.readFileSync('./certs/certificate.pem')
        },
    },
    jwt: {
        cookieName: 'romsync-dev',
        //mode: 'cookie', //session
        options: {
            //secure: false,
            //sameSite: true,
            algorithm: 'RS256',
            expiresIn: '1d'
        }
    },
    mongodb: {
        database: process.env.MONGO_DATABASE || 'mongodb://localhost:27017/romsync-dev',
        options: {
            useNewUrlParser: true,
            useUnifiedTopology: true,
            authSource: "admin",
            user: process.env.MONGO_USERNAME || 'root',
            pass: process.env.MONGO_PASSWORD || 'rootpassword',
        },
        strictQuery: true
    },
    youtube: {
        apiKey: process.env.YOUTUBE_APIKEY || 'AIzaSyBp2jfEZIR_Q52wgKCGJrIcL_YBVMzV65k'
    },
    sentry: {
        dsn: process.env.SENTRY_DSN,
        debug: true,
        environment: 'development'
    }
};

module.exports = options;