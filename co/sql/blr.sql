# phpMyAdmin SQL Dump
# version 2.5.3
# http://www.phpmyadmin.net
#
# Serveur: localhost
# Généré le : Mardi 06 Avril 2004 à 19:49
# Version du serveur: 4.0.16
# Version de PHP: 4.3.2
# 
# Base de données: `blr`
# 

# --------------------------------------------------------

#
# Structure de la table `admin`
#
# Création: Mercredi 04 Février 2004 à 20:35
# Dernière modification: Lundi 09 Février 2004 à 23:34
# Dernière vérification: Jeudi 19 Février 2004 à 23:06
#

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `numAdmin` int(10) unsigned NOT NULL auto_increment,
  `login` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`numAdmin`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Contenu de la table `admin`
#

INSERT INTO `admin` (`numAdmin`, `login`, `password`) VALUES (1, 'skink', 'fuka'),
(2, 'yoyo', 'yoyo');

# --------------------------------------------------------

#
# Structure de la table `commentaire`
#
# Création: Jeudi 05 Février 2004 à 22:21
# Dernière modification: Mardi 17 Février 2004 à 20:23
# Dernière vérification: Mardi 17 Février 2004 à 19:23
#

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE `commentaire` (
  `numCommentaire` int(10) unsigned NOT NULL auto_increment,
  `numLivre` int(10) unsigned default NULL,
  `numUrl` int(10) unsigned default NULL,
  `auteur` varchar(255) NOT NULL default '',
  `commentaire` text NOT NULL,
  `note` decimal(5,2) NOT NULL default '0.00',
  PRIMARY KEY  (`numCommentaire`)
) TYPE=MyISAM AUTO_INCREMENT=10 ;

#
# Contenu de la table `commentaire`
#

INSERT INTO `commentaire` (`numCommentaire`, `numLivre`, `numUrl`, `auteur`, `commentaire`, `note`) VALUES (1, 1, NULL, 'Fabien', 'Vraiment un très bon bouquin que tout programmeur python se devrait de posséder.', '16.00'),
(6, NULL, 7, 'fab', 'sdf', '20.00'),
(3, 4, NULL, 'fghdf', 'fghfghfghfghfghfgh', '18.00'),
(9, NULL, 4, 'cx', 'cx', '20.00');

# --------------------------------------------------------

#
# Structure de la table `dossier`
#
# Création: Mardi 17 Février 2004 à 23:38
# Dernière modification: Mardi 06 Avril 2004 à 19:32
# Dernière vérification: Mardi 06 Avril 2004 à 12:57
#

DROP TABLE IF EXISTS `dossier`;
CREATE TABLE `dossier` (
  `numDossier` int(10) unsigned NOT NULL auto_increment,
  `numDossierParent` int(10) unsigned default '0',
  `nom` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`numDossier`)
) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=113 ;

#
# Contenu de la table `dossier`
#

INSERT INTO `dossier` (`numDossier`, `numDossierParent`, `nom`) VALUES (2, 3, 'UML'),
(3, 0, '..'),
(5, 3, 'Python'),
(8, 3, 'PHP');

# --------------------------------------------------------

#
# Structure de la table `livre`
#
# Création: Lundi 05 Avril 2004 à 13:09
# Dernière modification: Mardi 06 Avril 2004 à 13:09
# Dernière vérification: Mardi 06 Avril 2004 à 12:57
#

DROP TABLE IF EXISTS `livre`;
CREATE TABLE `livre` (
  `numLivre` int(10) unsigned NOT NULL auto_increment,
  `numDossierParent` int(10) unsigned NOT NULL default '0',
  `dossierSouhaite` varchar(255) default NULL,
  `note` decimal(5,2) NOT NULL default '0.00',
  `nombreNote` int(10) unsigned NOT NULL default '0',
  `langue` varchar(10) NOT NULL default '',
  `nombreClick` int(10) unsigned NOT NULL default '0',
  `titre` varchar(255) NOT NULL default '',
  `sousTitre` varchar(255) default NULL,
  `auteur` varchar(255) default NULL,
  `editeur` varchar(255) default NULL,
  `prix` decimal(7,2) default NULL,
  `pages` tinyint(3) unsigned default NULL,
  `numEdition` tinyint(3) unsigned default NULL,
  `lienCommercial` text,
  `isbn` varchar(255) default NULL,
  `dateParution` varchar(255) default NULL,
  `collection` varchar(255) default NULL,
  `niveau` varchar(255) default NULL,
  `poids` tinyint(3) unsigned default NULL,
  `format` varchar(255) default NULL,
  `urlLivre` text,
  `resume` text,
  `valider` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`numLivre`)
) TYPE=MyISAM AUTO_INCREMENT=27 ;

#
# Contenu de la table `livre`
#

