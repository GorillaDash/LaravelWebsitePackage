const path = require('path')

module.exports = {
    plugins: [
        require('tailwindcss')(path.resolve(__dirname, './build/tailwind.js')),
        require('autoprefixer')
    ]
}
