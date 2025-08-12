const path = require('path');

module.exports = {
    paths: {
        /* Path to source files directory */
        source: path.resolve(__dirname, '../'),

        /* Path to built files directory */
        output: path.resolve(__dirname, '../../client'),

        /* Path to serve files directory */
        serveFrom: path.resolve(__dirname, '../../client'),
    },
    server: {
        host: 'localhost',
        port: 9000,
    },
    limits: {
        /* Image files size in bytes. Below this value the image file will be served as DataURL (inline base64). */
        images: 8192,

        /* Font files size in bytes. Below this value the font file will be served as DataURL (inline base64). */
        fonts: 8192,
    },
    app: {
        name:"test"
    }
};
