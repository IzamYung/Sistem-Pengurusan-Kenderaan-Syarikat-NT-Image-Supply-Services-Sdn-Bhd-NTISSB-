// permohonanModal.js
export default function initPermohonanModal() {
    const modal = document.getElementById("modalPermohonan");
    const modalCard = modal?.querySelector("[data-modal-card]");
    const lampiranContainer = document.getElementById("m-lampiran");
    const noLampiranText = document.getElementById("m-no-lampiran");

    // speedometer section
    const speedoSection = document.getElementById("m-speedometer-section");
    const speedoSebelum = document.getElementById("m-speedometer-sebelum");
    const speedoSelepas = document.getElementById("m-speedometer-selepas");
    const ulasanText = document.getElementById("m-ulasan");

    if (!modal || !modalCard) return;

    document
        .querySelectorAll("[data-modal-open='modalPermohonan']")
        .forEach((btn) => {
            btn.addEventListener("click", () => {
                // ===== BASIC INFO =====
                document.getElementById("m-user").innerText =
                    btn.dataset.user || "-";
                document.getElementById("m-idpekerja").innerText =
                    btn.dataset.idpekerja || "-";
                document.getElementById("m-no").innerText =
                    btn.dataset.no || "-";
                document.getElementById("m-model").innerText =
                    btn.dataset.model || "-";
                document.getElementById("m-tarikh").innerText =
                    btn.dataset.tarikh || "-";
                document.getElementById("m-lokasi").innerText =
                    btn.dataset.lokasi || "-";
                document.getElementById("m-bil").innerText =
                    btn.dataset.bil || "-";
                document.getElementById("m-kod").innerText =
                    btn.dataset.kod || "-";
                document.getElementById("m-hak").innerText =
                    btn.dataset.hak || "-";

                // ===== LAMPIRAN =====
                const files = JSON.parse(btn.dataset.lampiran || "[]");
                lampiranContainer.innerHTML = "";

                if (!files.length) {
                    noLampiranText.classList.remove("hidden");
                } else {
                    noLampiranText.classList.add("hidden");

                    files.forEach((file) => {
                        const url = `/storage/${file}`;
                        const filename = file.split("/").pop();
                        const ext = filename.split(".").pop().toLowerCase();

                        const card = document.createElement("div");
                        card.className =
                            "border rounded-lg bg-white hover:bg-gray-50 cursor-pointer overflow-hidden";
                        card.onclick = () => window.open(url, "_blank");

                        const preview = document.createElement("div");
                        preview.className =
                            "h-28 w-full bg-gray-100 overflow-hidden";

                        const img = document.createElement("img");
                        img.className = "w-full h-full object-cover object-top";

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

                        preview.appendChild(img);

                        const name = document.createElement("p");
                        name.className =
                            "text-xs text-gray-700 text-center truncate px-2 py-2";
                        name.innerText = filename;

                        card.appendChild(preview);
                        card.appendChild(name);
                        lampiranContainer.appendChild(card);
                    });
                }

                // ===== SPEEDOMETER (SELESAI ONLY) =====
                if (btn.dataset.status === "selesai") {
                    speedoSection.classList.remove("hidden");

                    speedoSebelum.src = btn.dataset.speedometerSebelum
                        ? `/storage/${btn.dataset.speedometerSebelum}`
                        : "/img/no-image.png";

                    speedoSelepas.src = btn.dataset.speedometerSelepas
                        ? `/storage/${btn.dataset.speedometerSelepas}`
                        : "/img/no-image.png";

                    ulasanText.innerText = btn.dataset.ulasan || "-";
                } else {
                    speedoSection.classList.add("hidden");
                }

                // ===== SHOW MODAL =====
                modal.classList.remove("hidden");
                requestAnimationFrame(() =>
                    modalCard.classList.add("scale-100", "opacity-100")
                );
            });
        });

    // ===== CLOSE MODAL =====
    modal.querySelectorAll("[data-modal-close]").forEach((btn) => {
        btn.addEventListener("click", () => {
            modalCard.classList.remove("scale-100", "opacity-100");
            setTimeout(() => modal.classList.add("hidden"), 200);
        });
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modalCard.classList.remove("scale-100", "opacity-100");
            setTimeout(() => modal.classList.add("hidden"), 200);
        }
    });
}
