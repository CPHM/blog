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
        maxWidth: {
            '360px': '360px'
        },
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