INSERT INTO `livre` (`numLivre`, `numDossierParent`, `dossierSouhaite`, `note`, `nombreNote`, `langue`, `nombreClick`, `titre`, `sousTitre`, `auteur`, `editeur`, `prix`, `pages`, `numEdition`, `lienCommercial`, `isbn`, `dateParution`, `collection`, `niveau`, `poids`, `format`, `urlLivre`, `resume`, `valider`) VALUES (1, 5, NULL, '0.00', 0, 'fr', 0, 'Python en concentré', 'Manuel de référence', 'Alex Martelli', 'O\'Reilly', '54.00', 255, 1, NULL, '2-84177-290-X', 'janvier 2004', NULL, NULL, NULL, NULL, 'http://www.oreilly.fr/catalogue/284177290X.html', 'Le programmeur Python est un programmeur heu-reux ! Python réunit de nombreuses vertus, qui en font un langage de plus en plus apprécié, aussi bien des administrateurs système pour ses qualités de langage de script que des développeurs pour la rigueur de son modèle objet, sa portabilité et son extensibilité. Polyvalent, il autorise aussi bien la programmation procédurale qu\'orientée objet. Il s\'interface aisément avec des composantes C ou Java. Derrière une simplicité apparente, se cache un langage puissant capable de relever les défis les plus ambitieux. En outre, il bénéficie d\'une imposante collection de bibliothèques et de modules d\'extension.', 1),
(2, 2, NULL, '0.00', 0, 'fr', 0, 'Introduction à UML', 'Modélisation de projets', 'Sinan Si Alhir', 'O\'Reilly', '40.00', 232, 1, NULL, '2-84177-279-9', 'décembre 2003', NULL, NULL, NULL, NULL, 'http://www.oreilly.fr/catalogue/2841772799.html', 'Le lecteur qui ne connaît ni UML (Unified Modeling Language) ni même la notion d\'objet au sens informatique du terme trouvera dans cet ouvrage des explications limpides et structurées et pourra les mettre en application sans tarder. L\'auteur commence par une solide présentation de la technologie objet avant d\'aborder en détail les différents types de diagrammes qui composent UML, indépendamment de tout langage d\'implémentation. Une étude de cas constitue le fil rouge et permet d\'ancrer dans la réalité des notions a priori abstraites.', 1),
(3, 5, NULL, '0.00', 0, 'fr', 0, 'Apprendre à programmer avec Python', 'La programmation à porté de tous', 'Gérard Swinnen', 'O\'Reilly', '36.00', 255, 1, NULL, '2-84177-294-2', 'décembre 2003', NULL, 'Débutant', NULL, NULL, 'http://www.oreilly.fr/catalogue/2841772942.html', 'Le bon duo pour apprendre à programmer, c\'est un langage bien structuré, simple, mais suffisamment évolué, en l\'occurrence Python, et une démarche pédagogique confirmée. Gérard Swinnen, qui enseigne l\'informatique dans une établissement d\'enseignement secondaire sait de quoi il parle. Très vite, le lecteur pourra réaliser des applications simples, mais utiles, et prendra goût à la programmation.', 1),
(4, 8, NULL, '0.00', 0, 'fr', 0, 'PHP en action', '290 recettes pour la programmation en PHP', 'David Sklar et Adam Trachtenberg', 'O\'Reilly', '43.00', 255, 1, NULL, '2-84177-231-4', 'septembre 2003', '', 'debutant', 0, '', 'http://www.oreilly.fr/catalogue/2841772314.html', 'PHP est le principal langage de développement rapide pour le Web grâce à ses nombreuses fonctionnalités, sa syntaxe accessible et sa disponibilité pour toutes les plates-formes. Avec PHP en action, vous trouverez un recueil de 290 recettes, prêtes à l\'emploi, qui répondent à tous les problèmes les plus fréquents que se posent les administrateurs de sites web, les webmasters ou les développeurs PHP.', 1);

# --------------------------------------------------------

#
# Structure de la table `url`
#
# Création: Mardi 06 Avril 2004 à 19:23
# Dernière modification: Mardi 06 Avril 2004 à 19:24
#

DROP TABLE IF EXISTS `url`;
CREATE TABLE `url` (
  `numUrl` int(10) unsigned NOT NULL auto_increment,
  `numDossierParent` int(10) unsigned NOT NULL default '0',
  `dossierSouhaite` varchar(255) default NULL,
  `nom` varchar(100) NOT NULL default '',
  `url` text NOT NULL,
  `note` decimal(4,2) NOT NULL default '0.00',
  `langue` varchar(5) NOT NULL default '',
  `nombreClick` int(10) unsigned NOT NULL default '0',
  `valider` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`numUrl`)
) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=2 ;

#
# Contenu de la table `url`
#

INSERT INTO `url` (`numUrl`, `numDossierParent`, `dossierSouhaite`, `nom`, `url`, `note`, `langue`, `nombreClick`, `valider`) VALUES (1, 3, '', 'Da Linux French Page', 'http://www.linuxfr.org', '0.00', 'fr', 0, 1);
