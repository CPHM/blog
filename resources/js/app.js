require("./detectThemeAtStartup")();

require("./areYouSure")();

window.toggleDarkMode = require("./toggleDarkMode");

window.toggleMenu = require("./toggleMenu");

window.toggleVisibility = require("./toggleVisibility");

window.initializeCommentsDrawer = require("./comments").initializeCommentsDrawer;

window.openCommentsDrawer = require("./comments").openCommentsDrawer;
