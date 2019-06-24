-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2019 at 06:31 PM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.17-1+ubuntu18.04.1+deb.sury.org+3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ChiefsRS`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `message`) VALUES
(1, 'Jay Varan', 'testingforproject0@gmail.com', 'Hello Chiefs RS Team I want to share that this is amazing site you have created.'),
(2, 'Jay Varan', 'testingforproject0@gmail.com', 'Hello Chiefs RS Team I want to share that this is amazing site you have created.'),
(3, 'Jay Varan', 'testingforproject0@gmail.com', 'Hello Chiefs RS Team I want to share that this is amazing site you have created.'),
(4, 'ASAS', 'testingforproject0@gmail.com', 'test test test test test est test test test test'),
(10, 'ASAS', 'rutusha1212joshi@gmail.com', 'wqwq'),
(12, 'Rutusha Joshi', 'rutusha1212joshi@gmail.com', 'Rutusha Here i want to convey something.'),
(13, 'Rutusha Joshi', 'rutusha1212joshi@gmail.com', 'Rutusha Here i want to convey something.'),
(14, 'Rutu Joshi', 'joshi.rutusha@gmail.com', 'Testing Email for contact us of Chiefs RS.'),
(15, 'Rutusha', 'rutusha1212joshi@gmail.com', 'Testing testing testing testing'),
(16, 'Kavi Joshi', 'kavijoshi8888@gmail.com', 'Hi I am Kavi Joshi I am PHP Developer.'),
(17, 'Rutu Joshi', 'joshi.rutusha@gmail.com', 'rrrrrrrrrrrrrrrrrrrrrrrrrr rrrrrrrrrrrrrrrrrrr rrrrrrrrrrrrrrrrrrrr rrrrrrrrrrrrrrrrrrrr rrrrrrrrrrrrrrrr rrrrrrrrrrrrrr rrrrrrrrrrrrrrrrr rrrrrrrrrrrrrrrrrr rrrrrrrrrrrrr rrrrrrrrrrrrrrr rrrrrrrrrrrrrrrr rrrrrrrrr'),
(18, 'Shahrukh Khan', 'imsrk@gmail.com', 'Hi This is Shahrukh Khan and I am  SRK the king khan.'),
(19, 'Karan Joshi', 'joshi.rutusha@gmail.com', 'This is an testing Email of contact us page.'),
(20, 'Rajwadu', 'rutush@hmkkkss.com', 'asdasdsad');

-- --------------------------------------------------------

--
-- Table structure for table `device_details`
--

CREATE TABLE `device_details` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `device_tocken` varchar(6000) DEFAULT NULL,
  `type` enum('0','1') NOT NULL,
  `gcm_id` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_details`
--

INSERT INTO `device_details` (`id`, `user_id`, `device_tocken`, `type`, `gcm_id`, `created_at`) VALUES
(1, 3, 'APA91bH5NJVttJXKC04OA36UDykn8RUIwtbci', '0', '', '2019-05-15 12:48:54'),
(2, 2, 'APA91bH5NJVttJXKC04OA36UDykn8RUIwtbciU6Y9t0Yg5GikL7RLz1aUIagVb9d8kPJJxqVOcCe8o9Ai67xrrXRDonlHl_R7id-p-uKbl8Gkr6NsehbqE8', '1', '', '2019-06-07 12:33:55');

-- --------------------------------------------------------

--
-- Table structure for table `email_format`
--

