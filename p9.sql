-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1:3306
-- Généré le :  Ven 31 Août 2018 à 13:13
-- Version du serveur :  5.6.34-log
-- Version de PHP :  7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `p9`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `reported` tinyint(4) NOT NULL,
  `comment_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `member_id`, `author`, `comment`, `reported`, `comment_date`) VALUES
(2, 1, 'ReTest', 'Je RE teste les commentaires..........', 2, '2018-08-15 05:59:14'),
(3, 1, 'Adeline', 'test !!!', 1, '2018-08-30 15:04:34');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL,
  `id_photo` int(11) NOT NULL,
  `id_member` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `likes`
--

INSERT INTO `likes` (`id`, `id_photo`, `id_member`) VALUES
(9, 6, 1),
(11, 15, 22),
(13, 3, 22),
(14, 14, 22),
(15, 13, 22),
(18, 9, 1),
(21, 8, 1),
(24, 12, 1),
(25, 3, 1),
(26, 11, 1),
(27, 1, 1),
(29, 7, 1),
(30, 13, 1);

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `idMember` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `avatar_url` varchar(255) NOT NULL,
  `registration_date` date NOT NULL,
  `statusMember` tinyint(4) NOT NULL,
  `reported` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `members`
--

INSERT INTO `members` (`idMember`, `pseudo`, `password`, `email`, `place`, `avatar_url`, `registration_date`, `statusMember`, `reported`) VALUES
(1, 'Adeline', '$2y$10$fCZ6k6WUSWuWsGO4FQbe3uVsXomzQ/vGWJwYPa8GlY00t.m4FDPwG', 'deca.adeline@gmail.com', 'Brest', 'public/avatar/5b86c2cc01cba.png', '2018-08-14', 1, 0),
(22, 'Ambre', '$2y$10$ZBAROchxRMvf33S7wcUTq.Tv6B4VvcB.6lF8lzCriguEMGy6O4bkq', 'mail@mail.com', '', '', '2018-08-15', 0, 1),
(23, 'MembreTest', '$2y$10$2pnhAbRPpEFvLo1VjRFHou19/PgxC59Sw.2hi.GTufRCw2ohgVHHK', 'monmail@mail.com', 'Loin', 'public/avatar/5b893d5b21378.jpg', '2018-08-31', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL,
  `memberId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `likes` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `photos`
--

INSERT INTO `photos` (`id`, `memberId`, `name`, `description`, `url`, `lat`, `lng`, `status`, `likes`, `date_added`) VALUES
(1, 22, 'Les calanques', 'Près de Marseille', 'public/img/calanques.jpg', 43.000000, 50.000000, 0, 6, '2018-08-07 16:25:00'),
(2, 1, 'Le Conquet', 'Le Conquet, Finistère, Bretagne... ', 'public/img/LeConquet.JPG', 48.362595, -4.788442, 0, 11, '2018-08-07 16:39:00'),
(3, 1, 'Lac de Longemer', 'Les lac de longemer dans les vosges', 'public/img/longemer.JPG', 48.067688, 6.954273, 0, 10, '2018-08-07 16:42:00'),
(6, 1, 'Le phare du petit Minou', 'Le phare du petit minou dans le finistère', 'public/img/minou2.JPG', 48.336592, -4.614252, 0, 5, '2018-08-07 17:26:38'),
(7, 22, 'Notre Dame de Paris', 'Notre Dame de Paris', 'public/img/NDdeParis.jpeg', 48.852729, 2.350564, 0, 11, '2018-08-07 17:26:38'),
(8, 1, 'Phare du petit Minou', 'Phare du petit Minou', 'public/img/pharePetitMinou.JPG', 48.336592, -4.614252, 0, 6, '2018-08-07 16:54:00'),
(9, 1, 'Phare du Portzic', 'Le phare du Portzic', 'public/img/pharePortzic.JPG', 48.358303, -4.534028, 0, 7, '2018-08-07 16:55:00'),
(11, 22, 'Strasbourg', 'Strasbourg', 'public/img/strasbourg.jpg', 48.573405, 7.752111, 1, 1, '2018-08-07 16:59:00'),
(12, 1, 'Sainte Yved ', 'Sainte Yved de Braine', 'public/img/StYved.JPG', 49.339510, 3.535375, 0, 4, '2018-08-07 17:26:00'),
(13, 22, 'Toulouse', 'Toulouse la ville rose', 'public/img/toulouse.jpg', 43.604652, 1.444209, 0, 7, '2018-08-07 17:54:00'),
(14, 22, 'La tour Eiffel', 'Tour Eiffel', 'public/img/tourEiffel.jpg', 48.855899, 2.298088, 0, 9, '2018-08-07 17:56:00'),
(15, 1, 'Cathédrale de Troyes', 'A l''intérieur de la cathédrale de Troyes', 'public/img/troyes.JPG', 48.300208, 4.080853, 0, 1, '2018-08-07 18:00:00'),
(17, 1, 'Petit port', 'Près de Brest...', 'public/img/5b7ac4cb75d8b.jpg', 48.351506, -4.570553, 0, 0, '2018-08-20 15:40:27'),
(18, 1, 'Vue sur mer', 'Finistère ...', 'public/img/5b7ac73b088ff.jpg', 48.329857, -4.770867, 0, 0, '2018-08-20 15:50:51'),
(19, 1, 'Pointe Saint-Mathieu', 'dans le Finistère', 'public/img/5b7f9cf411df7.jpg', 48.329857, -4.770867, 1, 0, '2018-08-24 07:51:48');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`idMember`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `members`
--
ALTER TABLE `members`
  MODIFY `idMember` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
