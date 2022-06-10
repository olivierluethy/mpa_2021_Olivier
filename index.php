<?php
require 'core/bootstrap.php';

$routes = [
	/* Hauptseiten */
	'/rechnungen/uebersicht' => 'WelcomeController@index',
	'/rechnungen/rechnungen' => 'WelcomeController@rechnungen',
	'/rechnungen/personen' => 'WelcomeController@personen',

	/* Personen */
	'/rechnungen/addPerson' => 'WelcomeController@addPerson',
	'/rechnungen/editPerson' => 'WelcomeController@editPerson',
	'/rechnungen/deletePerson' => 'WelcomeController@deletePerson',

	/* Rechnung */
	'/rechnungen/addBill' => 'WelcomeController@addBill',
	'/rechnungen/editBill' => 'WelcomeController@editBill',
	'/rechnungen/deleteBill' => 'WelcomeController@deleteBill',

	/* Mahnung hinzufügen */
	'/rechnungen/addReminder' => 'WelcomeController@addReminder',
	'/rechnungen/addReminder2' => 'WelcomeController@addReminder2',
	'/rechnungen/editReminder' => 'WelcomeController@editReminder',
	'/rechnungen/deleteReminder' => 'WelcomeController@deleteReminder',

	/* Rechnung begleichen */
	'/rechnungen/begleichen' => 'WelcomeController@begleichen',

	/* Übersicht der Rechnung */
	'/rechnungen/uebersichtRechnung' => 'WelcomeController@uebersichtRechnung',

	/* Übersicht der Person */
	'/rechnungen/uebersichtPerson' => 'WelcomeController@uebersichtPerson',

	/* Übersicht der Login & Logout */
	'/rechnungen/login' => 'WelcomeController@login',
	'/rechnungen/logout' => 'WelcomeController@logout',
];

$db = [
	'name'     => 'minipa',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');