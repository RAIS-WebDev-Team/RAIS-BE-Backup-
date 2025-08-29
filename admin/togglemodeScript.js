
document.addEventListener('DOMContentLoaded', function () {
    const themeSwitch = document.getElementById('theme-checkbox');
    const currentTheme = localStorage.getItem('theme');

    function setTheme(theme) {
        if (theme === 'dark') {
            document.body.classList.add('dark-mode');
            themeSwitch.checked = true;
        } else {
            document.body.classList.remove('dark-mode');
            themeSwitch.checked = false;
        }
    }

    if (currentTheme) {
        setTheme(currentTheme);
    }

    themeSwitch.addEventListener('change', function (event) {
        if (event.target.checked) {
            localStorage.setItem('theme', 'dark');
            setTheme('dark');
        } else {
            localStorage.setItem('theme', 'light');
            setTheme('light');
        }
    });
});