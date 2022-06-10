<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mein Formular</title>
</head>
<body>
<form action="validationController.php" method="post">

    <fieldset>
        <legend>Anmeldung zum Firmenevent</legend>

        <label for="checkbox">Wir möchten den Shuttle-Bus-Service beanspruchen:</label><br>
        <input value="1" type="checkbox" name="shuttleBus"><br><br>

        <label for="name">Name:</label><br>
        <input type="text" name="name"><br><br>

        <label for="number">Wie viele Personen werden von Ihrer Firma teilnehmen?:</label><br>
        <input min="0" type="number" name="number"><br><br>

        <label for="telefon">Telefon:</label><br>
        <input type="text" name="telefon"><br><br>

        <label for="note">Haben Sie sonst noch einen Wunsch oder eine Bemerkung?</label><br>
        <textarea name="note" id="note" rows="3"></textarea><br><br>

        <label for="radio">In welchem Hotel möchten Sie übernachten?</label><br>
        <input type="radio" id="age1" name="name_des_hotels" value="InterContinental Davos">
        <label for="age1">InterContinental Davos</label><br>
        <input type="radio" id="age2" name="name_des_hotels" value="Steinberger Grandhotel Belvédère">
        <label for="age2">Steinberger Grandhotel Belvédère</label><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email"><br><br>

        <label for="frage">Was möchten Sie am Abend unternehmen?</label><br>
            <select name="was_am_abend_unternehmen">
                <option value="">Kein Abendprogramm</option>
                <option value="Billardturnier">Billardturnier</option>
                <option value="Bowlingturnier">Bowlingturnier</option>
                <option value="Weindegustation">Weindegustation</option>
                <option value="Asiatischer Kochkurs">Asiatischer Kochkurs</option>
                <option value="Tankzurs für Webentwickler">Tankzurs für Webentwickler</option>
                <option value="Ying &amp; Yang Yoga Einsteigerkurs">Ying &amp; Yang Yoga Einsteigerkurs</option>
            </select><br>
    </fieldset>

    <input type="submit" value="Anmelden"><br>

</form>

</body>
</html>