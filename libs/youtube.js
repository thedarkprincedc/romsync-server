const axios = require('axios')
const config = require('config');

async function searchYoutube(data, apiKey){
    const {q, part, type} = data;
    const request = {
        url: "https://www.googleapis.com/youtube/v3/search",
        method: 'get',
        params: {
            q: q || '',
            part: part || 'snippet',
            key: apiKey || config.youtube.apiKey,
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
    searchYoutube
}