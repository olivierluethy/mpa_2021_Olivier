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
    <title>Person bearbeiten</title>
    <link rel="shortcut icon" href="../images/icon.png">
    <link rel="stylesheet" href="../public/css/editPage.css">
    <link rel="stylesheet" href="../public/css/general.css">
    <meta name="author" content="Olivier Luethy">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
<main>
    <h1>Person bearbeiten</h1>

    <form action="editPerson?id=<?= $personen[0][0] ?>" method="post">
        <label for="namen">Namen:</label><br>
        <input type="text" name="namen" id="namen" value="<?= $personen[0][1] ?>"><br><br>

        <label for="email">Adresse:</label><br>
        <textarea type="text" name="adresse" id="adresse" rows="4" cols="50"><?= $personen[0][2] ?></textarea><br><br>

        <label for="telefonnummer">Telefonnummer:</label><br>
        <input type="text" name="telefonnummer" id="telefonnummer" value="<?= $personen[0][3] ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= $personen[0][4] ?>"><br><br>
        <button type="submit" name="form-submit"><i class='fas fa-edit'></i> Person bearbeiten</button>
    </form>
    <script src="../public/js/clientSideValidationPerson.js"></script>
</main>
    
</body>

</html>