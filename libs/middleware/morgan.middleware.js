const morgan = require('morgan')
//const logger = require('../utility/logger');

// Override the stream method by telling
// Morgan to use our custom logger instead of the console.log.
const stream = {
    // Use the http severity
   // write: (message) => logger.http(message),
    write: (message) => console.log(message),
};

    // Skip all the Morgan http log if the 
    // application is not running in development mode.
    // This method is not really needed here since 
    // we already told to the logger that it should print
    // only warning and error messages in production.
const skip = () => {
    const env = process.env.NODE_ENV || "development";
    return env !== "development";
};

const middleware = ()=> { 
    return morgan(  
        // Define message format string (this is the default one).
        // The message format is made from tokens, and each token is
        // defined inside the Morgan library.
        // You can create your custom token to show what do you want from a request.
        // ":method :url :status :res[content-length] - :response-time ms",
        //":remote-addr :method :url :status :res[content-length] - :response-time ms",
        //"dev",
        ":method :url :status :response-time ms - :res[content-length] > :req[authorization]",
        // Options: in this case, I overwrote the stream and the skip logic.
        // See the methods above.
        { 
            stream, 
            skip
        }
    )
}

module.exports = middleware;
