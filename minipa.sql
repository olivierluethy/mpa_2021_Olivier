-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 24. Aug 2021 um 16:56
-- Server-Version: 10.4.14-MariaDB
-- PHP-Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `minipa`
--

DROP DATABASE IF EXISTS minipa;
CREATE DATABASE minipa;
USE minipa;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mahnung`
--

CREATE TABLE `mahnung` (
  `id` int(11) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `datum` date DEFAULT current_timestamp(),
  `fk_rechnungId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `personen`
--

CREATE TABLE `personen` (
  `id` int(11) NOT NULL,
  `namen` varchar(50) NOT NULL,
  `adresse` varchar(500) NOT NULL,
  `telefonnummer` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `personen`
--

INSERT INTO `personen` (`id`, `namen`, `adresse`, `telefonnummer`, `email`) VALUES
(1, 'Peter Steinmeier', 'peter.steinmeier@gmail.com', '041 422 32 62', 'peter.steinmeier@gmail.com');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rechnung`
--

CREATE TABLE `rechnung` (
  `id` int(11) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `beschreibung` varchar(50) NOT NULL,
  `betrag` int(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `fk_personenId` int(11) NOT NULL,
  `datum` date DEFAULT current_timestamp(),
  `datei` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rechnung`
--

INSERT INTO `rechnung` (`id`, `titel`, `beschreibung`, `betrag`, `status`, `fk_personenId`, `datum`, `datei`) VALUES
(11, 'Tabelle löschen', 'fdedvvedvd', 5000, 1, 1, '2021-08-12', ''),
(12, 'Tabelle erstellen', 'dsfvfefefe', 3000, 1, 1, '2021-08-27', ''),
(13, 'Spinner', 'Spinnen sind immer gut.', 600, 0, 1, '2021-08-13', 0x4d6f636b75702d4c6f67696e2e706e67);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'olivier@kauz.ch', '$2y$10$J9avJdaLghZ1QTcBmsg4NeotISw.e5i9WFgWmXwZlK.QhElXAVCli', '2021-08-19 13:32:55');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `mahnung`
--
ALTER TABLE `mahnung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rechnungId` (`fk_rechnungId`);

--
-- Indizes für die Tabelle `personen`
--
ALTER TABLE `personen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `rechnung`
--
ALTER TABLE `rechnung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personenId` (`fk_personenId`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `mahnung`
--
ALTER TABLE `mahnung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `personen`
--
ALTER TABLE `personen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `rechnung`
--
ALTER TABLE `rechnung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `mahnung`
--
ALTER TABLE `mahnung`
  ADD CONSTRAINT `mahnung_ibfk_1` FOREIGN KEY (`fk_rechnungId`) REFERENCES `rechnung` (`id`);

--
-- Constraints der Tabelle `rechnung`
--
ALTER TABLE `rechnung`
  ADD CONSTRAINT `rechnung_ibfk_1` FOREIGN KEY (`fk_personenId`) REFERENCES `personen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
