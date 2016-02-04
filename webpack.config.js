module.exports = {
    entry: './assets/js/idlikethis.js',
    output: {filename: './assets/js/dist/idlikethis-bundle.js'},
    module: {
        loaders: [
            {test: /\.js$/, loader: 'babel-loader', exclude: /node_modules/},
            {test: /\.css$/, loader: 'style!css'},
            {test: /\.scss$/, loaders: ['style', 'css', 'sass']}
        ]
    }
};