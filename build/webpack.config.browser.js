const merge = require('webpack-merge')

module.exports = merge(require('./webpack.base'), {
    output: {
        filename: 'gorilladash.min.js',
        library: 'gorilladash',
        libraryTarget: 'umd',
        globalObject: "typeof self !== 'undefined' ? self : this"
    }
})
