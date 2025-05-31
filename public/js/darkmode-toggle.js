console.log('darkmode-toggle.js geladen!');

document.addEventListener("DOMContentLoaded", function () {
    const toggleDarkMode = document.getElementById("toggle-dark-mode");
    const toggleDarkModeMoon = document.getElementById("toggle-dark-mode-moon");

    const htmlEl = document.documentElement;

    if (localStorage.getItem("darkMode") === "true") {
        htmlEl.classList.add("dark");
        toggleDarkMode?.classList.add("hidden");
        toggleDarkModeMoon?.classList.remove("hidden");
    } else {
        htmlEl.classList.remove("dark");
        toggleDarkMode?.classList.remove("hidden");
        toggleDarkModeMoon?.classList.add("hidden");
    }

    toggleDarkMode?.addEventListener("click", function () {
        htmlEl.classList.add("dark");
        toggleDarkMode.classList.add("hidden");
        toggleDarkModeMoon.classList.remove("hidden");
        localStorage.setItem("darkMode", "true");
    });

    toggleDarkModeMoon?.addEventListener("click", function () {
        htmlEl.classList.remove("dark");
        toggleDarkMode.classList.remove("hidden");
        toggleDarkModeMoon.classList.add("hidden");
        localStorage.setItem("darkMode", "false");
    });
});
