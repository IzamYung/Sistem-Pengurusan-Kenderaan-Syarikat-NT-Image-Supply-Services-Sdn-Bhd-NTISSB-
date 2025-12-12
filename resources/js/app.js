import "./bootstrap";
import initPasswordToggle from "./passwordToggle";
import initFilePreview from "./filePreview";
import initModal from "./modal";
import initLiveSearch from "./liveSearch";
import initVehicleFilter from "./filter";
import initDelete from "./deleteSelected";
import initVehicleBooking from "./vehicleBooking";
import initPemeriksaanToggle from "./vehicleInspection";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

document.addEventListener("DOMContentLoaded", () => {
    initPasswordToggle();
    initFilePreview();
    initModal();
    initPemeriksaanToggle();

    // USERS
    if (document.querySelector("#searchUser")) {
        initLiveSearch({
            inputId: "searchUser",
            cardClass: "user-card",
            noMatchId: "noMatch",
            noItemId: "noUser",
        });
    }

    // VEHICLES
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

    // PERMOHONAN PAGE (if combined)
    if (document.querySelector("#searchPermohonan")) {
        initLiveSearch({
            inputId: "searchPermohonan",
            cardClass: "permohonan-card",
            noMatchId: "noMatchPermohonan",
            noItemId: "noPermohonan",
        });

        if (document.querySelector("#searchKenderaan")) {
            initVehicleFilter({
                searchId: "searchKenderaan",
                cardClass: "vehicle-card",
                jenamaSelectName: "jenama",
                kapasitiInputName: "kapasiti",
                noMatchId: "noMatchVehicle",
                noItemId: "noVehicle",
            });
        }
    }

    // DELETE
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

    // ROADTAX DATES FLATPICKR
    const startInput = document.querySelector("#tarikhMulaRoadtax");
    const endInput = document.querySelector("#tarikhTamatRoadtax");

    if (startInput && endInput) {
        const startPicker = flatpickr(startInput, {
            dateFormat: "Y-m-d",
            allowInput: true,
            clickOpens: true,
            onChange: function (selectedDates) {
                endPicker.redraw(); // refresh gray styling when start changes
            },
        });

        const endPicker = flatpickr(endInput, {
            dateFormat: "Y-m-d",
            allowInput: true,
            clickOpens: true,
            onDayCreate: function (dObj, dStr, fp, dayElem) {
                const startDate = startPicker.selectedDates[0];
                if (startDate && dayElem.dateObj < startDate) {
                    dayElem.classList.add(
                        "bg-gray-200",
                        "text-gray-400",
                        "cursor-not-allowed",
                        "opacity-60"
                    );
                    // prevent selection
                    dayElem.addEventListener("click", (e) =>
                        e.preventDefault()
                    );
                }
            },
            onChange: function (selectedDates, dateStr, instance) {
                const startDate = startPicker.selectedDates[0];
                if (startDate && selectedDates[0] < startDate) {
                    instance.clear(); // auto-clear if user types or pastes invalid date
                }
            },
        });
    }
});