CREATE TABLE `email_format` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=In-Active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_format`
--

INSERT INTO `email_format` (`id`, `title`, `subject`, `body`, `status`, `created_at`, `updated_at`) VALUES
(1, 'forgot_password', 'Forgot Password', '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:20px 0 20px 0\" align=\"center\" valign=\"top\"><!-- [ header starts here] -->\r\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" bgcolor=\"FFFFFF\" border=\"0\" width=\"650\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p><a href=\"{logo_front_url}\"><img style=\"\" src=\"{logo_img_url}\" alt=\"ChiefsRS\" title=\"Chiefs RS\"></a></p><p></p><p></p></td>\r\n                    </tr>\r\n                    <!-- [ middle starts here] -->\r\n                    <tr>\r\n                        <td valign=\"top\">\r\n                        <p>Dear  {username},</p>  \r\n                        <p>Your New Password is :<br></p><p><strong>E-mail:</strong> {email}<br>     \r\n                         </p><p><strong>Password:</strong> {password}<br>    \r\n                        \r\n                        </p><p>&nbsp;</p>\r\n                        </td>\r\n                    </tr>\r\n                   <tr>\r\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\r\n                        <p style=\"font-size:12px; margin:0;\">Chiefs RS Team</p>\r\n                        </center></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 1, '2013-09-08 00:00:00', NULL),
(2, 'user_registration', 'Chiefs RS -New Account', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\r\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background:#444444; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p><a href=\"{logo_front_url}\"><img style=\"\" src=\"{logo_img_url}\" alt=\"ChiefsRS\" title=\"Chiefs RS\"></a></p><p></p><p></p></td>\r\n                    </tr>\r\n                    <!-- [ middle starts here] -->\r\n                    <tr>\r\n                        <td valign=\"top\">\r\n                        <p>Dear  {username},</p>  \r\n                        <p>Your account has been created.Please use below credential :<br></p>\r\n                          <p><strong>Url:</strong> <a href=\"{loginurl}\">{loginurl}</a><br></p>\r\n                          <p><strong>E-mail:</strong> {email} <br></p>\r\n<p><strong>Password:</strong> {password} <br></p>\r\n                        <p></p><p>&nbsp;</p>\r\n                        </td>\r\n                    </tr>\r\n                   <tr>\r\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\r\n                        <p style=\"font-size:12px; margin:0;\">Chiefs RS Team</p>\r\n                        </center></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 1, '2013-09-08 00:00:00', NULL),
(3, 'reset_password', 'Reset Password', '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:20px 0 20px 0\" align=\"center\" valign=\"top\"><!-- [ header starts here] -->\r\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" bgcolor=\"FFFFFF\" border=\"0\" width=\"650\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p><a href=\"{logo_front_url}\"><img style=\"\" src=\"{logo_img_url}\" alt=\"chiefsRS\" title=\"chiefsRS\"></a></p><p></p><p></p></td>\r\n                    </tr>\r\n                    <!-- [ middle starts here] -->\r\n                    <tr>\r\n                        <td valign=\"top\">\r\n                        <p>Dear  {username},</p>  \r\n                        <p>Follow the link below to reset your password:</p>\r\n                        <p>{resetLink}</p>\r\n                        \r\n                        </p><p>&nbsp;</p>\r\n                        </td>\r\n                    </tr>\r\n                   <tr>\r\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\r\n                        <p style=\"font-size:12px; margin:0;\">ChiefsRS Team</p>\r\n                        </center></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 1, '2013-09-08 00:00:00', NULL),
(4, 'contact_us', 'Chiefs RS Contact', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\r\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background:#444444; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p><a href=\"{logo_front_url}\"><img style=\"\" src=\"{logo_img_url}\" alt=\"ChiefsRS\" title=\"Chiefs RS\"></a></p><p></p><p></p></td>\r\n                    </tr>\r\n                    <!-- [ middle starts here] -->\r\n                    <tr>\r\n                        <td valign=\"top\">\r\n                        <p>Hello  Chiefs RS Admin,\r\n                        <p>{message}<br></p>\r\n                        <p></p><p>&nbsp;</p>\r\n                        </td>\r\n                    </tr>\r\n                   <tr>\r\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\r\n                        <p style=\"font-size:12px; margin:0;\">{name}</p>\r\n                        </center></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 1, '2013-09-08 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint(20) NOT NULL,
  `reservation_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) NOT NULL,
  `offset_id` bigint(20) DEFAULT NULL COMMENT 'project-id,milestone-id,task-id',
  `table_name` varchar(255) DEFAULT NULL,
  `action_type` varchar(255) DEFAULT NULL,
  `field_name` varchar(255) DEFAULT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `new_value` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `status` tinyint(6) NOT NULL COMMENT '"0"=In Active "1" = Active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BreakFast', 'BreakFast', 1, '2019-05-06 14:18:37', '2019-06-03 07:57:21'),
