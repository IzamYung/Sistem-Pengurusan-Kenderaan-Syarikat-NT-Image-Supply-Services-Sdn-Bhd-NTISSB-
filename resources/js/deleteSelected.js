export default function initDelete({ buttonId, checkboxClass, apiUrl }) {
    const deleteBtn = document.getElementById(buttonId);
    const checkboxes = document.querySelectorAll(`.${checkboxClass}`);

    if (!deleteBtn) return;

    const refreshDeleteState = () => {
        const anyChecked = [...checkboxes].some((c) => c.checked);
        deleteBtn.disabled = !anyChecked;
        deleteBtn.classList.toggle("opacity-50", !anyChecked);
        deleteBtn.classList.toggle("cursor-not-allowed", !anyChecked);
    };

    checkboxes.forEach((cb) => {
        cb.addEventListener("click", (e) => e.stopPropagation());
        cb.addEventListener("change", refreshDeleteState);
    });

    deleteBtn.addEventListener("click", () => {
        const selectedIds = [...checkboxes]
            .filter((c) => c.checked)
            .map((c) => c.dataset.id);
        if (!selectedIds.length) return;
        if (!confirm("Adakah anda pasti mahu memadam item yang dipilih?"))
            return;

        fetch(apiUrl, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ ids: selectedIds }),
        })
            .then((res) => res.json().then((data) => ({ res, data })))
            .then(({ res, data }) => {
                if (!res.ok)
                    return alert(data.message || "Gagal memadam item!");
                selectedIds.forEach((id) => {
                    document
                        .querySelector(`.${checkboxClass}[data-id="${id}"]`)
                        ?.closest(".user-card")
                        ?.remove();
                });
                refreshDeleteState();
                alert(data.message || "Berjaya dipadam!");
            })
            .catch(() => alert("Gagal memadam item!"));
    });
}
