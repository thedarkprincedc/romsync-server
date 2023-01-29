const fs = require('fs');
const xml2js = require('xml2js');
const path = require('path');
const glob = require('glob')


async function processSeedFiles(){
    const destDir = path.join(__dirname, '/../temp/gameslist.json')

    const setName = (name) => {
        return (name) ? name[0]: null
    }
    
    let games = [];
    glob.sync('temp/*.dat', {}).forEach(async (value)=>{
        const file = fs.readFileSync(value, {encoding: 'utf-8'});
        const xmlparser = new xml2js.Parser();
        const xmldata = await xmlparser.parseStringPromise(file);
        const {header, machine} = xmldata.datafile
        
        for(const item in machine){
            const game = {
                name: setName(machine[item].description),
                manufacturer: setName(machine[item].manufacturer),
                system: header[0].name[0],
                year: setName(machine[item].year),
                cloneof: machine[item]['$'].cloneof || null,
                filename: machine[item]['$'].name
            }
            games.push(game)
        }
        fs.writeFileSync(destDir, JSON.stringify(games, null, 2))
    })
}
processSeedFiles()

