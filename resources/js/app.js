import "./bootstrap";
import initPasswordToggle from "./passwordToggle";
import initFilePreview from "./filePreview";
import initModal from "./modal";
import initLiveSearch from "./liveSearch";
import initVehicleFilter from "./filter";
import initDelete from "./deleteSelected";

document.addEventListener("DOMContentLoaded", () => {
    initPasswordToggle();
    initFilePreview();
    initModal();

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
});
