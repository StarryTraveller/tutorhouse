-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2023 at 07:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutordb`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `subject` varchar(100) NOT NULL,
  `level` varchar(10) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `title`, `description`, `subject`, `level`, `file_path`, `teacher_id`, `created_at`) VALUES
(7, 'Activity 1', 'Place Values Hundreds', 'Mathematics', 'Grade 2', '../files/CS333LESSON8.pptx', 0, '2023-07-31 10:17:36'),
(8, 'Activity 2', 'Place Values', 'Mathematics', 'Grade 2', '../../files/LMS-System Documentation.docx', 0, '2023-07-31 10:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `actsubmit`
--

CREATE TABLE `actsubmit` (
  `id` int(11) NOT NULL,
  `activityid` int(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `level` varchar(50) NOT NULL,
  `studname` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` varchar(10) NOT NULL,
  `acaverage` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `actsubmit`
--

INSERT INTO `actsubmit` (`id`, `activityid`, `name`, `subject`, `level`, `studname`, `file_path`, `created_at`, `remarks`, `acaverage`) VALUES
(2, 6, 'Activity 1', 'Filipino', 'Grade 2', '0', '../../submit/FORMAT (1).docx', '2023-08-01 13:35:21', 'C', ''),
(3, 6, 'Activity 1', 'Filipino', 'Grade 2', 'Garino', '../../submit/LMS-System Documentation.docx', '2023-08-01 13:57:57', 'C', ''),
(4, 6, 'Activity 1', 'Filipino', 'Grade 2', 'Garino', '../../submit/FORMAT (1).docx', '2023-08-01 13:58:04', 'F', ''),
(5, 7, 'Activity 2', 'Mathematics', 'Grade 2', 'Garino', '../../submit/Presented-by-GROUP-3.pdf', '2023-08-03 12:33:08', 'C', ''),
(6, 7, 'Activity 1', 'Mathematics', 'Grade 2', 'Garino', '../../submit/EMERGINGTECHNOLOGIES.pptx', '2023-08-03 17:02:02', 'B', '');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(6, 'Welcome!', 'Mabuhay! Thank you for choosing Tutor House Inc. for your little ones. Rest assured that we offer quality tutoring sessions, now even virtually. We offer you our very own Learning Management System.\r\n\r\nWe are beyond grateful for your decision to join us and embark to your child\'s journey towards academic progression!\r\n\r\nSee you!', '2023-07-31 09:15:49', '2023-07-31 09:15:49'),
(7, 'General Meeting for First Month', 'Greetings!\r\nWe would like to invite you to our very first virtual meeting, to discuss the institutions\' values, rules, and platforms this coming August 21, 2023. Attendance is a must, especially for our first timer tutees.\r\n\r\nSee you!', '2023-07-31 09:37:32', '2023-07-31 09:37:32');

-- --------------------------------------------------------

--
-- Table structure for table `assess`
--

