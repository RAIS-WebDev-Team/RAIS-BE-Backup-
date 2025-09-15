-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 09:34 PM
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
(17, 'Mission', 'Mission Statement', 'To provide honest, transparent, and expert Canadian immigration consulting services, empowering individuals and families worldwide to achieve better opportunities and a brighter future in Canada.', 0),
(18, 'Vision', 'Vision Statement', 'To be a trusted global leader in Canadian immigration consultancy—known for our integrity, personalized service, and commitment to helping clients successfully build a new life in Canada.', 1),
(19, 'Objectives', 'Company Objectives', '• Deliver Expert Guidance: Continuously provide up-to-date, professional immigration advice on Canadian visas including study permits, work permits, visit visas, and family sponsorships.\n• Uphold Integrity and Transparency: Maintain 100% honesty in all client interactions, fostering long-term trust and confidence in our services.\n• Stay Informed and Compliant: Attend regular industry seminars, training, and regulatory updates to ensure compliance with the latest Canadian immigration laws and policies.\n• Expand Global Reach: Serve clients not only across Canada (except Quebec) but also in Asia, the Middle East, and beyond, helping more individuals access life-changing opportunities.\n• Enhance Client Support: Offer personalized, compassionate support that motivates and encourages clients throughout their immigration journey.\n• Ensure Affordable Excellence: Provide high-quality services at reasonable fees, reflecting the care, diligence, and dedication poured into every application.\n• Promote Responsible Immigration: Actively contribute to Canada’s values by supporting qualified, deserving applicants and helping them integrate successfully into Canadian society.', 2),
(20, 'Background', 'Company Background', 'Roman Canadian Immigration Services is a licensed Canadian immigration consultancy firm founded on December 1, 2016, and proudly based on Vancouver Island, British Columbia, Canada. We specialize in providing professional, transparent, and client-focused immigration services for individuals and families aiming to visit, study, work, or settle in Canada.\n\nOur firm is led by a Regulated Canadian Immigration Consultant (RCIC) and operates in full compliance with the Immigration Consultants of Canada Regulatory Council (ICCRC)—ensuring that all our services meet the highest standards of ethical and legal practice.\n\nWith nearly a decade of experience in the immigration industry, we have successfully guided clients from various parts of the world—including the Philippines, Japan, China, Korea, Saudi Arabia, UAE, Singapore, and Hong Kong—through the complex immigration process. We also serve clients across British Columbia and other Canadian provinces, excluding Quebec.\n\nAt Roman Canadian Immigration Services, we pride ourselves on our integrity, transparency, and dedication. We believe that each client deserves personalized attention, honest advice, and unwavering support throughout their immigration journey. Our commitment to lifelong learning and adaptation allows us to stay updated with the latest policies and pathways introduced by the Canadian government.\n\nOver the years, we have helped hundreds of clients realize their dream of starting a new life in Canada. Whether it\'s pursuing higher education, reuniting with loved ones, or securing a better job opportunity, we’re here to support our clients every step of the way.', 3);

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
(17, 'text', 'Canadian Immigration Consultants are able to help and support with the processing and documentation needed to work, study or immigrate to Canada. This process may seem overwhelming and confusing. We at Roman & Associates Immigration Services Ltd are here to provide support and services for your immigration needs and make it simple.', NULL, 'image', 0),
(18, 'text', 'We are registered Canadian Immigration consultants with active good standing with ICCRC. Book an appointment now to see how your life can change.', NULL, 'image', 1),
(19, 'text', 'We offer Immigration Services to clients across British Columbia including cities: Nanaimo, Ladysmith, Duncan, Parksville, Vancouver, Victoria, Richmond, Surrey, and the rest of Canada except Quebec.', NULL, 'image', 2),
(20, 'text', 'We also serve across China, Japan, Philippines, Korea, Hong Kong, Saudi Arabia, UAE, Singapore, and the rest of the world.', NULL, 'image', 3);

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
(1, 'About Roman & Associates Immigration Services LTD', 'We are a licensed Canadian immigration firm based in Vancouver Island BC, providing expert advice on visas, permits, and sponsorships to help people achieve a brighter future in Canada.', 'uploads/about/1757860640_9192391b07e6de5b.mov', 'video');

-- --------------------------------------------------------

--
-- Table structure for table `admin_access_requests`
--

