import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#f0f8ff',
                    100: '#e0f0fe',
                    200: '#b9e1fe',
                    300: '#7cc9fd',
                    400: '#36aef9',
                    500: '#0c93ea',
                    600: '#0873c7',
                    700: '#09539A',
                    800: '#0d4d8b',
                    900: '#114173',
                },
                secondary: {
                    50: '#fef2f3',
                    100: '#fde6e8',
                    200: '#fcd0d5',
                    300: '#f9a8b2',
                    400: '#f4758a',
                    500: '#eb4762',
                    600: '#DD2131',
                    700: '#c31d2b',
                    800: '#a31a26',
                    900: '#8a1924',
                },
                light: {
                    50: '#fcfcfd',
                    100: '#EEF2F9',
                    200: '#e3eaf5',
                    300: '#CBDAEA',
                    400: '#a8c0de',
                    500: '#739bc9',
                    600: '#517faf',
                    700: '#456b94',
                    800: '#3c5a7a',
                    900: '#354c66',
                },
                industrial: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                },
                green: colors.green,
                indigo: colors.indigo,
                red: colors.red,
                yellow: colors.yellow,
                emerald: colors.emerald,
            },
        },
    },

    plugins: [forms],
};
