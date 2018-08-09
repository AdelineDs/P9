-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1:3306
-- Généré le :  Jeu 09 Août 2018 à 13:24
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
  `note` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `photos`
--

INSERT INTO `photos` (`id`, `memberId`, `name`, `description`, `url`, `lat`, `lng`, `status`, `note`, `date_added`) VALUES
(1, 1, 'Les calanques', 'les calanques', 'public/img/calanques.jpg', 43.216667, 5.433333, 0, 5, '2018-08-07 16:25:00'),
(2, 1, 'Le Conquet', 'Le Conquet, Finistère', 'public/img/LeConquet.JPG', 48.362595, -4.788442, 1, 4, '2018-08-07 16:39:00'),
(3, 1, 'Lac de Longemer', 'Les lac de longemer dans les vosges', 'public/img/longemer.JPG', 48.067688, 6.954273, 0, 2, '2018-08-07 16:42:00'),
(6, 1, 'Le phare du petit Minou', 'Le phare du petit minous dans le finistère', 'public/img/minou2.JPG', 48.336592, -4.614252, 0, 4, '2018-08-07 17:26:38'),
(7, 1, 'Notre Dame de Paris', 'Notre Dame de Paris', 'public/img/NDdeParis.jpeg', 48.852729, 2.350564, 0, 5, '2018-08-07 17:26:38'),
(8, 1, 'Phare du petit Minou', 'Phare du petit Minou', 'public/img/pharePetitMinou.JPG', 48.336592, -4.614252, 0, 5, '2018-08-07 16:54:00'),
(9, 1, 'Phare du Portzic', 'Le phare du Portzic', 'public/img/pharePortzic.JPG', 48.358303, -4.534028, 0, 4, '2018-08-07 16:55:00'),
(11, 1, 'Strasbourg', 'Strasbourg', 'public/img/strasbourg.jpg', 48.573405, 7.752111, 1, 4, '2018-08-07 16:59:00'),
(12, 1, 'Sainte Yved ', 'Sainte Yved de Baine', 'public/img/StYved.JPG', 49.339510, 3.535375, 0, 3, '2018-08-07 17:26:00'),
(13, 1, 'Toulouse', 'Toulouse la ville rose', 'public/img/toulouse.jpg', 43.604652, 1.444209, 0, 5, '2018-08-07 17:54:00'),
(14, 1, 'La tour Eiffel', 'Tour Eiffel', 'public/img/tourEiffel.jpg', 48.855899, 2.298088, 0, 5, '2018-08-07 17:56:00'),
(15, 1, 'Cathédrale de Troyes', 'A l''intérieur de la cathédrale de Troyes', 'public/img/troyes.JPG', 48.300208, 4.080853, 0, 5, '2018-08-07 18:00:00');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
