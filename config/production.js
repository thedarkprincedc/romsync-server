const romsyncOptions = {
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
        }
    }
};

module.exports = romsyncOptions;