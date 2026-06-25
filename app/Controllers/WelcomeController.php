<?php

class WelcomeController
{
	public function index(){
        // Initialize the session
        session_start();
        
		/* Offene Rechnungen anzeigen */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT rechnung.id, rechnung.titel, rechnung.fk_personenId, rechnung.beschreibung, rechnung.datei, rechnung.betrag, personen.namen, rechnung.datum, rechnung.status FROM rechnung
INNER JOIN personen ON personen.id = rechnung.fk_personenId WHERE status = 0');
        $statement->execute();
        $rechnungen = $statement->fetchAll();
		
		require 'app/Views/welcome.view.php';
	}

	public function rechnungen(){
        // Initialize the session
        session_start();

		/* Alle Rechnungen anzeigen */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT rechnung.id, rechnung.titel, rechnung.beschreibung, rechnung.datei, rechnung.betrag, rechnung.fk_personenId, personen.namen, rechnung.datum, rechnung.status FROM rechnung
INNER JOIN personen ON personen.id = rechnung.fk_personenId');
        $statement->execute();
        $alle_rechnungen = $statement->fetchAll();

        /* Personen für die Auswahl im Modal */
        $statement = $pdo->prepare('SELECT id, namen FROM personen ORDER BY namen');
        $statement->execute();
        $personen = $statement->fetchAll();

		/* Überfällige offene Rechnungen anzeigen */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT rechnung.id, rechnung.titel, rechnung.beschreibung, rechnung.datei, rechnung.betrag, personen.namen, rechnung.datum, rechnung.status FROM rechnung
INNER JOIN personen ON personen.id = rechnung.fk_personenId WHERE rechnung.datum + INTERVAL 1 DAY < NOW() AND rechnung.status = 0');
        $statement->execute();
        $ueberfellig_offene_rechnungen = $statement->fetchAll();

        /* Nicht überfällige aber offene Rechnungen anzeigen */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT rechnung.id, rechnung.titel, rechnung.beschreibung, rechnung.datei, rechnung.betrag, personen.namen, rechnung.datum, rechnung.status FROM rechnung
INNER JOIN personen ON personen.id = rechnung.fk_personenId WHERE NOT rechnung.datum + INTERVAL 1 DAY < NOW() AND rechnung.status = 0');
        $statement->execute();
        $nicht_ueberfellige_offene_rechnungen = $statement->fetchAll();

        /* Beglichene Rechnungen anzeigen */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT rechnung.id, rechnung.titel, rechnung.beschreibung, rechnung.datei, rechnung.betrag, personen.namen, rechnung.datum, rechnung.status FROM rechnung
INNER JOIN personen ON personen.id = rechnung.fk_personenId WHERE status = 1');
        $statement->execute();
        $erledigte_rechnungen = $statement->fetchAll();

		require 'app/Views/rechnungen.view.php';
	}

	public function personen(){
        // Initialize the session
        session_start();

		/* Alle Personen anzeigen */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT * FROM personen');
        $statement->execute();
        $personen = $statement->fetchAll();

        /* Personen die schon einer Rechnung zugeteilt wurden */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT DISTINCT personen.id, personen.namen, personen.adresse, personen.telefonnummer, personen.email FROM personen
INNER JOIN rechnung ON rechnung.fk_personenId = personen.id');
        $statement->execute();
        $personen_schon_zugeteilt = $statement->fetchAll();

        /* Personen die keiner Rechnung zugeteilt wurden */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT personen.id, personen.namen, personen.adresse, personen.telefonnummer, personen.email FROM personen WHERE personen.id NOT IN 
        (SELECT rechnung.fk_personenId FROM rechnung)');
        $statement->execute();
        $personen_nicht_zugeteilt = $statement->fetchAll();

		require 'app/Views/personen.view.php';
	}

	public function addPerson(){
        // Initialize the session
        session_start();

        /* Person hinzufügen (erfolgt via Modal auf der Personen-Liste) */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rechnungen = new Rechnungen();
            $namen = $_POST['namen'];
            $adresse = $_POST['adresse'];
            $telefonnummer = $_POST['telefonnummer'];
            $email = $_POST['email'];

            $rechnungen->createPerson($namen, $adresse, $telefonnummer, $email);
        }

