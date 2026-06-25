<?php
class Rechnungen
{
	public $db;

	public function __construct()
	{
		$this->db = connectDatabase();
	}

	/* Person */
	public function createPerson($namen, $adresse, $telefonnummer, $email){
		$isValid = true;
		$namen = htmlspecialchars($_POST['namen']);
		$adresse = htmlspecialchars($_POST['adresse']);
		$email = htmlspecialchars($_POST['email']);
		$telefonnummer = htmlspecialchars($_POST['telefonnummer']);

		if (strpos($email, "@") === false) {
            $isValid = false;
        }

		if($isValid){
			$statement = $this->db->prepare("INSERT INTO `personen` (namen, adresse, telefonnummer, email) VALUES (:namen, :adresse, :telefonnummer, :email)");
			$statement->bindParam(':namen', $namen, PDO::PARAM_STR);
			$statement->bindParam(':adresse', $adresse, PDO::PARAM_STR);
			$statement->bindParam(':telefonnummer', $telefonnummer, PDO::PARAM_STR);
			$statement->bindParam(':email', $email, PDO::PARAM_STR);
			$statement->execute();
		}
	}

	public function changePerson($namen, $adresse, $telefonnummer, $email, $id){
		$isValid = true;
		$namen = htmlspecialchars($_POST['namen']);
		$adresse = htmlspecialchars($_POST['adresse']);
		$email = htmlspecialchars($_POST['email']);
		$telefonnummer = htmlspecialchars($_POST['telefonnummer']);

		if (strpos($email, "@") === false) {
            $isValid = false;
        }

		// Name muss vorhanden sein und darf nur aus Buchstaben (inkl. Umlaute/Akzente),
		// Leerzeichen, Bindestrich, Apostroph oder Punkt bestehen.
		if (trim($namen) === '' || preg_match('/[^\p{L}\s.\'-]/u', $namen)){
			$isValid = false;
		}

		if($isValid){
			$statement = $this->db->prepare('UPDATE `personen` SET namen = :namen, adresse = :adresse, telefonnummer = :telefonnummer, email = :email WHERE id = :id');
			$statement->bindParam(':namen', $namen, PDO::PARAM_STR);
			$statement->bindParam(':adresse', $adresse, PDO::PARAM_STR);
			$statement->bindParam(':telefonnummer', $telefonnummer, PDO::PARAM_STR);
			$statement->bindParam(':email', $email, PDO::PARAM_STR);
			$statement->bindParam(':id', $id);
			$statement->execute();
		}
		
	}

	public function removePerson($id){
		$statement = $this->db->prepare('DELETE FROM `personen` WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
	}

	/* Rechnung */
	public function createBill($titel, $beschreibung, $betrag, $person, $datei, $datum, $status){
		$titel = htmlspecialchars($_POST['titel']);
		$beschreibung = htmlspecialchars($_POST['beschreibung']);
		$betrag = htmlspecialchars($_POST['betrag']);
		$person = htmlspecialchars($_POST['person']);
		$datei = htmlspecialchars($_POST['datei']);
		$datum = htmlspecialchars($_POST['datum']);
		$status = htmlspecialchars($_POST['status']);

		$statement = $this->db->prepare("INSERT INTO `rechnung` (titel, beschreibung, betrag, status, fk_personenId, datum, datei) VALUES (:titel, :beschreibung, :betrag, :status, :fk_personenId, :datum, :datei)");
		$statement->bindParam(':titel', $titel, PDO::PARAM_STR);
		$statement->bindParam(':beschreibung', $beschreibung, PDO::PARAM_STR);
		$statement->bindParam(':betrag', $betrag, PDO::PARAM_STR);
		$statement->bindParam(':status', $status, PDO::PARAM_STR);
		$statement->bindParam(':fk_personenId', $person, PDO::PARAM_STR);
		$statement->bindParam(':datum', $datum, PDO::PARAM_STR);
		$statement->bindParam(':datei', $datei, PDO::PARAM_STR);
		$statement->execute();
	}

	public function changeBill($titel, $beschreibung, $betrag, $person, $datum, $id){
		$titel = htmlspecialchars($_POST['titel']);
		$beschreibung = htmlspecialchars($_POST['beschreibung']);
		$betrag = htmlspecialchars($_POST['betrag']);
		$person = htmlspecialchars($_POST['person']);
		$datum = htmlspecialchars($_POST['datum']);

		$statement = $this->db->prepare('UPDATE `rechnung` SET titel = :titel, beschreibung = :beschreibung, betrag = :betrag, fk_personenId = :fk_personenId, datum = :datum WHERE id = :id');
		$statement->bindParam(':titel', $titel, PDO::PARAM_STR);
		$statement->bindParam(':beschreibung', $beschreibung, PDO::PARAM_STR);
		$statement->bindParam(':betrag', $betrag, PDO::PARAM_STR);
		$statement->bindParam(':fk_personenId', $person, PDO::PARAM_STR);
		$statement->bindParam(':datum', $datum, PDO::PARAM_STR);
		$statement->bindParam(':id', $id);
		$statement->execute();
	}

	public function removeBill($id){
		$statement = $this->db->prepare('DELETE FROM `mahnung` WHERE fk_rechnungId = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();

        $statement = $this->db->prepare('DELETE FROM `rechnung` WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
	}

	/* Reminder */
	public function addReminder($titel, $datum, $id){
		$titel = htmlspecialchars($_POST['titel']);
		$datum = htmlspecialchars($_POST['datum']);

		$statement = $this->db->prepare("INSERT INTO `mahnung` (titel, datum, fk_rechnungId) VALUES (:titel, :datum, :fk_rechnungId)");
		$statement->bindParam(':titel', $titel, PDO::PARAM_STR);
		$statement->bindParam(':datum', $datum, PDO::PARAM_STR);
		$statement->bindParam(':fk_rechnungId', $id, PDO::PARAM_STR);
		$statement->execute();
	}

	public function changeReminder($titel, $datum, $id){
		$titel = htmlspecialchars($_POST['titel']);
		$datum = htmlspecialchars($_POST['datum']);

		$statement = $this->db->prepare('UPDATE `mahnung` SET titel = :titel, datum = :datum WHERE id = :id');
		$statement->bindParam(':titel', $titel, PDO::PARAM_STR);
		$statement->bindParam(':datum', $datum, PDO::PARAM_STR);
		$statement->bindParam(':id', $id);
		$statement->execute();
	}

	public function removeReminder($id){
		$statement = $this->db->prepare('DELETE FROM `mahnung` WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
	}

	/* Begleichen */
	public function begleichen($id){
		$statement = $this->db->prepare('UPDATE `rechnung` SET status = 1 WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
	}
}