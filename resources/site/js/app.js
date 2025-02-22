import './bootstrap.js';
import './components/stop-propagation.js';
import './components/glide.js';
import './components/search-modal.js';
import './components/image-zoom.js';
import './components/select2/select2-livewire.js';

document.addEventListener("DOMContentLoaded", () => {
    const themeToggle = document.getElementById("theme-toggle");
    const lightIcon = document.getElementById("light-icon");
    const darkIcon = document.getElementById("dark-icon");
    const logos = document.querySelectorAll('img[alt="search"]');

    function updateLogo() {
        if (document.documentElement.classList.contains("dark")) {
            logos.forEach((e) => {
                e.src = "/img/svg/logo-dark.svg";
            })

        } else {
            logos.forEach((e) => {
                e.src = "/img/svg/logo.svg";
            })
        }
    }

    // Функція для оновлення іконок
    function updateIcons() {
        if (document.documentElement.classList.contains("dark")) {
            darkIcon.classList.remove("hidden");
            lightIcon.classList.add("hidden");
        } else {
            darkIcon.classList.add("hidden");
            lightIcon.classList.remove("hidden");
        }
    }

    // Перевіряємо збережену тему
    if (localStorage.getItem("theme") === "dark" || 
        (!localStorage.getItem("theme") && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }

    updateLogo();
    updateIcons();

    // Обробник натискання на кнопку
    themeToggle.addEventListener("click", () => {
        if (document.documentElement.classList.contains("dark")) {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
        } else {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
        }

        updateLogo();
        updateIcons();
    });
});
