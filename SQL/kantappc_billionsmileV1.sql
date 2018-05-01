-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2018 at 07:16 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kantappc_billionsmile`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(1000) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `faculties_id` int(11) NOT NULL,
  `students_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `name`, `details`, `completed`, `faculties_id`, `students_id`) VALUES
(1, 'SQL Injection', 'Get some notes about SQL Injection', 0, 1, 3),
(2, 'DBMS', 'Discuss all type of joins', 0, 1, 1),
(3, 'Business Management', 'Discuss role of IT in HRM', 1, 1, 2),
(4, 'C++', 'Create a simple login app using c++', 0, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `billionsmile_user`
--

CREATE TABLE `billionsmile_user` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `image_url` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billionsmile_user`
--

INSERT INTO `billionsmile_user` (`id`, `full_name`, `gender`, `dob`, `image_url`, `email`, `password`, `token`) VALUES
(1, 'Arvind', 'male', '1992-11-13', '/img/male.png', 'kaantaa1311@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'b835dd41f450b27fe6d28ed93afdb76e'),
(2, 'Arvind', 'male', '1992-11-13', '/img/male.png', 'k1aantaa1311@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '91c16cbba5ed511889190bd12372057d'),
(3, 'Arvind', 'male', '1992-11-13', '/img/profile/profile_162fa85066caf4715b55ae628db862f1.png', 'kanta1311@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '162fa85066caf4715b55ae628db862f1');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `api_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `username`, `password`, `subject`, `api_key`) VALUES
(1, 'Ritesh Kumar', 'ritesh', '81dc9bdb52d04dc20036dbd8313ed055', 'DBMS', '0c81c1be0741a08d857f55e2dd0268b6');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `api_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `username`, `password`, `api_key`) VALUES
(1, 'belal', 'belal', '81dc9bdb52d04dc20036dbd8313ed055', '50addfeb14283e2568ca98e2a8ecf7f6'),
(2, 'Belal Khan', 'probelalkhan', '81dc9bdb52d04dc20036dbd8313ed055', '589d3d5ad22808e7cb54fd1ee2affd3c'),
(3, 'Vivek Raj', 'vivek', 'e2fc714c4727ee9395f324cd2e7f331f', '2d092996274be2edf7a0771ba427e134'),
(4, 'Arvind Kant', 'kanta1311', 'e10adc3949ba59abbe56e057f20f883e', '1a308289b049a8e5e79e3c24ac783ac8');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignments_faculties` (`faculties_id`),
  ADD KEY `assignments_students` (`students_id`);

--
-- Indexes for table `billionsmile_user`
--
ALTER TABLE `billionsmile_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `billionsmile_user`
--
ALTER TABLE `billionsmile_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_faculties` FOREIGN KEY (`faculties_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `assignments_students` FOREIGN KEY (`students_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
