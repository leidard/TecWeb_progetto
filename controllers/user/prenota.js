(function init() {
    let radios_service = document.getElementById('fieldset-service').getElementsByTagName("input");
    let radios_barber = document.getElementById('fieldset-barber').getElementsByTagName("input");
    let selected_svc = undefined;
    let selected_barbr = undefined;
    let confirm_btn_el = document.getElementById('conferma');

    function updateBTN() {
        let disabled = selected_svc === undefined || selected_barbr === undefined;
        confirm_btn_el.setAttribute("aria-disabled", disabled ? "true" : "false");
    }

    function setSelectedService(val) {
        selected_svc = val;
        updateBTN();
    }

    function setSelectedBarber(val) {
        selected_barbr = val;
        updateBTN();
    }

    Array.from(radios_service).forEach(el => {
        if (el.checked) setSelectedService(el.value);
        el.onclick = (e) => setSelectedService(e.target.value)
    });
    Array.from(radios_barber).forEach(el => {
        if (el.checked) setSelectedBarber(el.value);
        el.onclick = (e) => setSelectedBarber(e.target.value)
    });

    updateBTN();

    document.getElementById('new-book').onsubmit = (e) => {
        console.log(confirm_btn_el.ariaDisabled);
        if (confirm_btn_el.ariaDisabled === "true") {
            e.preventDefault();
            return false;
        }
        return true;
    }
})();