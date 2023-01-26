const banner = require('../libs/header')
const express = require('express')
const app = express();
const {server} = require('config');
const https = require("https");
const bodyParser = require('body-parser');
const cors = require('cors');
const compression = require('compression')
const cookieParser = require('cookie-parser');
const routes = require('../libs/routes')

const morganMiddleware = require('../libs/middleware/morgan.middleware')
app.use(morganMiddleware());
app.use(cors({
    origin: '*',
    methods: ['GET','POST']
}))
app.use(cookieParser())
app.use(bodyParser.urlencoded({ extended: false }))
app.use(bodyParser.json())
app.use(compression())

app.use('/api', routes)



app.listen(server.port, () => {
    banner.showBanner()
    console.log(`Server listening on port %s! Go to http://localhost:%s/`, server.port, server.port)
})

// https.createServer(server, app)
//     .listen(server.port, () => {
//          banner.showBanner()
//         console.log(`Server listening on port %s! Go to http://localhost:%s/`, server.port, server.port)
//     })