CREATE TABLE `assess` (
  `id` int(10) NOT NULL,
  `studentid` int(10) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `initial` varchar(255) NOT NULL,
  `act` varchar(10) NOT NULL,
  `ass` varchar(10) NOT NULL,
  `ave` varchar(10) NOT NULL,
  `final` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assess`
--

INSERT INTO `assess` (`id`, `studentid`, `lastname`, `subject`, `initial`, `act`, `ass`, `ave`, `final`, `status`) VALUES
(1, 15, 'Garino', '', '', '', '', '', '', ''),
(52, 0, 'Garino', 'Mathematics', 'B', '3', '3', '3', 'B', 'Pass'),
(53, 0, 'Garino', 'English', 'Ungraded', '0', '0', '0', 'Ungraded', 'Pass');

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `subject` varchar(100) NOT NULL,
  `level` varchar(10) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`id`, `title`, `description`, `subject`, `level`, `file_path`, `teacher_id`, `created_at`) VALUES
(2, 'Assessment 1', 'First Monthly Assessment', 'Mathematics', 'Grade 2', '../files/MOCKJOBINTERVIEWGUIDELINESANDRUBRIC.docx', 0, '2023-07-31 08:05:13');

-- --------------------------------------------------------

--
-- Table structure for table `assesssubmit`
--

CREATE TABLE `assesssubmit` (
  `id` int(11) NOT NULL,
  `assessid` int(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `level` varchar(50) NOT NULL,
  `studname` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(10) NOT NULL,
  `asaverage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assesssubmit`
--

INSERT INTO `assesssubmit` (`id`, `assessid`, `name`, `subject`, `level`, `studname`, `file_path`, `created_at`, `remarks`, `asaverage`) VALUES
(1, 0, '', '', '', '', '../../submit/MOCKJOBINTERVIEWGUIDELINESANDRUBRIC.pdf', '2023-08-01 12:21:25', '', 0),
(2, 2, 'Assessment 1', 'Mathematics', 'Grade 2', 'Garino', '../../submit/FORMAT (1).docx', '2023-08-01 12:53:47', 'C', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `description`, `name`, `subject`, `content`, `created_at`, `updated_at`) VALUES
(6, '', 'Garino', 'Mathematics', 'Bad', '2023-08-02 11:06:05', '2023-08-02 11:10:39'),
(7, '', 'Garino', 'Mathematics', 'Can count 1-20 now. Keep practicing at home.', '2023-08-02 11:11:04', '2023-08-02 11:11:04'),
(8, '', 'Garino', 'Reading', 'Diction is progressing, as well as the proper pronunciation. However, still needs more practice.', '2023-08-02 11:14:52', '2023-08-02 11:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `subject` varchar(100) NOT NULL,
  `level` varchar(10) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `description`, `subject`, `level`, `file_path`, `teacher_id`, `created_at`) VALUES
(3, 'Lesson 1', 'Ponema', 'Filipino', 'Grade 4', '../files/PRELIM_HANDOUT2.pdf', 0, '2023-07-31 08:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(5) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `email`, `password`, `type`, `level`) VALUES
(1, 'den.poblador0@gmail.com', '$2y$10$.9lEyan2Gc/fX6yVtaZ3L.rhy6DQTj9dc7MNZCNGctgAMvBgkCtda', 'admin', ''),
(2, 'dmacapagal@gmail.com', '$2y$10$ZB0Cj2uafgtjhFE1qtL07.Dkb2mRUuYKoCp86SjwwNVNnTOB38gsW', 'teacher', ''),
(3, 'denwhiz@gmail.com', '$2y$10$AiXsmaBRZDMY92BxyKj4Q.9AvgUvMk5Zg3V5zvpjdT68WjhOZTOKK', 'student', ''),
(18, 'garinobrix@gmail.com', '$2y$10$1koRGCNTB90M0lU1ZjxuQOTnagY3fI8FWLPojeRi9MraKo7QbBR8i', 'student', 'Grade 2'),
(20, 'anton_chi@gmail.com', '$2y$10$vHYUsGN1pXHBt3dZLgSbXe8H6MSvZe1D1x2O/caGsXgq3VjqXSthG', 'teacher', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudentinfo`
--

CREATE TABLE `tblstudentinfo` (
  `id` int(10) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `birthdate` varchar(255) NOT NULL,
  `age` int(10) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `parentname` varchar(255) NOT NULL,
  `parentaddress` varchar(255) NOT NULL,
  `parentnumber` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstudentinfo`
--

INSERT INTO `tblstudentinfo` (`id`, `lastname`, `firstname`, `middlename`, `suffix`, `address`, `barangay`, `city`, `email`, `phone`, `birthdate`, `age`, `gender`, `school`, `level`, `parentname`, `parentaddress`, `parentnumber`, `password`) VALUES
(15, 'Garino', 'Brix', 'Casintahan', 'Jr', 'Block 1 Lot 21 Villa Tagumpay', 'Halang', 'Calamba', 'garinobrix@gmail.com', '09265342612', '2017-02-07', 6, 'Male', 'LCBA', 'Grade 2', 'Larry Garino', 'Block 1 Lot 21 Villa Tagumpay, Halang, Calamba', '09265342612', '$2y$10$1koRGCNTB90M0lU1ZjxuQOTnagY3fI8FWLPojeRi9MraKo7QbBR8i');

-- --------------------------------------------------------

--
-- Table structure for table `tblteacherinfo`
--

CREATE TABLE `tblteacherinfo` (
  `id` int(10) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `suffix` varchar(10) NOT NULL,
  `address` int(75) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `email` varchar(15) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `birthdate` varchar(50) NOT NULL,
  `age` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblteacherinfo`
--

INSERT INTO `tblteacherinfo` (`id`, `lastname`, `firstname`, `middlename`, `suffix`, `address`, `barangay`, `city`, `email`, `phone`, `birthdate`, `age`, `gender`, `password`) VALUES
(1, 'Chigurh', 'Anton', 'Smith', 'II', 21, 'Parian', 'Calamba', 'anton_chi@gmail', '09627837266', '1995-11-11', 27, 'Male', '$2y$10$vHYUsGN1pXHBt3dZLgSbXe8H6MSvZe1D1x2O/caGsXgq3VjqXSthG');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `email`, `name`, `remarks`) VALUES
(1, 'garinobrix@gmail.com', 'Brix Garino', 'Resolved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `actsubmit`
--
ALTER TABLE `actsubmit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assess`
--
ALTER TABLE `assess`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assesssubmit`
--
ALTER TABLE `assesssubmit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstudentinfo`
--
ALTER TABLE `tblstudentinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblteacherinfo`
--
ALTER TABLE `tblteacherinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `actsubmit`
--
ALTER TABLE `actsubmit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `assess`
--
ALTER TABLE `assess`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assesssubmit`
--
ALTER TABLE `assesssubmit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblstudentinfo`
--
ALTER TABLE `tblstudentinfo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblteacherinfo`
--
ALTER TABLE `tblteacherinfo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
