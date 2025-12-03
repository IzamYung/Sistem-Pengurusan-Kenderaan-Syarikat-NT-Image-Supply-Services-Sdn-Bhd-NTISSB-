export default function initVehicleFilter({
    searchId,
    cardClass,
    jenamaSelectName,
    kapasitiInputName,
    noMatchId,
    noItemId,
}) {
    const searchInput = document.getElementById(searchId);
    const cards = document.querySelectorAll(`.${cardClass}`);
    const jenamaSelect = document.querySelector(
        `select[name='${jenamaSelectName}']`
    );
    const kapasitiInput = document.querySelector(
        `input[name='${kapasitiInputName}']`
    );
    const noMatch = document.getElementById(noMatchId);
    const noItem = document.getElementById(noItemId);

    if (!cards || cards.length === 0) return;

    function filterCards() {
        const query = searchInput?.value.toLowerCase() || "";
        const jenamaVal = jenamaSelect?.value.toLowerCase() || "";
        const kapasitiVal = parseInt(kapasitiInput?.value) || 0; // empty input = 0

        let anyVisible = false;

        cards.forEach((card) => {
            const name = card.dataset.name?.toLowerCase() || "";
            const plate = card.dataset.no_pendaftaran?.toLowerCase() || "";
            const brand = card.dataset.jenama?.toLowerCase() || "";
            const seat = parseInt(card.dataset.kapasiti) || 0;

            let visible = true;

            if (query && !name.includes(query) && !plate.includes(query))
                visible = false;
            if (jenamaVal && jenamaVal !== brand) visible = false;
            if (kapasitiVal > 0 && seat < kapasitiVal) visible = false;

            card.style.display = visible ? "" : "none";
            if (visible) anyVisible = true;
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
    }

    searchInput?.addEventListener("input", filterCards);
    jenamaSelect?.addEventListener("change", filterCards);
    kapasitiInput?.addEventListener("input", filterCards);

    filterCards(); // initial run
}
