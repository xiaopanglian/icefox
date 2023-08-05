/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: ['**/*.php'],
    theme: {
        extend: {},
        container: {
            center: true,
        },
        screens: {
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1280px'
        }
    }
}