(2, 'Lunch', 'Lunch', 1, '2019-05-06 14:22:03', '2019-06-03 07:57:35'),
(3, 'Dinner', 'Dinner', 1, '2019-05-08 11:45:06', '2019-06-03 07:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_no` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `layout_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `booking_start_time` time NOT NULL,
  `booking_end_time` time NOT NULL,
  `total_stay_time` int(11) DEFAULT NULL,
  `no_of_guests` int(11) NOT NULL,
  `pickup_drop` enum('0','1') NOT NULL DEFAULT '0',
  `pickup_location` varchar(255) DEFAULT NULL,
  `pickup_lat` float DEFAULT NULL,
  `pickup_long` float DEFAULT NULL,
  `pickup_time` time DEFAULT NULL,
  `drop_location` varchar(255) DEFAULT NULL,
  `drop_lat` float DEFAULT NULL,
  `drop_long` float DEFAULT NULL,
  `drop_time` time DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `special_comment` text,
  `status` tinyint(8) NOT NULL COMMENT '"0"="requested","1"="booked","2"="cancelled","3"="deleted","4"="completed","5"="seated"',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `first_name`, `last_name`, `email`, `contact_no`, `user_id`, `restaurant_id`, `layout_id`, `table_id`, `date`, `booking_start_time`, `booking_end_time`, `total_stay_time`, `no_of_guests`, `pickup_drop`, `pickup_location`, `pickup_lat`, `pickup_long`, `pickup_time`, `drop_location`, `drop_lat`, `drop_long`, `drop_time`, `tag_id`, `special_comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 'q', 'w', 'qw', 0, 22, 12, NULL, NULL, '2019-06-12', '08:00:00', '10:00:00', 60, 5, '1', 'test', NULL, NULL, '02:30:00', 'test', NULL, NULL, '01:30:00', NULL, 'tst', 0, '2019-06-10 08:18:29', '2019-06-12 07:03:30'),
(5, 'TEst', 'test', 'test@test.com', 7878787878, 22, 9, NULL, NULL, '2019-06-13', '16:00:00', '17:30:00', 90, 8, '0', '', NULL, NULL, '00:00:00', '', NULL, NULL, '00:00:00', NULL, 'test', 2, '2019-06-11 08:12:37', '2019-06-11 10:55:07'),
(6, 'test', 'tst', 'test@test.com', 4545454545, 22, 9, NULL, NULL, '2019-06-12', '12:00:00', '13:00:00', 60, 8, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'test', 0, '2019-06-11 13:48:41', '2019-06-11 13:48:41'),
(7, 'test', 'tst', 'test@test.com', 544444444, 22, 8, NULL, NULL, '2019-06-25', '01:30:00', '01:30:00', 60, 8, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rrrrrrrrrrr', 0, '2019-06-11 14:10:57', '2019-06-11 14:10:57'),
(8, 'test', 'tst', 'rwerwe@df.juu', 4545454545, 22, 22, NULL, NULL, '2019-06-22', '02:00:00', '01:30:00', 60, 8, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yyyyyyy', 0, '2019-06-11 14:13:08', '2019-06-11 14:28:22'),
(9, 'test', 'tst', 'rwerwe@df.juu', 4545454545, 22, 12, NULL, NULL, '2019-06-19', '01:00:00', '01:30:00', 60, 5, '1', 'test', NULL, NULL, '00:30:00', 'test', NULL, NULL, '08:00:00', NULL, 'trrr', 0, '2019-06-12 07:04:10', '2019-06-12 07:05:11'),
(10, 'test', 'tst', 'rwerwe@df.juu', 0, 22, 12, NULL, NULL, '2019-06-26', '02:00:00', '03:30:00', 60, 8, '1', 'test', NULL, NULL, '01:30:00', 'test', NULL, NULL, '04:30:00', NULL, 'teeee', 0, '2019-06-12 07:06:21', '2019-06-12 07:06:21'),
(11, 'q', 'w', 'rwerwe@df.juu', 4545454545, 22, 12, NULL, NULL, '2019-06-27', '02:00:00', '02:30:00', 60, 8, '1', 'test', NULL, NULL, '01:30:00', 'test', NULL, NULL, '01:30:00', NULL, 'test', 0, '2019-06-12 07:13:04', '2019-06-12 07:13:04'),
(12, 'krisha', 'Joshi', 'krisha@gmail.com', 8787878787, 22, 14, NULL, NULL, '2019-06-20', '16:26:00', '17:21:00', 60, 5, '1', 'test', NULL, NULL, '20:00:00', 'test', NULL, NULL, '22:30:00', 5, 'Please arrange birthday cake and Decorations.', 1, '2019-06-18 11:39:59', '2019-06-20 16:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `photo` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `lattitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contact_no` bigint(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `max_stay_time_after_reservation` int(11) NOT NULL,
  `status` tinyint(6) NOT NULL DEFAULT '1' COMMENT '''0'':''Active,''1'':''In-Active''',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `description`, `photo`, `address`, `city`, `state`, `country`, `pincode`, `lattitude`, `longitude`, `website`, `contact_no`, `email`, `max_stay_time_after_reservation`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, 'Rajwadu', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum', 'drink-9_5d075859a97ec.jpg', 'Nr. Jivraj Tolnaka, Behind Ambaji Temple, Malav Talav, Lavanya Society, Vasna, Ahmedabad, Gujarat 380007, India', ' Ahmedabad', 'Gujarat', ' India', 380007, 23.0041, 72.5397, 'test.com', 4567890890, 'rutush@hmkkkss.com', 50, 1, 2, 8, '2019-05-09 07:07:51', '2019-06-17 09:07:37'),
(8, 'The Gorthan Thal', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum', 'menu_1_5cee6f4aac038.jpg', 'Ground Floor, Sapath Complex, Opp. Rajpath Club, Sarkhej - Gandhinagar Hwy, Bodakdev, Highway Park Society, Bodakdev, Ahmedabad, Gujarat 380052, India', ' Ahmedabad', 'Gujarat', ' India', 380052, 23.0359, 72.5112, 'testing.com', 6767676767, 'tesss@test.com', 40, 1, 2, 8, '2019-05-14 08:28:35', '2019-05-30 12:42:16'),
(9, 'saffron', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum', 'offer_3_5cee6f2de0aea.jpg', 'Seville, Spain', 'undefined', 'undefined', ' Spain', 395009, 37.3891, -5.98446, 'www.saffron.com', 6765665666, 'saffron@gmail.com', 50, 1, 8, 8, '2019-05-29 11:30:13', '2019-05-30 12:41:46'),
(10, 'The Grand Bhagvati', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'menu_3_5cefa96e69a9f.jpg', 'TGB Rd, TGB, Hariom Nagar Society,Adajan Gam, Atman Park, L.P.Savani, Surat, Gujarat 395009, India', ' Surat', 'Gujarat', ' India', 395009, 21.1937, 72.7841, 'www.tgb.com', 4568989898, 'tgb@gmail.com', 40, 1, 8, 8, '2019-05-30 09:59:10', '2019-05-30 12:43:48'),
(11, 'Pakwan Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'offer_1_5cefa9f18d3ad.jpg', 'Bodakdev, Ahmedabad, Gujarat 380054, India', ' Ahmedabad', 'Gujarat', ' India', 380054, 23.0383, 72.5114, 'www.pakwan.com', 8989898989, 'pakwan@gmail.com', 60, 1, 8, 8, '2019-05-30 10:01:21', '2019-05-30 12:43:58'),
(12, 'Dinner Bell Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'offer_3_5cefaa69a82d0.jpg', '1st Floor, Atlantis Enclave, Above ICICI Bank & YES Bank, Gurukul, Subhash Chowk, Memnagar, Ahmedabad, Gujarat 380052, India', ' Ahmedabad', 'Gujarat', ' India', 380052, 23.0524, 72.535, 'www.dinnerbell.com', 7876565656, 'dinnerbell@gmail.com', 45, 1, 8, 8, '2019-05-30 10:03:21', '2019-05-30 12:44:09'),
(13, 'Patang Hotel', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'menu_2_5cefbf0c344ff.jpg', 'Patang, near Don Bosco College, NH2, Maram, Manipur 795015, India', ' Maram', 'Manipur', ' India', 795015, 25.405, 94.0969, 'www.patang.com', 6545678908, 'patang@gmail.com', 60, 1, 8, 8, '2019-05-30 11:31:24', '2019-05-30 12:44:20'),
(14, 'Domino\'s Pizza', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'maxresdefault_5cefd1a47e9af.jpg', 'A1 Amrapali Axiom, Sardar Patel Ring Rd, Ambli, Ahmedabad, Gujarat 380058, India', ' Ahmedabad', 'Gujarat', ' India', 380058, 23.0267, 72.477, 'dominos.com', 6765665668, 'dominos@gmail.com', 50, 1, 8, 8, '2019-05-30 12:50:44', '2019-05-30 12:52:05'),
(15, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(16, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(17, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(18, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(19, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(20, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(21, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(22, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(23, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(24, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(25, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(26, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(27, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(28, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(29, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(30, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(31, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(32, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(33, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(34, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(35, 'Honest Restaurant', '\"Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum.', 'honest_5cefd7dd57bf6.jpeg', '201, 2nd Floor, Circle P Complex, Near Auda Garden, Sarkhej - Gandhinagar Hwy, Prahlad Nagar, Ahmedabad, Gujarat 380015, India', ' Ahmedabad', 'Gujarat', ' India', 380015, 23.0115, 72.503, 'www.honest.com', 4554578787, 'honest@gmail.com', 50, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(36, 'test', 'tt test test test test test test test', 'maxresdefault_5d073e95e57d0.jpg', 'Temecula, CA, USA', 'Temecula', 'CA', ' USA', 343434, 33.4936, -117.148, 'tttt.tt.com', 5645656565, 'tets@taa.uu', 50, 1, 8, 8, '2019-06-17 07:17:41', '2019-06-17 07:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_feedback`
--

CREATE TABLE `restaurant_feedback` (
  `id` int(11) NOT NULL,
  `feedback_description` int(11) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_gallery`
--

CREATE TABLE `restaurant_gallery` (
  `id` bigint(20) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  `image_description` text NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `status` tinyint(6) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_gallery`
--

INSERT INTO `restaurant_gallery` (`id`, `restaurant_id`, `image_title`, `image_description`, `image_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(10, 2, 'asAS', 'AS', 'BMS_5cd2d40727a2b.png', 1, 2, 2, '2019-05-08 13:04:30', '2019-05-08 13:05:11'),
(11, 2, 'asda', 'asdasd', 'Wells Fargo_5cd2d3e95e53e.png', 1, 2, 2, '2019-05-08 13:04:41', '2019-05-08 13:04:41'),
(12, 2, 'dasd', 'sadasd', 'State of AR_5cd2d3f40a676.jpg', 1, 2, 2, '2019-05-08 13:04:52', '2019-05-08 13:04:52'),
(13, 7, 'TEST', 'TEST', 'drink-6_5cecd62b7e8c9.jpg', 1, 2, 8, '2019-05-11 13:44:33', '2019-05-29 14:19:32'),
(14, 8, 'test', 'test', 'location2_5cdd341239818.jpg', 1, 2, 2, '2019-05-16 09:57:38', '2019-05-16 09:57:38'),
(15, 8, 'test3', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(16, 8, 'test3', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(17, 8, 'test3', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(18, 7, 'test3', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(19, 7, 'test4', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(20, 7, 'test5', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(21, 7, 'test6', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(22, 7, 'test7', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(23, 7, 'test8', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(24, 7, 'test9', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(25, 7, 'test10', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50'),
(26, 7, 'test11', 'test3', 'location2_5cdd341e76b98.jpg', 1, 2, 2, '2019-05-16 09:57:50', '2019-05-16 09:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_layouts`
--

CREATE TABLE `restaurant_layouts` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `status` tinyint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_layouts`
--

INSERT INTO `restaurant_layouts` (`id`, `restaurant_id`, `name`, `created_by`, `updated_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 'First Floor', 2, 2, 1, '2019-05-16 06:37:33', '2019-05-16 09:34:14'),
(2, 8, 'Second Floor', 2, 2, 1, '2019-05-16 07:12:16', '2019-05-16 07:12:16'),
(3, 8, 'Third Floor', 2, 2, 1, '2019-05-16 09:34:09', '2019-05-16 09:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_menu`
--

CREATE TABLE `restaurant_menu` (
  `id` bigint(20) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `menu_category_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `status` tinyint(6) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_menu`
--

INSERT INTO `restaurant_menu` (`id`, `restaurant_id`, `name`, `description`, `menu_category_id`, `price`, `photo`, `created_by`, `updated_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 7, 'Salted Fried Chicken', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 35.5, 'drink-3_5cecd6e47b740.jpg', 2, 8, 1, '2019-05-16 09:56:35', '2019-06-03 10:52:58'),
(2, 7, 'Italian Sauce Mushroom', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 24.5, 'drink-9_5cf4fcc072ae0.jpg', 8, 8, 1, '2019-06-03 10:56:00', '2019-06-03 10:56:00'),
(3, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 20, 'pizza-5_5cf4fcf09a1de.jpg', 8, 8, 1, '2019-06-03 10:56:48', '2019-06-03 10:56:48'),
(4, 7, 'Italian Sauce Mushroom', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 45.5, 'pizza-8_5cf4fd5aa12c1.jpg', 8, 8, 1, '2019-06-03 10:58:34', '2019-06-03 10:58:34'),
(5, 7, 'Salted Fried Chicken', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 12.4, 'pizza-7_5cf4fda4e58e3.jpg', 8, 8, 1, '2019-06-03 10:59:48', '2019-06-03 10:59:48'),
(6, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(7, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(8, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(9, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(10, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(11, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(12, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(13, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(14, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(15, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(16, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(17, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(18, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(19, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(20, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(21, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(22, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(23, 7, 'Fried Potato w/ Garlic', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 1, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-03 11:00:40'),
(24, 7, 'test', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 2, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-04 06:13:06'),
(25, 7, 'test', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 2, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-04 06:12:57'),
(26, 7, 'test', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.', 2, 18.5, 'burger-1_5cf4fdd8b52f1.jpg', 8, 8, 1, '2019-06-03 11:00:40', '2019-06-04 06:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_tables`
--

CREATE TABLE `restaurant_tables` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `min_capacity` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `status` tinyint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_tables`
--

INSERT INTO `restaurant_tables` (`id`, `restaurant_id`, `layout_id`, `table_no`, `name`, `min_capacity`, `max_capacity`, `created_by`, `updated_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 2, 1, 'Special table', 6, 10, 2, 2, 1, '2019-05-16 09:22:22', '2019-05-16 09:22:22'),
(2, 8, 1, 1, 'Testing Table', 12, 16, 2, 2, 1, '2019-05-16 09:27:57', '2019-05-17 09:19:31'),
(3, 8, 1, 2, 'Testing Table 2', 4, 6, 2, 2, 1, '2019-05-16 09:33:20', '2019-05-16 09:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_working_hours`
--

CREATE TABLE `restaurant_working_hours` (
  `id` bigint(20) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `hours24` tinyint(2) DEFAULT NULL,
  `weekday` int(11) NOT NULL,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `status` tinyint(6) NOT NULL COMMENT '''0''=Closed, ''1'' = Open',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_working_hours`
--

INSERT INTO `restaurant_working_hours` (`id`, `restaurant_id`, `hours24`, `weekday`, `opening_time`, `closing_time`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 1, '06:00:00', '10:30:00', 1, 2, 2, '2019-05-14 08:44:13', '2019-05-16 09:42:59'),
(2, 7, 1, 2, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 08:45:29', '2019-05-16 09:43:00'),
(3, 7, 1, 3, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 08:45:29', '2019-05-16 09:43:00'),
(4, 7, 0, 4, '07:00:00', '12:00:00', 1, 2, 2, '2019-05-14 08:45:29', '2019-05-16 09:43:00'),
(5, 7, 1, 5, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 08:45:29', '2019-05-16 09:43:00'),
(6, 7, 1, 6, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 08:45:29', '2019-05-16 09:43:00'),
(7, 7, 1, 7, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 08:45:29', '2019-05-16 09:43:00'),
(8, 8, 1, 1, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 09:13:53', '2019-05-14 09:13:53'),
(9, 8, 1, 2, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 09:13:53', '2019-05-14 09:13:53'),
(10, 8, 1, 3, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 09:13:53', '2019-05-14 09:13:53'),
(11, 8, 1, 4, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 09:13:54', '2019-05-14 09:13:54'),
(12, 8, 1, 5, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 09:13:54', '2019-05-14 09:13:54'),
(13, 8, 1, 6, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 09:13:54', '2019-05-14 09:13:54'),
(14, 8, 1, 7, '00:00:00', '23:59:00', 1, 2, 2, '2019-05-14 09:13:54', '2019-05-14 09:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `restaurent_meal_times`
--

CREATE TABLE `restaurent_meal_times` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `meal_type` int(11) NOT NULL COMMENT '"1"= BreakFast,"2"=Lunch,"3" = Dinner',
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` tinyint(6) NOT NULL DEFAULT '1' COMMENT '"0"=active,"1"=In Active',
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurent_meal_times`
--

INSERT INTO `restaurent_meal_times` (`id`, `restaurant_id`, `meal_type`, `start_time`, `end_time`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 7, 1, '12:30:00', '02:30:00', 1, 2, 8, '2019-05-09 07:07:51', '2019-05-29 12:00:39'),
(2, 7, 2, '07:00:00', '15:30:00', 1, 2, 2, '2019-05-09 07:07:51', '2019-05-13 09:19:02'),
(3, 7, 3, '18:00:00', '23:55:00', 1, 2, 2, '2019-05-09 07:07:51', '2019-05-13 09:19:06'),
(4, 8, 1, NULL, NULL, 1, 2, 2, '2019-05-14 08:28:35', '2019-05-14 08:28:35'),
(5, 8, 2, NULL, NULL, 1, 2, 2, '2019-05-14 08:28:35', '2019-05-14 08:28:35'),
(6, 8, 3, NULL, NULL, 1, 2, 2, '2019-05-14 08:28:35', '2019-05-14 08:28:35'),
(7, 9, 1, '08:00:00', '11:00:00', 1, 8, 8, '2019-05-29 11:30:14', '2019-05-29 11:32:04'),
(8, 9, 2, '12:00:00', '15:30:00', 1, 8, 8, '2019-05-29 11:30:14', '2019-05-29 11:31:12'),
(9, 9, 3, '18:00:00', '23:30:00', 1, 8, 8, '2019-05-29 11:30:14', '2019-05-29 11:32:45'),
(10, 10, 1, NULL, NULL, 1, 8, 8, '2019-05-30 09:59:10', '2019-05-30 09:59:10'),
(11, 10, 2, NULL, NULL, 1, 8, 8, '2019-05-30 09:59:10', '2019-05-30 09:59:10'),
(12, 10, 3, NULL, NULL, 1, 8, 8, '2019-05-30 09:59:10', '2019-05-30 09:59:10'),
(13, 11, 1, NULL, NULL, 1, 8, 8, '2019-05-30 10:01:21', '2019-05-30 10:01:21'),
(14, 11, 2, NULL, NULL, 1, 8, 8, '2019-05-30 10:01:21', '2019-05-30 10:01:21'),
(15, 11, 3, NULL, NULL, 1, 8, 8, '2019-05-30 10:01:21', '2019-05-30 10:01:21'),
(16, 12, 1, NULL, NULL, 1, 8, 8, '2019-05-30 10:03:21', '2019-05-30 10:03:21'),
(17, 12, 2, NULL, NULL, 1, 8, 8, '2019-05-30 10:03:21', '2019-05-30 10:03:21'),
(18, 12, 3, NULL, NULL, 1, 8, 8, '2019-05-30 10:03:21', '2019-05-30 10:03:21'),
(19, 13, 1, NULL, NULL, 1, 8, 8, '2019-05-30 11:31:24', '2019-05-30 11:31:24'),
(20, 13, 2, NULL, NULL, 1, 8, 8, '2019-05-30 11:31:24', '2019-05-30 11:31:24'),
(21, 13, 3, NULL, NULL, 1, 8, 8, '2019-05-30 11:31:24', '2019-05-30 11:31:24'),
(22, 14, 1, NULL, NULL, 1, 8, 8, '2019-05-30 12:50:44', '2019-05-30 12:50:44'),
(23, 14, 2, NULL, NULL, 1, 8, 8, '2019-05-30 12:50:45', '2019-05-30 12:50:45'),
(24, 14, 3, NULL, NULL, 1, 8, 8, '2019-05-30 12:50:45', '2019-05-30 12:50:45'),
(25, 15, 1, NULL, NULL, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(26, 15, 2, NULL, NULL, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(27, 15, 3, NULL, NULL, 1, 2, 2, '2019-05-30 13:17:17', '2019-05-30 13:17:17'),
(28, 36, 1, NULL, NULL, 1, 8, 8, '2019-06-17 07:17:41', '2019-06-17 07:17:41'),
(29, 36, 2, NULL, NULL, 1, 8, 8, '2019-06-17 07:17:42', '2019-06-17 07:17:42'),
(30, 36, 3, NULL, NULL, 1, 8, 8, '2019-06-17 07:17:42', '2019-06-17 07:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `review_count` enum('1','2','3','4','5') NOT NULL,
  `review_title` varchar(255) NOT NULL,
  `review_description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(6) NOT NULL COMMENT '"0"=active,"1"=In Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test1222444', 'test', 1, NULL, '2019-05-29 14:11:38'),
(2, 'testing123444', 'testing123', 1, NULL, '2019-05-10 12:57:42'),
(3, 'test22222222222', '222222222222222222', 1, '2019-05-10 12:43:58', '2019-05-10 12:43:58'),
(4, 'teeesssssrttt', 'teet', 1, '2019-05-10 12:46:25', '2019-05-10 12:57:51'),
(5, 'test8888', 'test8888', 1, '2019-05-10 12:52:33', '2019-05-10 12:52:33'),
(6, 'testtttttttttttttttttttttttt', 'test', 1, '2019-05-10 12:53:08', '2019-05-29 14:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `address` text,
  `contact_no` bigint(20) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `is_code_verified` enum('0','1') DEFAULT '0',
  `password_reset_token` text,
  `badge_count` int(8) DEFAULT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1' COMMENT '''0'':''Active,''1'':''In-Active''',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `password`, `first_name`, `last_name`, `address`, `contact_no`, `restaurant_id`, `verification_code`, `is_code_verified`, `password_reset_token`, `badge_count`, `auth_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'testingforproject0@gmail.com', '9267a47fa59d5d96e2641b148825a0e8', 'Super', 'Admin', 'test', NULL, NULL, NULL, '1', '', 0, '', 1, '2019-05-03 10:09:57', '2019-05-03 11:21:09'),
(2, 3, 'rutusha1212jdddoshi@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Rutu', 'Joshi', 'Test 123', NULL, NULL, NULL, '1', '', 0, '', 1, '2019-05-03 12:09:08', '2019-06-07 12:33:55'),
(3, 5, 'jay.varan@zenocraft.com', '3a6096f3e070927602cbdc6d4796b7e9', 'Jay', 'Varan', 'Jay@Zenocraft', NULL, NULL, NULL, '1', '', 0, '', 1, '2019-05-03 13:03:04', '2019-05-20 12:59:26'),
(4, 4, 'rocks.avatar@gmail.com', 'afae5317a938fd4d6f24e14d6350faa3', 'Rocks', 'Avatar4', 'rocks@zenocraft', NULL, NULL, NULL, '1', '', 0, '', 1, '2019-05-03 13:06:26', '2019-05-10 12:02:32'),
(5, 4, 'testing@123.com', 'a421e6b1f4ef36ee345db8db566d6b02', 'test', 'user', 'testing data', NULL, NULL, NULL, '1', '', 0, '', 1, '2019-05-03 13:06:26', '2019-05-10 12:02:26'),
(6, 2, 'asaS@DSF.Hsdasdsad', 'cc479122636e68efd263c52148188088', 'Rutusha', 'aeqwe', 'qeqwewqe', NULL, 7, NULL, '1', '', 0, '', 1, '2019-05-14 13:50:37', '2019-05-14 13:50:37'),
(7, 3, 'weq@dgf.df', '830da998cd2ebf09cf59672b92c45224', 'rrr', 'rrrr', 'rrrrrrrrrrrr', NULL, 8, NULL, '1', '', 0, '', 1, '2019-05-14 13:51:07', '2019-05-14 14:08:47'),
(8, 2, 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'test', 'test', 'admin', NULL, 8, NULL, '1', '', 0, '', 1, '2019-05-17 09:30:22', '2019-05-17 09:30:22'),
(16, 5, '388883caba9ee7622a77c4e8ba435f86', 'admin', 'rutusha', 'jOSHI', 'test', NULL, NULL, NULL, '0', NULL, NULL, '0a690d039e388a9ccf5cf25f7e4450d9', 1, '2019-05-20 14:23:31', '2019-05-28 06:52:11'),
(17, 5, 'darshit@admin.com', '47c70eae0d6bdff878bcaf9c60ee55af', 'ASAS', 'DD', '47c70eae0d6bdff878bcaf9c60ee55af', NULL, NULL, NULL, '0', NULL, NULL, NULL, 1, '2019-05-28 09:56:15', '2019-05-28 09:56:15'),
(18, 5, 'eee@eee.vom', 'ebe1b49e3c01a7ed012ed737235fcc3b', 'wee', 'ee', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, 1, '2019-05-28 11:45:22', '2019-05-28 11:45:22'),
(19, 5, 'dd@dd.uuu', '415f5c12cd45d6eb9ecc269510ee75d2', 'vdfgdfgdsf', 'dsf', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, 1, '2019-05-28 11:47:20', '2019-05-28 11:47:20'),
(20, 5, 'rutusha1s212joshi@gmail.com', '341cd7d301d7f5125c895332ce90fdeb', 'SDSA', 'ddd', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, 1, '2019-05-28 14:01:26', '2019-05-28 14:01:26'),
(21, 5, 'avatar.rocks@gmail.com', '341cd7d301d7f5125c895332ce90fdeb', 'fff', 'ff', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, 1, '2019-05-28 14:10:33', '2019-05-28 14:10:33'),
(22, 5, 'rutusha1212joshi@gmail.com', '0192023a7bbd73250516f069df18b500', 'Rutusha', 'Joshi', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, 1, '2019-05-28 14:17:48', '2019-05-28 14:17:48'),
(23, 5, 'test@123.com', 'cc03e747a6afbbcbf8be7668acfebee5', 'test', 'testing', NULL, 1234567890, NULL, NULL, '0', NULL, NULL, NULL, 1, '2019-06-03 06:52:50', '2019-06-03 06:52:50'),
(24, 5, 'test@sss.com', 'cc03e747a6afbbcbf8be7668acfebee5', 'tede', 'teetst', 'asdsad', 1234567899, NULL, NULL, '0', NULL, NULL, NULL, 0, '2019-06-03 06:56:58', '2019-06-14 08:05:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role_name`, `role_description`) VALUES
(1, 'super_admin', 'Super Admin'),
(2, 'admin', 'Administrator'),
(3, 'manager', 'Manager'),
(4, 'supervisor', 'Hotel Supervisor'),
(5, 'customer', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `user_rules`
--

CREATE TABLE `user_rules` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `privileges_controller` varchar(255) NOT NULL,
  `privileges_actions` text NOT NULL,
  `permission` enum('allow','deny') NOT NULL DEFAULT 'allow',
  `permission_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_rules`
--

INSERT INTO `user_rules` (`id`, `role_id`, `privileges_controller`, `privileges_actions`, `permission`, `permission_type`) VALUES
(1, 1, 'SiteController', 'index,logout,change-password,forgot-password', 'allow', 'super_admin'),
(2, 2, 'SiteController', 'index,logout,change-password,forgot-password', 'allow', 'admin'),
(3, 3, 'SiteController', 'index,logout,change-password,forgot-password', 'allow', 'manager'),
(4, 4, 'SiteController', 'index,logout,change-password,forgot-password', 'allow', 'supervisor'),
(5, 1, 'UsersController', 'index,create,update,view,delete', 'allow', 'super_admin'),
(6, 2, 'UsersController', 'index,create,update,view,delete', 'allow', 'admin'),
(7, 1, 'TagsController', 'index,create,update,view,delete', 'allow', 'super_admin'),
(8, 2, 'TagsController', 'index,create,update,view,delete', 'allow', 'admin'),
(9, 1, 'menu-categoriesController', 'index,create,update,view,delete', 'allow', 'super_admin'),
(10, 2, 'menu-categoriesController', 'index,create,update,view,delete', 'allow', 'admin'),
(11, 1, 'RestaurantsController', 'index,create,update,view,delete', 'allow', 'super_admin'),
(12, 2, 'RestaurantsController', 'index,create,update,view,delete,test,update-workinghours', 'allow', 'admin'),
(13, 3, 'RestaurantsController', 'index,create,update,view,delete', 'allow', 'manager'),
(14, 1, 'restaurants-galleryController', 'index,create,update,view,delete', 'allow', 'super_admin'),
(15, 2, 'restaurants-galleryController', 'index,create,update,view,delete', 'allow', 'admin'),
(16, 3, 'restaurants-galleryController', 'index,create,update,view,delete', 'allow', 'manager'),
(17, 1, 'restaurant-menuController', 'index,create,update,view,delete', 'allow', 'super_admin'),
(18, 2, 'restaurant-menuController', 'index,create,update,view,delete', 'allow', 'admin'),
(19, 3, 'restaurant-menuController', 'index,create,update,view,delete', 'allow', 'manager'),
(20, 1, 'restaurant-meal-timesController', 'index,update,view', 'allow', 'super_admin'),
(21, 2, 'restaurant-meal-timesController', 'index,update,view', 'allow', 'admin'),
(22, 3, 'restaurant-meal-timesController', 'index,update,view', 'allow', 'manager'),
(23, 1, 'restaurant-working-hoursController', 'index,update,view', 'allow', 'super_admin'),
(24, 2, 'restaurant-working-hoursController', 'index,create,update,view', 'allow', 'admin'),
(25, 3, 'restaurant-working-hoursController', 'index,update,view', 'allow', 'manager'),
(26, 1, 'restaurant-layoutController', 'create,update,delete,index', 'allow', 'super_admin'),
(27, 2, 'restaurant-layoutController', 'create,update,delete,index', 'allow', 'admin'),
(28, 3, 'restaurant-layoutController', 'create,update,delete,index', 'allow', 'manager'),
(29, 5, 'SiteController', 'index,logout,change-password,forgot-password', 'allow', 'customer'),
(30, 5, 'UsersController', 'logout,book', 'allow', 'customer'),
(31, 5, 'reservationsController', 'create,index,update,view,cancel,delete', 'allow', 'customer'),
(32, 1, 'ReservationsController', 'index,view', 'allow', 'super_admin'),
(33, 2, 'ReservationsController', 'index,view', 'allow', 'admin'),
(34, 3, 'ReservationsController', 'index,view', 'allow', 'manager'),
(35, 1, 'contact-usController', 'index,view', 'allow', 'super_admin'),
(36, 2, 'contact-usController', 'index,view', 'allow', 'admin'),
(37, 3, 'contact-usController', 'index,view', 'allow', 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `user_rules_menu`
--

CREATE TABLE `user_rules_menu` (
  `id` int(10) NOT NULL,
  `category` enum('admin','front-top','front-bottom','front-middle') NOT NULL DEFAULT 'admin',
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `user_rules_id` int(10) NOT NULL,
  `label` varchar(255) NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `position` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 - inactive, 1 - active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_rules_menu`
--

INSERT INTO `user_rules_menu` (`id`, `category`, `parent_id`, `user_rules_id`, `label`, `class`, `url`, `position`, `status`) VALUES
(1, 'admin', 0, 1, 'Dashboard', 'icon-home', 'site/index', 1, 1),
(2, 'admin', 0, 2, 'Dashboard', 'icon-home', 'site/index', 1, 1),
(3, 'admin', 0, 3, 'Dashboard', 'icon-home', 'site/index', 1, 1),
(4, 'admin', 0, 4, 'Dashboard', 'icon-home', 'site/index', 1, 1),
(5, 'admin', 0, 5, 'Manage Users', '', 'users/index', 2, 1),
(6, 'admin', 0, 6, 'Manage Users', '', 'users/index', 2, 1),
(7, 'admin', 0, 7, 'Manage Tags', '', 'tags/index', 3, 1),
(8, 'admin', 0, 8, 'Manage Tags', '', 'tags/index', 3, 1),
(9, 'admin', 0, 9, 'Manage Menus Category', '', 'menu-categories/index', 4, 1),
(10, 'admin', 0, 10, 'Manage Menus Category', '', 'menu-categories/index', 4, 1),
(11, 'admin', 0, 11, 'Manage Restaurants', '', 'restaurants/index', 5, 1),
(12, 'admin', 0, 12, 'Manage Restaurants', '', 'restaurants/index', 5, 1),
(13, 'admin', 0, 13, 'Manage Restaurants', '', 'restaurants/index', 2, 1),
(14, 'admin', 0, 35, 'Manage Contact Us', '', 'contact-us/index', 6, 1),
(15, 'admin', 0, 36, 'Manage Contact Us', '', 'contact-us/index', 6, 1),
(16, 'admin', 0, 37, 'Manage Contact Us', '', 'contact-us/index', 6, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `device_details`
--
ALTER TABLE `device_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`user_id`);

--
-- Indexes for table `email_format`
--
ALTER TABLE `email_format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `layout_id` (`layout_id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `status` (`status`),
  ADD KEY `tags` (`tag_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_feedback`
--
ALTER TABLE `restaurant_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `restaurant_gallery`
--
ALTER TABLE `restaurant_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `restaurant_layouts`
--
ALTER TABLE `restaurant_layouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `menu_category_id` (`menu_category_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `layout_id` (`layout_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `status` (`status`),
  ADD KEY `updatedby` (`updated_by`);

--
-- Indexes for table `restaurant_working_hours`
--
ALTER TABLE `restaurant_working_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `restaurent_meal_times`
--
ALTER TABLE `restaurent_meal_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_rules`
--
ALTER TABLE `user_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_rules_menu`
--
ALTER TABLE `user_rules_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_rules_id` (`user_rules_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `device_details`
--
ALTER TABLE `device_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `email_format`
--
ALTER TABLE `email_format`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `restaurant_feedback`
--
ALTER TABLE `restaurant_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_gallery`
--
ALTER TABLE `restaurant_gallery`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `restaurant_layouts`
--
ALTER TABLE `restaurant_layouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `restaurant_working_hours`
--
ALTER TABLE `restaurant_working_hours`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `restaurent_meal_times`
--
ALTER TABLE `restaurent_meal_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_rules`
--
ALTER TABLE `user_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `user_rules_menu`
--
ALTER TABLE `user_rules_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `layout` FOREIGN KEY (`layout_id`) REFERENCES `restaurant_layouts` (`id`),
  ADD CONSTRAINT `restaurant` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`),
  ADD CONSTRAINT `tables` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`id`),
  ADD CONSTRAINT `tags` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`),
  ADD CONSTRAINT `users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `restaurant_feedback`
--
ALTER TABLE `restaurant_feedback`
  ADD CONSTRAINT `userid` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `restaurant_layouts`
--
ALTER TABLE `restaurant_layouts`
  ADD CONSTRAINT `created by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `restautrant_id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `updated by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  ADD CONSTRAINT ` createdby` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `menu category id` FOREIGN KEY (`menu_category_id`) REFERENCES `menu_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurent_id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD CONSTRAINT `createdby` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `layout_id` FOREIGN KEY (`layout_id`) REFERENCES `restaurant_layouts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurant id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `updatedby` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `restaurant_working_hours`
--
ALTER TABLE `restaurant_working_hours`
  ADD CONSTRAINT `r id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurent_meal_times`
--
ALTER TABLE `restaurent_meal_times`
  ADD CONSTRAINT `created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `restaurant_id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
