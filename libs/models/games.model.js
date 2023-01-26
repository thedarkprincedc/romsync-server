const mongoose = require('mongoose');
const Schema = mongoose.Schema;

let GameSchema = new Schema({
    name: {
        type: String,
        required: true
    },
    manufacturer: {
        type: String
    },
    system: {
        type: String,
        required: true
    },
    year: {
        type: String
    },
    images: {
        type: Object
    },
    youtube: {
        type: Object
    },
    cloneof: {
        type: String
    },
    cloneof2: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "Game"
    }
});

module.exports = mongoose.model('Game', GameSchema);