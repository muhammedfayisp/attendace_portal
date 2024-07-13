-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql108.infinityfree.com
-- Generation Time: Jul 13, 2024 at 04:52 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_36775444_eattendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendancesheet`
--

CREATE TABLE `attendancesheet` (
  `studentId` varchar(255) NOT NULL,
  `courseCode` varchar(255) NOT NULL,
  `facultyId` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendancesheet`
--

INSERT INTO `attendancesheet` (`studentId`, `courseCode`, `facultyId`, `date`, `class`) VALUES
('TVE22AE037', 'ECT255', 'JIM', '2024-06-23 18:30:00', 'EC355'),
('TVE22AE039', 'ECT255', 'JIM', '2024-06-23 18:30:00', 'EC355'),
('TVE22AE038', 'ECT255', 'JIM', '2024-06-23 18:30:00', 'EC355'),
('TVE22AE037', 'ECT255', 'JIM', '2024-06-23 18:30:00', 'EC355'),
('TVE22AE039', 'ECT255', 'JIM', '2024-06-24 04:00:00', 'EC355'),
('TVE22AE038', 'ECT255', 'JIM', '2024-06-24 04:00:00', 'EC355'),
('TVE22AE037', 'ECT255', 'JIM', '2024-06-24 04:00:00', 'EC355'),
('TVE22AE039', 'ECT255', 'JIM', '2024-06-24 04:00:00', 'EC355'),
('TVE22AE038', 'ECT255', 'JIM', '2024-06-24 04:00:00', 'EC355'),
('TVE22AE037', 'ECT255', 'JIM', '2024-06-24 04:00:00', 'EC355'),
('TVE22AE039', 'ECT255', 'JIM', '2024-06-24 04:00:00', 'EC355'),
('TVE22AE038', 'ECT255', 'JIM', '2024-06-24 04:00:00', 'EC355'),
('TVE22AE037', 'ECT255', 'JIM', '2024-06-24 04:00:00', 'EC355'),
('TVE22AE039', 'ECT201', 'AK', '2024-06-22 00:10:25', 'ECT355'),
('TVE22AE039', 'ECT201', 'AK', '2024-06-20 00:12:37', 'EC355'),
('202104', 'Physiology 21', 'ANJ', '2024-06-20 05:00:00', '2021'),
('202104', 'Anatomy 21', 'NHD', '2024-06-20 05:00:00', '2021');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class` varchar(255) NOT NULL,
  `staffAdvisorId` varchar(255) NOT NULL,
  `className` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class`, `staffAdvisorId`, `className`) VALUES
('EC355', 'JIM', 'S4 AEI'),
('EC155', 'AK', 'S8 AEI'),
('EC355', 'JIM', 'S4 AEI'),
('EC355', 'JIM', 'S4 AEI'),
('EC355', 'JIM', 'S4 AEI'),
('EC355', 'JIM', 'S4 AEI'),
('EC355', 'JIM', 'S4 AEI'),
('Anatomy', 'AA', 'Anatomy'),
('2021', 'NHD', 'Anatomy 21'),
('2021', 'ANJ', 'Physiology 21'),
('2021', 'IRS', 'Biochemistry 21');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseId` varchar(255) NOT NULL,
  `courseName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseId`, `courseName`) VALUES
('ECT255', 'LCD'),
('ECT201', 'SSD'),
('ECT203', 'NETWORK THEORY');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `facultyId` varchar(255) NOT NULL,
  `facultyName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `courses` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`facultyId`, `facultyName`, `password`, `courses`) VALUES
('JIM', 'Joaquim Iganatius Monteiro', '$2y$10$iDZPAhhvq4SKQHk9rYjG7ePKDFsZs0n/BRHUPzVLXOg0kbUrNhcMS', 'ECT205'),
('AK', 'Ammukkutty', '$2y$10$3OaDYUbt7Gg2L5MCity7fuAsEASdUtYJ94hi.hhjG80K/eGJTi/jy', 'AET202'),
('NHD', 'Naheed', '$2y$10$RqXG.JWa26kjDmqlZzqss.CyeDL3apJUowPstrwdx9wb1Hd7BanDm', 'Anatomy 21'),
('ANJ', 'Anjali', '$2y$10$Vahkw05cy0VKg0KJfV6Niu2W2JuPuUSybdusgkuaYWcWGe.EqrXVK', 'Physiology 21'),
('IRS', 'Irshad', '$2y$10$fsq/94cgk1nAwvxmRG9yieTORt2oLmik/i3mv9Hay.8NdpAnI4sWy', 'Biochemistry 21');

-- --------------------------------------------------------

--
-- Table structure for table `facultyattendance`
--

CREATE TABLE `facultyattendance` (
  `facultyId` varchar(255) NOT NULL,
  `courseCode` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `facultyattendance`
--

INSERT INTO `facultyattendance` (`facultyId`, `courseCode`, `class`, `date`) VALUES
('JIM', 'ECT255', 'EC355', '2024-06-23 18:30:00'),
('JIM', 'ECT255', 'EC355', '2024-06-23 18:30:00'),
('JIM', 'ECT255', 'EC355', '2024-06-23 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentId` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `allottedCourses` varchar(255) NOT NULL,
  `studentName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `totalavailableclasses` int(11) NOT NULL DEFAULT 0,
  `attendedclasses` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentId`, `class`, `allottedCourses`, `studentName`, `password`, `totalavailableclasses`, `attendedclasses`) VALUES
('TVE22AE039', 'EC355', 'ECT255,ECT201', 'SHADIN', '$2y$10$sw/1WS3CK.XjWjeesBJdv.E2N8TzQrqy7Ae6FhCk2QUMtY8RSoN5O', 4, 4),
('TVE22AE038', 'EC355', 'ECT255', 'BINSHAD', '$2y$10$8jcBlohWA9yriDa9RV7x0OMd6GZybvWZ20HJBbtcd6oxLiNxbRGK2', 4, 4),
('TVE22AE037', 'EC355', 'ECT255', 'RASHMIKA', '$2y$10$3TAAghM4/kmdTYEFqDRyTuZWlX7DBUPP3JzBJH6UOxcPAp2tUgZLO', 6, 6),
('TVE20AE050', 'EC155', 'AET402', 'PRANAV', '$2y$10$5oLfbmmHiWWQmIDiF74yGuMM9u5zCTqXN3UD6MbJJUMnnkxlVIUqy', 0, 0),
('202121', '2021', 'Anatomy 21, Physiology 21', 'Sharvan', '$2y$10$gzIBc0VeimxXGXvsHn28wuPKTS0TL9LUhDnOrAvaCEgiqSz.4i9Lq', 0, 0),
('202101', '2021', 'Anatomy 21', 'Basith', '$2y$10$vs8E9JFUBB3cEaLneYk21uqIUFEaI//x1NpCuo.1oZSaPyc8IsXxq', 0, 0),
('202104', '2021', 'Anatomy 21, Biochemistry 21, Physiology 21', 'Irfan', '$2y$10$A/XoPUzEJH6beT9t74LW8OuFie1Fxyb4Zn6PH75PZ0oJ3C2wYpive', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `superusers`
--

CREATE TABLE `superusers` (
  `superuser_name` varchar(255) NOT NULL,
  `superuser_password` varchar(255) NOT NULL,
  `superuser_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `superusers`
--

INSERT INTO `superusers` (`superuser_name`, `superuser_password`, `superuser_id`) VALUES
('Suhail', '$2y$10$HbVKOAttHme1awdx9wECHO5e5a74.fMMSRimMuz70vf/voAg0RgfO', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
