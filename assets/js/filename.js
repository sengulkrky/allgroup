document.querySelectorAll('.file-upload-wrapper input').forEach(input => {
    input.addEventListener('change', function () {
        const fileNameSpan = this.parentNode.querySelector('.file-name');
        fileNameSpan.textContent = this.files.length > 0
            ? this.files[0].name
            : "Geen bestand gekozen";
    });
});

// filename.js
document.addEventListener("DOMContentLoaded", () => {
  const fileInputs = document.querySelectorAll('input[type="file"]');

  // Update hint + enable/disable remove button
  function syncFileUI(inputEl) {
    const id = inputEl.id;
    const hintEl = document.getElementById(`${id}-hint`);
    const removeBtn = document.querySelector(`button[data-clear="${id}"]`);

    const hasFile = inputEl.files && inputEl.files.length > 0;

    if (hintEl) {
      hintEl.textContent = hasFile ? inputEl.files[0].name : "Nog geen bestand gekozen.";
    }

    if (removeBtn) {
      removeBtn.disabled = !hasFile;
      removeBtn.setAttribute("aria-disabled", String(!hasFile));
    }
  }

  // On change: show filename
  fileInputs.forEach((inputEl) => {
    inputEl.addEventListener("change", () => syncFileUI(inputEl));
    syncFileUI(inputEl); // init state
  });

  // On click "Verwijderen": clear file input
  document.addEventListener("click", (e) => {
    const btn = e.target.closest("button[data-clear]");
    if (!btn) return;

    const targetId = btn.getAttribute("data-clear");
    const inputEl = document.getElementById(targetId);
    if (!inputEl) return;

    inputEl.value = "";      // clears selected file
    syncFileUI(inputEl);
  });
});
