-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2024 at 09:44 PM
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
('akyriakidis', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('apantelidis', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('apapadopoulos', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('danagnostopoulos', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('epapakostantinou', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('gstasinopoulos', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('kavram', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('mkostopoulos', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
('skaragiannis', 'Patras', 'Karaoli & Dimitriou', 5, 26222),
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
  `arithmos_gs` varchar(11) DEFAULT NULL,
  `etos_gs` year(4) DEFAULT NULL,
  `logos` text NOT NULL DEFAULT '"από Διδάσκοντα"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `grade_filename` varchar(255) DEFAULT NULL,
  `gradeable` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diplomatiki`
--

INSERT INTO `diplomatiki` (`id`, `title`, `description`, `professor`, `student`, `url`, `status`, `filename`, `grade_filename`, `gradeable`) VALUES
(233, 'test', 'test', 'apapadopoulos', 'up0000011', NULL, 'energi', 'ekfonisi_web.pdf', NULL, 0),
(234, 'test2', 'test2', 'apapadopoulos', 'up0000030', NULL, 'eksetasi', NULL, NULL, 0),
(235, 'test3', 'test3', 'mkostopoulos', 'up0000015', NULL, 'eksetasi', NULL, NULL, 0),
(236, 'energi', 'energi', 'apapadopoulos', 'up0000024', NULL, 'energi', NULL, NULL, 0);

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
(208, '2024-12-05 22:35:23', 'diathesimi', 233),
(209, '2024-12-05 22:35:50', 'diathesimi', 234),
(210, '2024-12-05 22:35:59', 'anathesi', 233),
(211, '2024-12-05 22:36:04', 'anathesi', 234),
(212, '2024-12-05 22:39:45', 'energi', 233),
(213, '2024-12-05 22:39:49', 'energi', 234),
(214, '2024-12-05 22:43:20', 'diathesimi', 235),
(215, '2024-12-05 22:43:29', 'anathesi', 235),
(216, '2024-12-05 22:45:06', 'energi', 235),
(217, '2024-12-05 22:48:00', 'eksetasi', 235),
(218, '2024-12-05 22:48:01', 'eksetasi', 234),
(219, '2024-12-09 22:43:10', 'diathesimi', 236),
(220, '2024-12-09 22:43:16', 'anathesi', 236),
(221, '2024-12-09 22:43:48', 'energi', 236);

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
(233, 'apapadopoulos', 'danagnostopoulos', 'epapakostantinou'),
(234, 'apapadopoulos', 'gstasinopoulos', 'kavram'),
(235, 'mkostopoulos', NULL, NULL),
(236, 'apapadopoulos', 'danagnostopoulos', 'skaragiannis');

--
-- Triggers `epitroph`
--
DELIMITER $$
CREATE TRIGGER `remove_invitations` AFTER UPDATE ON `epitroph` FOR EACH ROW IF NEW.prof3 IS NOT NULL THEN
	DELETE FROM epitroph_app WHERE diplomatiki = NEW.diplomatiki;
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set_thesis_active` AFTER UPDATE ON `epitroph` FOR EACH ROW IF NEW.prof3 IS NOT NULL THEN
	UPDATE diplomatiki
    SET diplomatiki.status="energi"
    WHERE diplomatiki.id = NEW.diplomatiki;
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

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `diplomatiki` int(7) NOT NULL,
  `professor` varchar(30) NOT NULL,
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
('apapadopoulos', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('danagnostopoulos', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('epapakostantinou', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('gstasinopoulos', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('kavram', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('mkostopoulos', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available'),
('skaragiannis', 'Computer Science', 'University of Patras', 'Artificial Intelligence', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `username` varchar(30) NOT NULL,
  `am` int(7) NOT NULL,
  `etos_eisagwghs` int(4) NOT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`username`, `am`, `etos_eisagwghs`, `status`) VALUES
('up0000011', 11, 2015, 'unavailable'),
('up0000012', 12, 2015, 'available'),
('up0000013', 13, 2015, 'available'),
('up0000014', 14, 2015, 'available'),
('up0000015', 15, 2015, 'unavailable'),
('up0000016', 16, 2015, 'available'),
('up0000017', 17, 2015, 'available'),
('up0000018', 18, 2015, 'available'),
('up0000019', 19, 2015, 'available'),
('up0000020', 20, 2015, 'available'),
('up0000021', 21, 2015, 'available'),
('up0000022', 22, 2015, 'available'),
('up0000023', 23, 2015, 'available'),
('up0000024', 24, 2015, 'unavailable'),
('up0000025', 25, 2015, 'available'),
('up0000026', 26, 2015, 'available'),
('up0000027', 27, 2015, 'available'),
('up0000028', 28, 2015, 'available'),
('up0000029', 29, 2015, 'available'),
('up0000030', 30, 2015, 'unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
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

INSERT INTO `users` (`username`, `password`, `email`, `firstname`, `lastname`, `patrwnumo`, `kinito`, `stathero`, `role`) VALUES
('akyriakidis', '$2y$10$lun4E/82n.4/aiCErnUMkefuOUq7xiUjM0YB.92jSzXLMdiKBkgHm', 'akyriakidis@ac.upatras.gr', 'Ανδρέας', 'Κυριακίδης', 'Στέφανος', '6909234567', '2109999999', 'grammateia'),
('apantelidis', '$2y$10$c6lY7tK7MRXxFuCRVcWkDuYdvIHuboO0PSYE8uOFJOUZwLem6qRL6', 'apantelidis@ac.upatras.gr', 'Αλέξανδρος', 'Παντελίδης', 'Κωνσταντίνος', '6905234567', '2109555555', 'grammateia'),
('apapadopoulos', '$2y$10$tIDH1fzEbvUhFiCXJT8xUewiwb2Bxzb2bEVrOMAJJNHlitKAe0MzO', 'apapadopoulos@ac.upatras.gr', 'Αναστάσιος', 'Παπαδόπουλος', 'Γιώργος', '6901234567', '2109111111', 'professor'),
('danagnostopoulos', '$2y$10$ZsR4yY2PtacMVRKer3dWlOKHdCs7as1/oUzsqMZ5RGTT/V0yHtc1i', 'danagnostopoulos@ac.upatras.gr', 'Δημήτρης', 'Αναγνωστόπουλος', 'Σταύρος', '6904234567', '2109444444', 'professor'),
('epapakostantinou', '$2y$10$cO6/NihjObm.qyxxfA6.L.JFnRT.HGih14di5QH1qio4ENCcF07Gy', 'epapakostantinou@ac.upatras.gr', 'Ευάγγελος', 'Παπακωνσταντίνου', 'Αλέξανδρος', '6907234567', '2109777777', 'professor'),
('gstasinopoulos', '$2y$10$tqBUX63yjEyzOGSMG/s/HeAmbgsiWJ9JNYOSUMZ8ZfSo5bQAotR/6', 'gstasinopoulos@ac.upatras.gr', 'Γιάννης', 'Στασινόπουλος', 'Χρήστος', '6903234567', '2109333333', 'professor'),
('kavram', '$2y$10$6ijMk5ItqLCmKRfJeW.9Ke35MQbXdl5mZAPXQSldIrDQIIZjD5R/G', 'kavram@ac.upatras.gr', 'Κωνσταντίνος', 'Αβραάμ', 'Αντώνιος', '6908234567', '2109888888', 'professor'),
('mkostopoulos', '$2y$10$XDgTRqUj3HwHvdqrH9sY9OkD3r9tXMSyq2f7dRE8N5HEQh3wqBs76', 'mkostopoulos@ac.upatras.gr', 'Μαρία', 'Κωστόπουλος', 'Αλέξανδρος', '6902234567', '2109222222', 'professor'),
('skaragiannis', '$2y$10$2IwJ4QqCoQ8tLtp55lT5EOxk0TkdfSDIdnzIInk07prnApy1sRVia', 'skaragiannis@ac.upatras.gr', 'Σταύρος', 'Καραγιάννης', 'Πέτρος', '6906234567', '2109666666', 'professor'),
('up0000011', '$2y$10$WiC2x3YTwEvcxMUvOn/rCOvgnbHIgqRc/Z.3ZnmsNQu/1Ur2XXo2W', 'up0000011@ac.upatras.gr', 'Θεόφιλος', 'Κυριακίδης', 'Χρήστος', '6912234567', '2109112345', 'student'),
('up0000012', '$2y$10$fMoZE7qd2WMZXiwqt3BX..fhEFTVFBddiUQ6dUL/g4Tn5Xs9oL5ZO', 'up0000012@ac.upatras.gr', 'Αντώνιος', 'Παπαθεοδωρίδης', 'Δημήτρης', '6913234567', '2109212345', 'student'),
('up0000013', '$2y$10$9tZIe.rC30JMShlNzFdJFOCvOclQE85utWYktq9z0RjlpyazTSf8y', 'up0000013@ac.upatras.gr', 'Γεώργιος', 'Αδαμίδης', 'Παναγιώτης', '6914234567', '2109312345', 'student'),
('up0000014', '$2y$10$ihaYwLl2ByOZsifmPdavBeBRhU3EB.mzqN6IUElz9ThfNnbSRrgti', 'up0000014@ac.upatras.gr', 'Βασίλειος', 'Φωτόπουλος', 'Σωτήρης', '6915234567', '2109412345', 'student'),
('up0000015', '$2y$10$PN74J9hDTmdCfk5S2/jfH.vpa4ZZilyhQJH/iVG1PwwIWCL/lmYHy', 'up0000015@ac.upatras.gr', 'Χρήστος', 'Αντωνίου', 'Δημήτρης', '6916234567', '2109512345', 'student'),
('up0000016', '$2y$10$YRrdqik76PD91g4JmdKkN.HWYLNy7HLpdFgOrp2DX6xU/XaXEUpV2', 'up0000016@ac.upatras.gr', 'Νίκος', 'Πασχαλίδης', 'Αριστείδης', '6917234567', '2109612345', 'student'),
('up0000017', '$2y$10$icHT6hEh5Y1lK5y5y.9Be.D5ISUrcJArkWfomrSiX1pTWT8KdOSaG', 'up0000017@ac.upatras.gr', 'Γιώργος', 'Κωνσταντίνου', 'Χρήστος', '6918234567', '2109712345', 'student'),
('up0000018', '$2y$10$YR/DpvssnBx.2HwXwz27ien/QCFdSKrbMnSkfrSHzEvCoRUKdkx3.', 'up0000018@ac.upatras.gr', 'Ελένη', 'Στεφανάκη', 'Παναγιώτης', '6919234567', '2109812345', 'student'),
('up0000019', '$2y$10$VlVHi8Bh9cxAXTcuc/Rzge//XIpLKQPXHknvmSKLQM.gDU1M9Knyi', 'up0000019@ac.upatras.gr', 'Ανδρέας', 'Κατσούλης', 'Σπύρος', '6920234567', '2109912345', 'student'),
('up0000020', '$2y$10$cY1.pbUtOjqcUcoZgmloKO1gefVRjNfe/fRzHT93KkYi0pWTC/l8O', 'up0000020@ac.upatras.gr', 'Μαρία', 'Βαβούρης', 'Δημήτρης', '6921234567', '2109412345', 'student'),
('up0000021', '$2y$10$i85H3DBiVKvxoFyJCbLERuFImvB4C3sUQsFq5trp3yysmU7pRF91a', 'up0000021@ac.upatras.gr', 'Παναγιώτης', 'Καραφωτιάς', 'Σταύρος', '6922234567', '2109512345', 'student'),
('up0000022', '$2y$10$.1JxUXkAIGTSI5aEOQsNjOX2yn7rXza0EOTrlBiCZDQP4OA7Zz7c.', 'up0000022@ac.upatras.gr', 'Γιάννης', 'Κωστόπουλος', 'Γιώργος', '6923234567', '2109612345', 'student'),
('up0000023', '$2y$10$ER3RyudXZV2Ao9uSrA6QReSxb/W4ILo/TqFuebSBfgJeYPkkoJQT.', 'up0000023@ac.upatras.gr', 'Φώτης', 'Κουτσογιάννης', 'Στέφανος', '6924234567', '2109712345', 'student'),
('up0000024', '$2y$10$gsCR1cIzogpPq.KKPfpaZevl0LgeiVmBDK7zPEfC7Yr3X0ykIBtW6', 'up0000024@ac.upatras.gr', 'Νίκος', 'Πιλάτος', 'Αριστείδης', '6925234567', '2109812345', 'student'),
('up0000025', '$2y$10$D/IEX3Oiau4VWxeahgEr2eGaY2r3GagT8BWLY2vVrKZZ6wSh/5mcq', 'up0000025@ac.upatras.gr', 'Χρήστος', 'Καλαφάτης', 'Στέφανος', '6926234567', '2109912345', 'student'),
('up0000026', '$2y$10$STdx.Nln9t6F3xxONQd1cOjBMxGHhykcNpXnclGdCc29IUcbw8r/W', 'up0000026@ac.upatras.gr', 'Νίκος', 'Τσολάκης', 'Δημήτρης', '6927234567', '2109912345', 'student'),
('up0000027', '$2y$10$cQ.p8XiXHHOQ7GTtYR/2b.fR/AxUiICMF4NS2HdvhbbhH0HCny1gC', 'up0000027@ac.upatras.gr', 'Δημήτρης', 'Φωτόπουλος', 'Αλέξανδρος', '6928234567', '2109512345', 'student'),
('up0000028', '$2y$10$uQofDOmXfXjh/oMTDNaqI.te8BAf0.kW1AwSycOEFv8a0v99eX6le', 'up0000028@ac.upatras.gr', 'Κωνσταντίνος', 'Αντωνόπουλος', 'Γεώργιος', '6929234567', '2109612345', 'student'),
('up0000029', '$2y$10$RtnX/hzu.oGbhi/AqzSjheYCyC.P1Q38j46L8S6tC7iUNSYsqhDcO', 'up0000029@ac.upatras.gr', 'Γιώργος', 'Κοκκίνης', 'Νικόλαος', '6930234567', '2109712345', 'student'),
('up0000030', '$2y$10$b40xh.e7WjkNwH4HsLPAIeINT3tQfemIBHJu.LtjRCxuc4462QJqK', 'up0000030@ac.upatras.gr', 'Αντώνης', 'Μητσούλης', 'Σπύρος', '6931234567', '2109812345', 'student');

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
('11145a618dd7e1a00453d938c33a49029fd94d7595a16ce1bc48c67045b42cde', 'akyriakidis', '2024-12-09 23:43:51'),
('3c25d7d919889a77873b0c59c5873264e0e509e67248103593890af58ebe09e8', 'apapadopoulos', '2024-12-09 23:44:03'),
('b24da33a04339611e26a9608966f6be4bb180625a153c1bfa2d98d5aede1ed61', 'grammateia2', '2024-12-05 15:11:33');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_diplomatiki_epitroph_app_log` (`diplomatiki`),
  ADD KEY `fk_professor_epitroph_app_log` (`invited_professor`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`diplomatiki`),
  ADD KEY `fk_professor_evaluation` (`professor`);

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
  ADD PRIMARY KEY (`username`);

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
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `diplomatiki_log`
--
ALTER TABLE `diplomatiki_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `epitroph_app_log`
--
ALTER TABLE `epitroph_app_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  ADD CONSTRAINT `fk_epitroph_app_diplomatiki` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_epitroph_app_professor` FOREIGN KEY (`invited_professor`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `epitroph_app_log`
--
ALTER TABLE `epitroph_app_log`
  ADD CONSTRAINT `fk_diplomatiki_epitroph_app_log` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_professor_epitroph_app_log` FOREIGN KEY (`invited_professor`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `fk_diplomatiki_evaluation` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_professor_evaluation` FOREIGN KEY (`professor`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `fk_professor_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

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
