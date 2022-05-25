const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        screens: {
            'xs': '475px',
            ...defaultTheme.screens,
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                // sans: ["Blinker", ...defaultTheme.fontFamily.sans]
            },
            transitionProperty: {
                'width': 'width',
                'height': 'height',
            },
            colors: {
                primary: {
                    "100": "#feeff0",
                    "200": "#f36165",
                    "300": "#f14a4f",
                    "400": "#f03439",
                    "500": "#ee1d23",
                    "600": "#d61a20",
                    "700": "#be171c",
                    "800": "#a71419",
                    "900": "#8f1115"
                },
                secondary: {
                    "100": "#91c48f",
                    "200": "#7fba7d",
                    "300": "#6db06a",
                    "400": "#5aa658",
                    "500": "#489c45",
                    "600": "#418c3e",
                    "700": "#3a7d37",
                    "800": "#326d30",
                    "900": "#2b5e29"
                }
            },
            borderRadius: {
                'primary': '20px',
            },

        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
