-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2018 at 03:35 PM
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
(56, 'jQuery'),
(57, 'Al\'s Category');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Id` int(3) NOT NULL,
  `Post_Id` int(3) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `Date` date NOT NULL,
  `Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Id`, `Post_Id`, `Author`, `Email`, `Content`, `Date`, `Status`) VALUES
(1, 1, 'Alex Mifsud', 'alexm.1496@gmail.com', 'This is just an example', '2018-09-24', 'approved'),
(3, 1, 'Sarah', 'sarah@gmail.com', 'I simply love this cms!', '2018-09-24', 'approved'),
(4, 4, 'Test', 'test@test.com', 'sgbdjhkgbljkdbngdlkj', '2018-09-24', 'approved'),
(5, 1, 'Nathan', 'nateDrake69@gmail.com', 'Enter new comment here.', '2018-09-24', 'approved'),
(6, 1, 'Aidrian', 'adz@gmial.com', 'This should be comment number 5 ', '2018-09-24', 'unapproved'),
(7, 4, 'Aidrian', 'adz@gmial.com', 'This should be comment 5', '2018-09-24', 'unapproved');

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
(1, 1, 'Edwin\'s CMS PHP course is awsome', 'Jonh Dough', '2018-09-24', 'image_1.jpg', 'Wow i really really like this course.', 'edwin, php, javascript', 1, 'draft'),
(2, 52, 'Javascript Course Post', 'Belinda', '2018-09-24', 'image_2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam dictum sollicitudin augue, in pretium sem pulvinar ut. Proin lacinia libero id felis molestie lacinia. Integer tortor sem, volutpat ut porta sit amet, auctor a purus. Suspendisse sit amet maximus tortor, et porta lorem. Maecenas at sapien a enim facilisis iaculis. Duis viverra elementum lacus quis euismod. Nunc elit erat, mollis venenatis porttitor eu, tincidunt in magna.', 'Javascript2, course, class, Belina', 0, 'published');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `role` varchar(255) NOT NULL,
  `randSalt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `username`, `password`, `firstname`, `lastname`, `email`, `image`, `role`, `randSalt`) VALUES
(1, 'rico', '123', 'Rico', 'Suave', 'ricosuave@gmail.com', '', 'subscriber', ''),
(9, 'alexanderm.1496@gmail.com', 'qwerty789', 'Clarence', 'PotatoHead', 'clarencepotatote@gmail.com', '', 'subscriber', ''),
(10, 'BigWillyPete69', 'somepassword123', 'William', 'Peterson', 'peterson343@gmail.com', '', 'subscriber', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
