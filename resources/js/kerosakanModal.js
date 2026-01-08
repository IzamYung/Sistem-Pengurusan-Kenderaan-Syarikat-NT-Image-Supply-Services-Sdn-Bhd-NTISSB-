export function initKerosakanModal() {
    const modal = document.getElementById("modalPermohonan");
    const modalCard = modal?.querySelector(".transform");
    if (!modal || !modalCard) return;

    document
        .querySelectorAll("[data-modal-open='modalPermohonan']")
        .forEach((card) => {
            card.addEventListener("click", () => {
                document.getElementById("m-no").innerText =
                    card.dataset.no ?? "-";
                document.getElementById("m-model").innerText =
                    card.dataset.model ?? "-";
                document.getElementById("m-jenis").innerText =
                    card.dataset.jenis ?? "-";
                document.getElementById("m-ulasan").innerText = (
                    card.dataset.ulasan ?? "-"
                ).replaceAll("[[SELESAI]]", "Selesai");
                document.getElementById("m-tarikh").innerText =
                    card.dataset.tarikh ?? "-";

                const form = document.getElementById("formSelesai");
                if (card.dataset.id) {
                    form.action = `/admin/kerosakan/selesai/${card.dataset.id}`;
                }

                modal.classList.remove("hidden");
                requestAnimationFrame(() => {
                    modalCard.classList.add("scale-100", "opacity-100");
                });
            });
        });

    document.querySelectorAll("[data-modal-close]").forEach((btn) => {
        btn.addEventListener("click", closeModal);
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    function closeModal() {
        modalCard.classList.remove("scale-100", "opacity-100");
        setTimeout(() => modal.classList.add("hidden"), 200);
    }
}
