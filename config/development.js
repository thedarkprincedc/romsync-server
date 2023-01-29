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
        database: 'mongodb://localhost:27017/romsync-dev',
        options: {
            useNewUrlParser: true,
            useUnifiedTopology: true,
            authSource: "admin",
            user: 'root',
            pass: 'rootpassword',
        },
        strictQuery: true
    },
    youtube: {
        apiKey: 'AIzaSyBp2jfEZIR_Q52wgKCGJrIcL_YBVMzV65k'
    }
};

module.exports = rsOptions;