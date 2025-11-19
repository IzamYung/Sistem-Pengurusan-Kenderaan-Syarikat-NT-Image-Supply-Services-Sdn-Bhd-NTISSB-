export default function initLiveSearch({
    inputId,
    cardClass,
    noMatchId,
    noItemId,
}) {
    const searchInput = document.getElementById(inputId);
    const cards = document.querySelectorAll(`.${cardClass}`);
    const noMatch = document.getElementById(noMatchId);
    const noItem = document.getElementById(noItemId);

    if (!searchInput) return;

    searchInput.addEventListener("input", () => {
        const query = searchInput.value.toLowerCase();
        let anyVisible = false;

        cards.forEach((card) => {
            const match =
                (card.dataset.name &&
                    card.dataset.name.toLowerCase().includes(query)) ||
                (card.dataset.no_pendaftaran &&
                    card.dataset.no_pendaftaran.toLowerCase().includes(query));
            card.style.display = match ? "" : "none";
            if (match) anyVisible = true;
        });

        if (cards.length === 0) {
            noItem?.classList.remove("hidden");
            noMatch?.classList.add("hidden");
        } else if (!anyVisible) {
            noMatch?.classList.remove("hidden");
            noItem?.classList.add("hidden");
        } else {
            noMatch?.classList.add("hidden");
            noItem?.classList.add("hidden");
        }
    });
}
