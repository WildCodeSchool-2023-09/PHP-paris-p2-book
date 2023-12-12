-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 22 nov. 2023 à 15:26
-- Version du serveur : 8.0.28
-- Version de PHP : 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mybookshelf`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `id` int NOT NULL,
  `firstname` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Unknown',
  `lastname` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`id`, `firstname`, `lastname`) VALUES
(1, 'Victor', 'Hugo'),
(2, 'Mona', 'Chollet'),
(3, 'J.K', 'Rowling'),
(4, 'Laurent', 'Gounelle'),
(5, 'Jacques', 'Expert'),
(6, 'Karine', 'Giebel'),
(7, 'J.R.R', 'Tolkien'),
(8, 'Anthony', 'Horowitz'),
(9, 'Olivier', 'Heurtel'),
(10, 'Anne-Sophie', 'Girard'),
(11, 'Fedor', 'Dostoïevski'),
(12, 'Didier', 'Van Cauwelaert');

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id` int NOT NULL,
  `title` varchar(150) NOT NULL,
  `written_at` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `title`, `written_at`) VALUES
(1, 'Le dernier jour d\'un condamné', '0000'),
(2, 'Chez soi', '2015'),
(3, 'Harry Potter et la Chambre des Secrets', '2000'),
(4, 'Le philosophe qui n\'était pas sage', '2018'),
(5, 'La théorie des six', '2014'),
(6, 'Tu me plais', '2019'),
(7, 'Meurtres pour rédemption', '2007'),
(8, 'Le Seigneur des Anneaux : la Communauté de l\'Anneau', '1996'),
(9, 'Le Seigneur des Anneaux : les deux tours', '2000'),
(10, 'L\'île du crâne', '2004'),
(11, 'PHP 8', '2009'),
(12, 'Un esprit bof dans un corps pas ouf', '2020'),
(13, 'L\'idiot', '0000'),
(14, 'Le retour de Jules', '2000');

-- --------------------------------------------------------

--
-- Structure de la table `book_author`
--

CREATE TABLE `book_author` (
  `book_id` int NOT NULL,
  `author_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `book_author`
--

INSERT INTO `book_author` (`book_id`, `author_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 5),
(7, 6),
(8, 7),
(9, 7),
(10, 8),
(11, 9),
(12, 10),
(13, 11),
(14, 12);

-- --------------------------------------------------------

--
-- Structure de la table `book_editor`
--

