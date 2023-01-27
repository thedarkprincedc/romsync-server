const game = require('../models/games.model');
const {searchYoutube} = require('../youtube')

async function games(req, res){
    const {id} = req.params;
    const params = (id) ? {_id: req.params.id} : {}
    const games = await game.find(params)
    res.status(200).json(games)
}

async function systems(req, res){
    const games = await game.find({}, 'system').distinct('system')
    res.status(200).json(games)
}

async function years(req, res){
    const games = await game.find({}, 'year').distinct('year')
    res.status(200).json(games)
}

async function manufacturers(req, res){
    const games = await game.find({}, 'manufacturer').distinct('manufacturer')
    res.status(200).json(games)
}

async function youtube(req, res){
    searchYoutube(req.body)
        .then((result) => res.status(200).json(result))
        .catch((error) => res.status(403).json(error));
}

module.exports = {
    games,
    systems,
    years,
    manufacturers,
    youtube
}