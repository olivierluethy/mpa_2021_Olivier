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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../public/css/addPage.css">
    <link rel="stylesheet" href="../public/css/general.css">
    <link rel="shortcut icon" href="../images/icon.png">
    <meta name="author" content="Olivier Luethy">
    <title>Mahnung hinzufügen</title>
</head>
<body>
<main>
    <h1>Mahnung hinzufügen</h1>

     <form action="addReminder2" method="post">
        <label for="titel">Titel:</label><br>
        <input type="text" name="titel" id="titel" require><br><br>

        <label for="datum">Datum:</label><br>
        <input type="date" name="datum" id="datum" require><br><br>

        <input style="display: none;" type="text" name="id" id="id" value="<?= e($id) ?>">
      
        <button class="reset" type="reset"><i class="fas fa-undo"></i> Reset</button>
        <button type="submit" name="form-submit"><i class="fas fa-plus"></i> Mahnung hinzufügen</button>
    </form>
    <script src="../public/js/clientSideValidationReminder.js"></script>
</main>
    
</body>
</html>