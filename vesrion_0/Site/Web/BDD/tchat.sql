-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 16 déc. 2020 à 13:57
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet web`
--

-- --------------------------------------------------------

--
-- Structure de la table `tchat`
--

CREATE TABLE `tchat` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tchat`
--

INSERT INTO `tchat` (`id`, `pseudo`, `message`, `date`) VALUES
(1, 'Mom', '[b]b entre crochet et /b entre crochet[/b][br/]\r\n[i]i entre crochet texte et /i etre crochet[/i][br/]\r\n[m]m entre crochet texte et /m etre crochet[/m][br/]\r\n[color=blue]entre crochet color=blue + text + entre crochet /color[/color][br/]\r\nbr/ entre crochet => fait un routre à ligne', '2020-12-16');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tchat`
--
ALTER TABLE `tchat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tchat`
--
ALTER TABLE `tchat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
