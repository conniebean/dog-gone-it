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
                    "secondary": "#272635",
                    "accent": "#37cdbe",
                    "neutral": "#E0E0E0",
                    "base-100": "#656567",
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
