-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2019 at 03:49 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smd`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccounts`
--

CREATE TABLE `tblaccounts` (
  `id` int(11) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `mname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `office` varchar(20) NOT NULL,
  `rank` varchar(35) NOT NULL,
  `qualifier` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `authorityLevel` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `token` varchar(10) DEFAULT NULL,
  `tokenExpiry` datetime DEFAULT NULL,
  `dateAdded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblaccounts`
--

INSERT INTO `tblaccounts` (`id`, `fname`, `mname`, `lname`, `office`, `rank`, `qualifier`, `email`, `username`, `password`, `authorityLevel`, `status`, `token`, `tokenExpiry`, `dateAdded`) VALUES
(150, 'Admin', '', 'Admin', 'DICTM', '1', '', 'admin@gmail.com', 'admin.admin', 'f6fdffe48c908deb0f4c3bd36c032e72', 'admin', 'activated', '', '0000-00-00 00:00:00', '2019-03-12 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblaccounttrail`
--

CREATE TABLE `tblaccounttrail` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `accountId` int(11) NOT NULL,
  `action` varchar(15) NOT NULL,
  `dateModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblappfunction`
--

CREATE TABLE `tblappfunction` (
  `id` int(11) NOT NULL,
  `appFunctionality` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblappfunction`
--

INSERT INTO `tblappfunction` (`id`, `appFunctionality`) VALUES
(1, 'Payroll'),
(2, 'DTR'),
(3, 'Inventory Management'),
(4, 'Document Management'),
(5, 'None'),
(6, 'Application Processing');

-- --------------------------------------------------------

--
-- Table structure for table `tbldocuments`
--

CREATE TABLE `tbldocuments` (
  `id` int(11) NOT NULL,
  `systemId` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `folder` varchar(50) NOT NULL,
  `uploaded_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblloginhistory`
--

CREATE TABLE `tblloginhistory` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `timeIn` datetime NOT NULL,
  `timeOut` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblranks`
--

CREATE TABLE `tblranks` (
  `id` int(11) NOT NULL,
  `rank` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblranks`
--

INSERT INTO `tblranks` (`id`, `rank`) VALUES
(1, 'Non-Uniformed Personnel'),
(2, 'Patrolman/Patrolwoman (PO1)'),
(3, 'Police Corporal (P02)'),
(4, 'Police Staff Sergeant (P03)'),
(5, 'Police Master Sergeant (SPO1)'),
(6, 'Police Senior Master Sergeant (SP02)'),
(7, 'Police Chief Master Sergeant (SP03)'),
(8, 'Police Executive Master Sergeant (SP04)'),
(9, 'Police Lieutenant'),
(10, 'Police Captain'),
(11, 'Police Major'),
(12, 'Police Lieutenant Colonel'),
(13, 'Police Colonel'),
(14, 'Police Brigadier General'),
(15, 'Police Major General'),
(16, 'Police Lieutenant General'),
(17, 'Police General'),
(18, 'Civilian');

-- --------------------------------------------------------

--
-- Table structure for table `tblresearchers`
--

CREATE TABLE `tblresearchers` (
  `id` int(11) NOT NULL,
  `accountId` int(11) NOT NULL,
  `systemId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblsystems`
--

CREATE TABLE `tblsystems` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `office` text NOT NULL,
  `itOfficerRank` varchar(100) NOT NULL,
  `itOfficer` varchar(50) NOT NULL,
  `itOfficerContact` varchar(11) NOT NULL,
  `itOfficerEmail` varchar(30) NOT NULL,
  `description` longtext NOT NULL,
  `environment` varchar(20) NOT NULL,
  `appFunction` varchar(100) NOT NULL,
  `operatingSystem` varchar(100) NOT NULL,
  `devTool` varchar(50) NOT NULL,
  `backEnd` varchar(50) NOT NULL,
  `numRecords` int(11) NOT NULL,
  `dbSecurity` varchar(100) NOT NULL,
  `implementDate` varchar(30) NOT NULL,
  `source` varchar(50) NOT NULL,
  `dictmCertified` text NOT NULL,
  `systemDoc` text NOT NULL,
  `userManual` text NOT NULL,
  `userAcceptance` text NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `preparedBy` varchar(50) NOT NULL,
  `developedBy` varchar(50) NOT NULL,
  `developedByContact` varchar(11) NOT NULL,
  `developedByEmail` varchar(30) NOT NULL,
  `dateAdded` datetime NOT NULL,
  `typeIS` text NOT NULL,
  `statusIS` text NOT NULL,
  `dateInitiated` varchar(30) NOT NULL,
  `developmentDate` varchar(30) NOT NULL,
  `turnOverDate` varchar(30) NOT NULL,
  `cleansedDate` year(4) NOT NULL,
  `withContract` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsystems`
--

INSERT INTO `tblsystems` (`id`, `logo`, `name`, `office`, `itOfficerRank`, `itOfficer`, `itOfficerContact`, `itOfficerEmail`, `description`, `environment`, `appFunction`, `operatingSystem`, `devTool`, `backEnd`, `numRecords`, `dbSecurity`, `implementDate`, `source`, `dictmCertified`, `systemDoc`, `userManual`, `userAcceptance`, `remarks`, `preparedBy`, `developedBy`, `developedByContact`, `developedByEmail`, `dateAdded`, `typeIS`, `statusIS`, `dateInitiated`, `developmentDate`, `turnOverDate`, `cleansedDate`, `withContract`, `status`) VALUES
(1, '', 'Case Management Information System (CMIS)', 'TDCO', '1', 'Arjay Verdera', '', '', 'A system that records and manages the kidnap for ransom cases handled by AKG', 'LAN-Based', '3', 'Windows ', 'VISUAL BASIC.NET', 'MS SQL V 2005', 1, 'Secured', '', 'In-House (by ITMS)', 'yes', 'yes', 'no', 'no', 'End- users; PRO2 , PRO4B, PRO3, PRO6, PRO8, PRO9', 'SPO1 Russel N Perez', 'ITMS', '', '', '2019-03-12 08:47:56', 'Operations IS', 'Operational', '', '', '', 0000, 'no', 'active'),
(2, 'cidg.png', 'Case Information And Database Management System (CIDMS) Of CIDG', 'CIDG', '1', 'Marco Marco', '', '', 'Encode case folders of CIDG', 'Others', '3', 'Windows', 'VB.NET', 'MY SQL V 5.7', 1, 'Secured', '2012', 'In-House (by ITMS)', 'yes', 'no', 'no', 'no', 'PReviously not being reported because of the existence of CIDMS of DIDM', 'Admin', 'Admin', '', '', '2019-03-12 08:53:54', 'Support to Operations IS', 'Operational', '', '', '', 0000, 'no', 'active'),
(3, '', 'RID Database', 'PRO1', '1', 'Admin', '', '', 'A system used for crime Incident reporting', 'LAN-Based', '3', 'Windows ', 'PHP V6', 'MY SQL V 5.7', 1, 'Secured', '', 'In-House (c/o Unit)', 'yes', 'yes', 'no', 'no', 'Operational (jane 2018 by PO3 Supil; IS Form to follow) via SMS June 26, 2018', 'C RCPD  PRO1 2nd Sem 2016', 'Admin', '', '', '2019-03-12 10:38:55', 'Operations IS', 'Operational', '', '', '', 0000, 'no', 'active'),
(4, 'didm.png', 'ESubpoena', 'DIDM', '1', 'Test 2', '', '', 'A web-based system that will facilitate the expeditious and timely delivery of subpoena issued by the courts to concerned PNP personnel, who are named in the subpoena pertaining to a criminal case.', 'WEB-Based', '3', 'Windows ', 'PHP 5.4.33', 'MY SQL VER 5', 0, 'Secured', '2014', 'In-House (c/o Unit)', 'no', 'no', 'no', 'no', 'End users; PRO2, PRO4A, PRO4B, PRO3, PRO6, PRO8, PRO9, PRO10, PRO11', 'PCI CHRISTIAN DC SANTILLIAN', 'Admin', '', '', '2019-03-12 10:46:18', 'Operations IS', 'Operational', '', '', '', 0000, 'no', 'active'),
(5, 'didm.png', 'Baranggay Information Networks Information System (eWPIS) / (eWarranty)', 'DIDM', '1', 'Admin', '', '', 'The system contains a database that will allow the user to provide information of action agents and barangay information networks', 'WEB-Based', '3', 'Windows ', 'PHP V 5.5', 'MY SQL', 0, 'Secured', '2018', 'In-House (by ITMS)', 'no', 'no', 'yes', 'yes', 'Still minor issues to addressed', 'PO3 Joker Galano', 'ITMS', '', '', '2019-03-12 11:01:51', 'Support to Operations IS', 'Operational', '', '', '', 0000, 'no', 'active'),
(6, 'didm.png', 'Crime Incident Recording System (e-Blotter)', 'DIDM', '1', 'Test 4', '', '', 'An incident-based reporting system that efficiently manages data of crimes recorded into the database.', 'WEB-Based', '3', 'Windows ', 'PHP 5.4.33', 'MY SQL VER 5.6.14', 0, 'Secured', '', 'In-House (c/o Unit)', 'no', 'no', 'no', 'no', 'End Users; PRO2, , PRO4A, PRO8, PRO3, PRO6, PRO18, PRO4B, PRO7, PRO12, NPD', 'PCI CHRISTIAN DC SANTILLIAN', 'Admin', '', '', '2019-03-12 11:07:48', 'Operations IS', 'Non-Operational', '', '', '', 0000, 'no', 'active'),
(7, 'di.png', 'DI Personnel Information System', 'DI', '1', 'Admin', '', '', 'Database of DI Personnel information', 'WEB-Based', '3', 'Windows ', 'PHP V6', 'MY SQL', 0, 'Secured', '', 'In-House (c/o Unit)', 'yes', 'no', 'no', 'no', 'System is not utilized anymore', 'Admin', 'Admin', '', '', '2019-03-14 09:28:47', 'Administrative', 'Non-Operational', '', '', '', 0000, 'no', 'active'),
(8, '', 'ISentia Or MediaBanc Valuator', 'DPCR', '1', 'Admin', '', '', 'An online news monitoring and media intelligence service which provides an extensive range o media monitoring tools via user-friendly, customizable online interface that can access anytime and anywhere. it is a timely, accurate and comprehensive reporting system that tracks, sort, and monitors media materials on a daily, weekly, monthly, and yearly basis. It also compiles and delivers television, radio, print and online news coverage- http://www.isentia.com/', 'WEB-Based', '3', 'Windows ', 'PHP 5.4.33', 'MY SQL', 0, 'Secured', '', 'In-House (c/o Unit)', 'yes', 'no', 'no', 'no', 'Immaterial to work and lack of funds', 'Admin', 'Admin', '', '', '2019-03-14 09:35:26', 'Administrative', 'Non-Operational', '', '', '', 0000, 'yes', 'active'),
(9, '', 'Personnel Information Database', 'CESPO', '1', 'Admin', '', '', 'Personnel info  database', 'LAN-Based', '3', 'Windows ', 'PHP V6', 'MY SQL VER 5', 0, 'Secured', '', 'In-House (c/o Unit)', 'no', 'no', 'no', 'no', 'Not operational as per PO2 FABROS (via phone call)- reason.bugdown', 'Admin', 'Admin', '', '', '2019-03-14 09:37:16', 'Administrative', 'Non-Operational', '', '', '', 0000, 'no', 'active'),
(10, '', 'Computer-Aided Learning, Inventory, And Comprehension Of Knowledge On Human Rights (CLICK-HR)', 'HRAO', '1', 'Admin', '', '', 'Click HR is stand-alone software that will help manage and administer the human rights certification exam for the PNP uninformed personnel. Click HR will provide lessons and multiple choice exam on HR, IHL, and rights-based policing', 'LAN-Based', '3', 'Windows ', 'PHP', 'MY SQL ', 0, 'Secured', '', 'In-House (c/o Unit)', 'no', 'no', 'no', 'no', 'As per guidance of C, HRAO (PSSUPT Siervo) dated July 2015', 'Admin', 'Admin', '', '', '2019-03-14 09:42:06', 'Administrative', 'Non-Operational', '07/2015', '', '', 0000, 'no', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tblsystemtrail`
--

CREATE TABLE `tblsystemtrail` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `systemId` int(11) NOT NULL,
  `action` varchar(10) NOT NULL,
  `dateModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsystemtrail`
--

INSERT INTO `tblsystemtrail` (`id`, `userId`, `systemId`, `action`, `dateModified`) VALUES
(1, 150, 1, 'Added', '2019-03-12 08:47:56'),
(2, 150, 2, 'Added', '2019-03-12 08:53:54'),
(3, 150, 2, 'Deleted', '2019-03-12 08:54:41'),
(4, 150, 2, 'Recovered', '2019-03-12 08:54:50'),
(5, 150, 2, 'Edited', '2019-03-12 08:55:08'),
(6, 150, 3, 'Added', '2019-03-12 10:38:55'),
(7, 150, 4, 'Added', '2019-03-12 10:46:18'),
(8, 150, 5, 'Added', '2019-03-12 11:01:51'),
(9, 150, 6, 'Added', '2019-03-12 11:07:48'),
(10, 150, 7, 'Added', '2019-03-14 09:28:47'),
(11, 150, 8, 'Added', '2019-03-14 09:35:26'),
(12, 150, 9, 'Added', '2019-03-14 09:37:16'),
(13, 150, 10, 'Added', '2019-03-14 09:42:06'),
(14, 150, 5, 'Edited', '2019-03-15 08:43:30'),
(15, 150, 5, 'Deleted', '2019-03-15 08:55:29'),
(16, 150, 5, 'Recovered', '2019-03-15 09:18:31'),
(17, 150, 5, 'Deleted', '2019-03-15 09:47:51'),
(18, 150, 2, 'Edited', '2019-03-15 10:04:18'),
(19, 150, 2, 'Edited', '2019-03-15 10:12:17'),
(20, 150, 5, 'Recovered', '2019-03-15 10:13:44'),
(21, 150, 5, 'Edited', '2019-03-15 11:36:59'),
(22, 150, 5, 'Edited', '2019-03-15 11:37:10'),
(23, 150, 5, 'Deleted', '2019-03-25 08:21:48'),
(24, 150, 5, 'Recovered', '2019-03-25 08:22:05'),
(25, 150, 9, 'Edited', '2019-03-25 08:36:32'),
(26, 150, 5, 'Edited', '2019-03-25 08:40:52'),
(27, 150, 5, 'Edited', '2019-03-26 09:04:25'),
(28, 150, 2, 'Edited', '2019-03-26 09:04:36'),
(29, 150, 6, 'Edited', '2019-03-26 09:05:18'),
(30, 150, 7, 'Edited', '2019-03-26 09:05:47'),
(31, 150, 4, 'Edited', '2019-03-26 09:06:04'),
(32, 150, 5, 'Deleted', '2019-03-26 09:24:15'),
(33, 150, 5, 'Recovered', '2019-03-26 09:24:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblaccounttrail`
--
ALTER TABLE `tblaccounttrail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblappfunction`
--
ALTER TABLE `tblappfunction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbldocuments`
--
ALTER TABLE `tbldocuments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblloginhistory`
--
ALTER TABLE `tblloginhistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblranks`
--
ALTER TABLE `tblranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblresearchers`
--
ALTER TABLE `tblresearchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsystems`
--
ALTER TABLE `tblsystems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsystemtrail`
--
ALTER TABLE `tblsystemtrail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `tblaccounttrail`
--
ALTER TABLE `tblaccounttrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblappfunction`
--
ALTER TABLE `tblappfunction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbldocuments`
--
ALTER TABLE `tbldocuments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblloginhistory`
--
ALTER TABLE `tblloginhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tblranks`
--
ALTER TABLE `tblranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblresearchers`
--
ALTER TABLE `tblresearchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsystems`
--
ALTER TABLE `tblsystems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblsystemtrail`
--
ALTER TABLE `tblsystemtrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
