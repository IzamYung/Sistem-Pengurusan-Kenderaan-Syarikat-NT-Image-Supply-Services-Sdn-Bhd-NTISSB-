import "./bootstrap";

document.addEventListener("DOMContentLoaded", () => {
    const openButtons = document.querySelectorAll("[data-modal-open]");
    const closeButtons = document.querySelectorAll("[data-modal-close]");
    const body = document.body;

    openButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const targetId = btn.getAttribute("data-modal-open");
            const modal = document.getElementById(targetId);
            const card = modal?.querySelector("[data-modal-card]");
            if (!modal || !card) return;

            // disable scroll smoothly
            body.style.overflow = "hidden";
            body.style.paddingRight = `${
                window.innerWidth - document.documentElement.clientWidth
            }px`; // fix scrollbar jump

            modal.classList.remove("hidden");
            setTimeout(() => {
                card.classList.remove("scale-95", "opacity-0");
                card.classList.add("scale-100", "opacity-100");
            }, 10);
        });
    });

    function closeModal(modal, card) {
        card.classList.add("scale-95", "opacity-0");
        setTimeout(() => {
            modal.classList.add("hidden");
            // enable scroll again
            body.style.overflow = "";
            body.style.paddingRight = "";
        }, 200);
    }

    closeButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const modal = btn.closest("[data-modal]");
            const card = modal?.querySelector("[data-modal-card]");
            if (!modal || !card) return;
            closeModal(modal, card);
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
});
