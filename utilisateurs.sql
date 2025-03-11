-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 11 mars 2025 à 13:40
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crudphp`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `login`, `password`, `profil`) VALUES
(14, 'sow', 'Amadou ka', 'amadousow39@gmail.com', '$2y$10$E384LJMO7378fjCqLCML1.al85dQSEdrjx3WSXqUC0E/5w/hDXHrO', 'C:/Users/mague/OneDrive/Desktop/image/profil_67c8db0b51f315.52803463.jpg'),
(15, 'Thiam', 'Moustapha', 'moustaphathiam23@gmail.com', '$2y$10$jRvHyXHOSqXNcdUDkf2Nye/74YIse8ZeMFrFf/OriYwuvXLh6Ru9O', 'C:/Users/mague/OneDrive/Desktop/image/profil_67ca11954c2c63.85387995.jpg'),
(16, 'niang', 'maguette', 'maguetteniang037@gmail.com', '$2y$10$r50VRZj3/.CyXnguymzGkuJfjtWAXg7PMi4zfPIWWVA25LtQ26DQO', 'C:/Users/mague/OneDrive/Desktop/image/profil_67ca12fb59b898.14148349.jpg'),
(17, 'Ba', 'coumba', 'coumba23@gmail.com', '$2y$10$ll3/nicBK/Et1571XTIgz.UI1e0i2eAHiDVviLecL8yqdaWuIZU8i', 'C:/Users/mague/OneDrive/Desktop/image/profil_67ca134f710c39.44676359.jpg'),
(18, 'sy', 'Elhadj Bayel', 'elhadjsy@gmail.com', '$2y$10$O0Yejyp01VcF5bPCuDZaFuin66xNXVxIqQxQskyYuyI3AW6R0Sl0G', 'C:/Users/mague/OneDrive/Desktop/image/profil_67cb65b32622f6.03537476.jpg'),
(19, 'diop', 'Malick', 'malickdiop3@gmail.com', '$2y$10$10PhEf8fyOBMYInb78rYeuP1ygPR13d4BmA9mbCGVjIa9Lyc9VAD2', 'C:/Users/mague/OneDrive/Desktop/image/profil_67d025206a4779.15380189.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
