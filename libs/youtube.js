const axios = require('axios')
const config = require('config');

async function searchYoutube(query, apiKey){
    const request = {
        url: "https://www.googleapis.com/youtube/v3/search",
        method: 'get',
        params: {
            q: query || '',
            part: 'snippet',
            key: apiKey || config.youtube.apiKey,
            type: 'video'
        }
    }
 
    const embedUrls = (data) => {
        const embedUrl = "https://www.youtube.com/embed";
        return data.items.map((v)=>{
            v.embedUrl = `${embedUrl}/${v.id.videoId}`
            return v;
        })
    }

    return axios(request)
        .then(({data}) => embedUrls(data));
}

module.exports = {
    searchYoutube
}