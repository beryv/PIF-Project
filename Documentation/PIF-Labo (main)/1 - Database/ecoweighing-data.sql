SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

INSERT INTO `tblbill` (`BILLNUM`, `DATE`, `TOTALPRICE`, `PAYED`) VALUES
(1, '2023-11-14', '40.00', 'NO'),
(2, '2023-11-16', '12.00', 'YES'),
(3, '2023-11-01', '2.80', 'YES');

INSERT INTO `tblcenters` (`CENTERCODE`, `ADRESS`, `POSTCODE`, `CITY`) VALUES
('DHNRT', '15, Avenue G.D. Charlotte ', '6592', 'Luxembourg'),
('GHRTS', '8, Rue de la Gare', '8364', 'Rumelange'),
('LDNRT', '2, Bd Charles de Gaulle', '3209', 'Esch-sur-Alzette'),
('TRJZF', '4, Rue Henry', '2956', 'Esch-sur-Alzette');

INSERT INTO `tblstations` (`STATIONNUM`, `DESCRIPTION`, `FICENTERCODE`) VALUES
(1, 'Can measure Plastic and Aluminium', 'DHNRT'),
(2, 'Can Paper and Cardboard', 'TRJZF');

INSERT INTO `tblschedules` (`IDSCHEDULES`, `WEEKDAY`, `STARTTIME`, `ENDTIME`, `FICENTERCODE`) VALUES
(1, 'Monday', '08:00:00', '18:00:00', 'DHNRT'),
(2, 'Tuesday', '08:00:00', '17:00:00', 'DHNRT'),
(3, 'Wednesday', '08:00:00', '18:00:00', 'DHNRT'),
(4, 'Thursday', '08:00:00', '17:00:00', 'DHNRT'),
(5, 'Friday', '08:00:00', '20:00:00', 'DHNRT'),
(6, 'Saturday', '08:00:00', '12:00:00', 'LDNRT'),
(7, 'Sunday', '09:00:00', '12:00:00', 'LDNRT'),
(8, 'Thursday', '08:00:00', '16:00:00', 'GHRTS'),
(9, 'Wednesday', '08:00:00', '17:00:00', 'TRJZF');

INSERT INTO `tbltrashtype` (`TRASHCODE`, `DESCRIPTION`, `PRICE`) VALUES
('ALU', 'Aluminium', '1.30'),
('CAR', 'Cardboard', '0.50'),
('PAP', 'Paper', '0.40'),
('PLA', 'Plastic', '0.60');

INSERT INTO `tblstationstype` (`FISTATIONNUM`, `FITRASHCODE`) VALUES
(1, 'ALU'),
(2, 'CAR'),
(2, 'PAP'),
(1, 'PLA');

INSERT INTO `tblusers` (`USERNAME`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `TYPE`, `AUTHCODE`, `PASSWORD`, `FICENTERCODE`) VALUES
('dmueller', 'Daniel', 'Müller', 'dmueller@admin.net', 'adm', '984HGT98FF', 'dsffhffhgfghgfhacb407ede7a67db7025e8ad6907e15e74352601f36dfgff', NULL),
('jschmit', 'Jos', 'Schmit', 'jschmit@pt.lu', 'usr', 'ZTH675JUKP', 'cdfc26f9a35ba29acb407ede7a67db7025e8ad6907e15e74352601f362c37fed', 'DHNRT');
COMMIT;

INSERT INTO `tblmeasures` (`IDMEASURE`, `WEIGHT`, `TOTALPRICE`, `DATE`, `FIUSERNAME`, `FISTATIONNUM`, `FITRASHCODE`, `FIBILLNUM`) VALUES
(3, 30, '68.00', '2023-11-16', 'jschmit', 1, 'PLA', NULL),
(4, 2, '2.80', '2023-11-01', 'dmueller', 2, 'CAR', 3),
(5, 5, '10.00', '2023-11-14', 'jschmit', 1, 'ALU', 1),
(6, 8, '7.20', '2023-11-16', 'dmueller', 1, 'PLA', 2),
(7, 12, '9.00', '2023-11-14', 'dmueller', 2, 'PAP', NULL),
(8, 2, '4.00', '2023-11-14', 'jschmit', 1, 'ALU', 1);
