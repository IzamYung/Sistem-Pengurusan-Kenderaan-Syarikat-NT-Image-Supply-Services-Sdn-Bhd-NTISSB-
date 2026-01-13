import "./bootstrap";
import initPasswordToggle from "./passwordToggle";
import { initModal, initPermohonanModal, initKerosakanModal } from "./modal";
import {
    initLiveSearch,
    initVehicleFilter,
    initPermohonanFilter,
} from "./searchFilter";
import { initDelete, initMultiFilePicker } from "./multiSelected";
import { initVehicleBooking, initSpeedometerPreview } from "./vehicleProcess";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

document.addEventListener("DOMContentLoaded", () => {
    initPasswordToggle();
    initModal();
    initPermohonanModal();
    initKerosakanModal();
    initPermohonanFilter();
    initSpeedometerPreview();

    if (document.querySelector("#lampiranInput")) {
        initMultiFilePicker({
            inputId: "lampiranInput",
            listId: "lampiranList",
        });
    }

    if (document.querySelector("#searchUser")) {
        initLiveSearch({
            inputId: "searchUser",
            cardClass: "user-card",
            noMatchId: "noMatch",
            noItemId: "noUser",
        });
    }

    if (document.querySelector("#searchKenderaan")) {
        initLiveSearch({
            inputId: "searchKenderaan",
            cardClass: "vehicle-card",
            noMatchId: "noMatchVehicle",
            noItemId: "noVehicle",
        });

        initVehicleFilter({
            searchId: "searchKenderaan",
            cardClass: "vehicle-card",
            jenamaSelectName: "jenama",
            kapasitiInputName: "kapasiti",
            noMatchId: "noMatchVehicle",
            noItemId: "noVehicle",
        });
    }

    if (document.querySelector("#searchPermohonan")) {
        initLiveSearch({
            inputId: "searchPermohonan",
            cardClass: "permohonan-card",
            noMatchId: "noMatchPermohonan",
            noItemId: "noPermohonan",
        });
    }

    if (document.querySelector("#deleteSelected")) {
        initDelete({
            buttonId: "deleteSelected",
            checkboxClass: "userCheckbox",
            apiUrl: "/admin/senarai-pengguna/delete",
        });
    }

    if (document.querySelector("#deleteSelectedVehicle")) {
        initDelete({
            buttonId: "deleteSelectedVehicle",
            checkboxClass: "vehicleCheckbox",
            apiUrl: "/admin/senarai-kenderaan/delete",
        });
    }

    if (document.querySelector("#tarikhPelepasan") && window.bookedDates) {
        initVehicleBooking({
            inputId: "tarikhPelepasan",
            bookedDates: window.bookedDates,
        });
    }

    const startInput = document.querySelector("#tarikhMulaRoadtax");
    const endInput = document.querySelector("#tarikhTamatRoadtax");

    if (startInput && endInput) {
        const startPicker = flatpickr(startInput, {
            dateFormat: "Y-m-d",
            allowInput: true,
            clickOpens: true,
            onChange() {
                endPicker.redraw();
            },
        });

        const endPicker = flatpickr(endInput, {
            dateFormat: "Y-m-d",
            allowInput: true,
            clickOpens: true,
            onDayCreate(dObj, dStr, fp, dayElem) {
                const startDate = startPicker.selectedDates[0];
                if (startDate && dayElem.dateObj < startDate) {
                    dayElem.classList.add(
                        "bg-gray-200",
                        "text-gray-400",
                        "cursor-not-allowed",
                        "opacity-60"
                    );
                    dayElem.addEventListener("click", (e) =>
                        e.preventDefault()
                    );
                }
            },
            onChange(selectedDates, dateStr, instance) {
                const startDate = startPicker.selectedDates[0];
                if (startDate && selectedDates[0] < startDate) {
                    instance.clear();
                }
            },
        });
    }

    document.querySelectorAll(".speedometer-preview").forEach((img) => {
        img.addEventListener("click", () => {
            const modalImg = document.getElementById("modalSpeedometerImg");
            if (modalImg) modalImg.src = img.dataset.modalImg;
        });
    });
});
