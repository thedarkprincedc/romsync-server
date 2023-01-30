const rsOptions = {
    server: {
        port: process.env.ROMSYNC_PORT || 3000,
        certificates: {
            publicKey: process.env.ROMSYNC_PUBLIC_KEY || './certs/publicKey.pem',
            privateKey: process.env.ROMSYNC_PRIVATE_KEY || './certs/privateKey.pem'
        }
    },
    jwt: {
        cookieName: 'romsync',
        token: {
            
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

module.exports = rsOptions;