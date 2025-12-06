const toggleBtn = document.getElementById("toggle");
const nav = document.getElementById("nav");

toggleBtn.addEventListener("click", () => {
    nav.classList.toggle("nav-menu-open");
});
