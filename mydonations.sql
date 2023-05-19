-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 03:33 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydonations`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `campaign_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `goal_amount` decimal(10,2) DEFAULT NULL,
  `current_amount` decimal(10,2) DEFAULT NULL,
  `deadline_date` date DEFAULT NULL,
  `campaign_status` enum('draft','active','completed') DEFAULT 'active',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`campaign_id`, `user_id`, `title`, `description`, `image`, `goal_amount`, `current_amount`, `deadline_date`, `campaign_status`, `date_created`, `date_updated`) VALUES
(1, 1, 'Aider bobize please', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium nostrum ullam, ducimus vitae, non hic aspernatur in quidem, voluptatem eveniet voluptas ut ab laborum tempore sit sapiente perferendis soluta cum!<br />\r\n<br />\r\nLorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium nostrum ullam, ducimus vitae, non hic aspernatur in quidem, voluptatem eveniet voluptas ut ab laborum tempore sit sapiente perferendis soluta cum!<br />\r\n<br />\r\nLorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium nostrum ullam, ducimus vitae, non hic aspernatur in quidem, voluptatem eveniet voluptas ut ab laborum tempore sit sapiente perferendis soluta cum!<br />\r\nLorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium nostrum ullam, ducimus vitae, non hic aspernatur in quidem, voluptatem eveniet voluptas ut ab laborum tempore sit sapiente perferendis soluta cum!', 'public/img/campaigns/6175dogo.jpg', '9000.00', '0.00', '2023-05-31', 'active', '2023-05-13 00:54:59', '2023-05-19 01:22:53'),
(2, 1, 'Chat bobize hahahah', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium nostrum ullam, ducimus vitae, non hic aspernatur in quidem, voluptatem eveniet voluptas ut ab laborum tempore sit sapiente perferendis soluta cum!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium nostrum ullam, ducimus vitae, non hic aspernatur in quidem, voluptatem eveniet voluptas ut ab laborum tempore sit sapiente perferendis soluta cum!<br />\r\n<br />\r\nLorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium nostrum ullam, ducimus vitae, non hic aspernatur in quidem, voluptatem eveniet voluptas ut ab laborum tempore sit sapiente perferendis soluta cum!', 'public/img/campaigns/1326cat.jpg', '10000.00', '0.00', '2023-05-30', 'active', '2023-05-13 00:55:47', '2023-05-19 01:31:12'),
(3, 1, 'Kitler Byed', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fuga culpa consectetur totam illum consequatur repellat magni sequi voluptatum, placeat quos in. Distinctio, officia. Aut, eum. Quasi suscipit ad numquam quisquam?<br />\r\n<br />\r\nLorem ipsum dolor, sit amet consectetur adipisicing elit. Fuga culpa consectetur totam illum consequatur repellat magni sequi voluptatum, placeat quos in. Distinctio, officia. Aut, eum. Quasi suscipit ad numquam quisquam? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fuga culpa consectetur totam illum consequatur repellat magni sequi voluptatum, placeat quos in. Distinctio, officia. Aut, eum. Quasi suscipit ad numquam quisquam?', 'public/img/campaigns/433hitler.jpg', '80000.00', '0.00', '2023-07-13', 'active', '2023-05-15 04:16:46', '2023-05-15 03:19:44'),
(4, 1, 'Another Kitler Byed', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas minima mollitia illo magni, fugiat id, nulla alias quae dicta similique debitis officia vel corrupti eveniet ea error facere! Porro, saepe.<br />\r\n<br />\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas minima mollitia illo magni, fugiat id, nulla alias quae dicta similique debitis officia vel corrupti eveniet ea error facere! Porro, saepe.Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas minima mollitia illo magni, fugiat id, nulla alias quae dicta similique debitis officia vel corrupti eveniet ea error facere! Porro, saepe.', 'public/img/campaigns/5494byed.jpeg', '10000.00', '0.00', '2023-05-31', 'active', '2023-05-15 04:28:50', '2023-05-15 04:28:50'),
(5, 1, 'AHHHHH', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatem facere ex asperiores, hic odit ullam ratione! Quaerat blanditiis voluptatem rerum quidem, voluptate, explicabo adipisci saepe, deserunt id ipsa eligendi doloremque.<br />\r\n<br />\r\nLorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatem facere ex asperiores, hic odit ullam ratione! Quaerat blanditiis voluptatem rerum quidem, voluptate, explicabo adipisci saepe, deserunt id ipsa eligendi doloremque.', 'public/img/campaigns/9916friend.jpg', '9000.00', '0.00', '2023-05-15', 'active', '2023-05-15 05:08:02', '2023-05-15 05:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_categories`
--

CREATE TABLE `campaign_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL,
  `icon` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campaign_categories`
--

INSERT INTO `campaign_categories` (`category_id`, `category_name`, `icon`, `date_created`, `date_updated`) VALUES
(1, 'Médical', 'fa-regular fa-heart', '2023-05-10 23:51:49', '2023-05-10 23:51:49'),
(2, 'Urgence', 'fa-solid fa-tower-broadcast', '2023-05-10 23:51:49', '2023-05-10 23:51:49'),
(3, 'Éducation', 'fa-solid fa-book-open', '2023-05-10 23:53:15', '2023-05-10 23:53:15'),
(4, 'Famille', 'fa-solid fa-people-group', '2023-05-10 23:53:15', '2023-05-10 23:53:15'),
(5, 'Créative', 'fa-solid fa-palette', '2023-05-10 23:53:47', '2023-05-10 23:53:47'),
(6, 'Sportive', 'fa-solid fa-basketball', '2023-05-10 23:53:47', '2023-05-10 23:53:47'),
(7, 'Environnement', 'fa-solid fa-earth-americas', '2023-05-10 23:54:43', '2023-05-10 23:54:43'),
(8, 'Événement', 'fa-solid fa-award', '2023-05-10 23:54:43', '2023-05-10 23:54:43'),
(9, 'Animaux', 'fa-solid fa-paw', '2023-05-11 00:03:25', '2023-05-11 00:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_category_map`
--

CREATE TABLE `campaign_category_map` (
  `campaign_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campaign_category_map`
--

INSERT INTO `campaign_category_map` (`campaign_id`, `category_id`) VALUES
(1, 1),
(1, 6),
(2, 1),
(2, 5),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(4, 1),
(4, 5),
(4, 6),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `donation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `donation_status` enum('pending','complete','refunded','cancelled') DEFAULT NULL,
  `anonymous_donation` tinyint(1) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `donation_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('processing','complete','declined','refunded') DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `reward_id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `reward_title` varchar(255) DEFAULT NULL,
  `reward_description` text DEFAULT NULL,
  `reward_amount` decimal(10,2) DEFAULT NULL,
  `reward_limit` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `update_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `update_title` varchar(255) DEFAULT NULL,
  `update_text` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rank` enum('0','1','2') NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'public/img/avatars/default.jpg',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `rank`, `avatar`, `date_created`, `date_updated`) VALUES
(1, 'Sabir', 'Baichou', 'sabir.baichou@gmail.com', '$2y$10$.VnplK2im/GNFsNYmZkGNuTCNctFMz.shY6qmuGKvqAyHR0lC53Ja', '2', 'public/img/avatars/default.jpg', '2023-05-03 03:15:12', '2023-05-08 09:21:28'),
(2, 'Salma', 'El Halba', 'salma.elhalba@gmail.com', '$2y$10$3IunwxsDoF0E8qlixiS16u4YUNEIYO8Z.v9zkjuJ/lxWU0nYl.hQW', '2', 'public/img/avatars/default.jpg', '2023-05-03 03:15:36', '2023-05-08 08:15:40'),
(3, 'Mouhammed', 'Al Khabir', 'mouhammad.alkhabir@gmail.com', '$2y$10$BBV1nrgrZ8FmBJ2XkXY.p.fAC0.I6sUvwJBxiQFmAALHy71duOZBe', '0', 'public/img/avatars/default.jpg', '2023-05-03 03:15:52', '2023-05-04 00:44:25'),
(4, 'Amine', 'El Houjaji', 'amine.elhoujaji@gmail.com', '$2y$10$atlZ6EDmJUj1d86BLmjXruQ3d9dQvU7eIbZNS2I4eVFytT5bEmuSu', '0', 'public/img/avatars/default.jpg', '2023-05-03 03:16:05', '2023-05-04 00:44:30'),
(5, 'Adnane', 'Ihrkachen', 'adnane.ihrkachen@gmail.com', '$2y$10$SOF/1pxXCN071zjTqE7Sx.1GsLK7WLG.dBsNFgjk.JqWpnTX29MG2', '0', 'public/img/avatars/default.jpg', '2023-05-08 09:13:40', '2023-05-08 09:13:40'),
(6, 'Salah', 'Saadaoui', 'salah.saadaoui@gmail.com', '$2y$10$L8pqRSdOgM6OCXiZhZw.luIvVRRYo.G4HVDN6Uz/LWAbp8JqHg0Vq', '0', 'public/img/avatars/default.jpg', '2023-05-11 14:30:11', '2023-05-11 14:30:11');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`view`) VALUES
(2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`campaign_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `campaign_categories`
--
ALTER TABLE `campaign_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `campaign_category_map`
--
ALTER TABLE `campaign_category_map`
  ADD PRIMARY KEY (`campaign_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `campaign_id` (`campaign_id`),
  ADD KEY `donation_id` (`donation_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`reward_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`update_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `campaign_categories`
--
ALTER TABLE `campaign_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `campaign_category_map`
--
ALTER TABLE `campaign_category_map`
  ADD CONSTRAINT `campaign_category_map_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`),
  ADD CONSTRAINT `campaign_category_map_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `campaign_categories` (`category_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`);

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`),
  ADD CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`donation_id`) REFERENCES `donations` (`donation_id`);

--
-- Constraints for table `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `rewards_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`);

--
-- Constraints for table `updates`
--
ALTER TABLE `updates`
  ADD CONSTRAINT `updates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `updates_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
