const toggleBtn = document.getElementById("toggle");
const nav = document.getElementById("nav");

toggleBtn.addEventListener("click", () => {
    nav.classList.toggle("nav-menu-open");
});

// Language switcher
const langSelect = document.getElementById("language-select");
if (langSelect) {
  // Detecteer base path (werkt ook als de site in een subfolder staat, bv. GitHub Pages)
  const path = window.location.pathname;
  const match = path.match(/^(.*)\/(nl|en|fr)\//);
  const base = match ? match[1] : "";

  const targets = {
    nl: `${base}/nl/home.html`,
    fr: `${base}/fr/accueil.html`,
    en: `${base}/en/home.html`,
  };

  langSelect.addEventListener("change", (e) => {
    const lang = e.target.value;
    if (targets[lang]) {
      window.location.href = targets[lang];
    }
  });
}
