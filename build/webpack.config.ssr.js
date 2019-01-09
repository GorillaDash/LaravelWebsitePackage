const merge = require('webpack-merge')

module.exports = merge(require('./webpack.base'), {
    target: 'node',
    output: {
        filename: 'gorilladash.ssr.js',
        libraryTarget: 'commonjs2'
    }
})
