const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./views/**/*.blade.php",
    "./vendor/s4mpp/element/views/**/*.blade.php",
    "./vendor/s4mpp/laraguard/views/**/*.blade.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
],
}