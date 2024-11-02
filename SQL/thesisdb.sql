-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2024 at 03:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `street` int(100) NOT NULL,
  `zipcode` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diplomatiki`
--

CREATE TABLE `diplomatiki` (
  `id` int(7) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `student` varchar(30) NOT NULL,
  `url` text DEFAULT NULL,
  `status` enum('active','processing','closed','cancelled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `epitroph`
--

CREATE TABLE `epitroph` (
  `diplomatiki` int(7) NOT NULL,
  `prof1` varchar(30) NOT NULL,
  `prof2` varchar(30) DEFAULT NULL,
  `prof3` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `epitroph_app`
--

CREATE TABLE `epitroph_app` (
  `diplomatiki` int(7) NOT NULL,
  `professor` varchar(30) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('accepted','rejected','waiting') NOT NULL DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `username` varchar(30) NOT NULL,
  `etos_eisagwghs` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `kinito` int(10) NOT NULL,
  `stathero` int(10) NOT NULL,
  `role` enum('student','professor','grammateia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `am`, `email`, `firstname`, `lastname`, `patrwnumo`, `kinito`, `stathero`, `role`) VALUES
('up0000001', '$2y$10$OVPIOSKt1cltEXqmMTKKzOct.rfFlNYj3I/sKyFmh55ZeS.t0tg06', 1, 'up0000001@ac.upatras.gr', 'Αναστάσιος', 'Παπαδόπουλος', 'Γιώργος', 2147483647, 2109111111, 'professor'),
('up0000002', '$2y$10$juPLpyDdhun3GmYPzPmH3eThszl.dHyIDQ0hZ9dcjYe6GUzsiKvbG', 2, 'up0000002@ac.upatras.gr', 'Μαρία', 'Κωστόπουλος', 'Αλέξανδρος', 2147483647, 2109222222, 'professor'),
('up0000003', '$2y$10$ZmoKd8vAOcgvBmWVLUnmdu61cvt.2jWdwUjSp/vX4jPLNY/JyJeoy', 3, 'up0000003@ac.upatras.gr', 'Γιάννης', 'Στασινόπουλος', 'Χρήστος', 2147483647, 2109333333, 'professor'),
('up0000004', '$2y$10$djDD62FTDzVWmlCXwtFFXOwGWgRzybusm7qujQtMzysKXOaORv80G', 4, 'up0000004@ac.upatras.gr', 'Δημήτρης', 'Αναγνωστόπουλος', 'Σταύρος', 2147483647, 2109444444, 'professor'),
('up0000005', '$2y$10$CgE3aHTDNTvBpsug4v2IY.BUC866tNzVEBBQUZ0CD2mu0YMJ5K4VK', 5, 'up0000005@ac.upatras.gr', 'Αλέξανδρος', 'Παντελίδης', 'Κωνσταντίνος', 2147483647, 2109555555, 'professor'),
('up0000006', '$2y$10$T6/WdH7z82rbR5L0XHvrMOapUkzLy1xLZpGHPhRwlzPHYh8S6PKs6', 6, 'up0000006@ac.upatras.gr', 'Σταύρος', 'Καραγιάννης', 'Πέτρος', 2147483647, 2109666666, 'professor'),
('up0000007', '$2y$10$XDAaaSAWQY7T3wFQu7ydq.o3/QKSzLVCz3r70y1hG3LTChdKgLa1.', 7, 'up0000007@ac.upatras.gr', 'Ευάγγελος', 'Παπακωνσταντίνου', 'Αλέξανδρος', 2147483647, 2109777777, 'professor'),
('up0000008', '$2y$10$CLjHf1thkRFNeY1zYvtzk.tHnwvvr3TLTx.a7kxPTqJqih8o0W97S', 8, 'up0000008@ac.upatras.gr', 'Κωνσταντίνος', 'Αβραάμ', 'Αντώνιος', 2147483647, 2109888888, 'professor'),
('up0000009', '$2y$10$H5cRAKkZ4OdmLyEHW3msDO8Z8A0Cv6N5gYl8U0GXHHbZIsiYzimu2', 9, 'up0000009@ac.upatras.gr', 'Ανδρέας', 'Κυριακίδης', 'Στέφανος', 2147483647, 2109999999, 'professor'),
('up0000010', '$2y$10$vnytznuiiAUcD1ig0bSFE.wPxb9Wz460eGKb0DxlmtynMVzYcfoeC', 10, 'up0000010@ac.upatras.gr', 'Νικόλαος', 'Κωσταρίδης', 'Γεώργιος', 2147483647, 2101234567, 'grammateia'),
('up0000011', '$2y$10$JCToDBIMbLqRBRUvkpu8vufOwUEwFQT0B8j2UJrl090Zid3GUaEHC', 11, 'up0000011@ac.upatras.gr', 'Θεόφιλος', 'Κυριακίδης', 'Χρήστος', 2147483647, 2109112345, 'student'),
('up0000012', '$2y$10$utff.mWuz3UXq2hdUsCbj.YHE7Chv7wPUEsdMTMWWVi7osECUq/d.', 12, 'up0000012@ac.upatras.gr', 'Αντώνιος', 'Παπαθεοδωρίδης', 'Δημήτρης', 2147483647, 2109212345, 'student'),
('up0000013', '$2y$10$RP9B7UQZe1A4BT2b5gAqS.4Vf5XpOtQGOiXXotI1yX9/20TJ6ltTe', 13, 'up0000013@ac.upatras.gr', 'Γεώργιος', 'Αδαμίδης', 'Παναγιώτης', 2147483647, 2109312345, 'student'),
('up0000014', '$2y$10$vG12Z5wu8xu9MCrsvugb/.SuUFYu.lGe2LuJPyxQtZVmMqWtbGv5m', 14, 'up0000014@ac.upatras.gr', 'Βασίλειος', 'Φωτόπουλος', 'Σωτήρης', 2147483647, 2109412345, 'student'),
('up0000015', '$2y$10$8rW2Ps9jRgPCNstMUvh4zOBMFSyEm1Yl0O6CE5YcZ8oWXb10FYFVK', 15, 'up0000015@ac.upatras.gr', 'Χρήστος', 'Αντωνίου', 'Δημήτρης', 2147483647, 2109512345, 'student'),
('up0000016', '$2y$10$v5rVBlSehSwV/OI043Qu4.J1X38IVC/y8c0fpkQHK4kw7rkuePZKW', 16, 'up0000016@ac.upatras.gr', 'Νίκος', 'Πασχαλίδης', 'Αριστείδης', 2147483647, 2109612345, 'student'),
('up0000017', '$2y$10$lCzdJkCM5/vFtTuw1awknODX35EkGuS7YvGlVbN0QCW5hnCsCSvMi', 17, 'up0000017@ac.upatras.gr', 'Γιώργος', 'Κωνσταντίνου', 'Χρήστος', 2147483647, 2109712345, 'student'),
('up0000018', '$2y$10$cf2nTC0XrU1j.EB5j7tqcO7TMnNamsAmXhARH1Eq8wXzlJpFqQ3oG', 18, 'up0000018@ac.upatras.gr', 'Ελένη', 'Στεφανάκη', 'Παναγιώτης', 2147483647, 2109812345, 'student'),
('up0000019', '$2y$10$FEOjnc6H7NhfWLskSXd0we3Og5BNsFg6icZgMK.f85EppFZ43iXHq', 19, 'up0000019@ac.upatras.gr', 'Ανδρέας', 'Κατσούλης', 'Σπύρος', 2147483647, 2109912345, 'student'),
('up0000020', '$2y$10$q.NkHsCj3z5Ej1gtp8xbweV9Go/SnS.CldJyfcPlSpxgGuWpgExRS', 20, 'up0000020@ac.upatras.gr', 'Μαρία', 'Βαβούρης', 'Δημήτρης', 2147483647, 2109412345, 'student'),
('up0000021', '$2y$10$bWjU.92tu8o/IcRTLhojR.4az.p.ql/IeQF15TpBxxKEv146ptLOW', 21, 'up0000021@ac.upatras.gr', 'Παναγιώτης', 'Καραφωτιάς', 'Σταύρος', 2147483647, 2109512345, 'student'),
('up0000022', '$2y$10$TayJa3ieAuFQjRn/zupCTOTJOCgFRthFUQOxB7IGBcfxc7obiCzCa', 22, 'up0000022@ac.upatras.gr', 'Γιάννης', 'Κωστόπουλος', 'Γιώργος', 2147483647, 2109612345, 'student'),
('up0000023', '$2y$10$YIs38KF9CQ93EngpFb/Aye8ljqzDcS7yva0yMiQOYN0rigsQTcb4C', 23, 'up0000023@ac.upatras.gr', 'Φώτης', 'Κουτσογιάννης', 'Στέφανος', 2147483647, 2109712345, 'student'),
('up0000024', '$2y$10$4/9et1yp2drXskRITU/ZmODsV6R4qU0a/rDnomwvdmP0ZmZZvTpZe', 24, 'up0000024@ac.upatras.gr', 'Νίκος', 'Πιλάτος', 'Αριστείδης', 2147483647, 2109812345, 'student'),
('up0000025', '$2y$10$jLr3VkTb4Y1c/m0sRSmRo.r3G9f1XuM3LXhc6xmDkATg4NOgjpsUC', 25, 'up0000025@ac.upatras.gr', 'Χρήστος', 'Καλαφάτης', 'Στέφανος', 2147483647, 2109912345, 'student'),
('up0000026', '$2y$10$NwOIrVYjWGBuuEFjDKjq.ex0cVs9zmBuuuyK64bLYbUYBujy6n2nS', 26, 'up0000026@ac.upatras.gr', 'Νίκος', 'Τσολάκης', 'Δημήτρης', 2147483647, 2109912345, 'student'),
('up0000027', '$2y$10$X2eMrbJ6NQx9.Mvfs/IQtup0Z47gEfH7IxNCqLRlBYlT0ID3kJVN.', 27, 'up0000027@ac.upatras.gr', 'Δημήτρης', 'Φωτόπουλος', 'Αλέξανδρος', 2147483647, 2109512345, 'student'),
('up0000028', '$2y$10$2n1.xlXcqkIMBdBSlWLCre8N2c1fH8NRG1I1QTFqEdLh2b53P0F9y', 28, 'up0000028@ac.upatras.gr', 'Κωνσταντίνος', 'Αντωνόπουλος', 'Γεώργιος', 2147483647, 2109612345, 'student'),
('up0000029', '$2y$10$PIvJ3eJ/xwWw3hbiwyVm9eUcyFR1O8F73EcF8Jt9.CmZSm/J1V0WS', 29, 'up0000029@ac.upatras.gr', 'Γιώργος', 'Κοκκίνης', 'Νικόλαος', 2147483647, 2109712345, 'student'),
('up0000030', '$2y$10$eeht7HTGFUPUwMg7il.n5u/WgWlHbBCYo6wwpEMJhPi9dTNRBPC.i', 30, 'up0000030@ac.upatras.gr', 'Αντώνης', 'Μητσούλης', 'Σπύρος', 2147483647, 2109812345, 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `diplomatiki`
--
ALTER TABLE `diplomatiki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_diplomatiki_student` (`student`);

--
-- Indexes for table `diplomatiki_app`
--
ALTER TABLE `diplomatiki_app`
  ADD PRIMARY KEY (`diplomatiki`,`student`),
  ADD KEY `fk_diplomatiki_app_student` (`student`);

--
-- Indexes for table `epitroph`
--
ALTER TABLE `epitroph`
  ADD PRIMARY KEY (`diplomatiki`),
  ADD KEY `fk_comission_prof1` (`prof1`),
  ADD KEY `fk_comission_prof2` (`prof2`),
  ADD KEY `fk_comission_prof3` (`prof3`);

--
-- Indexes for table `epitroph_app`
--
ALTER TABLE `epitroph_app`
  ADD PRIMARY KEY (`diplomatiki`,`professor`),
  ADD KEY `fk_comission_app_professor` (`professor`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diplomatiki`
--
ALTER TABLE `diplomatiki`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diplomatiki`
--
ALTER TABLE `diplomatiki`
  ADD CONSTRAINT `fk_diplomatiki_student` FOREIGN KEY (`student`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diplomatiki_app`
--
ALTER TABLE `diplomatiki_app`
  ADD CONSTRAINT `fk_diplomatiki_app_diplomatiki` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_diplomatiki_app_student` FOREIGN KEY (`student`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `epitroph`
--
ALTER TABLE `epitroph`
  ADD CONSTRAINT `fk_comission_diplomatiki` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comission_prof1` FOREIGN KEY (`prof1`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comission_prof2` FOREIGN KEY (`prof2`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comission_prof3` FOREIGN KEY (`prof3`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `epitroph_app`
--
ALTER TABLE `epitroph_app`
  ADD CONSTRAINT `fk_comission_app_diplomatiki` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comission_app_professor` FOREIGN KEY (`professor`) REFERENCES `professor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `fk_evaluation_diplomatiki` FOREIGN KEY (`diplomatiki`) REFERENCES `diplomatiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `fk_professor_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
