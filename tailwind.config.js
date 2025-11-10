/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/**/*.vue',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php'
    ],
    theme: {
        screens: {
            'v580': '580px',
            'v1355': '1355px',
            ...defaultTheme.screens,
        },
        extend: {},
    },
    plugins: [],
}

