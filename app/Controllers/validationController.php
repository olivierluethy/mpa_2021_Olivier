<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = 'unknown'; // Standard-Wert für die Variable name setzen
    $name_des_hotels = ''; // Standard-Wert für die Variable name_des_hotels setzen

    if(isset($_POST['shuttleBus'])) {
        // Das Feld wurde mitgesendet, wir können den Wert also übernehmen
        $shuttleBus = trim($_POST['shuttleBus']);
    }

    if(isset($_POST['name'])) {
        // Das Feld wurde mitgesendet, wir können den Wert also übernehmen
        $name = trim($_POST['name']);
    }else{
        echo "$error Please enter the Name";
    }

    if(isset($_POST['number'])) {
        // Das Feld wurde mitgesendet, wir können den Wert also übernehmen
        $number = trim($_POST['number']);
    }else{
        echo "$error Please enter a number";
    }

    if(isset($_POST['telefon'])) {
        // Das Feld wurde mitgesendet, wir können den Wert also übernehmen
        $telefon = trim($_POST['telefon']);
    }else{
        echo "$error Please enter the phone number";
    }

    if(isset($_POST['note'])) {
        // Das Feld wurde mitgesendet, wir können den Wert also übernehmen
        $note = trim($_POST['note']);
    }else{
        echo "$error Please enter a note";
    }

    if(isset($_POST['name_des_hotels'])) {
        // Das Feld wurde mitgesendet, wir können den Wert also übernehmen
        $name_des_hotels = trim($_POST['name_des_hotels']);
    }else{
        echo "$error Please select a hotel";
    }

    if(isset($_POST['email'])) {
        // Das Feld wurde mitgesendet, wir können den Wert also übernehmen
        $email = trim($_POST['email']);
    }else{
        echo "$error Please enter a email adress";
    }

    if(isset($_POST['was_am_abend_unternehmen'])) {
        // Das Feld wurde mitgesendet, wir können den Wert also übernehmen
        $was_am_abend_unternehmen = trim($_POST['was_am_abend_unternehmen']);
    }else{
        echo "$error Please enter what you want to do in the evening";
    }
}

// echo $name;

require 'success.view.php';