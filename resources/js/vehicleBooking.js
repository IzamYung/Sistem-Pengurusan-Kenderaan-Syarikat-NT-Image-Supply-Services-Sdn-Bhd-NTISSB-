import flatpickr from "flatpickr";

export default function initVehicleBooking(options = {}) {
    const { inputId, bookedDates } = options;
    const input = document.getElementById(inputId);
    if (!input) return;

    const convertedDates = bookedDates.map((d) => {
        return new Date(d).toISOString().slice(0, 10); // only date part
    });

    flatpickr(input, {
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",

        disable: convertedDates, // 🔥 make them GRAY & unpickable

        onDayCreate: function (dObj, dStr, fp, dayElem) {
            const date = dayElem.dateObj.toISOString().slice(0, 10);

            if (convertedDates.includes(date)) {
                // 🔥 Style it gray & disabled
                dayElem.classList.add(
                    "bg-gray-200",
                    "text-gray-400",
                    "cursor-not-allowed",
                    "opacity-60"
                );
            }
        },

        onChange: function (selectedDates, dateStr) {
            const picked = selectedDates[0]?.toISOString().slice(0, 10);

            if (convertedDates.includes(picked)) {
                alert("Kereta ini telah ditempah pada tarikh ini.");
                this.clear();
            }
        },
    });
}
