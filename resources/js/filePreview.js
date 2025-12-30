export default function initFilePreview(selector = 'input[type="file"]') {
    document.querySelectorAll(selector).forEach((input) => {
        const previewBox = document.getElementById("m-lampiran");
        const noFileText = document.getElementById("m-no-lampiran");
        if (!previewBox) return;

        input.addEventListener("change", () => {
            previewBox.innerHTML = "";
            const files = Array.from(input.files || []);

            if (files.length === 0) {
                noFileText?.classList.remove("hidden");
                return;
            } else {
                noFileText?.classList.add("hidden");
            }

            files.forEach((file) => {
                const url = URL.createObjectURL(file);
                const filename = file.name;
                const ext = filename.split(".").pop().toLowerCase();

                const item = document.createElement("div");
                item.className =
                    "border rounded-lg p-2 bg-gray-50 flex flex-col";

                const iframe = document.createElement("iframe");
                iframe.className = "w-full h-64 mb-2 border rounded-md";

                if (
                    ["jpg", "jpeg", "png", "webp", "gif"].includes(ext) ||
                    ext === "pdf"
                ) {
                    // direct iframe for browser-renderable files
                    iframe.src = url;
                } else if (
                    ["doc", "docx", "xls", "xlsx", "ppt", "pptx"].includes(ext)
                ) {
                    // Office Online viewer
                    iframe.src = `https://view.officeapps.live.com/op/embed.aspx?src=${encodeURIComponent(
                        url
                    )}`;
                } else {
                    // fallback for unknown files
                    const fallback = document.createElement("div");
                    fallback.className =
                        "w-full h-32 flex items-center justify-center bg-gray-200 text-gray-600 font-bold mb-2 rounded-md";
                    fallback.innerText = ext.toUpperCase();
                    fallback.onclick = () => window.open(url, "_blank");
                    item.appendChild(fallback);
                    previewBox.appendChild(item);
                    return;
                }

                item.appendChild(iframe);

                const nameEl = document.createElement("p");
                nameEl.className =
                    "text-xs text-gray-600 text-center truncate w-full";
                nameEl.innerText = filename;

                item.appendChild(nameEl);
                previewBox.appendChild(item);
            });
        });
    });
}
