const rsOptions = {
    server: {
        port: 3000,
        certificates: {
            publicKey: './certs/publicKey.pem',
            privateKey: './certs/privateKey.pem'
        }
    },
    jwt: {
        cookieName: 'romsync',
        token: {
            
        }
    },
    mongodb: {
        database: 'mongodb://localhost:27017/romsync-stage',
        options: {
            useNewUrlParser: true,
            useUnifiedTopology: true,
            authSource: "admin",
            user: 'root',
            pass: 'rootpassword'
        },
        strictQuery: true
    },
    youtube: {
        apiKey: 'AIzaSyBp2jfEZIR_Q52wgKCGJrIcL_YBVMzV65k'
    },
    sentry: {
        dsn: '',
        debug: true,
        environment: 'production'
    }
};

module.exports = rsOptions;