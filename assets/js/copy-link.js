document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".copy-link-btn");
  if (!buttons.length) return;

  const copyText = async (text) => {
    // Moderne manier (werkt op https + localhost)
    if (navigator.clipboard && window.isSecureContext) {
      await navigator.clipboard.writeText(text);
      return;
    }

    // Fallback (werkt ook op http / file:// in sommige browsers)
    const ta = document.createElement("textarea");
    ta.value = text;
    ta.setAttribute("readonly", "");
    ta.style.position = "fixed";
    ta.style.top = "-9999px";
    document.body.appendChild(ta);
    ta.select();
    document.execCommand("copy");
    document.body.removeChild(ta);
  };

  buttons.forEach((btn) => {
    btn.addEventListener("click", async () => {
      const url = window.location.href;

      try {
        await copyText(url);

        const original = btn.textContent;
        const success = btn.dataset.success || "✓ Copied";
        btn.textContent = success;

        setTimeout(() => (btn.textContent = original), 1800);
      } catch (e) {
        // Als alles faalt: toon de URL zodat user hem kan kopiëren
        prompt("Kopieer deze link:", url);
      }
    });
  });
});
