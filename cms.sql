-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2018 at 03:37 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Id` int(3) NOT NULL,
  `Title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Id`, `Title`) VALUES
(1, 'Bootstrap Framework'),
(2, 'Javascript'),
(3, 'PHP'),
(4, 'Java'),
(50, 'Python'),
(52, 'CSS'),
(56, 'jQuery');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `Id` int(3) NOT NULL,
  `Post_Category_Id` int(3) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Image` text NOT NULL,
  `Content` text NOT NULL,
  `Tags` varchar(255) NOT NULL,
  `Comment_Count` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`Id`, `Post_Category_Id`, `Title`, `Author`, `Date`, `Image`, `Content`, `Tags`, `Comment_Count`, `Status`) VALUES
(1, 1, 'Edwin\'s CMS PHP course is awsome', 'Jonh Dough', '2018-09-06', 'image_1.jpg', 'Wow i really really like this course.', 'edwin, php, javascript', 0, 'draft'),
(2, 52, 'Javascript Course Post', 'Belinda', '2018-09-17', 'image_2.jpg', 'Wow man this is really cool post can you call me?', 'Javascript2, course, class, Belina', 0, 'draft'),
(4, 4, 'Javascript yay 2', 'Alexander Mifsud', '2018-09-17', '40084297_1744449952335073_6360448524986875904_n.jpg', 'Content that i added myself.', 'Javascript, course, class, great', 4, 'Draft'),
(5, 50, 'Added post 100', 'Alexander Mifsud', '2018-09-21', 'Images-Hd-Steampunk-Backgrounds.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus accumsan, eros a bibendum bibendum, enim felis viverra mi, eget bibendum urna eros eu arcu. Phasellus finibus laoreet aliquam. Quisque ultricies facilisis elit quis fermentum. Donec et mauris ac felis eleifend faucibus dignissim at felis. Etiam nec finibus mauris, at consequat massa. Vivamus iaculis turpis a maximus mollis. Nulla facilisi. Vivamus fermentum luctus pulvinar. Sed mattis purus eu odio viverra maximus. Fusce quis turpis efficitur, laoreet odio vitae, laoreet augue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed dapibus ante eget bibendum mattis.', 'Python, java, javascript, php', 4, 'Draft');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
