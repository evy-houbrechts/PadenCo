// darkmode eerst toepassen
(function () {
    try {
        if (localStorage.getItem("darkMode") === "true") {
            document.documentElement.classList.add("dark");
        }
    } catch (e) {}
})();
