<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /rechnungen/login");
    exit;
}

$anzahl_rechnungen_insgesammt = 0;
$anzahl_ueberfellig_offene_rechnungen = 0;
$anzahl_nicht_ueberfellig_offene_rechnungen = 0;
$anzahl_erledigte_rechnungen = 0;

foreach ($alle_rechnungen as $alle_rechnungenn){
    $anzahl_rechnungen_insgesammt++;
}

foreach ($ueberfellig_offene_rechnungen as $ueberfellig_offene_rechnungenn){
    $anzahl_ueberfellig_offene_rechnungen++;
}

foreach ($nicht_ueberfellige_offene_rechnungen as $nicht_ueberfellige_offene_rechnungenn){
    $anzahl_nicht_ueberfellig_offene_rechnungen++;
}

foreach ($erledigte_rechnungen as $erledigte_rechnungenn){
    $anzahl_erledigte_rechnungen++;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Rechnungen</title>
    <!-- CSS Import -->
    <link rel="stylesheet" href="../public/css/general.css">
    <link rel="stylesheet" href="../public/css/navigation.css">
    <link rel="stylesheet" href="../public/css/table.css">
    
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
        <a class="active" href="../rechnungen/rechnungen">Rechnungen</a>
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
    <h1><u>Rechnungen</u></h1>

    <?php
    if ($anzahl_rechnungen_insgesammt > 0){
        if ($anzahl_ueberfellig_offene_rechnungen > 0){
            /* Anzahl überfällige und offene Rechnungen */
            echo "<p style='color: red; font-weight: bold;'>Anzahl offen und überfällig ($anzahl_ueberfellig_offene_rechnungen)</p>";

            echo "<table>
                <tr>
                    <th>Titel</th>
                    <th>Beschreibung</th>
                    <th>Zu zahlender Betrag</th>
                    <th>Person</th>
                    <th>Datum</th>
                    <th>Datei</th>
                    <th>Bearbeiten</th>
                    <th>Löschen</th>
                    <th>Begleichen</th>
                    <th>Mahnen</th>
                </tr>";

            foreach ($ueberfellig_offene_rechnungen as $ueberfellig_offene_rechnungenn){
                echo "<tr>";
                echo "<td style='background-color: lightcoral;'>" . $ueberfellig_offene_rechnungenn['titel'] . "</td>";
                echo "<td style='background-color: lightcoral;'>" . $ueberfellig_offene_rechnungenn['beschreibung'] . "</td>";
                echo "<td style='background-color: lightcoral;'>" . $ueberfellig_offene_rechnungenn['betrag'] . ".-</td>";
                echo "<td style='background-color: lightcoral;'>" . $ueberfellig_offene_rechnungenn['namen'] . "</td>";
                echo "<td style='background-color: lightcoral;'>" . $ueberfellig_offene_rechnungenn['datum'] . "</td>";
                echo "<td style='background-color: lightcoral;'>" . $ueberfellig_offene_rechnungenn['datei'] . "</td>";
                echo "<td style='background-color: lightcoral;'><a href='editBill?id=" . $ueberfellig_offene_rechnungenn['id'] . "'><button class='edit'><i class='fas fa-edit'></i> Bearbeiten</button></a></td>";
                echo "<td style='background-color: lightcoral;'><a href='deleteBill?id=" . $ueberfellig_offene_rechnungenn['id'] . "'><button class='delete'><i class='fas fa-trash'></i> Löschen</button></a></td>";
                echo "<td style='background-color: lightcoral;'><a href='begleichen?id=" . $ueberfellig_offene_rechnungenn['id'] . "'><button class='Tofinish'><i class='fas fa-money-check'></i> Begleichen</button></a></td>";
                echo "<form action='addReminder' method='post'>";
                echo "<input style='display: none;' type='text' id='id' name='id' value=" . $ueberfellig_offene_rechnungenn['id'] . ">";
                echo "<td style='background-color: lightcoral;'><button type='submit' class='mahnen'><i class='fas fa-stopwatch'></i> Mahnen</button></td>";
                echo "</form>";
                echo "</tr>";
            }
        echo "</table><br><br>";  
        }
        if ($anzahl_nicht_ueberfellig_offene_rechnungen > 0){
            /* Anzahl Rechnungen die nicht überfällig aber offen sind */
            echo "<p style='color: green; font-weight: bold;'>Anzahl offen und nicht überfällig ($anzahl_nicht_ueberfellig_offene_rechnungen)</p>";

            echo "<table>
                <tr>
                    <th>Titel</th>
                    <th>Beschreibung</th>
                    <th>Zu zahlender Betrag</th>
                    <th>Person</th>
                    <th>Datum</th>
                    <th>Datei</th>
                    <th>Bearbeiten</th>
                    <th>Löschen</th>
                    <th>Begleichen</th>
                </tr>";

            foreach ($nicht_ueberfellige_offene_rechnungen as $nicht_ueberfellige_offene_rechnungenn){
                echo "<tr>";
                echo "<td style='background-color: lightgreen;'>" . $nicht_ueberfellige_offene_rechnungenn['titel'] . "</td>";
                echo "<td style='background-color: lightgreen;'>" . $nicht_ueberfellige_offene_rechnungenn['beschreibung'] . "</td>";
                echo "<td style='background-color: lightgreen;'>" . $nicht_ueberfellige_offene_rechnungenn['betrag'] . ".-</td>";
                echo "<td style='background-color: lightgreen;'>" . $nicht_ueberfellige_offene_rechnungenn['namen'] . "</td>";
                echo "<td style='background-color: lightgreen;'>" . $nicht_ueberfellige_offene_rechnungenn['datum'] . "</td>";
                echo "<td style='background-color: lightgreen;'>" . $nicht_ueberfellige_offene_rechnungenn['datei'] . "</td>";
                echo "<td style='background-color: lightgreen;'><a href='editBill?id=" . $nicht_ueberfellige_offene_rechnungenn['id'] . "'><button class='edit'><i class='fas fa-edit'></i> Bearbeiten</button></a></td>";
                echo "<td style='background-color: lightgreen;'><a href='deleteBill?id=" . $nicht_ueberfellige_offene_rechnungenn['id'] . "'><button class='delete'><i class='fas fa-trash'></i> Löschen</button></a></td>";
                echo "<td style='background-color: lightgreen;'><a href='begleichen?id=" . $nicht_ueberfellige_offene_rechnungenn['id'] . "'><button class='Tofinish'><i class='fas fa-money-check'></i> Begleichen</button></a></td>";
                echo "</tr>";
            }
            echo "</table><br><br>";
        }
        if ($anzahl_erledigte_rechnungen > 0){
            /* Beglichene Rechnungen */
            echo "<p style='font-weight: bold;'>Anzahl beglichener Rechnungen ($anzahl_erledigte_rechnungen)</p>";

            echo "<table>
                <tr>
                    <th>Titel</th>
                    <th>Beschreibung</th>
                    <th>Zu zahlender Betrag</th>
                    <th>Person</th>
                    <th>Datum</th>
                    <th>Datei</th>
                    <th>Bearbeiten</th>
                    <th>Löschen</th>
                    <th>Begleichen</th>
                </tr>";

            foreach ($erledigte_rechnungen as $erledigte_rechnungenn){
                echo "<tr>";
                echo "<td>" . $erledigte_rechnungenn['titel'] . "</td>";
                echo "<td>" . $erledigte_rechnungenn['beschreibung'] . "</td>";
                echo "<td>" . $erledigte_rechnungenn['betrag'] . ".-</td>";
                echo "<td>" . $erledigte_rechnungenn['namen'] . "</td>";
                echo "<td>" . $erledigte_rechnungenn['datum'] . "</td>";
                echo "<td>" . $erledigte_rechnungenn['datei'] . "</td>";
                echo "<td><a href='editBill?id=" . $erledigte_rechnungenn['id'] . "'><button class='edit'><i class='fas fa-edit'></i> Bearbeiten</button></a></td>";
                echo "<td><a href='deleteBill?id=" . $erledigte_rechnungenn['id'] . "'><button class='delete'><i class='fas fa-trash'></i> Löschen</button></a></td>";
                echo "<td><button class='finish'><i class='fas fa-check'></i> Beglichen</button></td>";
                echo "</tr>";
            }
            echo "</table><br><br>";
        }
    }else{
        echo "<h1 style='color: red';>Es wurde noch keine Rechnung hinzugefügt</h1>";
    }

    /* Rechnung hinzufügen */
    echo "<button class='hinzufuegen' onclick='addBill()'><i class='fas fa-plus'></i> Rechnung hinzufügen</button>";
    ?>
    
</main>

<script src="../public/js/app.js"></script>
</body>
</html>
