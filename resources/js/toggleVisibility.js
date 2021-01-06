/**
 * Toggle hidden class of element with given id
 */
module.exports = function (id) {
    document.getElementById(id).classList.toggle('hidden');
}
