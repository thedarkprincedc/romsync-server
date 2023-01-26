const mongoose = require('mongoose');
const Schema = mongoose.Schema;
const bcrypt = require('bcrypt');
//const Game = require('./games.model')

let UserSchema = new Schema({
    username: {
        type: String,
        trim: true,
        required: true
    },
    password: {
        type: String,
        trim: true,
        required: true
    },
    groups: [{
        type: String
    }],
    favorites: [{
        type: Object
    }],
    favorites2: [{
        type: mongoose.Schema.Types.ObjectId,
        ref: "Game"
    }],
    createdAt: {
        type: Date,
        default: Date.now()
    }
});

UserSchema.pre('save', function(next){
    if(this.password && this.isModified('password')){
        this.password = bcrypt.hashSync(this.password, 10);
    }
    next();
})

UserSchema.statics.createUser = function(data, callback){
    let user = new this({
        username: data.username,
        password: data.password, //bcrypt.hashSync(data.password, 10),
        groups: data.groups || ['user']
    });
    return user.save(callback);
}

UserSchema.methods.comparePassword = function(password){
    return bcrypt.compareSync(password, this.password)
}

module.exports = mongoose.model('User', UserSchema);