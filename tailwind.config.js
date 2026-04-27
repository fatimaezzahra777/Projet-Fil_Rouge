import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
        },
    },

    theme: {
        extend: {
            colors: {
            gd: '#051F20',
            gdp: '#0B2B26',
            gdk: '#163832',
            gm: '#235347',
            gl: '#8EB69B',
            gp: '#DAF1DE',
            cr: '#F7F5F0',
            td: '#0D1F1E',
            tm: '#3A5A52',
            }
        }
        },

    plugins: [forms],
};
