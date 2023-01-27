const fs = require('fs');
const xml2js = require('xml2js');
const path = require('path');

const inputPath = path.join(__dirname, '/../seed-input')
const outputPath = path.join(__dirname, '/../temp')

processDatFile(inputPath+'/arcade.xml')

function processDatFile(filename){
    const xmldata = fs.readFileSync(filename, {encoding: 'utf-8'});
    const xmlparser = new xml2js.Parser();
    xmlparser(xmldata, (error, result) => {
        if(error){
            throw new Error('Error happened')
        }
        const {header, machines} = result.datafile;
    
        for(const machine in machines){
            const game = {
                name: setName(machines[machine].description),
                manufacturer: setName(machines[machine].manufacturer),
                system: header[0].name[0],
                year: setName(machines[machine].year),
                cloneof: machines[machine]['$'].cloneof || null,
                filename: machines[machine]['$'].name
            }
            games.push(game);
        }
    });
}

