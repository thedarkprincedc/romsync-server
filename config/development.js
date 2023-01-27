const romsyncOptions = {
    server: {
        port: 3000
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
        apiKey: ""
    }
};

module.exports = romsyncOptions;