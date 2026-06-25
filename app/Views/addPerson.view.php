<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /rechnungen/login");
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
    <title>Person hinzufügen</title>
</head>
<body>
<main>
    <h1>Person hinzufügen</h1>

     <form action="addPerson" method="post">
        <label for="namen">Namen:</label><br>
        <input type="text" name="namen" id="namen" require><br><br>

        <label for="adresse">Adresse:</label><br>
        <input type="text" name="adresse" id="adresse" require><br><br>

        <label for="telefonnummer">Telefonnummer:</label><br>
        <input type="text" name="telefonnummer" id="telefonnummer"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email"><br><br>
      
        <button class="reset" type="reset"><i class="fas fa-undo"></i> Reset</button>
        <button type="submit" name="form-submit"><i class="fas fa-plus"></i> Person hinzufügen</button>
    </form>
    <script src="../public/js/clientSideValidationPerson.js"></script>
</main>
    
</body>
</html>