/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        darkOcean: '#1F316F',
        softWhite: '#F4F4F9',
        mutedGold: '#C5A880',
        coolGray: '#A6A6A6',
        deepTeal: '#396A75',
        lightSand: '#F9DBBA',
        softBlue: '#5B99C2',
        midBlue: '#1A4870',
        bgBlue: "#030344",
      },
    },
  },
  plugins: [],
}

