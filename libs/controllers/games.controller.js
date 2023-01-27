const game = require('../models/games.model');
const axios = require('axios')
const config = require('config');

async function games(req, res){
    const games = await game.find({})
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
    searchYoutube(req.body, config.youtube.apiKey)
        .then((result) => res.status(200).json(result))
        .catch((error) => res.status(403).json(error));
    
}
async function searchYoutube(data, apiKey){
    const {q, part, type} = data;
    const request = {
        url: "https://www.googleapis.com/youtube/v3/search",
        method: 'get',
        params: {
            q: q || '',
            part: part || 'snippet',
            key: apiKey,
            type: type || 'video'
        }
    }
    const embedUrls = (data) => {
        const embedUrl = "https://www.youtube.com/embed";
        return data.items.map((v)=>{
            v.embedUrl = `${embedUrl}/${v.id.videoId}`
            return v;
        })
    }
    return axios(request).then(embedUrls);
}

module.exports = {
    games,
    systems,
    years,
    manufacturers,
    youtube
}