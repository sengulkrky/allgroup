document.querySelectorAll('.file-upload-wrapper input').forEach(input => {
    input.addEventListener('change', function () {
        const fileNameSpan = this.parentNode.querySelector('.file-name');
        fileNameSpan.textContent = this.files.length > 0
            ? this.files[0].name
            : "Geen bestand gekozen";
    });
});
