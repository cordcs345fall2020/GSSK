SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `friend`
--

CREATE TABLE `friend` (
  `id` int(11) NOT NULL,
  `a` int(11) NOT NULL,
  `b` int(11) NOT NULL,
  `friends` tinyint(1) NOT NULL DEFAULT 0,
  `added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`id`, `a`, `b`, `friends`, `added`) VALUES
(8, 8, 8, 1, '2020-11-05 01:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `from`, `to`, `message`, `status`, `sent`) VALUES
(26, 8, 6, '?!', 0, '2020-11-06 01:35:18'),
(27, 8, 6, 'Hello', 0, '2020-11-06 01:35:48'),
(28, 8, 6, 'Create', 0, '2020-11-06 01:36:00'),
(29, 6, 8, 'wHAT IS UP', 0, '2020-11-06 01:36:57'),
(30, 8, 6, 'Hi', 0, '2020-11-06 01:38:11'),
(31, 8, 6, '?', 0, '2020-11-06 01:39:06'),
(32, 6, 8, 'wHAT IS UP', 0, '2020-11-06 01:40:43'),
(33, 8, 6, 'Testing', 0, '2020-11-06 01:42:00'),
(34, 8, 6, 'Hello?', 0, '2020-11-06 01:42:30'),
(35, 6, 8, 'wHAT IS UP', 0, '2020-11-06 01:42:41'),
(36, 8, 6, '?', 0, '2020-11-06 01:43:24'),
(37, 8, 6, 'Hello', 0, '2020-11-06 01:46:01'),
(38, 8, 6, 'Hello', 0, '2020-11-06 01:46:31'),
(39, 8, 6, 'Test', 0, '2020-11-06 01:46:55');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(70) NOT NULL,
  `session` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
