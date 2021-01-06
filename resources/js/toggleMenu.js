module.exports = function () {
    setTimeout(function () {
        document.getElementById('menu').classList.toggle('-left-32');
        document.getElementById('menu').classList.toggle('left-0');
        document.getElementById('main').classList.toggle('ml-32');
    }, 0);
}
