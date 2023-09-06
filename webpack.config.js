const path = require('path');
const fs = require('fs');

const entryDirectory = './assets/js'; // Adjust this to your directory path
const entryDirectoryscss = './assets/scss';
const entryPoints = {};

// Read all JavaScript files in the specified directory and set them as entry points
fs.readdirSync(entryDirectory).forEach((file) => {
    if (file.endsWith('.js')) {
        const entryName = path.basename(file, '.js');
        entryPoints[entryName] = path.resolve(entryDirectory, file);
    }
});

fs.readdirSync(entryDirectoryscss).forEach((file) => {
    if (file.endsWith('.scss')) {
        const entryName = path.basename(file, '.scss');
        entryPoints[entryName] = path.resolve(entryDirectoryscss, file);
    }
});

module.exports = {
    entry: entryPoints,
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'dist'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                },
            },
            {
                test: /\.scss$/, // Add a rule for SCSS files
                use: [
                    'style-loader',  // Inject CSS into the DOM
                    'css-loader',    // Convert CSS into JavaScript
                    'sass-loader'    // Compile SCSS to CSS
                ],
            },
        ],
    },
};
