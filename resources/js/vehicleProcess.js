import flatpickr from "flatpickr";
function initVehicleBooking({ inputId, bookedDates }) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const convertedDates = bookedDates.map((d) =>
        new Date(d).toISOString().slice(0, 10)
    );
    flatpickr(input, {
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        disable: convertedDates,
        onDayCreate(dObj, dStr, fp, dayElem) {
            const date = dayElem.dateObj.toISOString().slice(0, 10);
            if (convertedDates.includes(date)) {
                dayElem.classList.add(
                    "bg-gray-200",
                    "text-gray-400",
                    "cursor-not-allowed",
                    "opacity-60"
                );
            }
        },
        onChange(selectedDates) {
            const picked = selectedDates[0]?.toISOString().slice(0, 10);
            if (convertedDates.includes(picked)) {
                alert("Kereta ini telah ditempah pada tarikh ini.");
                this.clear();
            }
        },
    });
}
function initSpeedometerPreview() {
    const fileInputs = document.querySelectorAll(
        'input[type="file"][name^="speedometer_"]'
    );
    fileInputs.forEach((input) => {
        input.addEventListener("change", function () {
            const file = this.files[0];
            const isSebelum = this.name === "speedometer_sebelum";
            const formContainer = this.closest("form");
            const previewImg = isSebelum
                ? formContainer.querySelector('img[id^="preview-sebelum-"]')
                : formContainer.querySelector('img[id^="preview-selepas-"]');
            if (file && previewImg) {
                const reader = new FileReader();
                reader.onloadend = function () {
                    previewImg.src = reader.result;
                    previewImg.setAttribute("data-modal-img", reader.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
    const modal = document.getElementById("modalSpeedometer");
    const modalImg = document.getElementById("modalSpeedometerImg");
    if (modal && modalImg) {
        document.body.addEventListener("click", (e) => {
            if (e.target.classList.contains("speedometer-preview")) {
                const imgSrc = e.target.getAttribute("data-modal-img");
                if (imgSrc) {
                    modalImg.src = imgSrc;
                    modal.classList.remove("hidden");
                }
            }
        });
        modal.addEventListener("click", (e) => {
            if (e.target === modal || e.target.innerText === "×") {
                modal.classList.add("hidden");
            }
        });
    }
}
function initPemeriksaanToggle() {
    const radioButtons = document.querySelectorAll(".status-radio");
    const hiddenInput = document.getElementById("ulasan_kerosakan_auto");
    function binaAyatRumusan() {
        if (!hiddenInput) return;
        let rosak = [];
        let perhatian = [];
        document.querySelectorAll(".status-radio:checked").forEach((radio) => {
            const key = radio.dataset.key;
            const status = radio.dataset.status;
            const namaPenuh = kamusKomponen[key] || key;
            if (status === "3") rosak.push(namaPenuh);
            else if (status === "2") perhatian.push(namaPenuh);
        });
    }
    function toggleUlasanField(key, status) {
        const ulasanRow = document.getElementById("ulasan-row-" + key);
        const ulasanTextarea = document.getElementById("ulasan-" + key);
        if (!ulasanRow || !ulasanTextarea) return;
        if (status === "2" || status === "3")
            ulasanRow.classList.remove("hidden");
        else {
            ulasanRow.classList.add("hidden");
            ulasanTextarea.value = "";
        }
        binaAyatRumusan();
    }
    radioButtons.forEach((radio) => {
        radio.addEventListener("change", function () {
            toggleUlasanField(this.dataset.key, this.dataset.status);
        });
        if (radio.checked)
            toggleUlasanField(radio.dataset.key, radio.dataset.status);
    });
}
export { initVehicleBooking, initSpeedometerPreview, initPemeriksaanToggle };
