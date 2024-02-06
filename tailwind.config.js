const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    daisyui: {
        themes: [
            {
                mytheme: {
                    "primary": "#c4af9a",
                    "secondary": "#c5c9a4",
                    "accent": "#37cdbe",
                    "neutral": "#3d4451",
                    "base-100": "#476a6f",
                },
            },
        ],
    },

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require("daisyui")],
};
