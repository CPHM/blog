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
            '360px': '360px',
            '800px': '800px'
        },
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
