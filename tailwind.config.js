//import defaultTheme from 'tailwindcss/defaultTheme';
import preset from './vendor/filament/filament/tailwind.config.preset'


/** @type {import('tailwindcss').Config} */
export default {
    //darkMode: 'media',  // Menonaktifkan dark mode
    presets: [preset],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    /*theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Menambahkan warna kustom untuk tema
                primary: '#284173', // Misalnya warna utama kamu
                secondary: '#f5f5f5', // Warna sekunder kamu
            },
        },
    },*/
    theme: {
        extend: {
        colors: {
            secondary: {
            50: 'rgba(var(--secondary-50), <alpha-value>)',
            100: 'rgba(var(--secondary-100), <alpha-value>)',
            200: 'rgba(var(--secondary-200), <alpha-value>)',
            300: 'rgba(var(--secondary-300), <alpha-value>)',
            400: 'rgba(var(--secondary-400), <alpha-value>)',
            500: 'rgba(var(--secondary-500), <alpha-value>)',
            600: 'rgba(var(--secondary-600), <alpha-value>)',
            700: 'rgba(var(--secondary-700), <alpha-value>)',
            800: 'rgba(var(--secondary-800), <alpha-value>)',
            900: 'rgba(var(--secondary-900), <alpha-value>)',
            950: 'rgba(var(--secondary-950), <alpha-value>)',
            },
        },
        },
    },
    plugins: [],
};
