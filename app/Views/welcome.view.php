<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: rechnungen/login");
    exit;
}

$dataCounter = 0;

foreach ($rechnungen as $rechnung){
    $dataCounter++;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Übersicht</title>
    <!-- CSS Import -->
    <link rel="stylesheet" href="../public/css/general.css">
    <link rel="stylesheet" href="../public/css/navigation.css">
    <link rel="stylesheet" href="../public/css/table.css">

    <link rel="shortcut icon" href="../images/icon.png">
    <meta name="author" content="Olivier Luethy">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<nav>
    <div class="title">
        <img src="../images/icon.png" alt="">
        <h1>Rechnungen verwalten</h1>
    </div>

    <div class="anchors">
        <a class="active" href="../rechnungen/uebersicht">Übersicht</a>
        <a href="../rechnungen/rechnungen">Rechnungen</a>
        <a href="../rechnungen/personen">Personen</a>
        <?php
        if(isset($_SESSION['loggedin']) == true){
            echo "<a href='../rechnungen/logout'>Logout</a>";
        }else{
            echo "<a href='../rechnungen/login'>Login</a>";
        }?>
    </div>
</nav>

<main>
    <h1><u>Übersicht offener Rechnungen</u></h1>

    <?php
    if($dataCounter > 0){
        echo "<table>
                <tr>
                    <th>Titel</th>
                    <th>Beschreibung</th>
                    <th>Betrag</th>
                    <th>Person</th>
                    <th>Datum</th>
                    <th>Datei</th>
                    <th>Übersicht</th>
                </tr>";

        foreach ($rechnungen as $rechnung){
            echo "<tr>";
            echo "<td>" . $rechnung['titel'] . "</td>";
            echo "<td>" . $rechnung['beschreibung'] . "</td>";
            echo "<td>" . $rechnung['betrag'] . "</td>";
            echo "<td>" . $rechnung['namen'] . "</td>";
            echo "<td>" . $rechnung['datum'] . "</td>";
            echo "<td>" . $rechnung['datei'] . "</td>";
            echo "<td><a href='uebersichtRechnung?id=" . $rechnung['id'] . "'><button class='uebersicht'><i class='fas fa-eye'></i> Übersicht anschauen</button></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }else{
        echo "<h1 style='color: red';>Es wurde noch keine offene Rechnungen erfasst</h1>";
    }
    echo "<button class='hinzufuegen' onclick='addBill()'><i class='fas fa-plus'></i> Rechnung hinzufügen</button>";
    ?>
</main>

<script src="../public/js/app.js"></script>
</body>
</html>
