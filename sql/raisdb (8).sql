-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2025 at 10:41 AM
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
-- Database: `raisdb`
--
CREATE DATABASE IF NOT EXISTS `raisdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `raisdb`;

-- --------------------------------------------------------

--
-- Table structure for table `about_cards`
--

CREATE TABLE `about_cards` (
  `id` int(11) NOT NULL,
  `tab_title` varchar(255) NOT NULL,
  `card_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_cards`
--

INSERT INTO `about_cards` (`id`, `tab_title`, `card_title`, `content`, `sort_order`) VALUES
(1, 'one', 'mission', 'this is mission', 0),
(2, 'two', 'vision', 'this is vision ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `about_content_blocks`
--

CREATE TABLE `about_content_blocks` (
  `id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `content` text DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `media_type` varchar(10) DEFAULT 'image',
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_content_blocks`
--

INSERT INTO `about_content_blocks` (`id`, `type`, `content`, `media_path`, `media_type`, `sort_order`) VALUES
(1, 'text', 'to learn more about usafad;lj', NULL, 'image', 0);

-- --------------------------------------------------------

--
-- Table structure for table `about_main`
--

CREATE TABLE `about_main` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `media_type` varchar(10) DEFAULT 'image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_main`
--

INSERT INTO `about_main` (`id`, `title`, `description`, `media_path`, `media_type`) VALUES
(1, 'About Roman & Associates Immigration Services ', 'We are a licensed Canadian immigration firm based in Vancouver Island BC, providing expert advice on visas, permits, and sponsorships to help people achieve a brighter future in Canada.', 'uploads/about/1757296952_about_vid.mp4', 'video');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `hero_media_path` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `map_title` varchar(255) DEFAULT NULL,
  `map_summary` varchar(255) DEFAULT NULL,
  `map_address` text DEFAULT NULL,
  `map_latitude` decimal(10,8) DEFAULT NULL,
  `map_longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `summary`, `author`, `publish_date`, `hero_media_path`, `file_path`, `map_title`, `map_summary`, `map_address`, `map_latitude`, `map_longitude`) VALUES
(1, 'Ulgo Shipji Anha', 'Gwenchana', 'By Seventeen', '2025-09-08', 'uploads/blog/68be6726f0798-ieltsHero.png', 'blog/ulgo-shipji-anha.php', 'Calamba', 'This is the latest event', 'San Pedro, Santo tomas, Batangas', 14.08511300, 121.17705570);

-- --------------------------------------------------------

--
-- Table structure for table `blog_sections`
--

CREATE TABLE `blog_sections` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_sections`
--

INSERT INTO `blog_sections` (`id`, `blog_id`, `title`, `content`, `media_path`, `display_order`) VALUES
(9, 1, 'Okay po', 'Hello this is real this is me', 'uploads/blog/68be6726f1ad8-fam.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL COMMENT 'User ID from users table, or 0 for Admin',
  `receiver_id` int(11) NOT NULL COMMENT 'User ID from users table, or 0 for Admin',
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_archived_by_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`, `is_read`, `is_archived_by_admin`) VALUES
(1, 11, 0, 'gege', '2025-09-09 05:51:51', 0, 0),
(2, 0, 11, 'ok', '2025-09-09 05:52:02', 0, 0),
(3, 11, 0, 'fasfas', '2025-09-09 05:59:49', 0, 0),
(4, 11, 0, 'gasgasg', '2025-09-09 05:59:50', 0, 0),
(5, 11, 0, 'asgasg', '2025-09-09 05:59:50', 0, 0),
(6, 6, 0, 'Hello', '2025-09-09 07:13:10', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `client_applications`
--

CREATE TABLE `client_applications` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `interestPathway` text NOT NULL,
  `findUs` text NOT NULL,
  `facebookLink` varchar(255) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending Review','Approved','Cancelled') NOT NULL DEFAULT 'Pending Review'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_applications`
--

INSERT INTO `client_applications` (`id`, `email`, `fullName`, `phone`, `address`, `interestPathway`, `findUs`, `facebookLink`, `submission_date`, `status`) VALUES
(1, 'akizashibal@gmail.com', 'Higashikata, Josuke, D', '09359306521', 'Darasa', 'Student Pathway', 'Tiktok', 'https://www.facebook.com/chaepi04', '2025-09-03 03:38:36', 'Pending Review'),
(2, 'godoyjp443@gmail.com', 'Godoy, Jp, D', '09359306521', 'Tanauan City Batangas', 'Tourist/ Visitor Visa, Home & Inst-Caregiver Services Profile Creation', 'Instagram', 'https://www.facebook.com/chaepi04', '2025-09-03 03:39:32', 'Pending Review'),
(3, 'kimchae1chi@gmail.com', 'Kim, Chaewon, D', '09359306521', 'Darasa, Tanauan City Batangas', 'Tourist/ Visitor Visa, Family Sponsorship', 'Tiktok, Instagram', 'https://www.facebook.com/chaepi04', '2025-09-03 04:08:05', 'Pending Review');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `consultation_date` date NOT NULL,
  `consultation_time` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `user_id`, `consultation_date`, `consultation_time`, `notes`, `facebook_link`, `status`) VALUES
