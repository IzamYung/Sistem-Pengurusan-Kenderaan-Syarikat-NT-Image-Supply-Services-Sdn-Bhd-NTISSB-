import "./bootstrap";

// password toggle functionality
document.addEventListener("DOMContentLoaded", () => {
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    if (togglePassword && passwordInput && toggleIcon) {
        togglePassword.addEventListener("click", () => {
            const type =
                passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;

            toggleIcon.src =
                type === "password"
                    ? "/images/view_password.png"
                    : "/images/hide_password.png";
        });
    }
});

// floating card functionality
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

            body.style.overflow = "hidden";
            body.style.paddingRight = `${
                window.innerWidth - document.documentElement.clientWidth
            }px`;

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

// auto search functionality
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchUser");
    const userCards = document.querySelectorAll(".user-card");
    const noMatch = document.getElementById("noMatch");
    const noUser = document.getElementById("noUser");

    if (!searchInput) return;

    searchInput.addEventListener("input", function () {
        const query = searchInput.value.toLowerCase();
        let anyVisible = false;

        userCards.forEach((card) => {
            const name = card.dataset.name.toLowerCase();
            if (name.includes(query)) {
                card.style.display = "";
                anyVisible = true;
            } else {
                card.style.display = "none";
            }
        });

        if (userCards.length === 0) {
            noUser?.classList.remove("hidden");
            noMatch?.classList.add("hidden");
        } else if (!anyVisible) {
            noMatch?.classList.remove("hidden");
            noUser?.classList.add("hidden");
        } else {
            noMatch?.classList.add("hidden");
            noUser?.classList.add("hidden");
        }
    });
});

// delete users functionality
document.addEventListener("DOMContentLoaded", () => {
    const deleteBtn = document.getElementById("deleteSelected");
    const checkboxes = document.querySelectorAll(".userCheckbox");

    if (!deleteBtn || checkboxes.length === 0) return;

    checkboxes.forEach((cb) => {
        cb.addEventListener("click", (e) => e.stopPropagation());

        cb.addEventListener("change", () => {
            const anyChecked = Array.from(checkboxes).some((c) => c.checked);
            deleteBtn.disabled = !anyChecked;

            deleteBtn.classList.toggle("opacity-50", !anyChecked);
            deleteBtn.classList.toggle("cursor-not-allowed", !anyChecked);
        });
    });

    deleteBtn.addEventListener("click", () => {
        const selectedIds = Array.from(checkboxes)
            .filter((c) => c.checked)
            .map((c) => c.dataset.id);

        if (!selectedIds.length) return;
        if (!confirm("Adakah anda pasti mahu memadam pengguna yang dipilih?"))
            return;

        fetch("/admin/senarai-pengguna/delete", {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ ids: selectedIds }),
        })
            .then(async (res) => {
                const data = await res.json();
                if (!res.ok) {
                    alert(data.message || "Gagal memadam pengguna!");
                    return;
                }

                selectedIds.forEach((id) => {
                    const cb = document.querySelector(
                        `.userCheckbox[data-id="${id}"]`
                    );
                    cb?.closest(".user-card")?.remove();
                });
                deleteBtn.disabled = true;
                deleteBtn.classList.add("opacity-50", "cursor-not-allowed");
                alert(data.message || "Pengguna berjaya dipadam!");
            })
            .catch((err) => {
                console.error(err);
                alert("Gagal memadam pengguna!");
            });
    });
});
