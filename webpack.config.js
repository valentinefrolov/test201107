//const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const webpack = require('webpack');

require("babel-polyfill");


module.exports = {
    devtool: 'source-map',
    entry: {
        app: ['babel-polyfill', './resources/js/app.js']
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader"
            }
        ]
    },
    output: {
        filename: '[name].bundle.js'
    },
    plugins: [
        //new UglifyJsPlugin({sourceMap: process.env.NODE_ENV !== 'production'})
    ],
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        }
    },

};
