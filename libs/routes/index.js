//require('./authorization.route')
const gamesRoute = require('./games.route')
const authorizationRoute = require('./authorization.route')

const express = require('express');
const router = express.Router()

router.use('/', authorizationRoute)
router.use('/', gamesRoute)
module.exports = router;