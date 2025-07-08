-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 07, 2025 at 11:30 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `prueba_tecnica`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_topics`
--

CREATE TABLE `course_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `publication_date` date NOT NULL,
  `is_mandatory` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_topics`
--

INSERT INTO `course_topics` (`id`, `name`, `description`, `publication_date`, `is_mandatory`, `created_at`, `updated_at`) VALUES
(1, 'Introduction to Programming', 'Covers fundamental programming concepts and logic building.', '2023-01-15', 1, '2025-07-07 23:30:00', '2025-07-07 23:30:00'),
(2, 'Data Structures', 'Explains arrays, linked lists, stacks, queues, and trees.', '2023-02-01', 1, '2025-07-07 23:30:00', '2025-07-07 23:30:00'),
(3, 'Web Development Basics', 'Introduction to HTML, CSS, and basic JavaScript.', '2023-03-10', 0, '2025-07-07 23:30:00', '2025-07-07 23:30:00'),
(4, 'Software Testing Fundamentals', 'Overview of unit testing, integration testing, and QA processes.', '2023-04-05', 0, '2025-07-07 23:30:00', '2025-07-07 23:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_topics`
--
ALTER TABLE `course_topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_topics_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_topics`
--
ALTER TABLE `course_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

COMMIT; 