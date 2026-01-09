export default function initMultiFilePicker({ inputId, listId }) {
    const fileInput = document.getElementById(inputId);
    const fileList = document.getElementById(listId);

    if (!fileInput || !fileList) return;

    let filesArray = [];

    fileInput.addEventListener("change", (e) => {
        filesArray = filesArray.concat(Array.from(e.target.files));
        renderList();
    });

    function renderList() {
        fileList.innerHTML = "";

        filesArray.forEach((file, index) => {
            // Logic untuk asingkan nama dan extension
            const fileName = file.name;
            const lastDotIndex = fileName.lastIndexOf(".");
            const extension =
                lastDotIndex !== -1 ? fileName.substring(lastDotIndex) : "";
            const nameOnly =
                lastDotIndex !== -1
                    ? fileName.substring(0, lastDotIndex)
                    : fileName;

            const div = document.createElement("div");
            div.className = "file-item"; // Guna class dari CSS Blade

            div.innerHTML = `
                <div class="file-name-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    <div class="flex items-center overflow-hidden">
                        <span class="file-name-text">${nameOnly}</span>
                        <span class="file-ext-text">${extension}</span>
                    </div>
                </div>
                <button type="button" class="remove-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;

            div.querySelector("button").addEventListener("click", () => {
                filesArray.splice(index, 1);
                renderList();
            });

            fileList.appendChild(div);
        });

        // Update input asal Laravel (PENTING)
        const dataTransfer = new DataTransfer();
        filesArray.forEach((file) => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
}
