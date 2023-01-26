const express = require('express');
const router = express.Router()
const gamesController = require('../controllers/games.controller')

router.get('/games/:id', gamesController.getGames);
router.get('/systems', gamesController.getSystems);
router.get('/years', gamesController.getYears);
router.get('/manufacturers', gamesController.getManufacturers);

module.exports = router;