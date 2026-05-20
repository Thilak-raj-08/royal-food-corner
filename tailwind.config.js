import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                royal: {
                    50:  '#fff1f1',
                    100: '#ffdfdf',
                    200: '#ffc5c5',
                    300: '#ff9d9d',
                    400: '#ff6464',
                    500: '#f44336',
                    600: '#e02020',
                    700: '#bd1818',
                    800: '#9c1818',
                    900: '#811a1a',
                    950: '#460808',
                },
                gold: {
                    400: '#fbbf24',
                    500: '#f59e0b',
                    600: '#d97706',
                },
            },
            backgroundImage: {
                'royal-gradient': 'linear-gradient(135deg, #460808 0%, #811a1a 35%, #e02020 70%, #f59e0b 100%)',
                'spice-radial': 'radial-gradient(circle at 20% 20%, rgba(244,67,54,0.45), transparent 50%), radial-gradient(circle at 80% 0%, rgba(251,191,36,0.35), transparent 55%), radial-gradient(circle at 50% 100%, rgba(70,8,8,0.6), transparent 60%), linear-gradient(180deg, #1a0808 0%, #2a0a0a 100%)',
            },
            boxShadow: {
                glass: '0 8px 32px 0 rgba(0, 0, 0, 0.37)',
                'inner-glass': 'inset 0 1px 0 0 rgba(255,255,255,0.08)',
                glow: '0 0 24px rgba(244, 67, 54, 0.55)',
            },
            keyframes: {
                'fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'pulse-glow': {
                    '0%, 100%': { boxShadow: '0 0 0 0 rgba(244,67,54,0.6)' },
                    '50%': { boxShadow: '0 0 0 14px rgba(244,67,54,0)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-1000px 0' },
                    '100%': { backgroundPosition: '1000px 0' },
                },
            },
            animation: {
                'fade-up': 'fade-up 0.6s ease-out both',
                'pulse-glow': 'pulse-glow 2.5s ease-in-out infinite',
                shimmer: 'shimmer 8s linear infinite',
            },
        },
    },
    plugins: [forms],
};
