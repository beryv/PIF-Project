-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 05 jan. 2024 à 12:48
-- Version du serveur : 8.0.29
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `db_ecoweighing`
--

--
-- Déchargement des données de la table `tblbill`
--

INSERT INTO `tblbill` (`BILLNUM`, `DATE`, `PAYED`) VALUES
(1, '2023-12-13', 'YES'),
(5, '2024-01-03', 'NO'),
(7, '2024-01-04', 'NO'),
(8, '2024-01-02', 'YES');


--
-- Déchargement des données de la table `tbltrashtype`
--

INSERT INTO `tbltrashtype` (`TRASHCODE`, `DESCRIPTION`, `PRICE`) VALUES
('ALU', 'Aluminium', 0.12),
('PLA', 'plastic', 0.50);

--
-- Déchargement des données de la table `tblstations`
--

INSERT INTO `tblstations` (`STATIONNUM`, `DESCRIPTION`, `FICENTERCODE`) VALUES
(1, 'TEST', 'SIVEC'),
(2, 'TEST2', 'RCLUX');



--
-- Déchargement des données de la table `tblmeasures`
--

INSERT INTO `tblmeasures` (`IDMEASURE`, `WEIGHT`, `TOTALPRICE`, `DATE`, `FIUSERNAME`, `FISTATIONNUM`, `FITRASHCODE`, `FIBILLNUM`) VALUES
(1, 5.300, 10.00, '2023-12-13', 'admin', 1, 'ALU', 1),
(5, 7.000, 9.99, '2023-10-09', 'admin', 1, 'ALU', 1),
(6, 1.200, 4.00, '2023-12-20', 'admin', 1, 'PLA', 5),
(7, 3.000, 6.00, '2023-12-19', 'admin', 1, 'PLA', 1),
(8, 4.000, 8.00, '2023-12-21', 'admin', 1, 'ALU', NULL),
(10, 5.000, 8.00, '2023-12-20', 'admin', 1, 'ALU', 5),
(11, 7.000, 6.00, '2023-12-19', 'admin', 1, 'PLA', NULL),
(12, 1.200, 4.00, '2023-12-21', 'admin', 1, 'ALU', NULL),
(13, 7.000, 14.00, '2023-12-19', 'admin', 1, 'ALU', 1),
(14, 6.700, 4.00, '2023-12-20', 'admin', 1, 'PLA', NULL),
(15, 0.450, 3.78, '2023-12-27', 'admin', 2, 'PLA', NULL),
(16, 3.123, 7.00, '2023-12-16', 'test', 2, 'ALU', 7),
(17, 2.000, 10.00, '2024-01-03', 'test', 1, 'ALU', 7),
(18, 2.000, 4.00, '2024-01-02', 'test', 2, 'ALU', 8);



--
-- Déchargement des données de la table `tblstationstype`
--

INSERT INTO `tblstationstype` (`FISTATIONNUM`, `FITRASHCODE`) VALUES
(1, 'ALU'),
(1, 'PLA');


COMMIT;
