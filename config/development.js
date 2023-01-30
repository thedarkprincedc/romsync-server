const rsOptions = {
    server: {
        port: 3000,
        options: {
            key: './certs/publicKey.pem',
            cert: './certs/certificate.pem'
        }
    },
    jwt: {
        cookieName: 'romsync-dev',
        token: {

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
    }
};

module.exports = rsOptions;