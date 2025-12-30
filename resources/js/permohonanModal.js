export default function initPermohonanModal() {
    document.querySelectorAll("[data-modal-open]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const modal = document.getElementById("modalPermohonan");
            const modalCard = modal.querySelector("[data-modal-card]");

            // FILL BASIC INFO
            document.getElementById("m-no").innerText = btn.dataset.no;
            document.getElementById("m-model").innerText = btn.dataset.model;
            document.getElementById("m-tarikh").innerText = btn.dataset.tarikh;
            document.getElementById("m-lokasi").innerText = btn.dataset.lokasi;
            document.getElementById("m-bil").innerText = btn.dataset.bil;
            document.getElementById("m-kod").innerText = btn.dataset.kod;
            document.getElementById("m-hak").innerText = btn.dataset.hak;

            // LAMPIRAN
            const lampiran = JSON.parse(btn.dataset.lampiran || "[]");
            const container = document.getElementById("m-lampiran");
            const noFileText = document.getElementById("m-no-lampiran");
            container.innerHTML = "";

            if (!lampiran.length) {
                noFileText.classList.remove("hidden");
            } else {
                noFileText.classList.add("hidden");
                lampiran.forEach((file) => {
                    const url = `/storage/${file}`;
                    const filename = file.split("/").pop();
                    const ext = filename.split(".").pop().toLowerCase();

                    const card = document.createElement("div");
                    card.className =
                        "border rounded-lg bg-white hover:bg-gray-50 transition cursor-pointer overflow-hidden";
                    card.onclick = () => window.open(url, "_blank");

                    const preview = document.createElement("div");
                    preview.className =
                        "h-28 w-full bg-gray-100 overflow-hidden";

                    const img = document.createElement("img");
                    if (["jpg", "jpeg", "png", "webp", "gif"].includes(ext))
                        img.src = url;
                    else if (ext === "pdf") img.src = "/img/thumb-pdf.png";
                    else if (["doc", "docx"].includes(ext))
                        img.src = "/img/thumb-doc.png";
                    else if (["xls", "xlsx", "csv"].includes(ext))
                        img.src = "/img/thumb-excel.png";
                    else if (["ppt", "pptx"].includes(ext))
                        img.src = "/img/thumb-ppt.png";
                    else img.src = "/img/thumb-file.png";

                    img.className = "w-full h-full object-cover object-top";
                    preview.appendChild(img);

                    const name = document.createElement("p");
                    name.className =
                        "text-xs text-gray-700 text-center truncate px-2 py-2";
                    name.innerText = filename;

                    card.appendChild(preview);
                    card.appendChild(name);
                    container.appendChild(card);
                });
            }

            // SHOW MODAL
            modal.classList.remove("hidden");
            setTimeout(
                () => modalCard.classList.add("scale-100", "opacity-100"),
                10
            );

            // CLOSE BUTTON
            modal.querySelectorAll("[data-modal-close]").forEach((btn) => {
                btn.addEventListener("click", () => {
                    modalCard.classList.remove("scale-100", "opacity-100");
                    setTimeout(() => modal.classList.add("hidden"), 200);
                });
            });
        });
    });
}
