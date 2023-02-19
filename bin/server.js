const mongoose = require('../libs/mongoose')
const express = require('express')
const app = express();
const {server} = require('config');
const https = require("https");
const bodyParser = require('body-parser');
const cors = require('cors');
const compression = require('compression')
const cookieParser = require('cookie-parser');
const banner = require('../libs/header')
const morganMiddleware = require('../libs/middleware/morgan.middleware')
const { TokenMiddleware} = require('../libs/middleware/token.middleware')

app.set('json spaces', 2);

app.use(morganMiddleware());
app.use(cors({
    origin: '*',
    methods: ['GET','POST']
}))
app.use(cookieParser())
app.use(bodyParser.urlencoded({ extended: false }))
app.use(bodyParser.json())
app.use(compression())
app.use(TokenMiddleware())
//app.use(TokenCookieMiddleware())
//app.use(TokenBearerMiddleware())


app.use('/api', require('../libs/routes'))

if(server.https){
    https.createServer(server.options, app)
        .listen(() => banner.onServerStarted(server))
} else {
    app.listen(server.port, () => banner.onServerStarted(server))
}

mongoose.start();