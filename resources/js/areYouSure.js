module.exports = function () {
    const elements = document.getElementsByClassName('areYouSure');
    for (const element of elements) {
        element.addEventListener('click', function (e) {
            let message = element.getAttribute('data-sure-message') || 'Are you sure?!';
            if (!confirm(message))
                e.preventDefault();
        });
    }
}
