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

        if (document.querySelector('#titel') != null) {
            if (document.querySelector('#titel').value.trim() === '') {
                document.querySelector('#titel').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie einen Titel ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#beschreibung') != null) {
            if (document.querySelector('#beschreibung').value.trim() === '') {
                document.querySelector('#beschreibung').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie eine Beschreibung ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#betrag') != null) {
            if (document.querySelector('#betrag').value.trim() === '' || (document.querySelector('#betrag').value.includes("/^\d+$/"))) {
                document.querySelector('#betrag').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie einen Betrag ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#person') != null) {
            if (document.querySelector('#person').value.trim() === '') {
                document.querySelector('#person').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte wählen Sie eine Person aus</label>");
                errors = true;
            }
        }

        if (document.querySelector('#datum') != null) {
            if (document.querySelector('#datum').value.trim() === '') {
                document.querySelector('#datum').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte wählen Sie ein Datum aus</label>");
                errors = true;
            }
        }

        if (errors) {
            evt.preventDefault();
        }

    });
});