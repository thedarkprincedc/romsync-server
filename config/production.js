const fs = require('fs');

const options = {
    server: {
        port: process.env.ROMSYNC_PORT || 3000,
        certificates: {
            key: fs.readFileSync('./certs/publicKey.pem'),
            privateKey: fs.readFileSync('./certs/privateKey.pem'),
            certificate: fs.readFileSync('./certs/certificate.pem')
        }
    },
    jwt: {
        cookieName: 'romsync-prod',
        token: {
            secure: true,
            algorithm: 'RS256',
            expiresIn: '1d'
        }
    },
    mongodb: {
        database: process.env.MONGO_DATABASE,
        options: {
            useNewUrlParser: true,
            useUnifiedTopology: true,
            authSource: "admin",
            user: process.env.MONGO_USERNAME,
            pass: process.env.MONGO_PASSWORD
        },
        strictQuery: true
    },
    youtube: {
        apiKey: process.env.YOUTUBE_APIKEY
    },
    sentry: {
        dsn: process.env.SENTRY_DSN,
        debug: true,
        environment: 'production'
    }
};

module.exports = options;