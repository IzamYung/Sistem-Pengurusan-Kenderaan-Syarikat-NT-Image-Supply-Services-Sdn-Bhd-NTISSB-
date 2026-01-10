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

    if (radioButtons.length === 0) return;

    const kamusKomponen = {
        badan_luaran: "Badan Luaran Kenderaan",
        cermin_hadapan: "Cermin Hadapan / Kaca",
        pengelap_cermin: "Pengelap Cermin",
        lampu: "Lampu (Hadapan, Brek, Isyarat Belok)",
        lampu_dalaman: "Lampu Dalaman",
        penghawa_dingin: "Operasi Penghawa Dingin",
        pemanasan: "Pemanasan",
        brek: "Brek (Pad / Kasut Brek)",
        salur_hos_brek: "Salur & Hos Brek",
        sistem_stereng: "Sistem Stereng",
        penyerap_kejutan: "Penyerap Kejutan & Topang",
        sistem_ekzos: "Sistem Ekzos",
        salur_hos_bahan_api: "Salur & Hos Bahan Api",
        minyak_enjin: "Minyak Enjin",
        bendalir_brek: "Bendalir Brek",
        bendalir_stereng: "Bendalir Stereng Kuasa",
        bendalir_pencuci: "Bendalir Pencuci Cermin",
        tali_sawat_hos: "Tali Sawat & Hos",
        antibeku_penyejuk: "Anti-Beku / Penyejuk",
        penapis_udara: "Penapis Udara",
        penapis_kabin: "Penapis Kabin",
        penapis_bahan_api: "Penapis Bahan Api",
        palam_pencucuh: "Plam Pencucuh / Wayar",
        bendalir_transmisi: "Bendalir Transmisi dan Perumah",
        sistem_gantung: "Sistem Gantung / Ampaian",
        caj_bateri: "Caj Bateri",
        bendalir_bateri: "Bendalir Bateri",
        kabel_sambungan: "Kabel & Sambungan",
        bunga_kiri_hadapan: "Kedalaman Bunga (Kiri Hadapan)",
        bunga_kiri_belakang: "Kedalaman Bunga (Kiri Belakang)",
        bunga_kanan_hadapan: "Kedalaman Bunga (Kanan Hadapan)",
        bunga_kanan_belakang: "Kedalaman Bunga (Kanan Belakang)",
        udara_kiri_hadapan: "Tekanan Udara (Kiri Hadapan)",
        udara_kiri_belakang: "Tekanan Udara (Kiri Belakang)",
        udara_kanan_hadapan: "Tekanan Udara (Kanan Hadapan)",
        udara_kanan_belakang: "Tekanan Udara (Kanan Belakang)",
        penjajaran: "Penjajaran (Alignment)",
        pengimbangan: "Pengimbangan (Balancing)",
        putaran: "Putaran (Rotation)",
        tayar_baru: "Tayar Baru (Ganti)",
    };

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

        let ayatFinal = "";
        if (rosak.length > 0)
            ayatFinal += "Kerosakan kritikal pada: " + rosak.join(", ") + ". ";
        if (perhatian.length > 0)
            ayatFinal +=
                "Perlu perhatian segera bagi: " + perhatian.join(", ") + ".";
        hiddenInput.value = ayatFinal;
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
