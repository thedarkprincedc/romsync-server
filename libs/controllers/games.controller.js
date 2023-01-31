const game = require('../models/games.model');
const {searchYoutube} = require('../youtube')

async function games(req, res){
    const {id} = req.params;
    const params = (id) ? {_id: id} : {}
    const games = await game.find(params)
    res.status(200).json(games)
}

async function gamesById(req, res){
    const {id} = req.params;
    if(!id || id.length < 12){
        res.status(200).json({})
        return;
    }
    const params = (id) ? {_id: id} : {}
    const games = await game.find(params)
    res.status(200).json(games)
}

async function query(req, res){
    const {id, name, year, system, limit} = req.body || {};
    // let query = undefined
    // if(!id || id.length < 12){
    //     res.status(200).json({})
    //     return;
    // }
    let query = {}
    if(id){
        query._id = id
    }
    if(name){
        query.name = { $regex: name, $options: 'i' }
    }
    if(year){
        query.year = year
    }
    if(system){
        query.system = system
    }
    let games = await game.find(query)
        .limit(limit || 100)
        .lean()
        .exec()
    
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
    const response = await searchYoutube(query)
        .then((result) => res.status(200).json(result))
        .catch((error) => res.status(403).json(error));
}

module.exports = {
    games,
    gamesById,
    query,
    systems,
    years,
    manufacturers,
    youtube
}