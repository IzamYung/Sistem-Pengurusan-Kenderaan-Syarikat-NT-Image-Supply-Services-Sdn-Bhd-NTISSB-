export default function initPemeriksaanToggle() {
    const radioButtons = document.querySelectorAll(".status-radio");
    // Kita cari input hidden yang kita akan buat dekat Blade nanti
    const hiddenInput = document.getElementById("ulasan_kerosakan_auto");

    if (radioButtons.length === 0) return;

    // "Kamus" untuk tukar ID/Key DB kepada Nama Manusia
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
        palam_pencucuh: "Palam Pencucuh / Wayar",
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

        // Scan semua radio button yang kena tick
        document.querySelectorAll(".status-radio:checked").forEach((radio) => {
            const key = radio.dataset.key;
            const status = radio.dataset.status;
            const namaPenuh = kamusKomponen[key] || key;

            if (status === "3") {
                rosak.push(namaPenuh);
            } else if (status === "2") {
                perhatian.push(namaPenuh);
            }
        });

        // Cantum jadi ayat
        let ayatFinal = "";
        if (rosak.length > 0) {
            ayatFinal += "Kerosakan kritikal pada: " + rosak.join(", ") + ". ";
        }
        if (perhatian.length > 0) {
            ayatFinal +=
                "Perlu perhatian segera bagi: " + perhatian.join(", ") + ".";
        }

        // Simpan dalam input tersembunyi
        hiddenInput.value = ayatFinal;
    }

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

        // JALANKAN bina ayat setiap kali status berubah
        binaAyatRumusan();
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
