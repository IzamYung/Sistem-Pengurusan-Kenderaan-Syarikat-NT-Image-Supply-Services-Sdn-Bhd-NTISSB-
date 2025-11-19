import "./bootstrap";

import initPasswordToggle from "./passwordToggle";
import initFilePreview from "./filePreview";
import initModal from "./modal";
import initLiveSearch from "./liveSearch";
import initDelete from "./deleteSelected";

// Initialize
document.addEventListener("DOMContentLoaded", () => {
    initPasswordToggle();
    initFilePreview();
    initModal();

    // For user page
    if (document.querySelector("#searchUser")) {
        initLiveSearch({
            inputId: "searchUser",
            cardClass: "user-card",
            noMatchId: "noMatch",
            noItemId: "noUser",
        });
        initDelete({
            buttonId: "deleteSelected",
            checkboxClass: "userCheckbox",
            apiUrl: "/admin/senarai-pengguna/delete",
        });
    }

    // For vehicle page
    if (document.querySelector("#searchKenderaan")) {
        initLiveSearch({
            inputId: "searchKenderaan",
            cardClass: "vehicle-card",
            noMatchId: "noMatchVehicle",
            noItemId: "noVehicle",
        });
        initDelete({
            buttonId: "deleteSelectedVehicle",
            checkboxClass: "vehicleCheckbox",
            apiUrl: "/admin/senarai-kenderaan/delete",
        });
    }
});
