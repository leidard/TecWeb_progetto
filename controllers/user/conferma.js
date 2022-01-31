(function init() {
    let radios_service = document.getElementById('fieldset-hour').getElementsByTagName("input");
    let selected_hour = undefined;
    let confirm_btn_el = document.getElementById('conferma');

    function updateBTN() {
        let disabled = selected_hour === undefined;
        confirm_btn_el.setAttribute("aria-disabled", disabled ? "true" : "false");
    }

    function setHour(val) {
        selected_hour = val;
        updateBTN();
    }

    Array.from(radios_service).forEach(el => {
        if (el.checked) setHour(el.value);
        el.onclick = (e) => setHour(e.target.value)
    });

    updateBTN();

    document.getElementById('confirm-book').onsubmit = (e) => {
        console.log(confirm_btn_el.ariaDisabled);
        if (confirm_btn_el.ariaDisabled === "true") {
            e.preventDefault();
            return false;
        }
        return true;
    }
})();