/* eslint-disable import/no-extraneous-dependencies */
const { merge } = require('webpack-merge');

const webpackConfiguration = require('../webpack.config');
const environment = require('./environment');
const path = require('path');

module.exports = merge(webpackConfiguration, {
    mode: 'development',

    /* Manage source maps generation process */
    devtool: 'eval-source-map',

    /* Development Server Configuration */
    devServer: {
        contentBase: environment.paths.serveFrom,
        disableHostCheck: false,
        watchContentBase: true,
        publicPath: '/assets',
        open: false,
        historyApiFallback: true,
        compress: true,
        overlay: true,
        writeToDisk :true,
        hot: true,
        watchOptions: {
            poll: 300,
        },
        ...environment.server,
    },

    /* File watcher options */
    watchOptions: {
        aggregateTimeout: 300,
        poll: 300,
        ignored: /node_modules/,
    },

    /* Additional plugins configuration */
    plugins: [],
});
