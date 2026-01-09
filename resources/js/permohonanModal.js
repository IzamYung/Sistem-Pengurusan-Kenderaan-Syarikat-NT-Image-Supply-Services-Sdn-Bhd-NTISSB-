// permohonanModal.js
export default function initPermohonanModal() {
    const modal = document.getElementById("modalPermohonan");
    const modalCard = modal?.querySelector("[data-modal-card]");
    const lampiranContainer = document.getElementById("m-lampiran");
    const noLampiranText = document.getElementById("m-no-lampiran");

    // speedometer section elements
    const speedoSection = document.getElementById("m-speedometer-section");
    const speedoSebelum = document.getElementById("m-speedometer-sebelum");
    const speedoSelepas = document.getElementById("m-speedometer-selepas");
    const ulasanText = document.getElementById("m-ulasan");

    if (!modal || !modalCard) return;

    // open modal when any trigger is clicked
    document
        .querySelectorAll("[data-modal-open='modalPermohonan']")
        .forEach((btn) => {
            btn.addEventListener("click", () => {
                // ===== BASIC INFO =====
                [
                    "user",
                    "idpekerja",
                    "no",
                    "model",
                    "tarikh",
                    "lokasi",
                    "bil",
                    "kod",
                    "hak",
                ].forEach((key) => {
                    const el = document.getElementById(`m-${key}`);
                    if (el) el.innerText = btn.dataset[key] || "-";
                });

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

                        const iconMap = {
                            pdf: "pdf.png",
                            doc: "doc.png",
                            docx: "doc.png",
                            xls: "excel.png",
                            xlsx: "excel.png",
                            csv: "excel.png",
                            ppt: "ppt.png",
                            pptx: "ppt.png",
                            jpg: "image.png",
                            jpeg: "image.png",
                            png: "image.png",
                            webp: "image.png",
                            gif: "image.png",
                            zip: "zip.png",
                            rar: "zip.png",
                        };

                        const icon =
                            "/images/icons/" + (iconMap[ext] || "file.png");

                        const card = document.createElement("div");
                        card.className =
                            "flex items-center gap-3 p-3 rounded-lg bg-white hover:bg-gray-50 cursor-pointer transition shadow-sm hover:shadow-md border border-gray-100";
                        card.onclick = () => window.open(url, "_blank");

                        // icon kiri
                        const iconBox = document.createElement("div");
                        iconBox.className =
                            "w-12 h-12 flex-shrink-0 rounded-md bg-gray-100 flex items-center justify-center";

                        const img = document.createElement("img");
                        img.src = icon;
                        img.className = "w-7 h-7";

                        iconBox.appendChild(img);

                        // text kanan
                        const textBox = document.createElement("div");
                        textBox.className = "min-w-0 flex-1";

                        const name = document.createElement("p");
                        name.className =
                            "text-sm font-medium text-gray-800 truncate";
                        name.innerText = filename;

                        const type = document.createElement("p");
                        type.className = "text-xs text-gray-500 uppercase";
                        type.innerText = `.${ext}`;

                        textBox.appendChild(name);
                        textBox.appendChild(type);

                        card.appendChild(iconBox);
                        card.appendChild(textBox);

                        lampiranContainer.appendChild(card);
                    });
                }

                // ===== SPEEDOMETER SECTION =====
                if (btn.dataset.status === "selesai" && speedoSection) {
                    speedoSection.classList.remove("hidden");

                    speedoSebelum.src = btn.dataset.speedometerSebelum
                        ? `/storage/${btn.dataset.speedometerSebelum}`
                        : "/img/no-image.png";

                    speedoSelepas.src = btn.dataset.speedometerSelepas
                        ? `/storage/${btn.dataset.speedometerSelepas}`
                        : "/img/no-image.png";

                    ulasanText.innerText = btn.dataset.ulasan || "-";
                } else if (speedoSection) {
                    speedoSection.classList.add("hidden");
                }

                // ===== SHOW MODAL =====
                modal.classList.remove("hidden");
                requestAnimationFrame(() =>
                    modalCard.classList.add("scale-100", "opacity-100")
                );
            });
        });

    // ===== CLOSE MODAL BUTTONS =====
    modal.querySelectorAll("[data-modal-close]").forEach((btn) => {
        btn.addEventListener("click", () => {
            modalCard.classList.remove("scale-100", "opacity-100");
            setTimeout(() => modal.classList.add("hidden"), 200);
        });
    });

    // ===== CLOSE WHEN CLICK OUTSIDE =====
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modalCard.classList.remove("scale-100", "opacity-100");
            setTimeout(() => modal.classList.add("hidden"), 200);
        }
    });
}
