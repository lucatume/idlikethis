var path = require('path');

module.exports = {
    entry:
    {
        'idlikethis': './assets/js/idlikethis.js',
        'idlikethis-admin': './assets/js/idlikethis-admin.js'
    },
    output: {filename: './assets/js/dist/[name].js'},
    module: {
        loaders: [
            {test: /\.js$/, loader: 'babel-loader', exclude: /node_modules/},
            {test: /\.css$/, loader: 'style!css'},
            {test: /\.scss$/, loaders: ['style', 'css', 'sass']}
        ]
    },
    resolve: {
        root: [
            path.resolve('./assets/js/modules'),
        ],
        extensions: ['', '.js'],
    }
};