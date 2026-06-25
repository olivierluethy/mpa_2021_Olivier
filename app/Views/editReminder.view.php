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
    <title>Mahnung bearbeiten</title>
    <link rel="shortcut icon" href="../images/icon.png">
    <link rel="stylesheet" href="../public/css/editPage.css">
    <link rel="stylesheet" href="../public/css/general.css">
    <meta name="author" content="Olivier Luethy">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
<main>
    <h1>Mahnung bearbeiten</h1>

    <form action="editReminder?id=<?= $mahnung[0][0] ?>" method="post">
        <label for="titel">Titel:</label><br>
        <input type="text" name="titel" id="titel" value="<?= $mahnung[0][1] ?>"><br><br>

        <label for="datum">Datum:</label><br>
        <input type="date" id="datum" name="datum" value="<?= $mahnung[0][2] ?>"><br><br>
        
        <button type="submit" name="form-submit"><i class='fas fa-edit'></i> Mahnung bearbeiten</button>
    </form>
    <script src="../public/js/clientSideValidationReminder.js"></script>
</main>
    
</body>

</html>