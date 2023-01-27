const rsOptions = {
    server: {
        port: 3000
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
        apiKey: ''
    },
    sentry: {
        dsn: '',
        debug: true,
        environment: 'production'
    }
};

module.exports = rsOptions;