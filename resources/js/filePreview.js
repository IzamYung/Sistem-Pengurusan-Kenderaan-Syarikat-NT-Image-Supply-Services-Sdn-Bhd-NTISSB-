export default function initFilePreview(selector = 'input[type="file"]') {
    document.querySelectorAll(selector).forEach((input) => {
        const fileNameSpan = input.nextElementSibling?.nextElementSibling;
        input.addEventListener("change", (e) => {
            const file = e.target.files?.[0];
            if (fileNameSpan) fileNameSpan.textContent = file ? file.name : "";
        });
    });
}