(1, 11, '2025-09-10', '11:00 AM', '', NULL, 'Approved'),
(2, 11, '2025-09-11', '2:00 PM', '', NULL, 'Cancelled'),
(3, 11, '2025-09-04', '2:00 PM', '', 'https://www.facebook.com/chaepi04', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','cancelled') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `hero_media_path` varchar(255) DEFAULT NULL,
  `about_content` text DEFAULT NULL,
  `about_media_path` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_choice_cards`
--

CREATE TABLE `exam_choice_cards` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_faqs`
--

CREATE TABLE `exam_faqs` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_formats`
--

CREATE TABLE `exam_formats` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `icon_class` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_infocards`
--

CREATE TABLE `exam_infocards` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `departure_date` date NOT NULL,
  `departureLocation` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `user_id`, `departure_date`, `departureLocation`, `destination`, `booking_date`) VALUES
(1, 11, '2025-10-02', 'Manila', 'Canada', '2025-09-03 07:50:28'),
(2, 11, '2025-09-27', 'dad', 'dasdasd', '2025-09-03 08:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `hero_media`
--

CREATE TABLE `hero_media` (
  `id` int(11) NOT NULL,
  `media_name` varchar(255) NOT NULL,
  `uploader` varchar(255) NOT NULL,
  `upload_date` datetime NOT NULL DEFAULT current_timestamp(),
  `file_path` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_media`
--

INSERT INTO `hero_media` (`id`, `media_name`, `uploader`, `upload_date`, `file_path`, `is_active`) VALUES
(1, 'Trial', 'me', '2025-09-04 12:30:50', 'uploads/hero/hero_68b915fa451cf3.70130649.mp4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'general',
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `type`, `link`, `is_read`, `created_at`) VALUES
(1, 11, 'Your consultation scheduled for September 10, 2025 has been Approved.', 'consultation_status', NULL, 0, '2025-09-03 08:44:28'),
(2, 11, 'Your consultation scheduled for September 11, 2025 has been Cancelled.', 'consultation_status', NULL, 0, '2025-09-03 08:49:29'),
(3, 11, 'Your consultation for September 4, 2025 has been submitted and is now pending review.', 'consultation_status', NULL, 0, '2025-09-03 08:49:47'),
(4, 6, 'Your document \'Jp weekly accomplishments report.pdf\' has been Approved.', 'document_approved', 'documents.php', 0, '2025-09-09 07:57:13');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `hero_media_path` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `hero_media_path`, `file_path`, `created_at`) VALUES
(7, 'Visa Permit', 'A tourist visa lets individuals visit a country for leisure or family visits, typically requiring a valid passport, financial proof, and return tickets. It does not permit work during the stay.', 'uploads/service/68be3b678a482-Fvisit.jpg', 'services/visa-permit.php', '2025-09-04 12:03:36'),
(8, 'Study Permit', 'Hello this is the file', 'uploads/service/68be359bef4b1-1757296027.png', 'services/study-permit.php', '2025-09-08 01:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `service_sections`
--

CREATE TABLE `service_sections` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_sections`
--

INSERT INTO `service_sections` (`id`, `service_id`, `title`, `content`, `media_path`, `display_order`) VALUES
(19, 7, 'About', 'asdfhvkclxcx', '', 0),
(21, 8, 'About', 'asdfhjkl', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `statement_of_account`
--

CREATE TABLE `statement_of_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `charges` decimal(10,2) DEFAULT NULL,
  `payments` decimal(10,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profileImage` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `gmail` varchar(255) DEFAULT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `documents_uploaded` tinyint(1) NOT NULL DEFAULT 0,
  `profile_picture_uploaded` tinyint(1) NOT NULL DEFAULT 0,
  `birthday_added` tinyint(1) NOT NULL DEFAULT 0,
  `social_links_added` tinyint(1) NOT NULL DEFAULT 0,
  `has_seen_tour` tinyint(1) NOT NULL DEFAULT 0,
  `role` varchar(50) NOT NULL DEFAULT 'client',
  `status` varchar(50) NOT NULL DEFAULT 'Inactive',
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `address`, `phone`, `email`, `password`, `profileImage`, `location`, `birthday`, `facebook`, `instagram`, `gmail`, `email_notifications`, `dark_mode`, `documents_uploaded`, `profile_picture_uploaded`, `birthday_added`, `social_links_added`, `has_seen_tour`, `role`, `status`, `last_login`, `last_activity`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'John Paul', 'Godoy', 'Darasa, Tanauan City Batangas', '09359306521', 'godoyjp443@gmail.com', '$2y$10$LxDGp8XROe201KZCttcLSOUlAqajOp5/TqhlZk89ReZwLbMjpzFf.', 'uploads/68b15e9bb7f37-cha.jpg', NULL, '2005-02-04', 'https://www.facebook.com/chaepi04', '', '', 1, 1, 0, 1, 1, 1, 1, 'client', 'Inactive', NULL, '2025-09-01 15:54:57', 'a076d34d7b4910555d046e2bcb80ac4ffc78a8d43e8f6ff4634ba8aa97138ee4', '2025-09-03 05:58:06'),
(2, 'Kim', 'Chaewon', 'Darasa, Tanauan City Batangas', '09359306521', 'kimchae1chi@gmail.com', '$2y$10$YzarQtmz8o0nxRxl5vASierqYIj5.pGSSZ1yNhkgHQ/2gnW4N9vqC', 'uploads/68aea7cdd0f67-cha.jpg', NULL, '2005-08-18', 'https://www.facebook.com/chaepi04', '', 'godoyjp443@gmail.com', 1, 0, 0, 1, 1, 1, 1, 'client', 'Inactive', NULL, '2025-08-28 16:12:19', NULL, NULL),
(3, 'Kim', 'Yooyeon', 'Darasa', '09359306521', 'jp04@gmail.com', '$2y$10$hCC3xNl8HBw99lN/6gi5Z.etwr0OC79hXywGdIC5nrq2BfR6m3NQm', 'uploads/68ae93c2840bb-chaewon.jpg', NULL, '2005-02-04', 'https://www.facebook.com/chaepi04', '', '', 1, 1, 0, 1, 1, 1, 1, 'client', 'Inactive', NULL, NULL, NULL, NULL),
(4, 'Jisoo', 'Hong', 'San Pedro, Santo Tomas, Batangas', '09618225084', 'hongjisoo@gmail.com', '$2y$10$JdXfhvws62So9kLTaB5Q7uyznoRFIbsVKdawmKKGea44eZZlTMUGu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 1, 'client', 'Inactive', NULL, '2025-08-28 16:53:00', NULL, NULL),
(5, 'Matthew', 'Hernandez', 'San Pedro, Santo Tomas, Batangas', '09067664653', 'matthewehernandez0712@gmail.com', '$2y$10$zP6A5R8G.vX7qY.tK.eM4u.iB/n3o.aD/cK/sS/fG/hJ/l', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 1, 'Super Admin', 'Inactive', NULL, '2025-08-28 16:03:28', NULL, NULL),
(6, 'Aespa', 'Karina', 'Darasa', '09359306521', 'jjampi72@gmail.com', '$2y$10$dhwlIzGxPVzEkqOSN2TIY.2Qg5Yk9ZqZs/GuFru9TAEqM1pHJ6huK', 'uploads/68b554ed4465f-karina.jpg', NULL, '2005-02-04', 'https://www.facebook.com/chaepi04', 'https://www.facebook.com/chaepi04', 'godoyjp443@gmail.com', 1, 0, 0, 1, 1, 1, 1, 'client', 'Inactive', NULL, NULL, NULL, NULL),
(7, 'Kim', 'Minjeong', 'Darasa', '09359306521', 'tzuyoda28@gmail.com', '$2y$10$tQcjHW5jI2bHHeGGOnLlQu8FXeOeCV9OdLzMcEjecfPmb/YwvVz7S', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 1, 'client', 'Inactive', NULL, NULL, '84af595f8ecd300d186dd864ee0168a33a4d2e1c55de607801ee64f5a6cff69d', '2025-09-03 05:56:50'),
(8, 'Josuke', 'Higashikata', 'Darasa', '09359306521', 'akizashibal@gmail.com', '$2y$10$XlySF0CzDJqAtqCx6IU2Tu30xcZLbxAQkOo1TTYm0ZxWLsgP4QMcm', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 1, 'client', 'Inactive', NULL, NULL, NULL, NULL),
(10, 'Kim', 'Chaewon', '123 Admin Lane', '09000000000', 'aimiyuji180@gmail.com', '$2y$10$nZ8W.X7V.y6U.z5T.a4S.b3R.c2Q.d1P.e0O.f9N.g8M.h7L', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 1, 'Super Admin', 'Active', NULL, NULL, NULL, NULL),
(11, 'Jessica ', 'Sotto', 'Darasa', '09359306521', 'jessica@gmail.com', '$2y$10$RkkQMzIgZhwQLWXYLh6yeubpeeLzPE/dBZr6rE1ZCU.0aCLh8IViK', 'uploads/68b7eaa2dcf40-8e0bab69-56d5-4a7b-a7cd-78e25b8da0ef.jpg', NULL, '2025-09-26', 'https://www.facebook.com/chaepi04', 'https://www.facebook.com/chaepi04', 'godoyjp443@gmail.com', 1, 0, 0, 1, 1, 1, 1, 'client', 'Inactive', NULL, '2025-09-09 15:12:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_documents`
--

INSERT INTO `user_documents` (`id`, `user_id`, `file_name`, `file_path`, `upload_date`, `status`) VALUES
(1, 2, 'cha.jpg', '../uploads/68ae9150f3ca9-cha.jpg', '2025-08-27 05:02:09', 'pending'),
(2, 3, 'afs.webp', '../uploads/68ae96a5e3c80-afs.webp', '2025-08-27 05:24:53', 'pending'),
(3, 3, 'chae.webp', '../uploads/68ae96a5e57d6-chae.webp', '2025-08-27 05:24:53', 'pending'),
(4, 6, 'karina.jpg', '../uploads/68b6583663021-karina.jpg', '2025-09-02 02:36:38', 'pending'),
(8, 6, 'Jp weekly accomplishments report.pdf', 'uploads/68b6905b1c6f7-Jpweeklyaccomplishmentsreport.pdf', '2025-09-02 06:36:11', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `v_chat_with_names`
--

CREATE TABLE `v_chat_with_names` (
  `message_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sender_id` int(11) DEFAULT NULL,
  `sender_firstName` varchar(50) DEFAULT NULL,
  `sender_lastName` varchar(50) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_cards`
--
ALTER TABLE `about_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_content_blocks`
--
ALTER TABLE `about_content_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_main`
--
ALTER TABLE `about_main`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_sections`
--
ALTER TABLE `blog_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `client_applications`
--
ALTER TABLE `client_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_choice_cards`
--
ALTER TABLE `exam_choice_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_faqs`
--
ALTER TABLE `exam_faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_formats`
--
ALTER TABLE `exam_formats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_infocards`
--
ALTER TABLE `exam_infocards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hero_media`
--
ALTER TABLE `hero_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_sections`
--
ALTER TABLE `service_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `statement_of_account`
--
ALTER TABLE `statement_of_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_cards`
--
ALTER TABLE `about_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `about_content_blocks`
--
ALTER TABLE `about_content_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `about_main`
--
ALTER TABLE `about_main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_sections`
--
ALTER TABLE `blog_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `client_applications`
--
ALTER TABLE `client_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_choice_cards`
--
ALTER TABLE `exam_choice_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_faqs`
--
ALTER TABLE `exam_faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_formats`
--
ALTER TABLE `exam_formats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_infocards`
--
ALTER TABLE `exam_infocards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hero_media`
--
ALTER TABLE `hero_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_sections`
--
ALTER TABLE `service_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `statement_of_account`
--
ALTER TABLE `statement_of_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_sections`
--
ALTER TABLE `blog_sections`
  ADD CONSTRAINT `blog_sections_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_choice_cards`
--
ALTER TABLE `exam_choice_cards`
  ADD CONSTRAINT `exam_choice_cards_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_faqs`
--
ALTER TABLE `exam_faqs`
  ADD CONSTRAINT `exam_faqs_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_formats`
--
ALTER TABLE `exam_formats`
  ADD CONSTRAINT `exam_formats_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_infocards`
--
ALTER TABLE `exam_infocards`
  ADD CONSTRAINT `exam_infocards_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_sections`
--
ALTER TABLE `service_sections`
  ADD CONSTRAINT `service_sections_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `statement_of_account`
--
ALTER TABLE `statement_of_account`
  ADD CONSTRAINT `statement_of_account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `user_documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