CREATE TABLE `book_editor` (
  `id` int NOT NULL,
  `book_id` int NOT NULL,
  `editor_id` int NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `synopsis` text NOT NULL,
  `nb_pages` int NOT NULL,
  `cover` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `published_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `book_editor`
--

INSERT INTO `book_editor` (`id`, `book_id`, `editor_id`, `isbn`, `synopsis`, `nb_pages`, `cover`, `published_at`) VALUES
(1, 1, 1, '31043924037', 'Un homme, bien trop jeune pour mourir, s\'adresse à nous. Jugé, emprisonné, enchaîné, il a attendu sa grâce, mais elle lui a été refusée. Tout est fini. Bientôt, il montera dans la charrette et traversera la foule hideuse. La guillotine apparaîtra alors et son supplice sera cent fois pire que son crime. C\'est écrit, la société le veut, la loi l\'exige : avant la fin du jour, sa tête tombera dans la sciure.\r\nAvec lui nous vivons ce cauchemar, cette absurdité horrifiante de la peine capitale que personne avant Victor Hugo n\'avait songé à dénoncer.', 221, '61Dia9UUcML._SL1329_.jpg', 2001),
(2, 2, 2, '31043924544', 'La maison, le chez-soi : de ce sujet, on a souvent l\'impression qu\'il n\'y a rien à dire. Pourtant, la maison est aussi une base arrière où l\'on peut se protéger, refaire ses forces, se souvenir de ses désirs, résister à l\'éparpillement et à la dissolution. Un bel essai, intelligent et sensible, par l\'auteure de Beauté fatale.', 355, '71pL4ikmTvL._SL1215_.jpg', 2017),
(3, 3, 3, '31043924548', 'Une rentrée fracassante en voiture volante, une étrange malédiction qui s\'abat sur les élèves, cette deuxième année à l\'école des sorciers ne s\'annonce pas de tout repos ! Entre les cours de potions magiques, les matchs de Quidditch et les combats de mauvais sorts, Harry et ses amis Ron et Hermione trouveront-ils le temps de percer le mystère de la Chambre des Secrets ?', 523, '91cX-rB4dPL._SL1500_.jpg', 2002),
(4, 4, 1, '31043924035', 'Une tribu au cœur de la forêt tropicale, reconnue peuple le plus heureux de la terre. Survient Sandro, jeune philosophe. Poussé par une vengeance personnelle, il fait le vœu de détruire l’équilibre de ses habitants et de les rendre malheureux à vie. Il va devoir affronter Elianta, une jeune femme qui se bat pour lui résister, déterminée à protéger son peuple. « La forêt tropicale semblait retenir son souffle dans la chaleur moite du crépuscule. Assise devant l\'entrée de sa hutte, Élianta tourna les yeux vers Sandro qui s\'avançait. Pourquoi ce mystérieux étranger, que l\'on disait philosophe, s\'acharnait-il à détruire secrètement la paix et la sérénité de sa tribu ? Elle ne reconnaissait plus ses proches, ne comprenait plus leurs réactions... Qu\'avaient-ils fait pour mériter ça ? D\'heure en heure, Élianta sentait monter en elle sa détermination à protéger son peuple. Jamais elle ne laisserait cet homme jouer avec le bonheur des siens. »', 367, '71fUNDLUxUL._SL1311_.jpg', 2022),
(5, 5, 4, '54849489845', 'Selon la «théorie des six», énoncée en 1929 par le Hongrois Frigyes Karinthy, tout individu sur terre peut être relié à n\'importe quel autre par une chaîne de connaissances ne comptant pas plus de cinq intermédiaires. Ainsi, chacun de nous est à six poignées de main de n\'importe quel habitant du fin fond de la Mongolie-Extérieure.\r\n°Cet auteur ne s\'attendait certainement pas à ce que sa théorie devienne un jour le mode opératoire d\'un tueur en série. Julien Dussart lance pourtant ce défi à la police : il annonce qu\'il a décidé de tuer «quelqu\'un» et que la seule façon de l\'arrêter consiste à comprendre sa logique.\r\nQui sera la sixième cible ? La réponse à cette énigme permettrait au commissaire divisionnaire Sophie Pont de sauver les cinq premières victimes. Enfin... quatre. Le premier cadavre est retrouvé, le jeu peut commencer...', 898, 'la_theorie_des_six-254858-264-432.jpg', 2015),
(6, 6, 4, '1656841555', 'Quand, par une succession de hasards, Vincent se retrouve assis face à Stéphanie sur la ligne 1 du métro parisien, la scène a tout d’une belle rencontre. La jeune femme tombe immédiatement sous son charme ; lui, semble fasciné par le galbe et la finesse de son cou. Mais ce coup de foudre pourrait bien se révéler fatal... Car, sous ses airs enjôleurs, Vincent dissimule de terrifiantes pulsions. Hasard de l’existence ou force du destin, comment sauver Stéphanie des griffes de ce funeste séducteur ?', 577, '8mBkNWaWJ-wbm.jpg', 2020),
(7, 7, 5, '1209987771', 'Marianne, vingt ans. Les miradors comme unique perspective, les barreaux pour seul horizon. Perpétuité pour cette meurtrière. Une vie entière à écouter les grilles s\'ouvrir puis se refermer. Indomptable, incapable de maîtriser la violence qui est en elle, Marianne refuse de se soumettre, de se laisser briser par l\'univers carcéral sans pitié où elle affronte la haine, les coups, les humiliations. Aucun espoir de fuir cet enfer. Ou seulement dans ses rêves les plus fous. Elle qui s\'évade parfois, grâce à la drogue, aux livres, au bruit des trains. Grâce à l\'amitié et à la passion qui l\'atteignent en plein cœur de l\'enfermement. Pourtant, un jour, l\'inimaginable se produit. Une porte s\'ouvre. On lui propose une libération... conditionnelle. \" La liberté Marianne, tu dois en rêver chaque jour, chaque minute, non ? \" Oui. Mais le prix à payer est terrifiant. Pour elle qui n\'aspire qu\'à la rédemption...', 238, 'BmNE29L21-gbm.jpg', 2008),
(8, 8, 1, '31043924544', 'Aux temps reculés qu\'évoque le récit, la Terre est peuplée d\'innombrables créatures étranges. Les Hobbits, apparentés à l\'Homme, mais proches également des Elfes et des Nains, vivent en paix au nord-ouest de l\'Ancien Monde, dans la Comté. Paix précaire et menacée, cependant, depuis que Bilbon Sacquet a dérobé au monstre Gollum l\'Anneau de Puissance jadis forgé par Sauron de Mordor. Car cet anneau est doté d\'un pouvoir immense et maléfique. Il permet à son détenteur de se rendre invisible et lui confère une autorité sans limites sur les possesseurs des autres Anneaux. Bref, il fait de lui le Maître du Monde. C\'est pourquoi Sauron s\'est juré de reconquérir l\'Anneau par tous les moyens. Déjà ses Cavaliers Noirs rôdent aux frontières de la Comté.', 1023, 'volbPgx3W-wbm.jpg', 1998),
(9, 9, 1, '1645456465', 'Dispersée dans les terres de l\'Ouest, la Communauté de l\'Anneau affronte les périls de la guerre, tandis que Frodon, accompagné du fidèle Samsagace, poursuit une quête presque désespérée : détruire l\'Anneau, unique en le jetant dans les crevasses d\'Oradruir, a Montagne du destin. Mais aux frontières du royaume de Mordor, une mystérieuse créature les épie... Pour les perdre ou pour les sauver ?', 987, '00Pov2VlR-olm.jpg', 2001),
(10, 10, 4, '4668488747', 'David Eliot vient d\'être renvoyé du collège et cette fois ses parents ont décidé de sévir ! Il se retrouve dans une école bien étrange, sur la sinistre île du crâne, au large de l\'Angleterre. Très vite, il soupçonne le pire. Mais il est encore loin de la vérité...', 368, 'OQEwJ78b1-wbl.jpg', 2007),
(11, 11, 6, '8497878554', 'Ce livre sur PHP 8 (en version 8.0 au moment de l\'écriture) s\'adresse aux concepteurs et développeurs qui souhaitent utiliser PHP pour développer un site web dynamique et interactif.\r\nAprès une présentation des principes de base du langage, l\'auteur se focalise sur les besoins spécifiques du développement de sites dynamiques et interactifs et s\'attache à apporter des réponses précises et complètes aux problématiques habituelles (gestion des formulaires, accès aux bases de données, gestion des sessions, envoi de courriers électroniques...). Les nouveautés de la version 8 qui méritent une attention particulière sont clairement signalées tout au long du livre.\r\nPour toutes les fonctionnalités détaillées, de nombreux exemples de code sont présentés et commentés. En complément, cet ouvrage propose plusieurs exercices destinés à vous permettre de mettre en pratique les connaissances acquises dans les différents chapitres. Ce livre didactique, à la fois complet et synthétique, vous permet d\'aller droit au but ; c\'est l\'ouvrage idéal pour se lancer sur PHP.', 365, '71dXzhgGzAL._SL1500_.jpg', 2012),
(12, 12, 7, '15546446486', 'Aujourd\'hui, nous devons constamment être positifs et chercher à nous améliorer, travailler à devenir \"la meilleure version de nous-mêmes\", afin d\'être heureux, beaux, riches et en bonne santé, tout ça grâce au \"pouvoir magique de la volonté\", parce que \"si on veut, on peut\" et que \"sky is the limit\"... Et si tout ça était faux ? Et si nous n\'avions pas de \"potentiel infini\" ? Et si notre exigence était tout simplement en train de nous rendre tous très malheureux ? Un esprit bof dans un corps pas ouf est un livre de développement personnel qui nous invite à être moins exigeants et à nous libérer de ces injonctions au bonheur qui nous pourrissent la vie. Portée par une lucidité désarmante, Anne-Sophie Girard nous offre ici un guide à contre-courant qui va radicalement changer notre vision des choses et de nous-mêmes.', 687, '61AQGcF8WVL._SL1240_.jpg', 2021),
(13, 13, 4, '645445457789', 'Le prince Muichkine arrive à Saint-Pétersbourg. Idiot de naissance parce qu\'incapable d\'agir, il est infiniment bon. Projeté dans un monde cupide, arriviste et passionnel, il l\'illumine de son regard. Par sa générosité, tel le Christ, Léon Nicolaïevitch révélera le meilleur enfoui en chacun. La trop belle Anastasia, achetée cent mille roubles, retrouve la pureté, Gania Yvolguine le sens de l\'honneur, et le sanglant Rogojine goûte, un instant, la fraternité. Dostoïevski voulait représenter l\'homme positivement bon. Mais que peut-il face aux vices de la société, face à la passion ? Récit admirablement composé, riche en rebondissements extraordinaires, L\'Idiot est à l\'image de la Sainte Russie, vibrant et démesuré. Manifeste politique et credo de l\'auteur, son oeuvre a été et restera un livre phare, car son héros est l\'homme tendu vers le bien mais harcelé par le mal.\r\nEdition commentée par Louis Martinez.', 423, '61PdZyh5jIL._SL1257_.jpg', 1980),
(14, 14, 4, '31043924548', 'Guide d’aveugle au chômage depuis qu’Alice a recouvré la vue, Jules s’est reconverti en chien d’assistance pour épileptiques. Il a retrouvé sa fierté, sa raison de vivre. Il est même tombé amoureux de Victoire, une collègue de travail. Et voilà que, pour une raison aberrante, les pouvoirs publics le condamnent à mort. Alice et moi n’avons pas réussi à protéger notre couple ; il nous reste vingt-quatre heures pour sauver notre chien.\r\nAu cœur des tourments amoureux affectant les humains comme les animaux, Didier van Cauwelaert nous entraîne dans un suspense endiablé, où se mêlent l’émotion et la drôlerie qui ont fait l’immense succès de Jules.', 116, '81vsmTdZtyL._SL1500_.jpg', 2006);

-- --------------------------------------------------------

--
-- Structure de la table `book_genre`
--

CREATE TABLE `book_genre` (
  `book_id` int NOT NULL,
  `genre_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `book_genre`
--

INSERT INTO `book_genre` (`book_id`, `genre_id`) VALUES
(1, 21),
(2, 8),
(3, 2),
(4, 19),
(5, 28),
(6, 28),
(7, 28),
(8, 2),
(9, 1),
(10, 12),
(11, 9),
(12, 20),
(13, 19),
(14, 5);

-- --------------------------------------------------------

--
-- Structure de la table `editor`
--

CREATE TABLE `editor` (
  `id` int NOT NULL,
  `label` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `editor`
--

INSERT INTO `editor` (`id`, `label`) VALUES
(1, 'Pocket'),
(2, 'La Découverte'),
(3, 'Folio Junior'),
(4, 'Le Livre de Poche'),
(5, '1221'),
(6, 'ENI'),
(7, 'Flammarion');

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id` int NOT NULL,
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `label`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(3, 'Bibliography'),
(4, 'Biography'),
(5, 'Comedy'),
(6, 'Cookbook'),
(7, 'Epic'),
(8, 'Essay'),
(9, 'Encyclopedic'),
(10, 'Fabulation'),
(11, 'Fantasy'),
(12, 'Folklore'),
(13, 'Historical'),
(14, 'Horror'),
(15, 'Journalistic'),
(16, 'Mystery'),
(17, 'Paranoid'),
(18, 'Pastoral'),
(19, 'Philosophical'),
(20, 'Political'),
(21, 'Realist'),
(22, 'Religious'),
(23, 'Romance'),
(24, 'Satire'),
(25, 'Science fiction'),
(26, 'Social'),
(27, 'Theatre'),
(28, 'Thriller'),
(29, 'Travel'),
(30, 'Western'),
(31, 'Action'),
(32, 'Adventure'),
(33, 'Bibliography'),
(34, 'Biography'),
(35, 'Comedy'),
(36, 'Cookbook'),
(37, 'Epic'),
(38, 'Essay'),
(39, 'Encyclopedic'),
(40, 'Fabulation'),
(41, 'Fantasy'),
(42, 'Folklore'),
(43, 'Historical'),
(44, 'Horror'),
(45, 'Journalistic'),
(46, 'Mystery'),
(47, 'Paranoid'),
(48, 'Pastoral'),
(49, 'Philosophical'),
(50, 'Political'),
(51, 'Realist'),
(52, 'Religious'),
(53, 'Romance'),
(54, 'Satire'),
(55, 'Science fiction'),
(56, 'Social'),
(57, 'Theatre'),
(58, 'Thriller'),
(59, 'Travel'),
(60, 'Western');

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

CREATE TABLE `review` (
  `id` int NOT NULL,
  `book_editor_id` int NOT NULL,
  `user_id` int NOT NULL,
  `note` tinyint NOT NULL,
  `difficulty` tinyint NOT NULL,
  `opinion` text,
  `reading_time` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `review`
--

INSERT INTO `review` (`id`, `book_editor_id`, `user_id`, `note`, `difficulty`, `opinion`, `reading_time`, `created_at`) VALUES
(1, 2, 3, 4, 3, 'Quel livre ! Cela m\'a tant appris !', '2023-05', '2023-11-22 14:22:38'),
(2, 3, 2, 5, 2, 'J\'ai adoré comment Harry Potter a tué Tom Jédusor ! L\'histoire était magnifique !', '2016-06', '2023-11-22 14:24:42'),
(3, 4, 2, 4, 4, 'Laurent Gounelle quitte la psychologie et le développement personnel pour la philosophie (au sens large).\r\nIl nous emmène dans une aventure forestière avec une tribu d\'Amazonie.\r\nLecture facile et agréable, scénario sans grande surprise mais efficace.\r\nDes personnages avec une certaine épaisseur et attachants.', '2023-01', '2023-11-22 14:26:52'),
(4, 5, 5, 4, 2, 'Il s\'agit de l\'un des premiers polars de Jacques Expert et il est généralement considéré comme l\'un de ses moins réussis par les critiques. Pour ce qui me concerne, je ne suis pas de cet avis. Si l\'intrigue est convenue à la base, la manière de l\'auteur de l\'aborder est particulière et j\'ai passé un moment de lecture divertissant. Tout d\'abord, le fait d\'utiliser la théorie des six de Frigyes Karynthi est assez originale pour mettre en scène des meurtres en série. de même, faire du coupable le narrateur principal de l\'histoire, le suivre dans ses crimes odieux et surtout suivre ses réflexions de déséquilibré pourvu d\'une intelligence remarquable et d\'un sens de l\'ironie en prime', '2017-12', '2023-11-22 14:29:47'),
(5, 7, 2, 3, 2, 'un roman noir, un coup de poing au goût de sang qui vous percute dès les premières pages.', '2020-01', '2023-11-22 14:33:49'),
(6, 9, 4, 5, 2, 'C\'est quand même dingue, quand on y pense.\r\nJe connais l\'histoire par cœur. J\'ai lu l\'ancienne traduction il y a 35 ans pour la première fois, puisque mon père possédait ces livres dans son immense bibliothèque, en poches, avec Asimov, Van Vogt, Vance, aux côtés des œuvres complètes de V. Hugo, Rimbaud, Anouilh et plein d\'autres reliées cuir, merci papa.', '2012-08', '2023-11-22 14:38:34'),
(7, 11, 5, 3, 4, 'Tout y est. Très pédagogue bien expliqué. Attention faut maitriser le HTML pour comprendre ce livre.', '2020-01', '2023-11-22 14:43:38'),
(8, 13, 1, 5, 4, 'On peut juste regretter de devoir s\'arrêter à 5 étoiles. Dix peut-être ne suffiraient pas à encenser un tel roman.', '2023-02', '2023-11-22 14:48:10');

-- --------------------------------------------------------

--
-- Structure de la table `review_tag`
--

CREATE TABLE `review_tag` (
  `review_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `review_tag`
--

INSERT INTO `review_tag` (`review_id`, `tag_id`) VALUES
(1, 6),
(1, 8),
(1, 1),
(2, 5),
(2, 6),
(2, 9),
(2, 14),
(3, 12),
(3, 11),
(4, 10),
(4, 9),
(4, 6),
(4, 3),
(5, 3),
(5, 2),
(5, 6),
(5, 5),
(5, 9),
(6, 1),
(6, 5),
(6, 10),
(6, 9),
(6, 7),
(7, 2),
(7, 8),
(7, 13),
(8, 3),
(8, 4),
(8, 5),
(8, 12);

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `id` int NOT NULL,
  `label` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`id`, `label`) VALUES
(1, 'Amazing'),
(2, 'Cry'),
(3, 'Dark'),
(4, 'Disappointment'),
(5, 'Emotion'),
(6, 'Intense'),
(7, 'Joy'),
(8, 'Laugh'),
(9, 'Mystery'),
(10, 'Plot-twist'),
(11, 'Sad'),
(12, 'Unexpected'),
(13, 'Weird'),
(14, 'Wonder'),
(15, 'Amazing'),
(16, 'Cry'),
(17, 'Dark'),
(18, 'Disappointment'),
(19, 'Emotion'),
(20, 'Intense'),
(21, 'Joy'),
(22, 'Laugh'),
(23, 'Mystery'),
(24, 'Plot-twist'),
(25, 'Sad'),
(26, 'Unexpected'),
(27, 'Weird'),
(28, 'Wonder');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(75) NOT NULL,
  `phone` char(10) DEFAULT NULL,
  `bio` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `firstname`, `lastname`, `birthdate`, `email`, `phone`, `bio`, `created_at`) VALUES
