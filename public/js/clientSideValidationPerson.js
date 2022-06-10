// Clientside Validierung
window.addEventListener("load", function () {

    document.querySelector('form').addEventListener('submit', function (evt) {

        var errors = false;
        var warnings = document.querySelectorAll(".warning");
        if (warnings != null) {
            warnings.forEach(element => {
                element.remove();
            });
        }


        if (document.querySelector('#namen') != null) {
            if (document.querySelector('#namen').value.trim() === '') {
                document.querySelector('#namen').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie einen Namen ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#adresse') != null) {
            if (document.querySelector('#adresse').value.trim() === '') {
                document.querySelector('#adresse').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie eine Adresse ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#telefonnummer') != null) {
            if (document.querySelector('#telefonnummer').value.trim() === '' || (document.querySelector('#telefonnummer').value.includes("/[^0-9\/()\+\-\s]/g"))) {
                document.querySelector('#telefonnummer').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie eine gültige Telefonnummer ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#email') != null) {
            if (document.querySelector('#email').value.trim() === '' || !document.querySelector('#email').value.trim().includes("@")) {
                document.querySelector('#email').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie eine gültige Email ein</label>");
                errors = true;
            }
        }

        if (errors) {
            evt.preventDefault();
        }

    });
});