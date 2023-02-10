const express = require('express');
const router = express.Router()
const authorizationController = require('../controllers/authorization.controller')

router.all('/login/:credential?', authorizationController.login);
router.get('/logout', authorizationController.logout);
router.post('/register', authorizationController.register);
router.all('/favorites', authorizationController.favorites);
router.get('/checkLogin', authorizationController.checkLogin);

module.exports = router;