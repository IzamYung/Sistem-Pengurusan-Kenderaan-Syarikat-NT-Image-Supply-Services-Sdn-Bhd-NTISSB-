export default function initModal() {
    const body = document.body;

    function openModal(modal, card) {
        body.style.overflow = "hidden";
        body.style.paddingRight = `${
            window.innerWidth - document.documentElement.clientWidth
        }px`;
        modal.classList.remove("hidden");

        requestAnimationFrame(() => {
            card.classList.remove("scale-95", "opacity-0");
            card.classList.add("scale-100", "opacity-100");
        });
    }

    function closeModal(modal, card) {
        card.classList.add("scale-95", "opacity-0");
        setTimeout(() => {
            modal.classList.add("hidden");
            body.style.overflow = "";
            body.style.paddingRight = "";
        }, 200);
    }

    document.querySelectorAll("[data-modal-open]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const modal = document.getElementById(btn.dataset.modalOpen);
            const card = modal?.querySelector("[data-modal-card]");
            if (modal && card) openModal(modal, card);
        });
    });

    document.querySelectorAll("[data-modal-close]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const modal = btn.closest("[data-modal]");
            const card = modal?.querySelector("[data-modal-card]");
            if (modal && card) closeModal(modal, card);
        });
    });

    document.querySelectorAll("[data-modal]").forEach((modal) => {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                const card = modal.querySelector("[data-modal-card]");
                closeModal(modal, card);
            }
        });
    });
}
