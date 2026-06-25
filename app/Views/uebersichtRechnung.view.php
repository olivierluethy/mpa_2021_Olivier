<?php
$reminderCounter = 0;

foreach ($mahnungen as $mahnung){
    $reminderCounter++;
}
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /rechnungen/login");
    exit;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
    <h1><u>Übersicht Rechnung</u></h1>
    
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
        </tr>

        <?php
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
            }?>
    </table>

    <h1><u>Übersicht Person</u></h1>

    <table>
        <tr>
            <th>Id</th>
            <th>Namen</th>
            <th>Adresse</th>
            <th>Telefonnummer</th>
            <th>Email</th>
        </tr>

        <?php
            foreach ($person as $persons){
                echo "<tr>";
                echo "<td>" . $persons['id'] . "</td>";
                echo "<td>" . $persons['namen'] . "</td>";
                echo "<td>" . $persons['adresse'] . "</td>";
                echo "<td>" . $persons['telefonnummer'] . "</td>";
                echo "<td>" . $persons['email'] . "</td>";
                echo "</tr>";
            }?>
    </table>

    <h1><u>Übersicht Mahnungen</u></h1>
            <?php
            if($reminderCounter > 0){
                echo "<table>
                    <tr>
                        <th>Id</th>
                        <th>Titel</th>
                        <th>Datum</th>
                        <th>Bearbeiten</th>
                        <th>Löschen</th>
                    </tr>";
                
                foreach ($mahnungen as $mahnung){
                    echo "<tr>";
                    echo "<td>" . $mahnung['id'] . "</td>";
                    echo "<td>" . $mahnung['titel'] . "</td>";
                    echo "<td>" . $mahnung['datum'] . "</td>";
                    echo "<td><a href='editReminder?id=" . $mahnung['id'] . "'><button class='edit'><i class='fas fa-edit'></i> Bearbeiten</button></a></td>";
                    echo "<td><a href='deleteReminder?id=" . $mahnung['id'] . "'><button class='delete'><i class='fas fa-trash'></i> Löschen</button></a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }else{
                echo "<h1 style='color: red';>Es wurde noch keine Mahnung hinzugefügt</h1>";
            }
    ?>
</main>
<a href='uebersicht'><button class='zurueck'><i class="fas fa-long-arrow-alt-left"></i> Zurück</button></a>

<script src="../public/js/app.js"></script>
</body>
</html>
