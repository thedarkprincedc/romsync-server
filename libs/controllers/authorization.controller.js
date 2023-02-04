const User = require('../models/users.model');
const config = require('config');
const bcrypt = require('bcrypt')
const token = require('../token')

function convertFromBase64String(string){
    const credentials = Buffer.from(string, "base64").toString().split(':');
    return {
        username: credentials[0],
        password: credentials[1]
    }
}

async function login(req, res){
    const {authorization} = req.headers;
    const credential = req.params.credential || authorization.split(' ')[1]
    const {username, password} = convertFromBase64String(credential);
    const user = await User.findOne({username: username});

    if(!user || !user.comparePassword(password)){
        return res.status(401).json({ message: 'Authentication failed. Invalid user or password.'});
    }

    const payload = {
        id: user.id,
        username: user.username,
        group: user.group,
        favorites: user.favorites
    };

    const signedToken = token.sign(payload);

    const result = {
        userinfo: payload,
        token: signedToken
    };

    return res.status(200)
        .cookie(config.jwt.cookieName, signedToken, config.jwt.options)
        .json(result);
}

function logout(req, res){
    const result = {
        logout: true
    };

    res.status(200)
        .clearCookie(config.jwt.cookieName)
        .json(result);
}

async function register(req, res){
    let {username, password, email, groups, favorites} = req.body;
    const user = await User.findOne({username: username})
    if(user){
        return res.status(400).json({
            email: 'This user is already registered'
        });
    } else {
        const newUser = new User({
            username: username,
            password: password,
            email: email,
            groups: groups || [
                'user'
            ],
            favorites: favorites || []
        })

        newUser.hash_password = bcrypt.hashSync(password, 10);
        newUser.save()

        return res.status(200).json({
            msg: newUser
        });
    }
}

async function favorites(req, res){
    const {method} = req;
    const query = {username: req.user}
    const favorites = await User.find(query, 'favorites')
    res.status(200).json(favorites)
}

async function groups(req, res){
    const {method} = req;
    const query = {username: req.user}
    const groups = await User.find(query, 'groups')
    res.status(200).json(groups)
}

module.exports = {
    login,
    logout,
    register,
    favorites,
    groups
}