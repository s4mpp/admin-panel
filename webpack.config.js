const path = require('path');

module.exports = {
  entry: './assets/js/input.js',
  output: {
    path: path.resolve(__dirname, 'assets/js'),
    filename: 'script.min.js',
  },
};
