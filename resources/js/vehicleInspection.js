/**
 * Toggle textarea Penjelasan/Ulasan
 * bila Status 2 atau 3 dipilih.
 */
export default function initPemeriksaanToggle() {
    const radioButtons = document.querySelectorAll(".status-radio");

    if (radioButtons.length === 0) return;

    function toggleUlasanField(key, status) {
        const ulasanRow = document.getElementById("ulasan-row-" + key);
        const ulasanTextarea = document.getElementById("ulasan-" + key);

        if (!ulasanRow || !ulasanTextarea) return;

        if (status === "2" || status === "3") {
            ulasanRow.classList.remove("hidden");
        } else {
            ulasanRow.classList.add("hidden");
            ulasanTextarea.value = "";
        }
    }

    radioButtons.forEach((radio) => {
        radio.addEventListener("change", function () {
            const key = this.dataset.key;
            const status = this.dataset.status;
            toggleUlasanField(key, status);
        });

        if (radio.checked) {
            const key = radio.dataset.key;
            const status = radio.dataset.status;
            toggleUlasanField(key, status);
        }
    });
}
