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
            'md': '640px',
            'lg': '640px',
            'xl': '640px',
            '2xl': '640px'
        }
    }
}