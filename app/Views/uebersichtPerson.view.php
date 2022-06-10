<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: rechnungen/login");
    exit;
}

$wie_oft_zu_spaet = 0;
$dataCounter = 0;

foreach($zu_spaet as $zu_spaets){
    $wie_oft_zu_spaet++;
}

foreach($rechnung as $rechnungs){
    $dataCounter++;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Übersicht Rechnung</title>
    <!-- CSS Import -->
    <link rel="stylesheet" href="../public/css/general.css">
    <link rel="stylesheet" href="../public/css/navigation.css">
    <link rel="stylesheet" href="../public/css/table.css">
    <link rel="stylesheet" href="../public/css/uebersichtSeiten.css">
    
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
        <a href="../rechnungen/uebersicht">Übersicht</a>
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
    
    <?php
    if($dataCounter > 0){
        if($wie_oft_zu_spaet > 0){
            echo "<h3 style='color: red; font-weight: bold;'>Der Kunde hat $wie_oft_zu_spaet Mal zu spät bezahlt</h3>";
        }else{
            echo "<h3 style='color: green; font-weight: bold;'>Der Kunde hat nie zu spät bezahlt</h3>";
        }

        echo "<h1><u>Übersicht von allen bisherigen Rechnungen</u></h1>

        <table>
            <tr>
                <th>Id</th>
                <th>Titel</th>
                <th>Beschreibung</th>
                <th>Betrag</th>
                <th>Status</th>
                <th>Person</th>
                <th>Datum</th>
                <th>Datei</th>
            </tr>";
            foreach ($rechnung as $rechnungs){
                echo "<tr>";
                echo "<td>" . $rechnungs['id'] . "</td>";
                echo "<td>" . $rechnungs['titel'] . "</td>";
                echo "<td>" . $rechnungs['beschreibung'] . "</td>";
                echo "<td>" . $rechnungs['betrag'] . ".-</td>";
                if($rechnungs['status'] == 0){
                    echo "<td>Offen</td>";
                }else{
                    echo "<td>Erledigt</td>";
                }
                echo "<td>" . $rechnungs['namen'] . "</td>";
                echo "<td>" . $rechnungs['datum'] . "</td>";
                echo "<td>" . $rechnungs['datei'] . "</td>";
                echo "</tr>";
            }
        echo "</table>";
    }else{
        echo "<h1>Person enthält noch keine Rechnungen</h1>";
    }
    
    ?>

    
</main>
<a href='personen'><button class='zurueck'><i class="fas fa-long-arrow-alt-left"></i> Zurück</button></a>

<script src="../public/js/app.js"></script>
</body>
</html>
