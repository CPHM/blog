/**
 * Toggles dark mode
 * Side Effect: change html class 'dark'
 * Side Effect: Sets localStorage.theme
 */
module.exports = function () {
    const html = document.querySelector('html');
    let targetIsDark = !html.classList.contains('dark');
    if (targetIsDark) {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
}
