// permohonanModal.js
export default function initPermohonanModal() {
    const modal = document.getElementById("modalPermohonan");
    const modalCard = modal?.querySelector("[data-modal-card]");
    const lampiranContainer = document.getElementById("m-lampiran");
    const noLampiranText = document.getElementById("m-no-lampiran");

    // speedometer section (admin only)
    const speedoSection = document.getElementById("m-speedometer-section");
    const speedoSebelum = document.getElementById("m-speedometer-sebelum");
    const speedoSelepas = document.getElementById("m-speedometer-selepas");
    const ulasanText = document.getElementById("m-ulasan");

    if (!modal || !modalCard) return;

    document
        .querySelectorAll("[data-modal-open='modalPermohonan']")
        .forEach((btn) => {
            btn.addEventListener("click", () => {
                // ===== BASIC INFO (safe check) =====
                const mUser = document.getElementById("m-user");
                if (mUser) mUser.innerText = btn.dataset.user || "-";

                const mId = document.getElementById("m-idpekerja");
                if (mId) mId.innerText = btn.dataset.idpekerja || "-";

                const mNo = document.getElementById("m-no");
                if (mNo) mNo.innerText = btn.dataset.no || "-";

                const mModel = document.getElementById("m-model");
                if (mModel) mModel.innerText = btn.dataset.model || "-";

                const mTarikh = document.getElementById("m-tarikh");
                if (mTarikh) mTarikh.innerText = btn.dataset.tarikh || "-";

                const mLokasi = document.getElementById("m-lokasi");
                if (mLokasi) mLokasi.innerText = btn.dataset.lokasi || "-";

                const mBil = document.getElementById("m-bil");
                if (mBil) mBil.innerText = btn.dataset.bil || "-";

                const mKod = document.getElementById("m-kod");
                if (mKod) mKod.innerText = btn.dataset.kod || "-";

                const mHak = document.getElementById("m-hak");
                if (mHak) mHak.innerText = btn.dataset.hak || "-";

                // ===== LAMPIRAN =====
                lampiranContainer.innerHTML = "";
                const files = JSON.parse(btn.dataset.lampiran || "[]");

                if (!files.length) {
                    if (noLampiranText)
                        noLampiranText.classList.remove("hidden");
                } else {
                    if (noLampiranText) noLampiranText.classList.add("hidden");

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

                // ===== SPEEDOMETER (ADMIN ONLY, SELESAI) =====
                if (speedoSection && btn.dataset.status === "selesai") {
                    speedoSection.classList.remove("hidden");

                    if (speedoSebelum)
                        speedoSebelum.src = btn.dataset.speedometerSebelum
                            ? `/storage/${btn.dataset.speedometerSebelum}`
                            : "/img/no-image.png";

                    if (speedoSelepas)
                        speedoSelepas.src = btn.dataset.speedometerSelepas
                            ? `/storage/${btn.dataset.speedometerSelepas}`
                            : "/img/no-image.png";

                    if (ulasanText)
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
