<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: rechnungen/login");
    exit;
}

$anzahl_personen_total = 0;
$anzahl_personen_zugeteilt = 0;
$anzahl_personen_nicht_zugeteilt = 0;

foreach ($personen as $person){
    $anzahl_personen_total++;
}

foreach ($personen_schon_zugeteilt as $personen_schon_zugeteiltt){
    $anzahl_personen_zugeteilt++;
}

foreach ($personen_nicht_zugeteilt as $personen_nicht_zugeteiltt){
    $anzahl_personen_nicht_zugeteilt++;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Personen</title>
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
        <a href="../rechnungen/uebersicht">Übersicht</a>
        <a href="../rechnungen/rechnungen">Rechnungen</a>
        <a class="active" href="../rechnungen/personen">Personen</a>
        <?php
        if(isset($_SESSION['loggedin']) == true){
            echo "<a href='../rechnungen/logout'>Logout</a>";
        }else{
            echo "<a href='../rechnungen/login'>Login</a>";
        }?>
    </div>
</nav>

<main>
    <h1><u>Personen</u></h1>

    <?php
    /* Exisieren Personen? */
    if($anzahl_personen_total > 0){
        /* Wenn ja wird kontrolliert, ob es Personen die schon zugeteilt wurden und auch die die nicht zugeteilt wurden existiert */
        if ($anzahl_personen_zugeteilt > 0 && $anzahl_personen_nicht_zugeteilt > 0){
            /* Alle Personen werden ausgegeben */
            echo "<table>
                <tr>
                    <th>Namen</th>
                    <th>Adresse</th>
                    <th>Telefonnummer</th>
                    <th>Email</th>
                    <th>Bearbeiten</th>
                    <th>Löschen</th>
                    <th>Übersicht</th>
                </tr>";

            foreach ($personen_schon_zugeteilt as $personen_schon_zugeteiltt){
                echo "<tr>";
                echo "<td>" . $personen_schon_zugeteiltt['namen'] . "</td>";
                echo "<td>" . $personen_schon_zugeteiltt['adresse'] . "</td>";
                echo "<td>" . $personen_schon_zugeteiltt['telefonnummer'] . "</td>";
                echo "<td>" . $personen_schon_zugeteiltt['email'] . "</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td><a href='uebersichtPerson?id=" . $personen_schon_zugeteiltt['id'] . "'><button class='uebersicht'><i class='fas fa-eye'></i> Übersicht anschauen</button></a></td>";
                echo "</tr>";
            }

            foreach ($personen_nicht_zugeteilt as $personen_nicht_zugeteiltt){
                echo "<tr>";
                echo "<td>" . $personen_nicht_zugeteiltt['namen'] . "</td>";
                echo "<td>" . $personen_nicht_zugeteiltt['adresse'] . "</td>";
                echo "<td>" . $personen_nicht_zugeteiltt['telefonnummer'] . "</td>";
                echo "<td>" . $personen_nicht_zugeteiltt['email'] . "</td>";
                echo "<td><a href='editPerson?id=" . $personen_nicht_zugeteiltt['id'] . "'><button class='edit'><i class='fas fa-edit'></i> Bearbeiten</button></a></td>";
                echo "<td><a href='deletePerson?id=" . $personen_nicht_zugeteiltt['id'] . "'><button class='delete'><i class='fas fa-trash'></i> Löschen</button></a></td>";
                echo "<td></td>";
                echo "</tr>";
            }
        }
        /* Existieren nur Personen die zugeteilt wurden? */
        if($anzahl_personen_zugeteilt > 0 && $anzahl_personen_nicht_zugeteilt == 0){
            /* Daten der zugeteilten Personen werden ausgegeben */
            echo "<table>
                <tr>
                    <th>Namen</th>
                    <th>Adresse</th>
                    <th>Telefonnummer</th>
                    <th>Email</th>
                    <th>Übersicht</th>
                </tr>";

            foreach ($personen_schon_zugeteilt as $personen_schon_zugeteiltt){
                echo "<tr>";
                echo "<td>" . $personen_schon_zugeteiltt['namen'] . "</td>";
                echo "<td>" . $personen_schon_zugeteiltt['adresse'] . "</td>";
                echo "<td>" . $personen_schon_zugeteiltt['telefonnummer'] . "</td>";
                echo "<td>" . $personen_schon_zugeteiltt['email'] . "</td>";
                echo "<td><a href='uebersichtPerson?id=" . $personen_schon_zugeteiltt['id'] . "'><button class='uebersicht'><i class='fas fa-eye'></i> Übersicht anschauen</button></a></td>";
                echo "</tr>";
            }
        }
        /* Existieren nur Personen die nicht zugeteilt wurden? */
        if ($anzahl_personen_zugeteilt == 0 && $anzahl_personen_nicht_zugeteilt > 0){
            /* Daten der nicht zugeteilten Personen werden ausgegeben */
            echo "<table>
                <tr>
                    <th>Namen</th>
                    <th>Adresse</th>
                    <th>Telefonnummer</th>
                    <th>Email</th>
                    <th>Bearbeiten</th>
                    <th>Löschen</th>
                </tr>";

            foreach ($personen_nicht_zugeteilt as $personen_nicht_zugeteiltt){
                echo "<tr>";
                echo "<td>" . $personen_nicht_zugeteiltt['namen'] . "</td>";
                echo "<td>" . $personen_nicht_zugeteiltt['adresse'] . "</td>";
                echo "<td>" . $personen_nicht_zugeteiltt['telefonnummer'] . "</td>";
                echo "<td>" . $personen_nicht_zugeteiltt['email'] . "</td>";
                echo "<td><a href='editPerson?id=" . $personen_nicht_zugeteiltt['id'] . "'><button class='edit'><i class='fas fa-edit'></i> Bearbeiten</button></a></td>";
                echo "<td><a href='deletePerson?id=" . $personen_nicht_zugeteiltt['id'] . "'><button class='delete'><i class='fas fa-trash'></i> Löschen</button></a></td>";
                echo "</tr>";
            }
        }
        
        echo "</table>";
    }
    /* Es existieren noch keine Personen */
    else{
        echo "<h1 style='color: red';>Es wurde noch keine Person hinzugefügt</h1>";
    }
    echo "<button class='hinzufuegen' onclick='addPerson()'><i class='fas fa-plus'></i> Person hinzufügen</button>";
    ?>
</main>

<script src="../public/js/app.js"></script>
</body>
</html>
