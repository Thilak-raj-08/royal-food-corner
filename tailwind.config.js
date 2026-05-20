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
                sans:    ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
                script:  ['"Dancing Script"', 'cursive'],
            },
            colors: {
                // Warm bistro palette
                cream: {
                    50:  '#FFFCF7',
                    100: '#FFF8F0',
                    200: '#FDF4E7',
                    300: '#F7EAD6',
                    400: '#EFDBBE',
                    500: '#E8DDD0',
                },
                cocoa: {
                    50:  '#FAF6F2',
                    100: '#F2EBE3',
                    200: '#E0D0C0',
                    300: '#C4A48A',
                    400: '#A07A5C',
                    500: '#8B6F5C',
                    600: '#6E4F3A',
                    700: '#5B3A2E',
                    800: '#3D281F',
                    900: '#2B1810',
                },
                signature: {
                    50:  '#FFF1F2',
                    100: '#FFE2E5',
                    200: '#FFC9CE',
                    300: '#FF9099',
                    400: '#F4505C',
                    500: '#C8102E',     // primary brand red
                    600: '#A30E27',
                    700: '#85091E',
                    800: '#6B0817',
                    900: '#4A0510',
                },
                gold: {
                    50:  '#FBF7EB',
                    100: '#F6ECCC',
                    200: '#EDD699',
                    300: '#E1BC5A',
                    400: '#D4AF37',     // accent gold
                    500: '#C19A2E',
                    600: '#9C7C24',
                    700: '#74591C',
                },
            },
            boxShadow: {
                soft:    '0 6px 24px -8px rgba(75, 52, 38, 0.18)',
                'soft-lg': '0 18px 48px -12px rgba(75, 52, 38, 0.22)',
                'inner-warm': 'inset 0 -1px 0 0 rgba(75,52,38,0.06)',
                'glow-red': '0 8px 30px -6px rgba(200, 16, 46, 0.5)',
                'glow-gold': '0 8px 30px -6px rgba(212, 175, 55, 0.45)',
            },
            backgroundImage: {
                'cream-noise': "radial-gradient(circle at 20% 10%, rgba(244,80,92,0.06), transparent 40%), radial-gradient(circle at 80% 90%, rgba(212,175,55,0.08), transparent 40%)",
                'red-gradient': 'linear-gradient(135deg, #C8102E 0%, #85091E 100%)',
                'gold-gradient': 'linear-gradient(135deg, #D4AF37 0%, #9C7C24 100%)',
            },
            keyframes: {
                'fade-up': {
                    '0%':   { opacity: '0', transform: 'translateY(14px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'pulse-soft': {
                    '0%, 100%': { transform: 'scale(1)' },
                    '50%':      { transform: 'scale(1.05)' },
                },
            },
            animation: {
                'fade-up':    'fade-up 0.5s ease-out both',
                'pulse-soft': 'pulse-soft 2s ease-in-out infinite',
            },
        },
    },
    plugins: [forms],
};
