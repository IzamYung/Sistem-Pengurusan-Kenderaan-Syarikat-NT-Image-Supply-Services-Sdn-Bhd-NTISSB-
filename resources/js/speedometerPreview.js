/**
 * Fungsi untuk mengendalikan Live Preview gambar speedometer
 * dan integrasi dengan modal zoom.
 */
export default function initSpeedometerPreview() {
    // 1. Handle Live Preview apabila fail dipilih
    const fileInputs = document.querySelectorAll(
        'input[type="file"][name^="speedometer_"]'
    );

    fileInputs.forEach((input) => {
        input.addEventListener("change", function () {
            const file = this.files[0];
            // Mencari ID preview yang sepadan (contoh: preview-sebelum-ID atau preview-selepas-ID)
            const isSebelum = this.name === "speedometer_sebelum";
            const formContainer = this.closest("form");
            const previewImg = isSebelum
                ? formContainer.querySelector('img[id^="preview-sebelum-"]')
                : formContainer.querySelector('img[id^="preview-selepas-"]');

            if (file && previewImg) {
                const reader = new FileReader();
                reader.onloadend = function () {
                    previewImg.src = reader.result;
                    // Update data-modal-img untuk kegunaan modal zoom di app.js
                    previewImg.setAttribute("data-modal-img", reader.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // 2. Handle Modal Zoom (Jika belum ada dalam logic global anda)
    // Nota: app.js anda sudah ada logic klik .speedometer-preview,
    // jadi bahagian ini hanya sebagai pelengkap jika diperlukan.
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

        // Tutup modal jika klik butang tutup atau latar belakang
        modal.addEventListener("click", (e) => {
            if (e.target === modal || e.target.innerText === "×") {
                modal.classList.add("hidden");
            }
        });
    }
}