(1, 'ElieB', 'bendier', 'elie', 'bendier', '0000-00-00', 'elie.bendier@gmail.com', NULL, NULL, '2023-11-22 14:52:16'),
(2, 'ZinedineC', 'chader', 'Zinedine', 'Chader', '0000-00-00', 'zinedine.chader@gmail.com', NULL, NULL, '2023-11-22 14:53:13'),
(3, 'NicolasA', 'alibert', 'Nicolas', 'Alibert', '0000-00-00', 'nicolas.alibert@gmail.com', NULL, NULL, '2023-11-22 14:53:50'),
(4, 'EddyJ', 'joncoux', 'Eddy', 'Joncoux', '0000-00-00', 'eddy.joncoux@gmail.com', NULL, NULL, '2023-11-22 14:54:29');

-- --------------------------------------------------------

--
-- Structure de la table `user_book_edition`
--

CREATE TABLE `user_book_edition` (
  `user_id` int NOT NULL,
  `book_edition_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`book_id`,`author_id`);

--
-- Index pour la table `book_editor`
--
ALTER TABLE `book_editor`
  ADD PRIMARY KEY (`id`,`book_id`,`editor_id`);

--
-- Index pour la table `book_genre`
--
ALTER TABLE `book_genre`
  ADD PRIMARY KEY (`book_id`,`genre_id`);

--
-- Index pour la table `editor`
--
ALTER TABLE `editor`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `book_editor`
--
ALTER TABLE `book_editor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `editor`
--
ALTER TABLE `editor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
