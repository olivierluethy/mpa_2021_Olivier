<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: rechnungen/login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rechnung bearbeiten</title>
    <link rel="shortcut icon" href="../images/icon.png">
    <link rel="stylesheet" href="../public/css/editPage.css">
    <link rel="stylesheet" href="../public/css/general.css">
    <meta name="author" content="Olivier Luethy">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
<main>
    <h1>Rechnung bearbeiten</h1>

    <form action="editBill?id=<?= $rechnung[0][0] ?>" method="post">
        <label for="titel">Titel:</label><br>
        <input type="text" name="titel" id="titel" value="<?= $rechnung[0][1] ?>"><br><br>

        <label for="beschreibung">Beschreibung:</label><br>
        <textarea type="text" name="beschreibung" id="beschreibung" rows="4" cols="50"><?= $rechnung[0][2] ?></textarea><br><br>

        <label for="betrag">Der zu zahlende Betrag:</label><br>
        <input type="text" name="betrag" id="betrag" value="<?= $rechnung[0][3] ?>"><br><br>

        <label for="person">Person:</label><br>

        <select name="person" id="person" require>

        <?php 
        foreach ($personen as $person){
            if ($rechnung[0][5] == $person['id']){
                echo "<option value='" . $person['id'] . "' selected>" . $person['id'] . ", " . $person['namen'] . "</option>";
            }else{
                echo "<option value='" . $person['id'] . "'>" . $person['id'] . ", " . $person['namen'] . "</option>";
            }
        }?>

        </select><br><br>

        <label for="datum">Datum:</label><br>
        <input type="date" id="datum" name="datum" value="<?= $rechnung[0][6] ?>"><br><br>
        
        <button type="submit" name="form-submit"><i class='fas fa-edit'></i> Rechnung bearbeiten</button>
    </form>
    <script src="../public/js/clientSideValidationRechnung.js"></script>
</main>
    
</body>

</html>