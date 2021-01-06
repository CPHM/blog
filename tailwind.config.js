module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js'
    ],
    darkMode: 'class', // or 'media' or 'class'
    theme: {
        minWidth: {
            '240px': '240px'
        },
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