        header('Location: /rechnungen/personen');
        exit;
	}

	public function addBill(){
        // Initialize the session
        session_start();

        /* Rechnung hinzufügen (erfolgt via Modal auf der Rechnungen-Liste) */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rechnungen = new Rechnungen();
            $titel = $_POST['titel'];
            $beschreibung = $_POST['beschreibung'];
            $betrag = $_POST['betrag'];
            $person = $_POST['person'];
            $datei = $_POST['datei'];
            $datum = $_POST['datum'];
            $status = 0;

            $rechnungen->createBill($titel, $beschreibung, $betrag, $person, $datei, $datum, $status);
        }

        header('Location: /rechnungen/rechnungen');
        exit;
	}

    public function editPerson(){
        $rechnungen = new Rechnungen();

        // Initialize the session
        session_start();

        /* Person bearbeiten */
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $namen = $_POST['namen'];
            $adresse = $_POST['adresse'];
			$telefonnummer = $_POST['telefonnummer'];
			$email = $_POST['email'];

            $rechnungen->changePerson($namen, $adresse, $telefonnummer, $email, $id);

            header('Location: /rechnungen/personen');
        }else{
            $statement = $pdo->prepare('SELECT * FROM personen WHERE id = :id');
            $statement->bindParam(':id', $id);
            $statement->execute();
            $personen = $statement->fetchAll();
        }
        require 'app/Views/editPerson.view.php';
    }

    public function deletePerson(){
        $rechnungen = new Rechnungen();

        // Initialize the session
        session_start();

        /* Person löschen */
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $rechnungen->removePerson($id);
        
        header('Location: /rechnungen/personen');

        require 'app/Views/personen.view.php';
    }

    public function editBill(){
        $rechnungen = new Rechnungen();

        // Initialize the session
        session_start();

        /* Rechnung bearbeiten */
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titel = $_POST['titel'];
            $beschreibung = $_POST['beschreibung'];
			$betrag = $_POST['betrag'];
			$person = $_POST['person'];
            $datum = $_POST['datum'];

            $rechnungen->changeBill($titel, $beschreibung, $betrag, $person, $datum, $id);

            header('Location: /rechnungen/rechnungen');
        }else{
            $statement = $pdo->prepare('SELECT * FROM rechnung WHERE id = :id');
            $statement->bindParam(':id', $id);
            $statement->execute();
            $rechnung = $statement->fetchAll();

            /* Personen anzeigen */
            $pdo = connectDatabase();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $pdo->prepare('SELECT * FROM personen');
            $statement->execute();
            $personen = $statement->fetchAll();
        }
        require 'app/Views/editBill.view.php';
    }

    public function deleteBill(){
        $rechnungen = new Rechnungen();

        // Initialize the session
        session_start();

        /* Rechnung löschen */
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $rechnungen->removeBill($id);
        
        header('Location: /rechnungen/rechnungen');

        require 'app/Views/rechnungen.view.php';
    }

    public function addReminder(){
        // Initialize the session
        session_start();

        /* Id wird genommen und zur nächsen Seiten weitergeschickt */
        $id = $_POST['id'];

        require 'app/Views/addReminder.view.php';
    }

    public function addReminder2(){
        $rechnungen = new Rechnungen();

        // Initialize the session
        session_start();

        /* Mahnung wird hinzugefügt */
		$title = '';
        $pdo = connectDatabase();

        $titel = $_POST['titel'];
        $datum = $_POST['datum'];
        $id = $_POST['id'];

        $rechnungen->addReminder($titel, $datum, $id);

        header('Location: /rechnungen/rechnungen');
    }

    public function editReminder(){
        $rechnungen = new Rechnungen();

        // Initialize the session
        session_start();

        /* Rechnung bearbeiten */
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titel = $_POST['titel'];
            $datum = $_POST['datum'];

            $rechnungen->changeReminder($titel, $datum, $id);

            header('Location: /rechnungen/uebersicht');
        }else{
            $statement = $pdo->prepare('SELECT * FROM mahnung WHERE id = :id');
            $statement->bindParam(':id', $id);
            $statement->execute();
            $mahnung = $statement->fetchAll();
        }
        require 'app/Views/editReminder.view.php';
    }

    public function deleteReminder(){
        $rechnungen = new Rechnungen();

        // Initialize the session
        session_start();

        /* Rechnung löschen */
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $rechnungen->removeReminder($id);
        
        header('Location: /rechnungen/uebersicht');

        require 'app/Views/welcome.view.php';
    }

    public function begleichen(){
        $rechnungen = new Rechnungen();

        // Initialize the session
        session_start();

        /* Rechnung begleichen */
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $rechnungen->begleichen($id);

        header('Location: /rechnungen/rechnungen');
    }

    public function uebersichtRechnung(){
        // Initialize the session
        session_start();

        /* Alles zur Rechnung */
        $id = $_GET['id'];

		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT rechnung.id, rechnung.titel, rechnung.beschreibung, rechnung.datei, rechnung.betrag, personen.namen, rechnung.datum, rechnung.status FROM rechnung
INNER JOIN personen ON personen.id = rechnung.fk_personenId WHERE rechnung.id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $rechnung = $statement->fetchAll();

        /* Alles zur person */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT personen.id, personen.namen, personen.adresse, personen.telefonnummer, personen.email FROM personen
INNER JOIN rechnung ON rechnung.fk_personenId = personen.id
WHERE rechnung.id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $person = $statement->fetchAll();

        /* Mahnungen anzeigen wenn welche vorhanden sind */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT mahnung.id, mahnung.titel, mahnung.datum FROM mahnung
INNER JOIN rechnung ON rechnung.id = mahnung.fk_rechnungId WHERE rechnung.id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $mahnungen = $statement->fetchAll();
		
		require 'app/Views/uebersichtRechnung.view.php';
    }

    public function uebersichtPerson(){
        // Initialize the session
        session_start();

        /* Übersicht einer Person */
        $id = $_GET['id'];

        /* Wie oft hat die Person zu spät bezahlt */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT * FROM rechnung WHERE rechnung.datum + INTERVAL 1 DAY < NOW() AND rechnung.fk_personenId = :id AND rechnung.status = 1');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $zu_spaet = $statement->fetchAll();

        /* Alle bisherigen Rechnungen von der Person werden angezeigt */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT rechnung.id, rechnung.titel, rechnung.beschreibung, rechnung.betrag, rechnung.status, personen.namen, rechnung.datum, rechnung.datei FROM rechnung
INNER JOIN personen ON personen.id = rechnung.fk_personenId WHERE personen.id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $rechnung = $statement->fetchAll();

        require 'app/Views/uebersichtPerson.view.php';
    }

    public function login(){
        require 'app/Views/login.php';
    }

    public function logout(){
        require 'app/Views/logout.php';
    }
}

