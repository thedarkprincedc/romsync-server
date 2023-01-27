const game = require('../models/games.model');
const {searchYoutube} = require('../youtube')

async function games(req, res){
    const {id} = req.params;
    const params = (id) ? {_id: id} : {}
    const games = await game.find(params)
    res.status(200).json(games)
}

async function query(req, res){
    const {id} = req.params;
    const games = await game.find({_id: id})
        //.then( (response) => Object.values(response)[0])
        // .then((response) => {
        //     const game = response;
        //     game.youtube = ""
        //     return game;
        //     // return response.map((value) => {
        //     //     //value.m = "feefeef"
        //     //     return value;
        //     // })
        // })
        // .then((response) => {
        //     response[0].l = "efe"
        //     // response.youtube = await searchYoutube({
        //     //     query: response.name
        //     // });
        //     return response;
        // })
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
    const {query} = req.params
    const response = await searchYoutube({ query })
        .then((result) => res.status(200).json(result))
        .catch((error) => res.status(403).json(error));
}

module.exports = {
    games,
    query,
    systems,
    years,
    manufacturers,
    youtube
}