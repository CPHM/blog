/**
 * Attach to window load event and set the theme to dark or light
 * localStorage.theme if present has precedence over prefer-color-scheme
 * Side Effect: Sets html class dark
 */
module.exports = function () {
    window.addEventListener('load', function () {
       let dark = false;
       if (window.matchMedia('(prefers-color-scheme: dark)').matches)
           dark = true;
       if (localStorage.getItem('theme'))
           dark = localStorage.getItem('theme') === 'dark';
       if (dark)
           document.querySelector('html').classList.add('dark');
       else
           document.querySelector('html').classList.remove('dark');
    });
}
