const express = require('express');
const router = express.Router()
const authorizationController = require('../controllers/authorization.controller')

router.get('/login', authorizationController.login)
router.get('/logout', authorizationController.logout)
router.get('/register', authorizationController.register)
router.get('/favorites', authorizationController.favorites)
router.get('/config', authorizationController.config)

module.exports = router;