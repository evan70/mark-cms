/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        "./resources/views/**/*.php",
        "./resources/js/**/*.js"
    ],
    theme: {
        extend: {
            colors: {
                primary: '#1a365d',
                secondary: '#2d3748',
                nav: 'transparent',
                // Accessible color variants with better contrast
                'gray': {
                    150: '#eaeaea',  // Very light gray for dark backgrounds
                    250: '#d1d1d1',  // Light gray with better contrast on dark
                    350: '#b8b8b8',  // Medium light gray with good contrast
                    450: '#9e9e9e',  // Medium gray with acceptable contrast
                },
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in',
                'slide-up': 'slideUp 0.5s ease-out',
                'scale-in': 'scaleIn 0.3s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                scaleIn: {
                    '0%': { transform: 'scale(0.9)', opacity: '0' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
}