CREATE TABLE `admin_access_requests` (
  `id` int(11) NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','denied') NOT NULL DEFAULT 'pending',
  `authorized_by_superadmin_id` int(11) DEFAULT NULL,
  `authorized_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_access_requests`
--

INSERT INTO `admin_access_requests` (`id`, `admin_user_id`, `requested_at`, `status`, `authorized_by_superadmin_id`, `authorized_at`) VALUES
(1, 15, '2025-09-11 10:08:59', 'denied', 12, '2025-09-11 10:13:09'),
(2, 15, '2025-09-11 10:13:20', 'denied', 12, '2025-09-11 10:13:25'),
(3, 15, '2025-09-11 10:13:37', 'denied', 12, '2025-09-11 10:13:42'),
(4, 15, '2025-09-11 10:13:46', 'approved', 12, '2025-09-11 10:13:49'),
(5, 15, '2025-09-12 05:47:00', 'pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_log`
--

CREATE TABLE `admin_activity_log` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `target_id` int(11) DEFAULT NULL,
  `target_type` varchar(50) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_activity_log`
--

INSERT INTO `admin_activity_log` (`id`, `admin_id`, `action`, `target_id`, `target_type`, `details`, `timestamp`) VALUES
(1, 12, 'Approved Consultation', 1, 'consultation', 'Approved consultation for user Jessica Sotto.', '2025-09-10 21:30:10'),
(2, 12, 'Cancelled Consultation', 2, 'consultation', 'Cancelled consultation for user Jessica Sotto.', '2025-09-10 20:15:20'),
(3, 13, 'Approved Document', 8, 'user_document', 'Approved document \'Jp weekly accomplishments report.pdf\' for user Aespa Karina.', '2025-09-10 04:05:00'),
(4, 12, 'Updated Profile', 12, 'admin_profile', 'Updated own profile information.', '2025-09-10 01:45:33'),
(5, 13, 'Approved Application', 3, 'client_application', 'Approved client application for Kim, Chaewon, D.', '2025-09-11 00:12:45'),
(6, 12, 'Cancelled Application', 1, 'client_application', 'Cancelled client application for Higashikata, Josuke, D.', '2025-09-11 01:05:18'),
(7, 12, 'Deleted Document', 4, 'user_document', 'Deleted document \'karina.jpg\' for user Aespa Karina.', '2025-09-11 02:22:03');

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
(6, 6, 0, 'Hello', '2025-09-09 07:13:10', 0, 1),
(7, 12, 0, 'Anyeong', '2025-09-10 15:05:28', 0, 0),
(8, 12, 0, 'Anyeong Again', '2025-09-10 15:18:29', 0, 0),
(9, 2, 0, 'Anyeonggg!!!', '2025-09-10 15:24:29', 0, 0),
(10, 6, 0, 'Hi', '2025-09-12 02:11:13', 0, 0),
(11, 0, 11, 'f', '2025-09-12 08:41:10', 0, 0);

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
(1, 'Niagara Falls View', 'Admin', '2025-09-14 18:00:00', 'vids/niagarapoh.mp4', 1),
(2, 'Try', 'Jp Godoy', '2025-09-14 21:31:15', 'uploads/hero/hero_68c6c3a38cf36.mp4', 0);

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
(4, 6, 'Your document \'Jp weekly accomplishments report.pdf\' has been Approved.', 'document_approved', 'documents.php', 0, '2025-09-09 07:57:13'),
(5, 11, 'Your document \'chae1.jpg\' has been Approved.', 'document_approved', 'documents.php', 0, '2025-09-10 11:20:58'),
(6, 3, 'Your document \'afs.webp\' has been Approved.', 'document_approved', 'documents.php', 0, '2025-09-11 08:19:22');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `website_link` varchar(2083) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `background_image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_key` varchar(50) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `hero_image_path` varchar(255) DEFAULT NULL,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_key`, `page_title`, `hero_image_path`, `hero_title`, `hero_description`) VALUES
(1, 'family_permit', 'Family Permit', 'img/Ffam.jpg', 'Family Permit', 'Family sponsorship allows individuals to bring their family members to live with them in another country, requiring proof of financial stability and support commitment. It helps reunite families and provides opportunities for a better life.'),
(2, 'caregiver', 'Caregiver Permit', 'img/Fcaregiver.jpg', 'Caregiver Permit', 'A caregiver provides personal care and support to individuals in need, such as the elderly or those with disabilities. They assist with daily activities while promoting dignity and independence.'),
(3, 'lmia', 'Labor Market Impact Assessment', 'img/Flmia.jpg', 'Labour Market Impact Assessment (LMIA)', 'An LMIA is a document in Canada that evaluates the effect of hiring a foreign worker on the local job market. A positive LMIA shows a need for a foreign worker because no local candidates are available.'),
(4, 'pr', 'Permanent Residency', 'img/Fpr.jpg', 'Permanent Residency', 'Permanent Residency allows foreign nationals to live, work, and study in Canada indefinitely, with access to most social benefits enjoyed by citizens. It is a step toward becoming a Canadian citizen and provides stability for you and your family.'),
(5, 'study_permit', 'Study Permit', 'img/Fstudy.jpg', 'Study Permit', 'A study permit allows individuals to study legally in a country, requiring proof of enrollment and financial stability. In some countries, like the Philippines, it is also necessary for obtaining a driver’s license.'),
(6, 'visit_permit', 'Visit Permit', 'img/fvisit.jpg', 'Visit Permit', 'A tourist visa lets individuals visit a country for leisure or family visits, typically requiring a valid passport, financial proof, and return tickets. It does not permit work during the stay.'),
(7, 'work_permit', 'Work Permit', 'img/Fwork.jpg', 'Work Permit', 'A work permit allows individuals to work legally in a specific country, often requiring employer sponsorship or meeting eligibility criteria. For caregivers, additional requirements may include qualifications and a positive Labour Market Impact Assessment (LMIA).');

-- --------------------------------------------------------

--
-- Table structure for table `service_tabs`
--

CREATE TABLE `service_tabs` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `tab_key` varchar(50) NOT NULL,
  `content` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_tabs`
--

INSERT INTO `service_tabs` (`id`, `service_id`, `tab_key`, `content`, `image_path`, `display_order`) VALUES
(1, 1, 'about', 'Family Sponsorship is a Canadian immigration program designed to allow citizens and permanent residents to bring their close family members—such as spouses, partners, dependent children, parents, and grandparents—to live with them in Canada permanently. This initiative plays a crucial role in supporting family unity, offering sponsored individuals the opportunity to settle, thrive, and contribute to Canadian society. The ultimate goal of the program is to help families reunite, foster stronger social bonds, and build a stable life together in Canada.', 'img/fam.png', 1),
(2, 1, 'criteria', 'Criteria:\n\nEligibility of the Sponsor:\n- Canadian Citizenship or Permanent Residency: Must be a Canadian citizen or permanent resident.\n- Age: At least 18 years old.\n- Financial Support: Must demonstrate the ability to financially support their relative and provide basic needs (food, clothing, shelter).\n- Not Receiving Social Assistance: Must not be receiving social assistance (except for reasons of disability).\n\nEligibility of the Sponsored Person:\n- Spouse, Common-law Partner, or Conjugal Partner: They must be in a genuine relationship with the sponsor and meet the legal definition of spouse, common-law, or conjugal partner.\n- Dependent Children: Must be under 22 years old and not married or in a common-law relationship. Children over 22 may be eligible if they are financially dependent due to a physical or mental condition.\n- Parents or Grandparents: Parents and grandparents can be sponsored, but they must meet specific eligibility criteria, including health and security requirements.', 'img/criteria.jpg', 2),
(3, 1, 'process', 'Process:\n\n1. Determine eligibility:\nBoth the sponsor and the sponsored person need to meet eligibility requirements. The sponsor must ensure they can financially support the relative and provide the required documentation.\n\n2. Submit Sponsorship Application:\nThe sponsor must submit a complete sponsorship application to Immigration, Refugees and Citizenship Canada (IRCC), including both sponsorship and applicant forms.\n\n3. IRCC Review:\nThe IRCC will assess the eligibility of both the sponsor and the sponsored person to ensure they meet all criteria.\n\n4. Approval and Permanent Residency:\nOnce approved, the sponsored family member will receive permanent resident status, allowing them to live, work, and study in Canada.\n\n5. Arrival in Canada:\nThe sponsored person can then arrive in Canada and begin their life as a permanent resident.', 'img/proc.png', 3),
(4, 1, 'documents', 'To apply for Family Sponsorship, the following documents are typically required:\n\nFor the Sponsor:\n- Proof of Canadian citizenship or permanent residency (e.g., passport, PR card).\n- Proof of income: Demonstrating the ability to financially support the sponsored person.\n- Application for sponsorship: Completed and signed.\n- Any previous relationships: Divorce certificates or death certificates if applicable (for spousal sponsorship).\n\nFor the Sponsored Person:\n- Proof of relationship: Evidence of marriage, common-law partnership, or proof of dependency (e.g., marriage certificate, joint financial records).\n- Proof of identity: Passport, national ID card, or birth certificate.\n- Medical exam results: To confirm they are medically admissible to Canada.\n- Police certificates: To show that they have no serious criminal history.\n- Proof of financial dependency: For children or dependent adults.\n\nFor Both:\n- Application fee: Payment for processing the sponsorship application.', 'img/documents.png', 4),
(5, 1, 'faq', 'Frequently Asked:\n\nQ1: Can I sponsor someone if I live outside of Canada?\nA: No, you must live in Canada to sponsor a relative. However, there are exceptions for Canadian citizens who are living abroad and have a clear intent to return to Canada.\n\nQ2: How long does the Family Sponsorship process take?\nA: The processing time for family sponsorship applications can vary, but it generally takes 12 to 24 months. Processing times may vary depending on the specific relationship and whether the application is complete.\n\nQ3: Can I sponsor my siblings or other family members?\nA: The Family Sponsorship program is generally limited to spouses, common-law partners, dependent children, parents, and grandparents. Other family members, such as siblings, cannot be sponsored under this program, but there may be other immigration pathways for them.\n\nQ4: What if the sponsored person is already in Canada?\nA: If the sponsored person is already in Canada, they may be eligible for inland sponsorship. This allows them to stay in Canada while their sponsorship application is being processed.\n\nQ5: Can the sponsor be responsible for providing financial support indefinitely?\nA: The sponsor’s obligation to financially support the sponsored person typically lasts for 3 years for a spouse, common-law partner, or dependent child, and 10 years or until the person becomes a Canadian citizen for parents or grandparents.\n\nQ6: What happens if the sponsor or the sponsored person’s application is refused?\nA: If the application is refused, the sponsor can appeal the decision or reapply, depending on the reason for refusal.', 'img/faq.jpg', 5),
(6, 2, 'about', 'The Caregiver Pilot Program is designed for individuals who wish to migrate to Canada and work as caregivers. This program provides two pathways for prospective applicants: the Home Child Care Provider Pilot (HCCP) and the Home Support Worker Pilot (HSWP).\n\nThese programs were introduced in 2019 following the closure of the Interim Pathway for Caregivers, offering more flexibility and options for caregivers interested in immigrating to Canada.\n\nCaregivers under this program must have a valid job offer from a Canadian employer, meet the standard criteria for economic immigration, and work in Canada to gain the required experience needed to apply for permanent residence.', 'img/care.png', 1),
(7, 2, 'criteria', 'Criteria:\n\nBasic Immigration Criteria (for Employees):\n- Work Experience: Must have at least 2 years of experience in NOC 4411 (Home Child Care Provider) or NOC 4412 (Home Support Worker).\n- Job Offer: Must have a valid, genuine job offer from a Canadian employer.\n- Language Skills: Minimum CLB 5 in English or French.\n- Education: At least 1 year of post-secondary education or equivalent recognized in Canada.\n\nJob Offer Criteria (for Employers):\n- Must use the Offer of Employment IMM 5983 form.\n- Job must be full-time and located outside Quebec.\n- Must fall under NOC 4411 or 4412 categories.\n- Employer must prove no Canadian/permanent resident was available for the job.', 'img/criteria.jpg', 2),
(8, 2, 'process', 'Process:\n\n1. Employer Extends a Job Offer:\nThe employer must provide a genuine, full-time job offer to the caregiver. The offer must meet criteria for NOC 4411 or 4412 and use form IMM 5983.\n\n2. Employee Applies for a Work Permit:\nAfter receiving the job offer, the caregiver applies online for a work permit.\n\n3. Work Permit Approval:\nOnce approved, the caregiver is authorized to work in Canada.\n\n4. Gaining Work Experience:\nThe caregiver must work for at least 2 years in their designated role.\n\n5. Apply for Permanent Residence:\nOnce 2 years of Canadian experience is completed, the caregiver can apply for PR. Applications may be submitted through Express Entry or other immigration pathways.', 'img/proc.png', 3),
(9, 2, 'documents', 'Documents:\n\nFor Employees:\n- Valid Job Offer: A full-time, permanent job offer from a Canadian employer.\n- Work Experience: Evidence of at least 2 years of experience as a Home Child Care Provider (NOC 4411) or Home Support Worker (NOC 4412).\n- Language Proficiency: Proof of language skills (CLB 5) in English or French.\n- Education: Educational credentials or proof of post-secondary education equivalent to Canadian standards.\n- Passport: Valid passport and other travel documents.\n- Proof of Relationship (if applicable): For spouses or dependents who may accompany the applicant.\n\nFor Employers:\n- Offer of Employment IMM 5983: This form must be used to extend the job offer to the caregiver.\n- Employer’s Evidence: Proof that the employer was unable to fill the position with a Canadian citizen or permanent resident.\n- Job Description: The job description must match the relevant NOC (4411 or 4412).', 'img/documents.png', 4),
(10, 2, 'faq', 'Frequently Asked:\n\nQ1: What is the difference between the Home Child Care Provider Pilot (HCCP) and the Home Support Worker Pilot (HSWP)?\nA: HCCP is for individuals who provide child care in a private home, while HSWP is for individuals providing support services to individuals with disabilities, elderly people, or others requiring assistance.\n\nQ2: Can I apply if I don’t have a job offer yet?\nA: No, you must have a valid job offer from a Canadian employer before applying for the work permit under this program.\n\nQ3: How can my employer prove they were unable to hire a Canadian citizen or permanent resident?\nA: The employer must provide evidence of recruitment efforts to hire a Canadian citizen or permanent resident, showing that they were unable to find a suitable candidate for the position.\n\nQ4: Is there a minimum duration for my job offer?\nA: Yes, the job offer must be full-time and permanent, not temporary.\n\nQ5: How long do I need to work in Canada before applying for Permanent Residency?\nA: You must work for at least 2 years in your designated role in Canada to qualify for permanent residency.\n\nQ6: Can my family come with me?\nA: Yes, under the Caregiver Pilot Program, your spouse and dependent children may be eligible to join you in Canada during your stay.', 'img/faq.jpg', 5),
(11, 3, 'about', 'A Labour Market Impact Assessment (LMIA) is a crucial document that employers in Canada must obtain before hiring a temporary foreign worker (TFW). The LMIA process allows the Canadian government to assess whether hiring a foreign worker will have a positive or negative impact on the Canadian labor market. A positive LMIA means there is a demonstrated need for a foreign worker to fill the position and that no qualified Canadian citizens or permanent residents are available.\n\nAdditionally, there are high-wage and low-wage categories for LMIA applications, depending on the offered salary compared to the provincial or territorial median wage. Some work permit types are LMIA-exempt and fall under the International Mobility Program.', 'img/lmia1.png', 1),
(12, 3, 'criteria', 'Criteria:\n\nEmployer Eligibility:\n- The employer must be a legitimate Canadian business with the ability to meet the requirements of the LMIA process.\n- The employer must be willing to hire a temporary foreign worker and provide employment conditions that comply with Canadian labor standards.\n\nJob Advertisement:\n- Employers are generally required to advertise the job position for at least four weeks using recognized platforms (e.g., job boards, newspapers) to prove that no qualified Canadian citizen or permanent resident was available for the job.\n\nSalary and Job Type:\n- Positions are classified as high-wage or low-wage based on the provincial/territorial median wage.\n\nDocumentation:\n- Employers must provide comprehensive documentation detailing why Canadian applicants were not hired and must prove no qualified citizens or permanent residents applied.\n\nEmployer’s Ability to Support:\n- The employer must demonstrate the ability to support the foreign worker, including providing a safe work environment and complying with labor laws.', 'img/criteria.jpg', 2),
(13, 3, 'process', 'LMIA Process:\n\n1. Determine the job category: Identify if it’s a high-wage or low-wage position.\n\n2. Advertise the job: Publish the job ad for a minimum of four weeks using multiple platforms.\n\n3. Gather documentation: Prepare business details, financials, and recruitment efforts.\n\n4. Submit LMIA application: Send the complete application to ESDC for review.\n\n5. ESDC assessment: Government assesses employer\'s legitimacy and labor market impact.\n\n6. Receive decision: Employer gets a positive or negative LMIA decision.', 'img/proc.png', 3),
(14, 3, 'documents', 'To apply for an LMIA, employers typically need to submit the following documents:\n\nEmployer’s Information:\n- Business license or registration – Proof of the company’s legal status.\n- Financial information or evidence that the business can financially support a foreign worker.\n\nJob Advertisement Records:\n- Proof of the job advertisement for at least four weeks, including dates, platforms used, and a description of the recruitment efforts made.\n\nJob Description:\n- Detailed job description outlining duties, responsibilities, salary, and working conditions.\n\nReasons for Not Hiring Canadians:\n- Documentation explaining why Canadian candidates were not suitable for the position (e.g., skills mismatch, lack of experience).\n\nEmployee Salary Information:\n- Proof of the salary offered to the foreign worker and its comparison to the provincial or territorial median wage.\n\nEmployer’s Statement:\n- A letter or statement from the employer explaining the need for a foreign worker and the terms of employment.\n\nAdditional Documents:\n- Any other documents requested by Employment and Social Development Canada (ESDC) based on the job type or wage category.', 'img/documents.png', 4),
(15, 3, 'faq', 'Frequently Asked:\n\nQ1: What is the difference between high-wage and low-wage LMIA applications?\nA: High-wage LMIA applications are for positions that offer a salary at or above the provincial/territorial median wage, while low-wage applications are for positions paying below that threshold.\n\nQ2: Do I need an LMIA for every type of work permit?\nA: No, not all work permits require an LMIA. Some workers may be exempt from needing an LMIA if their position falls under the International Mobility Program.\n\nQ3: How long does it take to get a positive LMIA?\nA: The processing time for an LMIA application can take several weeks to a few months, depending on the complexity of the application and the volume of requests being processed.\n\nQ4: Can I hire a foreign worker without advertising the job for four weeks?\nA: Generally, the advertisement period is required. However, there may be exceptions in certain cases. It’s essential to check if your specific situation qualifies for an exemption or expedited process.\n\nQ5: What happens if my LMIA is denied?\nA: If your LMIA application is denied, you can either reapply with additional documentation or review the reasons for the refusal. You may also need to make adjustments to your recruitment process.\n\nQ6: Is there any way to speed up the LMIA process?\nA: The LMIA process can take time, but ensuring your application is complete and well-documented can help avoid delays. Some employers may be eligible for expedited processing under certain circumstances, such as for high-demand jobs or workers in critical sectors.', 'img/faq.jpg', 5),
(16, 4, 'about', 'Permanent Residency (PR) in Canada grants foreign nationals the right to live, work, and study anywhere in the country without time limits. PR holders enjoy many of the same benefits as Canadian citizens, such as access to publicly funded healthcare, social services, and legal protections under Canadian law. They can freely move between provinces, work for almost any employer, and pursue educational opportunities at domestic tuition rates. PR status also allows individuals to sponsor eligible family members, making it a key step in reuniting loved ones in Canada.\n\nObtaining PR is also a pathway to citizenship. After meeting residency requirements — typically living in Canada for at least 1,095 days within a five-year period — PR holders can apply for Canadian citizenship and enjoy full voting rights and passports. However, PR comes with responsibilities, such as maintaining residency obligations, paying taxes, and abiding by Canadian laws. For many, securing PR status represents not just legal stability but also the opportunity to thrive in one of the world’s most diverse, prosperous, and welcoming countries.', 'img/pr.png', 1),
(17, 4, 'criteria', 'Criteria:\n\n- Meet eligibility requirements of one of the immigration programs (e.g., Express Entry, Provincial Nominee Program, Family Sponsorship, or Refugee programs).\n- Minimum language proficiency in English or French (CLB requirements vary by program).\n- Proof of sufficient settlement funds (unless exempt).\n- Relevant work experience or education credentials (Canadian equivalency may be required and assessed through an Educational Credential Assessment).\n- Must not be inadmissible to Canada for reasons of security, criminal record, or health.', 'img/criteria.jpg', 2),
(18, 4, 'process', 'Process:\n\n1. Choose the right program: Identify the immigration pathway that best fits your profile (e.g., Express Entry, PNP).\n\n2. Gather documents: Collect all required documents, including proof of language proficiency, educational assessments, and work experience letters.\n\n3. Submit application: Create a profile and submit your application to Immigration, Refugees and Citizenship Canada (IRCC) through the appropriate online portal.\n\n4. Receive invitation: If your profile meets the criteria, you may receive an Invitation to Apply (ITA) for permanent residence.\n\n5. Medical and security checks: Complete required medical exams and provide police certificates from every country you\'ve lived in for more than six months since age 18.\n\n6. Confirmation of Permanent Residence: Once your application is approved, you will receive a Confirmation of Permanent Residence (COPR) and a permanent resident visa.\n\n7. Arrival in Canada: Upon arrival, your PR status is officially granted, and your PR card will be mailed to you.', 'img/proc.png', 3),
(19, 4, 'documents', 'Required Documents:\n\n- Valid passport or travel document.\n- Language test results (e.g., IELTS, CELPIP, TEF Canada).\n- Educational Credential Assessment (ECA) report for foreign education.\n- Proof of work experience (letters from employers, pay stubs).\n- Proof of funds (bank statements or other financial documents).\n- Police certificates from all countries where you have lived for more than six months since age 18.\n- Medical examination results.\n- Birth certificates and marriage certificates, if applicable.', 'img/documents.png', 4),
(20, 4, 'faq', 'Frequently Asked:\n\nQ1: What is the difference between a permanent resident and a citizen?\nA: A permanent resident is a foreign national who has been granted the right to live in Canada. They can live, work, and study anywhere in Canada. A citizen has the added benefits of holding a Canadian passport, the right to vote, and not being subject to removal from Canada.\n\nQ2: How do I maintain my permanent resident status?\nA: To maintain your PR status, you must be physically present in Canada for at least 730 days within a five-year period. These 730 days do not have to be continuous.\n\nQ3: Can a permanent resident lose their status?\nA: Yes, a permanent resident can lose their status if they fail to meet the residency obligation, are found to be inadmissible for security or criminal reasons, or become a Canadian citizen.\n\nQ4: Can I travel outside Canada as a permanent resident?\nA: Yes, you can travel outside of Canada, but you need a valid Permanent Resident Card to re-enter the country. It is important to meet the residency obligations to maintain your status.\n\nQ5: What is the Express Entry system?\nA: Express Entry is an online system used to manage applications for permanent residence under three economic immigration programs: the Federal Skilled Worker Program, the Federal Skilled Trades Program, and the Canadian Experience Class.\n\nQ6: How much does it cost to apply for Permanent Residency?\nA: The cost varies by program, but it typically includes processing fees for the principal applicant, spouse or partner, and any dependent children, as well as the right of permanent residence fee. Additional costs may include language tests, educational assessments, and medical exams.', 'img/faq.jpg', 5),
(21, 5, 'about', 'Canada\'s education system is renowned worldwide for its quality, and it attracts thousands of international students every year. The Canadian government and institutions prioritize academic excellence, making Canada one of the top choices for students seeking world-class education. Students who graduate from Canadian institutions often find that their credentials are highly valued globally, enhancing their job prospects and career growth.\n\nStudying in Canada offers not only access to top-notch education but also an unparalleled cultural and living experience. The country\'s vibrant, multicultural environment makes it a great place to live and learn, with a high quality of life and excellent safety standards. Furthermore, Canada offers opportunities for international students to work during their studies and even stay on after graduation through programs such as the Post-Graduation Work Permit Program (PGWPP).', 'img/study.png', 1),
(22, 5, 'criteria', 'Criteria:\n\n1. Eligibility for International Students:\n- You must have accepted admission to a Designated Learning Institution (DLI) in Canada.\n- You must prove that you have enough funds to cover tuition fees, living expenses, and return travel to your home country.\n- You must have no criminal record and provide a police certificate, if necessary.\n- You must be in good health and may need a medical exam.\n- You must satisfy the visa officer that you will leave Canada at the end of your authorized stay.\n\n2. Admission Requirements for Schools:\n- Schools may have different requirements based on the program and institution.\n- Most Canadian institutions require that applicants provide academic transcripts, language proficiency test scores (e.g., IELTS or TOEFL), and sometimes letters of recommendation.\n- Each school and program may have specific documents or prerequisites, so always check with the institution for detailed information.\n\n3. English/French Language Proficiency:\n- As most programs in Canada are offered in English or French, you will likely need to prove your language proficiency through a recognized test (such as IELTS, TOEFL, or TEF).', 'img/criteria.jpg', 2),
(23, 5, 'process', 'Process:\n\n1. Choose Your Course and School: Research and select a Designated Learning Institution (DLI) that offers the program of your choice. Only DLIs can accept international students. Make sure the school you apply to offers the program that matches your academic and career interests.\n\n2. Understand School Requirements: Check the admission requirements of the school or program. These can include academic transcripts, test scores (IELTS/TOEFL), letters of recommendation, and more. Different institutions may have varying admission deadlines, so ensure you are well aware of them.\n\n3. Submit Your Application: Apply to schools in Canada through their online application systems. Most schools allow you to apply to multiple institutions. Prepare to pay an administration fee, which can range from CAD 100 to CAD 2,500, depending on the school.\n\n4. Wait for Admission Results: Admission results are typically released within 2-3 weeks. If admitted, you will be required to pay the tuition fees for the first semester. The school will send you an official letter of admission (Letter of Acceptance, LOA), which you will need for your study permit application.\n\n5. Apply for a Study Permit: After receiving your Letter of Acceptance (LOA), apply for a study permit. The application process can take 20-70 days. Submit required documents such as proof of financial support, medical exam results (if required), and police clearance (if applicable).\n\n6. Travel to Canada: Once your study permit is approved, begin planning your travel to Canada. Ensure you travel after the start date mentioned on your study permit.\n\n7. Begin Your Studies in Canada: Upon arrival, ensure you follow all the conditions of your study permit, including the ability to work part-time (up to 20 hours per week during the semester and full-time during breaks). Build connections and gain Canadian work experience, which could later help in applying for permanent residency through the Post-Graduation Work Permit Program (PGWPP).', 'img/proc.png', 3),
(24, 5, 'documents', 'Required Documents:\n\nDocuments for Study Permit Application:\n- Proof of citizenship or permanent residency.\n- Letter of Acceptance (LOA) from a Designated Learning Institution (DLI).\n- Proof of Funds to show financial support for yourself and any accompanying family.\n- Valid Passport.\n- Proof of Language Proficiency (e.g., IELTS, TOEFL).\n- Medical Examination (if required).\n- Police Certificate (if required).\n- Digital Photo for your application.\n- Statement of Purpose outlining your goals and plans after study.\n\nDocuments for Admission to Canadian Schools:\n- Academic Transcripts from previous education.\n- Language Proficiency Test Results (e.g., IELTS or TOEFL).\n- Medical exam results (if required).\n- Letters of Recommendation.\n- Statement of Purpose for some programs.\n\nDocuments for Family Members:\n- If bringing a spouse or children, submit supporting documents for their visitor visa or work/study permits.', 'img/documents.png', 4),
(25, 5, 'faq', 'Frequently Asked:\n\nQ1: Can I work while studying in Canada?\nA: Yes, international students can work up to 20 hours per week during the academic session and full-time during scheduled breaks (like summer holidays).\n\nQ2: Can I bring my family with me while I study in Canada?\nA: Yes, your spouse or common-law partner can apply for a work permit and your dependent children can apply for a study permit to attend school in Canada.\n\nQ3: What is the Post-Graduation Work Permit Program (PGWPP)?\nA: The PGWPP allows students who have graduated from eligible Designated Learning Institutions (DLIs) to apply for an open work permit, giving them the opportunity to gain Canadian work experience. This work experience may help qualify them for permanent residency through the Canadian Experience Class within the Express Entry system.\n\nQ4: How long does it take to get a study permit?\nA: The processing time for a study permit can vary, typically taking 20 to 70 days, depending on the country of application and other factors.\n\nQ5: Can I apply to multiple schools in Canada?\nA: Yes, you can apply to multiple schools in Canada. However, you must carefully manage application fees, as they can range from CAD 100 to CAD 2,500 per institution.\n\nQ6: Can I extend my study permit if my course duration is longer than expected?\nA: Yes, you can apply for an extension of your study permit while you are still in Canada, as long as your program is ongoing.\n\nQ7: What happens after I graduate from a Canadian institution?\nA: After graduation, you may be eligible to apply for a Post-Graduation Work Permit (PGWP), which allows you to work in Canada and gain Canadian work experience that can help in your application for permanent residency.', 'img/faq.jpg', 5),
(26, 6, 'about', 'A Visitor Visa, also known as a Temporary Resident Visa (TRV) or tourist visa, is an official document placed in your passport by a Canadian visa office to show that you meet the requirements to enter Canada as a temporary resident. Visitors can enter Canada for various purposes, such as tourism, family visits, or business activities. Most visitors can stay in Canada for up to 6 months.\n\nVisitors are not Canadian citizens or permanent residents, but they are legally authorized to enter Canada temporarily. The length of stay is typically 6 months, but the border services officer at the port of entry may adjust this duration based on individual circumstances. Visitors may also receive a visitor record, which outlines the date they are required to leave.', 'img/visa1.png', 1),
(27, 6, 'criteria', 'Criteria:\n\nYou may need a Visitor Visa if you meet the following criteria:\n\n1. Purpose of Visit:\n- You are traveling to Canada for tourism, business, or to visit family members.\n\n2. Travel Document:\n- You are traveling with a valid passport or travel document.\n\n3. Nationality:\n- Your nationality determines whether you need a Visitor Visa or an Electronic Travel Authorization (eTA).\n\n4. Eligibility: You must be able to demonstrate that you:\n- Have enough money for your stay and return.\n- Have strong ties to your home country (such as a job, family, or property) to prove that you will leave Canada at the end of your visit.\n- Will obey the conditions of your visa and leave Canada at the end of your authorized stay.\n\nIf you are unsure whether you qualify for a Visitor Visa, you can speak to an immigration specialist for further guidance.', 'img/criteria.jpg', 2),
(28, 6, 'process', 'Process:\n\n1. Check Visa Requirements: Verify if you need a Visitor Visa or an Electronic Travel Authorization (eTA) based on your nationality, travel document, and method of travel.\n\n2. Prepare Your Application: Gather all necessary documents, including proof of financial support, travel history, and ties to your home country.\n\n3. Submit Your Application: Complete the online or paper application for a Visitor Visa and submit it along with required documents.\n\n4. Wait for Decision: Once your application is submitted, the Canadian visa office will review it. Processing times can vary, so check the estimated timeframes.\n\n5. Receive a Decision: If your application is approved, you will receive a Visitor Visa in your passport. If additional documents are required, you will be contacted.\n\n6. Travel to Canada: After receiving your Visitor Visa, you can travel to Canada. Upon arrival, the border services officer will determine your exact length of stay.', 'img/proc.png', 3),
(29, 6, 'documents', 'Required Documents:\n\n1. Valid Passport: Your passport should be valid for the duration of your stay in Canada.\n\n2. Completed Application Form: The official application for a Visitor Visa (available online or in paper form).\n\n3. Proof of Financial Support: Documents showing you have enough money to support yourself during your stay in Canada.\n\n4. Travel Itinerary: A detailed plan of your travel in Canada (e.g., flight bookings, accommodation arrangements).\n\n5. Ties to Home Country: Evidence of ties to your home country (e.g., employment letter, property ownership, family).\n\n6. Photographs: Passport-sized photos that meet Canada’s visa photo requirements.\n\n7. Application Fees: Payment of the visa application fee.\n\n8. Additional Documents (if applicable): Depending on your case, additional documents may be required, such as an invitation letter from family or business partners in Canada.', 'img/documents.png', 4),
(30, 6, 'faq', 'Frequently Asked:\n\nQ1: How long can I stay in Canada with a Visitor Visa?\nA: Most visitors are allowed to stay for up to 6 months. However, the border services officer may allow a shorter or longer stay based on individual circumstances.\n\nQ2: Do I need a Visitor Visa to visit Canada?\nA: Not everyone needs a Visitor Visa. Depending on your nationality and travel document, you may need either a Visitor Visa or an Electronic Travel Authorization (eTA). Check with the Canadian authorities or consult an immigration specialist.\n\nQ3: Can I work or study while on a Visitor Visa?\nA: No, a Visitor Visa does not allow you to work or study in Canada. If you wish to work or study, you will need to apply for the appropriate visa or permit.\n\nQ4: What happens if I stay longer than the allowed time?\nA: If you overstay your visa, you may be subject to penalties, including removal from Canada or a ban from entering in the future. It’s crucial to comply with the conditions of your visa.\n\nQ5: Can I extend my stay in Canada with a Visitor Visa?\nA: Yes, you can apply to extend your stay while in Canada if you want to remain longer. You must apply for an extension before your current visitor status expires.\n\nQ6: Do I need to provide biometrics for my Visitor Visa application?\nA: Some applicants are required to provide biometrics (fingerprints and a photo) as part of the application process. You will be notified if you need to provide biometrics.\n\nQ7: Can I visit Canada multiple times with the same Visitor Visa?\nA: A Visitor Visa is typically valid for a single entry or multiple entries, depending on the visa issued. You can apply for multiple-entry visas if you plan to visit Canada more than once.', 'img/faq.jpg', 5),
(31, 7, 'about', 'A work permit is required for foreign skilled workers wishing to work temporarily in Canada. To qualify, a person must have a temporary offer of employment from a Canadian employer. Certain positions may require knowledge of the National Occupation Classification (NOC) Code, which classifies employment types by Canadian standards. Individuals applying for a Permanent Resident (PR) card may also apply for an open work permit.', 'img/work.png', 1),
(32, 7, 'criteria', 'Criteria:\n\nThere are two main types of work permits in Canada:\n\n1. Open Work Permit (OWP):\n- This permit is not job-specific.\n- Applicants do not need to specify an employer when applying.\n- Includes permits for spouses, post-graduation work, youth programs, and more.\n\n2. Employer-Specific Work Permit:\n- The work permit specifies the employer, job duration, and work location (if applicable).\n- Conditions must be followed as per the permit details.\n\nThe specific criteria you need to meet depends on which type of work permit you are applying for, your qualifications, job offer, and other individual circumstances.', 'img/criteria.jpg', 2),
(33, 7, 'process', 'Process:\n\n1. Employer Applies for Labour Market Opinion (if necessary):\nThe employer may need to apply for a Labour Market Impact Assessment (LMIA) to prove there is a need for a foreign worker.\n\n2. Employer Extends a Temporary Job Offer:\nOnce the employer receives the LMIA (if needed), they can extend a temporary job offer to the foreign worker.\n\n3. Foreign Skilled Worker Applies for Work Permit:\nAfter receiving the job offer, the foreign worker applies for a work permit.\n\n4. Work Permit Is Issued:\nIf all the criteria are met, the work permit is issued to the foreign worker, and they can begin their employment in Canada.', 'img/proc.png', 3),
(34, 7, 'documents', 'Required Documents:\n\nFor Employer-Specific Work Permits:\n- Valid job offer from a Canadian employer.\n- LMIA (if applicable).\n- Proof of qualifications (educational certificates, work experience).\n- Passport and travel documents.\n\nFor Open Work Permits:\n- Proof of relationship (for spouse permits).\n- Post-graduation certificate (for Post-Graduation Work Permit).\n- Temporary Resident Visa or status documents (if applicable).\n- Passport and other identity documents.\n\nNote: Always check the specific requirements for the work permit category you are applying for, as requirements may vary.', 'img/documents.png', 4),
(35, 7, 'faq', 'Frequently Asked:\n\nQ1: Can I apply for a work permit without a job offer?\nA: No, in most cases, you need a job offer from a Canadian employer to apply for a work permit unless you are applying under an open work permit category.\n\nQ2: What is the difference between an open work permit and an employer-specific work permit?\nA: An open work permit is not tied to a specific employer or job and allows flexibility in employment. An employer-specific work permit is tied to a particular employer, job, and location.\n\nQ3: How long can I stay in Canada on a work permit?\nA: The duration of your work permit depends on the terms of your job offer and the specific type of work permit you have received.\n\nQ4: Can my family come with me to Canada?\nA: Yes, if you hold an open work permit, your spouse or common-law partner may be eligible for an open work permit, and dependent children may be allowed to study in Canada.\n\nQ5: How can I ensure my work permit application is successful?\nA: Ensure that all required documents are submitted and meet the criteria for the work permit. Consulting with an immigration consultant may increase the chances of a successful application.', 'img/faq.jpg', 5);

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
(1, 'John Paul', 'Godoy', 'Darasa, Tanauan City Batangas', '09359306521', 'godoyjp443@gmail.com', '$2y$10$LxDGp8XROe201KZCttcLSOUlAqajOp5/TqhlZk89ReZwLbMjpzFf.', 'uploads/68b15e9bb7f37-cha.jpg', NULL, '2005-02-04', 'https://www.facebook.com/chaepi04', '', '', 1, 1, 0, 1, 1, 1, 1, 'client', 'Inactive', '2025-09-15 21:52:02', NULL, '5db0547617249f92d9b1561185299303a79e9a45e6d9e539ed29525e545d353f', '2025-09-12 11:28:44'),
(2, 'Kim', 'Chaewon', 'Darasa, Tanauan City Batangas', '09359306521', 'kimchae1chi@gmail.com', '$2y$10$YzarQtmz8o0nxRxl5vASierqYIj5.pGSSZ1yNhkgHQ/2gnW4N9vqC', 'uploads/68aea7cdd0f67-cha.jpg', NULL, '2005-08-18', 'https://www.facebook.com/chaepi04', '', 'godoyjp443@gmail.com', 1, 0, 0, 1, 1, 1, 1, 'client', 'Inactive', '2025-09-11 17:39:27', NULL, NULL, NULL),
(3, 'Kim', 'Yooyeon', 'Darasa', '09359306521', 'jp04@gmail.com', '$2y$10$hCC3xNl8HBw99lN/6gi5Z.etwr0OC79hXywGdIC5nrq2BfR6m3NQm', 'uploads/68ae93c2840bb-chaewon.jpg', NULL, '2005-02-04', 'https://www.facebook.com/chaepi04', '', '', 1, 1, 0, 1, 1, 1, 1, 'client', 'Inactive', '2025-09-12 14:31:29', NULL, NULL, NULL),
(4, 'Jisoo', 'Hong', 'San Pedro, Santo Tomas, Batangas', '09618225084', 'hongjisoo@gmail.com', '$2y$10$JdXfhvws62So9kLTaB5Q7uyznoRFIbsVKdawmKKGea44eZZlTMUGu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 1, 'client', 'Inactive', NULL, '2025-08-28 16:53:00', NULL, NULL),
(5, 'Matthew', 'Hernandez', 'San Pedro, Santo Tomas, Batangas', '09067664653', 'matthewehernandez0712@gmail.com', '$2y$10$vaS5dZNbkVNfkYLlLI8DcOAlAKQB0.qKh.E3XQPAUWYyifnVvvXKq', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 1, 'Super Admin', 'Inactive', NULL, '2025-08-28 16:03:28', NULL, NULL),
(6, 'Aespa', 'Karina', 'Darasa', '09359306521', 'jjampi72@gmail.com', '$2y$10$dhwlIzGxPVzEkqOSN2TIY.2Qg5Yk9ZqZs/GuFru9TAEqM1pHJ6huK', 'uploads/68b554ed4465f-karina.jpg', NULL, '2005-02-04', 'https://www.facebook.com/chaepi04', '', 'godoyjp443@gmail.com', 1, 0, 0, 1, 1, 1, 1, 'client', 'Inactive', '2025-09-12 10:10:50', NULL, NULL, NULL),
(7, 'Kim', 'Minjeong', 'Darasa', '09359306521', 'tzuyoda28@gmail.com', '$2y$10$tQcjHW5jI2bHHeGGOnLlQu8FXeOeCV9OdLzMcEjecfPmb/YwvVz7S', 'uploads/68c3be617e0ae-winter2.jpg', NULL, '2025-09-03', 'https://www.facebook.com/chaepi04', '', 'godoyjp443@gmail.com', 1, 1, 0, 1, 1, 1, 1, 'client', 'Inactive', '2025-09-12 14:32:21', NULL, '84af595f8ecd300d186dd864ee0168a33a4d2e1c55de607801ee64f5a6cff69d', '2025-09-03 05:56:50'),
(8, 'Josu', 'Higa', 'Darasa', '09359306521', 'akizashibal@gmail.com', '$2y$10$XlySF0CzDJqAtqCx6IU2Tu30xcZLbxAQkOo1TTYm0ZxWLsgP4QMcm', 'uploads/68c3df1d3308a-josu.jpg', NULL, '2025-09-03', '', '', '', 1, 0, 0, 1, 1, 0, 1, 'client', 'Inactive', '2025-09-12 16:51:25', NULL, NULL, NULL),
(10, 'Kim', 'Chaewon', '123 Admin Lane', '09000000000', 'aimiyuji180@gmail.com', '$2y$10$nZ8W.X7V.y6U.z5T.a4S.b3R.c2Q.d1P.e0O.f9N.g8M.h7L', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 1, 'Super Admin', 'Active', NULL, NULL, NULL, NULL),
(11, 'Jessica ', 'Sotto', 'Darasa', '09359306521', 'jessica@gmail.com', '$2y$10$RkkQMzIgZhwQLWXYLh6yeubpeeLzPE/dBZr6rE1ZCU.0aCLh8IViK', 'uploads/68b7eaa2dcf40-8e0bab69-56d5-4a7b-a7cd-78e25b8da0ef.jpg', NULL, '2025-09-26', 'https://www.facebook.com/chaepi04', 'https://www.facebook.com/chaepi04', 'godoyjp443@gmail.com', 1, 0, 0, 1, 1, 1, 1, 'client', 'Inactive', '2025-09-12 14:36:29', NULL, NULL, NULL),
(12, 'Jp', 'Godoy', 'Darasa, Tanauan City, Batangas', '09359306521', 'adminjp@gmail.com', '$2y$10$Zfy6I02.fIJ5/JFykVrTbOzz6RpdbdVKMpBrfE.h.mzYK25LJrt1u', 'uploads/profiles/68c16e01912ae-chae1.jpg', NULL, '0000-00-00', 'https://www.facebook.com/chaepi04', 'https://www.facebook.com/chaepi04', 'godoyjp443@gmail.com', 1, 0, 0, 0, 0, 1, 1, 'Super Admin', 'Active', '2025-09-16 01:37:16', '2025-09-16 01:39:31', NULL, NULL),
(13, 'Chae', 'Won', '', '', 'chaewon@gmail.com', 'chaewon04.', 'uploads/profiles/68c18a975561d-cha.jpg', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 'Super Admin', 'Active', '2025-09-11 16:12:19', '2025-09-11 16:12:19', NULL, NULL),
(14, 'Marga', 'Dela Rosa', '', '', 'marga@gmail.com', 'itsmarga', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 'Super Admin', 'Inactive', NULL, NULL, NULL, NULL),
(15, 'Triples', 'Yooyeon', 'Seoul, Korea', '09359306521', 'yooyeon@gmail.com', '$2y$10$Ogi5m0tCHA1x/ayhRg6WGu12KQTfR0snXUcVz8qwqlzgbBoOkZ8t.', 'uploads/profiles/68c29c73c242f-yooyeon.jpg', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 'Admin', 'Inactive', '2025-09-15 20:54:40', NULL, NULL, NULL);

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
(2, 3, 'afs.webp', '../uploads/68ae96a5e3c80-afs.webp', '2025-08-27 05:24:53', 'approved'),
(3, 3, 'chae.webp', '../uploads/68ae96a5e57d6-chae.webp', '2025-08-27 05:24:53', 'pending'),
(4, 6, 'karina.jpg', '../uploads/68b6583663021-karina.jpg', '2025-09-02 02:36:38', 'pending'),
(8, 6, 'Jp weekly accomplishments report.pdf', 'uploads/68b6905b1c6f7-Jpweeklyaccomplishmentsreport.pdf', '2025-09-02 06:36:11', 'approved'),
(9, 11, 'chae1.jpg', 'uploads/68c15ed39c0b6-chae1.jpg', '2025-09-10 11:19:47', 'approved');

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
-- Indexes for table `admin_access_requests`
--
ALTER TABLE `admin_access_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_user_id` (`admin_user_id`),
  ADD KEY `authorized_by_superadmin_id` (`authorized_by_superadmin_id`);

--
-- Indexes for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

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
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_key` (`service_key`);

--
-- Indexes for table `service_tabs`
--
ALTER TABLE `service_tabs`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `about_content_blocks`
--
ALTER TABLE `about_content_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `about_main`
--
ALTER TABLE `about_main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_access_requests`
--
ALTER TABLE `admin_access_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `service_tabs`
--
ALTER TABLE `service_tabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `statement_of_account`
--
ALTER TABLE `statement_of_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_access_requests`
--
ALTER TABLE `admin_access_requests`
  ADD CONSTRAINT `admin_access_requests_ibfk_1` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_access_requests_ibfk_2` FOREIGN KEY (`authorized_by_superadmin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  ADD CONSTRAINT `admin_activity_log_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `service_tabs`
--
ALTER TABLE `service_tabs`
  ADD CONSTRAINT `service_tabs_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

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
