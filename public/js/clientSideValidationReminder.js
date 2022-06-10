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