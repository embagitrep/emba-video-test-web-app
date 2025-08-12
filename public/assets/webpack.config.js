/**
 * Webpack main configuration file
 */

const path = require('path');
const fs = require('fs');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const HTMLWebpackPlugin = require('html-webpack-plugin');
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const { extendDefaultPlugins } = require('svgo');
const WebpackShellPluginNext = require('webpack-shell-plugin-next');
const FontFaceGenerator = require('./webpack-plugins/font-face-generator');
const IconfontWebpackPlugin = require('iconfont-webpack-plugin');
var SpritesmithPlugin = require('webpack-spritesmith');




const environment = require('./configuration/environment');

const templateFiles = fs.readdirSync(environment.paths.source)
    .filter((file) => path.extname(file).toLowerCase() === '.html');

const htmlPluginEntries = templateFiles.map((template) => new HTMLWebpackPlugin({
    inject: true,
    hash: false,
    filename: template,
    template: path.resolve(environment.paths.source, template),
    favicon: path.resolve(environment.paths.source, 'images', 'favicon.ico'),
}));

module.exports = {
    entry: {
        app: path.resolve(environment.paths.source, 'javascripts', 'design.js'),
    },
    output: {
        filename: 'js/design.js',
        path: environment.paths.output,
    },
    externals: {
        // require("jquery") is external and available
        //  on the global var jQuery
        "jquery": "jQuery"
    },
    module: {
        rules: [
            {
                test: /\.less$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: (loader) => {
                                return {
                                    plugins: [
                                        new IconfontWebpackPlugin({
                                            resolve: loader.resolve,
                                            fontNamePrefix: 'icon-',
                                            enforcedSvgHeight: 3000,
                                        })
                                    ]
                                }
                            }
                        }
                    },
                    // 'postcss-loader',
                    'less-loader'
                ],
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: ['babel-loader'],
            },
            {
                test: /\.(png|gif|jpe?g|svg)$/i,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            name: 'images/design/[name].[hash:6].[ext]',
                            publicPath: '../',
                            limit: environment.limits.images,
                        },
                    },
                ],
            },
            {
                test: /\.(eot|ttf|woff|woff2)$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            name: 'fonts/[name].[hash:6].[ext]',
                            publicPath: '../',
                            limit: environment.limits.fonts,
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        new FontFaceGenerator({
            fontDir: './fonts',
            outputFile: './css/utilities/fonts.less',
            // template:  '@include font-face("' +
            //     '{{font}}", font-files(' +
            //     '"{{font}}.woff", ' +
            //     '"{{font}}.ttf", ' +
            //     '"{{font}}.svg#{{font}}"), ' +
            //     '"{{font}}.eot");',
            template: '@font-face{ font-family: "' +
                '{{font}}"; ' +
                'src: url("../../fonts/{{fontFile}}.ttf");' +
                // 'src: url("../../fonts/{{font}}.eot") format(\'embedded-opentype\')' +
                // ',url("../../fonts/{{font}}.woff2") format(\'woff2\')' +
                // ',url("../../fonts/{{font}}.woff") format(\'woff\')' +
                // ',url("../../fonts/{{font}}.ttf") format(\'truetype\')' +
                // ',url("../../fonts/{{font}}.svg") format(\'svg\')' +
                // ';' +
                'font-weight:{{w}};'+
                'font-style:{{s}};'+
                '}',
            removeFromFile: '-webfont'
        }),
        new WebpackShellPluginNext({
            onBuildStart:{
                // scripts: ['glue ./images/pico/ ./images/content --margin=10 --less=./css/utilities/ --less-template=./images/sprites/template.jinja --retina --namespace= --sprite-namespace= -f �quiet'],
                blocking: true,
                parallel: false
            },
        }),
        new MiniCssExtractPlugin({
            filename: 'css/design.css',
        }),
        // new ImageMinimizerPlugin({
        //     test: /\.(jpe?g|png|gif|svg)$/i,
        //     minimizerOptions: {
        //         // Lossless optimization with custom option
        //         // Feel free to experiment with options for better result for you
        //         plugins: [
        //             ['gifsicle', { interlaced: true }],
        //             ['jpegtran', { progressive: true }],
        //             ['gifsicle', { interlaced: true }],
        //             ['mozjpeg', { progressive: true, quality: 75 }],
        //             ['pngquant', { quality: [0.65, 0.90], speed: 4 }],
        //             ['optipng', { optimizationLevel: 5 }],
        //             [
        //                 'svgo',
        //                 {
        //                     plugins: extendDefaultPlugins([
        //                         {
        //                             name: 'removeViewBox',
        //                             active: false,
        //                         },
        //                     ]),
        //                 },
        //             ],
        //         ],
        //     },
        // }),
        new CleanWebpackPlugin({
            verbose: true,
            cleanOnceBeforeBuildPatterns: ['**/*', '!stats.json'],
        }),
        new CopyWebpackPlugin({
            patterns: [
                {
                    from: path.resolve(environment.paths.source, 'images', 'content'),
                    to: path.resolve(environment.paths.output, 'images', 'content'),
                    toType: 'dir',
                    globOptions: {
                        ignore: ['*.DS_Store', 'Thumbs.db'],
                    },
                },
            ],
        }),
        new SpritesmithPlugin({
            src: {
                cwd: path.resolve(__dirname, 'images/pico'),
                glob: '*.png'
            },
            target: {
                image: path.resolve(__dirname, 'images/content/sprite.png'),
                css: path.resolve(__dirname, 'css/bem/utilities/sprite.less')
            },
            apiOptions: {
                cssImageRef: path.resolve(__dirname, 'images/content/sprite.png')
            }
        })

    ].concat(htmlPluginEntries),
    target: 'web',
};
