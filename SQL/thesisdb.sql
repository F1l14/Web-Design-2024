-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2024 at 04:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesisdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `username` varchar(30) NOT NULL,
  `city` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `number` int(11) NOT NULL,
  `zipcode` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`username`, `city`, `street`, `number`, `zipcode`) VALUES
('up0000001', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('up0000002', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('up0000003', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('up0000004', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('up0000005', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('up0000006', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('up0000007', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('up0000008', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('up0000009', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('up0000011', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000012', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000013', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000014', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000015', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000016', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000017', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000018', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000019', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000020', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000021', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000022', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000023', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000024', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000025', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000026', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000027', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000028', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000029', 'Patras', 'Othonos-Amalias', 123, 26221),
('up0000030', 'Patras', 'Othonos-Amalias', 123, 26221);

-- --------------------------------------------------------

--
-- Table structure for table `akiromeni_diplomatiki`
--

CREATE TABLE `akiromeni_diplomatiki` (
  `diplomatiki` int(11) NOT NULL,
  `arithmos_gs` int(11) DEFAULT NULL,
  `etos_gs` year(4) DEFAULT NULL,
  `logos` text NOT NULL DEFAULT '"από Διδάσκοντα"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akiromeni_diplomatiki`
--

INSERT INTO `akiromeni_diplomatiki` (`diplomatiki`, `arithmos_gs`, `etos_gs`, `logos`) VALUES
(205, NULL, NULL, '\"από Διδάσκοντα\"');

-- --------------------------------------------------------

--
-- Table structure for table `diplomatiki`
--

CREATE TABLE `diplomatiki` (
  `id` int(7) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `professor` varchar(30) DEFAULT NULL,
  `student` varchar(30) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `status` enum('energi','eksetasi','peratomeni','akiromeni','anathesi','diathesimi') NOT NULL DEFAULT 'diathesimi',
  `filename` varchar(255) DEFAULT NULL,
  `grade_filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diplomatiki`
--

INSERT INTO `diplomatiki` (`id`, `title`, `description`, `professor`, `student`, `url`, `status`, `filename`, `grade_filename`) VALUES
(199, 'Super duper Thesis', 'MOKO', 'up0000002', 'up0000011', NULL, 'energi', 'Typologio-D.E..pdf', NULL),
(200, 'ela re mpro', 'fjladsfk', 'up0000001', 'up0000025', NULL, 'energi', NULL, NULL),
(202, 'assign', 'fjadksfjads\r\n', 'up0000004', 'up0000022', NULL, 'anathesi', NULL, NULL),
(203, 'yahoo mario', 'test', 'up0000002', 'up0000013', NULL, 'anathesi', NULL, NULL),
(205, 'cancel', 'fdashjfa', 'up0000001', 'up0000028', NULL, 'akiromeni', NULL, NULL);

--
-- Triggers `diplomatiki`
--
DELIMITER $$
CREATE TRIGGER `clear_epitroph` AFTER UPDATE ON `diplomatiki` FOR EACH ROW IF NEW.status = 'diathesimi' THEN
	UPDATE epitroph
    SET prof2 = NULL,
        prof3 = NULL
	WHERE NEW.id = epitroph.diplomatiki;
    
    DELETE FROM epitroph_app
    WHERE NEW.id =  epitroph_app.diplomatiki;
    
	DELETE FROM epitroph_app_log
    WHERE NEW.id = epitroph_app_log.diplomatiki;
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `on_cancel_insert_to_akiromeni` AFTER UPDATE ON `diplomatiki` FOR EACH ROW IF NEW.status='akiromeni' THEN
	INSERT INTO akiromeni_diplomatiki(diplomatiki) VALUES (NEW.id);
    END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `on_create_add_supervisor` AFTER INSERT ON `diplomatiki` FOR EACH ROW INSERT INTO epitroph(diplomatiki,prof1) VALUES (NEW.id, NEW.professor)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `on_create_log` AFTER INSERT ON `diplomatiki` FOR EACH ROW INSERT INTO diplomatiki_log (new_state, diplomatiki)
        VALUES ('diathesimi', NEW.id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `on_update_log` AFTER UPDATE ON `diplomatiki` FOR EACH ROW IF OLD.status <> NEW.status THEN
	INSERT INTO diplomatiki_log (new_state, diplomatiki)
        VALUES (NEW.status, NEW.id);
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `diplomatiki_app`
--

CREATE TABLE `diplomatiki_app` (
  `diplomatiki` int(7) NOT NULL,
  `student` varchar(30) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('accepted','rejected','waiting') NOT NULL DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diplomatiki_log`
--

CREATE TABLE `diplomatiki_log` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `new_state` enum('energi','eksetasi','peratomeni','akiromeni','anathesi','diathesimi') NOT NULL,
  `diplomatiki` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diplomatiki_log`
--

INSERT INTO `diplomatiki_log` (`id`, `date`, `new_state`, `diplomatiki`) VALUES
(13, '2024-11-30 21:26:05', 'diathesimi', 199),
(14, '2024-11-30 21:26:23', 'diathesimi', 200),
(15, '2024-11-30 21:26:39', 'anathesi', 200),
(16, '2024-11-30 21:26:55', 'diathesimi', 200),
(17, '2024-11-30 21:27:00', 'anathesi', 199),
(18, '2024-11-30 21:27:25', 'anathesi', 200),
(21, '2024-12-01 20:06:53', 'energi', 200),
(22, '2024-12-01 20:09:36', 'eksetasi', 200),
(23, '2024-12-01 20:17:19', 'eksetasi', 199),
(24, '2024-12-01 20:20:50', 'anathesi', 199),
(25, '2024-12-01 20:48:55', 'energi', 200),
(26, '2024-12-01 21:08:25', 'diathesimi', 202),
(27, '2024-12-01 21:08:32', 'anathesi', 202),
(28, '2024-12-01 21:13:53', 'anathesi', 200),
(29, '2024-12-01 21:28:04', 'diathesimi', 202),
(30, '2024-12-01 21:28:07', 'diathesimi', 199),
(31, '2024-12-01 21:28:20', 'anathesi', 202),
(32, '2024-12-01 21:28:46', 'diathesimi', 202),
(33, '2024-12-01 21:29:56', 'anathesi', 202),
(34, '2024-12-01 21:30:01', 'diathesimi', 202),
(35, '2024-12-01 21:30:31', 'anathesi', 202),
(36, '2024-12-01 21:30:32', 'anathesi', 199),
(37, '2024-12-01 21:30:37', 'diathesimi', 202),
(38, '2024-12-01 21:30:41', 'diathesimi', 199),
(39, '2024-12-01 21:31:13', 'anathesi', 202),
(40, '2024-12-01 21:31:22', 'diathesimi', 200),
(41, '2024-12-01 21:31:26', 'anathesi', 199),
(42, '2024-12-01 21:31:43', 'anathesi', 200),
(43, '2024-12-01 21:31:59', 'diathesimi', 202),
(44, '2024-12-01 21:32:02', 'diathesimi', 199),
(45, '2024-12-01 21:32:26', 'diathesimi', 200),
(46, '2024-12-01 21:32:36', 'anathesi', 200),
(47, '2024-12-01 21:32:40', 'anathesi', 202),
(48, '2024-12-01 21:33:34', 'diathesimi', 202),
(49, '2024-12-01 21:33:39', 'anathesi', 199),
(50, '2024-12-01 21:33:55', 'diathesimi', 199),
(51, '2024-12-01 21:34:19', 'diathesimi', 200),
(52, '2024-12-01 21:34:47', 'anathesi', 200),
(53, '2024-12-01 21:34:50', 'anathesi', 202),
(54, '2024-12-01 21:35:26', 'anathesi', 199),
(55, '2024-12-01 21:35:33', 'diathesimi', 199),
(56, '2024-12-01 21:37:41', 'anathesi', 199),
(57, '2024-12-01 21:37:48', 'diathesimi', 199),
(58, '2024-12-01 21:38:26', 'diathesimi', 200),
(59, '2024-12-01 21:38:33', 'anathesi', 199),
(60, '2024-12-01 21:38:41', 'diathesimi', 199),
(61, '2024-12-01 21:39:06', 'diathesimi', 202),
(62, '2024-12-01 21:39:16', 'anathesi', 200),
(63, '2024-12-01 21:39:20', 'anathesi', 202),
(64, '2024-12-01 21:39:24', 'anathesi', 199),
(65, '2024-12-01 21:55:06', 'diathesimi', 203),
(66, '2024-12-01 21:55:14', 'anathesi', 203),
(69, '2024-12-01 22:27:41', 'diathesimi', 203),
(71, '2024-12-01 22:28:01', 'anathesi', 203),
(72, '2024-12-01 22:45:24', 'diathesimi', 200),
(73, '2024-12-01 22:46:05', 'anathesi', 200),
(74, '2024-12-01 22:46:34', 'diathesimi', 200),
(75, '2024-12-01 22:47:18', 'anathesi', 200),
(76, '2024-12-02 14:14:40', 'energi', 199),
(77, '2024-12-02 14:44:25', 'energi', 200),
(78, '2024-12-02 14:52:33', 'eksetasi', 200),
(79, '2024-12-02 14:54:33', 'energi', 200),
(80, '2024-12-02 15:02:59', 'eksetasi', 200),
(81, '2024-12-02 15:03:11', 'energi', 200),
(82, '2024-12-02 15:18:17', 'anathesi', 200),
(83, '2024-12-02 15:22:51', 'energi', 200),
(84, '2024-12-02 16:17:15', 'diathesimi', 205),
(85, '2024-12-02 16:17:27', 'anathesi', 205),
(86, '2024-12-02 16:17:36', 'energi', 205),
(121, '2024-12-02 16:24:01', 'akiromeni', 205),
(122, '2024-12-02 16:25:03', 'energi', 205),
(123, '2024-12-02 16:25:09', 'akiromeni', 205);

-- --------------------------------------------------------

--
-- Table structure for table `epitroph`
--

CREATE TABLE `epitroph` (
  `diplomatiki` int(7) NOT NULL,
  `prof1` varchar(30) NOT NULL,
  `prof2` varchar(30) DEFAULT NULL,
  `prof3` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `epitroph`
--

INSERT INTO `epitroph` (`diplomatiki`, `prof1`, `prof2`, `prof3`) VALUES
(199, 'up0000002', 'up0000004', 'up0000001'),
(200, 'up0000001', NULL, NULL),
(202, 'up0000004', 'up0000001', NULL),
(203, 'up0000002', NULL, NULL),
(205, 'up0000001', NULL, NULL);

--
-- Triggers `epitroph`
--
DELIMITER $$
CREATE TRIGGER `remove_invitations` AFTER UPDATE ON `epitroph` FOR EACH ROW IF NEW.prof3 IS NOT NULL THEN
	DELETE FROM epitroph_app WHERE diplomatiki = NEW.diplomatiki;
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `epitroph_app`
--

CREATE TABLE `epitroph_app` (
  `diplomatiki` int(7) NOT NULL,
  `invited_professor` varchar(30) NOT NULL,
  `status` enum('accepted','rejected','waiting') NOT NULL DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `epitroph_app`
--

INSERT INTO `epitroph_app` (`diplomatiki`, `invited_professor`, `status`) VALUES
(202, 'up0000002', 'waiting');

--
-- Triggers `epitroph_app`
--
DELIMITER $$
CREATE TRIGGER `log_response` AFTER UPDATE ON `epitroph_app` FOR EACH ROW IF OLD.status <> NEW.status THEN
INSERT INTO epitroph_app_log (new_state, diplomatiki, invited_professor)
        VALUES (NEW.status, NEW.diplomatiki, NEW.invited_professor);
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_waiting` AFTER INSERT ON `epitroph_app` FOR EACH ROW INSERT INTO epitroph_app_log (new_state, diplomatiki, invited_professor)
        VALUES ('waiting', NEW.diplomatiki, NEW.invited_professor)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `epitroph_app_log`
--

CREATE TABLE `epitroph_app_log` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `new_state` enum('accepted','rejected','waiting') NOT NULL,
  `diplomatiki` int(11) NOT NULL,
  `invited_professor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `epitroph_app_log`
--

INSERT INTO `epitroph_app_log` (`id`, `date`, `new_state`, `diplomatiki`, `invited_professor`) VALUES
(1, '2024-12-01 21:55:34', 'waiting', 202, 'up0000002'),
(2, '2024-12-01 21:59:36', 'waiting', 199, 'up0000001'),
(3, '2024-12-01 22:02:36', 'accepted', 199, 'up0000001');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `diplomatiki` int(7) NOT NULL,
  `datetime` datetime NOT NULL,
  `grade` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `username` varchar(30) NOT NULL,
  `tmhma` varchar(255) NOT NULL,
  `panepistimio` varchar(255) NOT NULL,
  `thema` text NOT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`username`, `tmhma`, `panepistimio`, `thema`, `status`) VALUES
('up0000001', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('up0000002', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('up0000003', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('up0000004', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('up0000005', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('up0000006', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('up0000007', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('up0000008', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('up0000009', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `username` varchar(30) NOT NULL,
  `etos_eisagwghs` int(4) NOT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`username`, `etos_eisagwghs`, `status`) VALUES
('up0000011', 2015, 'unavailable'),
('up0000012', 2015, 'available'),
('up0000013', 2015, 'unavailable'),
('up0000014', 2015, 'available'),
('up0000015', 2015, 'available'),
('up0000016', 2015, 'available'),
('up0000017', 2015, 'unavailable'),
('up0000018', 2015, 'unavailable'),
('up0000019', 2015, 'unavailable'),
('up0000020', 2015, 'unavailable'),
('up0000021', 2015, 'unavailable'),
('up0000022', 2015, 'unavailable'),
('up0000023', 2015, 'available'),
('up0000024', 2015, 'unavailable'),
('up0000025', 2015, 'unavailable'),
('up0000026', 2015, 'available'),
('up0000027', 2015, 'available'),
('up0000028', 2015, 'unavailable'),
('up0000029', 2015, 'available'),
('up0000030', 2015, 'unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `am` int(7) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `patrwnumo` varchar(50) NOT NULL,
  `kinito` varchar(10) NOT NULL,
  `stathero` varchar(10) NOT NULL,
  `role` enum('student','professor','grammateia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `am`, `email`, `firstname`, `lastname`, `patrwnumo`, `kinito`, `stathero`, `role`) VALUES
('grammateia', '789', 69, 'grammateia@ceid.upatras.gr', 'Κωνσταντίνος', 'Αχλάδης', 'Γεώργιος', '6975464452', '2610865974', 'grammateia'),
('up0000001', '123', 1, 'up0000001@ac.upatras.gr', 'Αναστάσιος', 'Παπαδόπουλος', 'Γιώργος', '6901234567', '2109111111', 'professor'),
('up0000002', '123', 2, 'up0000002@ac.upatras.gr', 'Μαρία', 'Κωστόπουλος', 'Αλέξανδρος', '6902234567', '2109222222', 'professor'),
('up0000003', '123', 3, 'up0000003@ac.upatras.gr', 'Γιάννης', 'Στασινόπουλος', 'Χρήστος', '6903234567', '2109333333', 'professor'),
('up0000004', '123', 4, 'up0000004@ac.upatras.gr', 'Δημήτρης', 'Αναγνωστόπουλος', 'Σταύρος', '6904234567', '2109444444', 'professor'),
('up0000005', '$2y$10$CgE3aHTDNTvBpsug4v2IY.BUC866tNzVEBBQUZ0CD2mu0YMJ5K4VK', 5, 'up0000005@ac.upatras.gr', 'Αλέξανδρος', 'Παντελίδης', 'Κωνσταντίνος', '6905234567', '2109555555', 'professor'),
('up0000006', '$2y$10$T6/WdH7z82rbR5L0XHvrMOapUkzLy1xLZpGHPhRwlzPHYh8S6PKs6', 6, 'up0000006@ac.upatras.gr', 'Σταύρος', 'Καραγιάννης', 'Πέτρος', '6906234567', '2109666666', 'professor'),
('up0000007', '$2y$10$XDAaaSAWQY7T3wFQu7ydq.o3/QKSzLVCz3r70y1hG3LTChdKgLa1.', 7, 'up0000007@ac.upatras.gr', 'Ευάγγελος', 'Παπακωνσταντίνου', 'Αλέξανδρος', '6907234567', '2109777777', 'professor'),
('up0000008', '$2y$10$CLjHf1thkRFNeY1zYvtzk.tHnwvvr3TLTx.a7kxPTqJqih8o0W97S', 8, 'up0000008@ac.upatras.gr', 'Κωνσταντίνος', 'Αβραάμ', 'Αντώνιος', '6908234567', '2109888888', 'professor'),
('up0000009', '$2y$10$H5cRAKkZ4OdmLyEHW3msDO8Z8A0Cv6N5gYl8U0GXHHbZIsiYzimu2', 9, 'up0000009@ac.upatras.gr', 'Ανδρέας', 'Κυριακίδης', 'Στέφανος', '6909234567', '2109999999', 'professor'),
('up0000011', '456', 11, 'up0000011@ac.upatras.gr', 'Θεόφιλος', 'Κυριακίδης', 'Χρήστος', '6912234567', '2109112345', 'student'),
('up0000012', '$2y$10$utff.mWuz3UXq2hdUsCbj.YHE7Chv7wPUEsdMTMWWVi7osECUq/d.', 12, 'up0000012@ac.upatras.gr', 'Αντώνιος', 'Παπαθεοδωρίδης', 'Δημήτρης', '6913234567', '2109212345', 'student'),
('up0000013', '$2y$10$RP9B7UQZe1A4BT2b5gAqS.4Vf5XpOtQGOiXXotI1yX9/20TJ6ltTe', 13, 'up0000013@ac.upatras.gr', 'Γεώργιος', 'Αδαμίδης', 'Παναγιώτης', '6914234567', '2109312345', 'student'),
('up0000014', '$2y$10$vG12Z5wu8xu9MCrsvugb/.SuUFYu.lGe2LuJPyxQtZVmMqWtbGv5m', 14, 'up0000014@ac.upatras.gr', 'Βασίλειος', 'Φωτόπουλος', 'Σωτήρης', '6915234567', '2109412345', 'student'),
('up0000015', '$2y$10$8rW2Ps9jRgPCNstMUvh4zOBMFSyEm1Yl0O6CE5YcZ8oWXb10FYFVK', 15, 'up0000015@ac.upatras.gr', 'Χρήστος', 'Αντωνίου', 'Δημήτρης', '6916234567', '2109512345', 'student'),
('up0000016', '$2y$10$v5rVBlSehSwV/OI043Qu4.J1X38IVC/y8c0fpkQHK4kw7rkuePZKW', 16, 'up0000016@ac.upatras.gr', 'Νίκος', 'Πασχαλίδης', 'Αριστείδης', '6917234567', '2109612345', 'student'),
('up0000017', '$2y$10$lCzdJkCM5/vFtTuw1awknODX35EkGuS7YvGlVbN0QCW5hnCsCSvMi', 17, 'up0000017@ac.upatras.gr', 'Γιώργος', 'Κωνσταντίνου', 'Χρήστος', '6918234567', '2109712345', 'student'),
('up0000018', '$2y$10$cf2nTC0XrU1j.EB5j7tqcO7TMnNamsAmXhARH1Eq8wXzlJpFqQ3oG', 18, 'up0000018@ac.upatras.gr', 'Ελένη', 'Στεφανάκη', 'Παναγιώτης', '6919234567', '2109812345', 'student'),
('up0000019', '$2y$10$FEOjnc6H7NhfWLskSXd0we3Og5BNsFg6icZgMK.f85EppFZ43iXHq', 19, 'up0000019@ac.upatras.gr', 'Ανδρέας', 'Κατσούλης', 'Σπύρος', '6920234567', '2109912345', 'student'),
('up0000020', '$2y$10$q.NkHsCj3z5Ej1gtp8xbweV9Go/SnS.CldJyfcPlSpxgGuWpgExRS', 20, 'up0000020@ac.upatras.gr', 'Μαρία', 'Βαβούρης', 'Δημήτρης', '6921234567', '2109412345', 'student'),
('up0000021', '$2y$10$bWjU.92tu8o/IcRTLhojR.4az.p.ql/IeQF15TpBxxKEv146ptLOW', 21, 'up0000021@ac.upatras.gr', 'Παναγιώτης', 'Καραφωτιάς', 'Σταύρος', '6922234567', '2109512345', 'student'),
('up0000022', '$2y$10$TayJa3ieAuFQjRn/zupCTOTJOCgFRthFUQOxB7IGBcfxc7obiCzCa', 22, 'up0000022@ac.upatras.gr', 'Γιάννης', 'Κωστόπουλος', 'Γιώργος', '6923234567', '2109612345', 'student'),
('up0000023', '$2y$10$YIs38KF9CQ93EngpFb/Aye8ljqzDcS7yva0yMiQOYN0rigsQTcb4C', 23, 'up0000023@ac.upatras.gr', 'Φώτης', 'Κουτσογιάννης', 'Στέφανος', '6924234567', '2109712345', 'student'),
('up0000024', '$2y$10$4/9et1yp2drXskRITU/ZmODsV6R4qU0a/rDnomwvdmP0ZmZZvTpZe', 24, 'up0000024@ac.upatras.gr', 'Νίκος', 'Πιλάτος', 'Αριστείδης', '6925234567', '2109812345', 'student'),
('up0000025', '$2y$10$jLr3VkTb4Y1c/m0sRSmRo.r3G9f1XuM3LXhc6xmDkATg4NOgjpsUC', 25, 'up0000025@ac.upatras.gr', 'Χρήστος', 'Καλαφάτης', 'Στέφανος', '6926234567', '2109912345', 'student'),
('up0000026', '$2y$10$NwOIrVYjWGBuuEFjDKjq.ex0cVs9zmBuuuyK64bLYbUYBujy6n2nS', 26, 'up0000026@ac.upatras.gr', 'Νίκος', 'Τσολάκης', 'Δημήτρης', '6927234567', '2109912345', 'student'),
('up0000027', '$2y$10$X2eMrbJ6NQx9.Mvfs/IQtup0Z47gEfH7IxNCqLRlBYlT0ID3kJVN.', 27, 'up0000027@ac.upatras.gr', 'Δημήτρης', 'Φωτόπουλος', 'Αλέξανδρος', '6928234567', '2109512345', 'student'),
('up0000028', '$2y$10$2n1.xlXcqkIMBdBSlWLCre8N2c1fH8NRG1I1QTFqEdLh2b53P0F9y', 28, 'up0000028@ac.upatras.gr', 'Κωνσταντίνος', 'Αντωνόπουλος', 'Γεώργιος', '6929234567', '2109612345', 'student'),
('up0000029', '$2y$10$PIvJ3eJ/xwWw3hbiwyVm9eUcyFR1O8F73EcF8Jt9.CmZSm/J1V0WS', 29, 'up0000029@ac.upatras.gr', 'Γιώργος', 'Κοκκίνης', 'Νικόλαος', '6930234567', '2109712345', 'student'),
('up0000030', '$2y$10$eeht7HTGFUPUwMg7il.n5u/WgWlHbBCYo6wwpEMJhPi9dTNRBPC.i', 30, 'up0000030@ac.upatras.gr', 'Αντώνης', 'Μητσούλης', 'Σπύρος', '6931234567', '2109812345', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `token` varchar(255) NOT NULL,
  `user` varchar(30) NOT NULL,
  `expiration_date` datetime NOT NULL DEFAULT (current_timestamp() + interval 1 hour)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tokens`
--

INSERT INTO `user_tokens` (`token`, `user`, `expiration_date`) VALUES
('7ce495b7400cb853627d977aa831cda8f3f2e5b7fdfbdc71eb95786a36f4c1ef', 'up0000002', '2024-12-02 18:18:21'),
('81d8e70f3a1841eab56a045aa3bc2bc94fbcbb90710371772582472910eb16a0', 'up0000001', '2024-12-02 18:21:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `akiromeni_diplomatiki`
--
ALTER TABLE `akiromeni_diplomatiki`
  ADD PRIMARY KEY (`diplomatiki`);

--
-- Indexes for table `diplomatiki`
--
ALTER TABLE `diplomatiki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_diplomatiki_student` (`student`),
  ADD KEY `fk_professor_diplomatiki` (`professor`);

--
-- Indexes for table `diplomatiki_app`
--
ALTER TABLE `diplomatiki_app`
  ADD PRIMARY KEY (`diplomatiki`,`student`),
  ADD KEY `fk_diplomatiki_app_student` (`student`);

--
-- Indexes for table `diplomatiki_log`
--
ALTER TABLE `diplomatiki_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_diplomatiki_log_diplomatiki` (`diplomatiki`);

--
-- Indexes for table `epitroph`
--
ALTER TABLE `epitroph`
  ADD PRIMARY KEY (`diplomatiki`),
  ADD KEY `fk_epitroph_professor1` (`prof1`),
  ADD KEY `fk_epitroph_professor2` (`prof2`),
  ADD KEY `fk_epitroph_professor3` (`prof3`);

--
-- Indexes for table `epitroph_app`
--
ALTER TABLE `epitroph_app`
  ADD PRIMARY KEY (`diplomatiki`,`invited_professor`),
  ADD KEY `fk_comission_app_professor` (`invited_professor`);

--
-- Indexes for table `epitroph_app_log`
--
ALTER TABLE `epitroph_app_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`diplomatiki`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `am` (`am`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`token`),
  ADD KEY `fk_user_tokens` (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akiromeni_diplomatiki`
--
ALTER TABLE `akiromeni_diplomatiki`
  MODIFY `diplomatiki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `diplomatiki`
--
ALTER TABLE `diplomatiki`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `diplomatiki_log`
--
ALTER TABLE `diplomatiki_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `epitroph_app_log`
--
ALTER TABLE `epitroph_app_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akiromeni_diplomatiki`
--
ALTER TABLE `akiromeni_diplomatiki`
  ADD CONSTRAINT `fk_akiromeni_diplomatiki_diplomatiki` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diplomatiki`
--
ALTER TABLE `diplomatiki`
  ADD CONSTRAINT `fk_professor_diplomatiki` FOREIGN KEY (`professor`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_diplomatiki` FOREIGN KEY (`student`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diplomatiki_log`
--
ALTER TABLE `diplomatiki_log`
  ADD CONSTRAINT `fk_diplomatiki_log_diplomatiki` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `epitroph`
--
ALTER TABLE `epitroph`
  ADD CONSTRAINT `fk_epitroph_diplomatiki` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_epitroph_professor1` FOREIGN KEY (`prof1`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_epitroph_professor2` FOREIGN KEY (`prof2`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_epitroph_professor3` FOREIGN KEY (`prof3`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `epitroph_app`
--
ALTER TABLE `epitroph_app`
  ADD CONSTRAINT `fk_epitroph_app_diplomatiki` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`),
  ADD CONSTRAINT `fk_epitroph_app_professor` FOREIGN KEY (`invited_professor`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `fk_professor_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `CLEAR_TOKENS` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-11-18 17:47:44' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
DELETE FROM user_tokens
WHERE expiration_date < CURRENT_TIMESTAMP();
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
