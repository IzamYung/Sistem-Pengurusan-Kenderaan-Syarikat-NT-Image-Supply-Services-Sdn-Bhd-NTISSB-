export default function initMultiFilePicker({ inputId, listId }) {
    const fileInput = document.getElementById(inputId);
    const fileList = document.getElementById(listId);
    let filesArray = [];

    fileInput.addEventListener("change", (e) => {
        filesArray = filesArray.concat(Array.from(e.target.files));
        renderList();
    });

    function renderList() {
        fileList.innerHTML = "";

        filesArray.forEach((file, index) => {
            const div = document.createElement("div");
            div.classList.add(
                "flex",
                "justify-between",
                "items-center",
                "bg-gray-100",
                "p-2",
                "rounded-lg"
            );

            div.innerHTML = `
                <span>${file.name}</span>
                <button type="button" class="text-red-500 font-bold">X</button>
            `;

            div.querySelector("button").addEventListener("click", () => {
                filesArray.splice(index, 1);
                renderList();
            });

            fileList.appendChild(div);
        });

        // **Update input file sebenar supaya Laravel dapat files**
        const dataTransfer = new DataTransfer();
        filesArray.forEach((file) => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
}
