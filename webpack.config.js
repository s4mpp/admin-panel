const path = require('path');

module.exports = {
  entry: './workbench/assets/js/input.js',
  output: {
    path: path.resolve(__dirname, './vendor/orchestra/testbench-core/laravel/public/js'),
    filename: 'script.js',
  },
};
