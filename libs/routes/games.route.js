const express = require('express');
const router = express.Router()
const gamesController = require('../controllers/games.controller')

router.get('/games', gamesController.games);
router.get('/games/:id', gamesController.gamesById)
router.post('/query', gamesController.query)
router.get('/systems', gamesController.systems);
router.get('/years', gamesController.years);
router.get('/manufacturers', gamesController.manufacturers);
router.get('/youtube/:query', gamesController.youtube);

module.exports = router;