
async function getGames(req, res){
    res.status(200).json({})
}

async function getSystems(req, res){
    res.status(200).json({})
}

async function getYears(req, res){
    res.status(200).json({})
}

async function getManufacturers(req, res){
    res.status(200).json({})
}

async function getYoutubeSearch(req, res){
    const searchUrl = "https://www.googleapis.com/youtube/v3/search";
    const embedUrl = "https://www.youtube.com/embed";
    const youtubeApiKey = "";
    const request = {
        url: searchUrl,
        method: 'get',
        params: {
            q: q || '',
            part: part || 'snippet',
            key: youtubeApiKey,
            type: type || 'video'
        }
    }

    return axios(request)
        .then(({data}) => {
            const d = data.items.map((v)=>{
                v.embedUrl = `${youtubeEmbedUrl}/${v.id.videoId}`
                return v;
            })
            res.status(200)
                .json(d)
        })
        .catch((error) => {

        });
}
module.exports = {
    getGames,
    getSystems,
    getYears,
    getManufacturers,
    getYoutubeSearch
}