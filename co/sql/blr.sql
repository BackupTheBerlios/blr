# phpMyAdmin SQL Dump
# version 2.5.3
# http://www.phpmyadmin.net
#
# Serveur: localhost
# G�n�r� le : Mardi 06 Avril 2004 � 19:49
# Version du serveur: 4.0.16
# Version de PHP: 4.3.2
# 
# Base de donn�es: `blr`
# 

# --------------------------------------------------------

#
# Structure de la table `admin`
#
# Cr�ation: Mercredi 04 F�vrier 2004 � 20:35
# Derni�re modification: Lundi 09 F�vrier 2004 � 23:34
# Derni�re v�rification: Jeudi 19 F�vrier 2004 � 23:06
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
# Cr�ation: Jeudi 05 F�vrier 2004 � 22:21
# Derni�re modification: Mardi 17 F�vrier 2004 � 20:23
# Derni�re v�rification: Mardi 17 F�vrier 2004 � 19:23
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

INSERT INTO `commentaire` (`numCommentaire`, `numLivre`, `numUrl`, `auteur`, `commentaire`, `note`) VALUES (1, 1, NULL, 'Fabien', 'Vraiment un tr�s bon bouquin que tout programmeur python se devrait de poss�der.', '16.00'),
(6, NULL, 7, 'fab', 'sdf', '20.00'),
(3, 4, NULL, 'fghdf', 'fghfghfghfghfghfgh', '18.00'),
(9, NULL, 4, 'cx', 'cx', '20.00');

# --------------------------------------------------------

#
# Structure de la table `dossier`
#
# Cr�ation: Mardi 17 F�vrier 2004 � 23:38
# Derni�re modification: Mardi 06 Avril 2004 � 19:32
# Derni�re v�rification: Mardi 06 Avril 2004 � 12:57
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
# Cr�ation: Lundi 05 Avril 2004 � 13:09
# Derni�re modification: Mardi 06 Avril 2004 � 13:09
# Derni�re v�rification: Mardi 06 Avril 2004 � 12:57
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

INSERT INTO `livre` (`numLivre`, `numDossierParent`, `dossierSouhaite`, `note`, `nombreNote`, `langue`, `nombreClick`, `titre`, `sousTitre`, `auteur`, `editeur`, `prix`, `pages`, `numEdition`, `lienCommercial`, `isbn`, `dateParution`, `collection`, `niveau`, `poids`, `format`, `urlLivre`, `resume`, `valider`) VALUES (1, 5, NULL, '0.00', 0, 'fr', 0, 'Python en concentr�', 'Manuel de r�f�rence', 'Alex Martelli', 'O\'Reilly', '54.00', 255, 1, NULL, '2-84177-290-X', 'janvier 2004', NULL, NULL, NULL, NULL, 'http://www.oreilly.fr/catalogue/284177290X.html', 'Le programmeur Python est un programmeur heu-reux ! Python r�unit de nombreuses vertus, qui en font un langage de plus en plus appr�ci�, aussi bien des administrateurs syst�me pour ses qualit�s de langage de script que des d�veloppeurs pour la rigueur de son mod�le objet, sa portabilit� et son extensibilit�. Polyvalent, il autorise aussi bien la programmation proc�durale qu\'orient�e objet. Il s\'interface ais�ment avec des composantes C ou Java. Derri�re une simplicit� apparente, se cache un langage puissant capable de relever les d�fis les plus ambitieux. En outre, il b�n�ficie d\'une imposante collection de biblioth�ques et de modules d\'extension.', 1),
(2, 2, NULL, '0.00', 0, 'fr', 0, 'Introduction � UML', 'Mod�lisation de projets', 'Sinan Si Alhir', 'O\'Reilly', '40.00', 232, 1, NULL, '2-84177-279-9', 'd�cembre 2003', NULL, NULL, NULL, NULL, 'http://www.oreilly.fr/catalogue/2841772799.html', 'Le lecteur qui ne conna�t ni UML (Unified Modeling Language) ni m�me la notion d\'objet au sens informatique du terme trouvera dans cet ouvrage des explications limpides et structur�es et pourra les mettre en application sans tarder. L\'auteur commence par une solide pr�sentation de la technologie objet avant d\'aborder en d�tail les diff�rents types de diagrammes qui composent UML, ind�pendamment de tout langage d\'impl�mentation. Une �tude de cas constitue le fil rouge et permet d\'ancrer dans la r�alit� des notions a priori abstraites.', 1),
(3, 5, NULL, '0.00', 0, 'fr', 0, 'Apprendre � programmer avec Python', 'La programmation � port� de tous', 'G�rard Swinnen', 'O\'Reilly', '36.00', 255, 1, NULL, '2-84177-294-2', 'd�cembre 2003', NULL, 'D�butant', NULL, NULL, 'http://www.oreilly.fr/catalogue/2841772942.html', 'Le bon duo pour apprendre � programmer, c\'est un langage bien structur�, simple, mais suffisamment �volu�, en l\'occurrence Python, et une d�marche p�dagogique confirm�e. G�rard Swinnen, qui enseigne l\'informatique dans une �tablissement d\'enseignement secondaire sait de quoi il parle. Tr�s vite, le lecteur pourra r�aliser des applications simples, mais utiles, et prendra go�t � la programmation.', 1),
(4, 8, NULL, '0.00', 0, 'fr', 0, 'PHP en action', '290 recettes pour la programmation en PHP', 'David Sklar et Adam Trachtenberg', 'O\'Reilly', '43.00', 255, 1, NULL, '2-84177-231-4', 'septembre 2003', '', 'debutant', 0, '', 'http://www.oreilly.fr/catalogue/2841772314.html', 'PHP est le principal langage de d�veloppement rapide pour le Web gr�ce � ses nombreuses fonctionnalit�s, sa syntaxe accessible et sa disponibilit� pour toutes les plates-formes. Avec PHP en action, vous trouverez un recueil de 290 recettes, pr�tes � l\'emploi, qui r�pondent � tous les probl�mes les plus fr�quents que se posent les administrateurs de sites web, les webmasters ou les d�veloppeurs PHP.', 1);

# --------------------------------------------------------

#
# Structure de la table `url`
#
# Cr�ation: Mardi 06 Avril 2004 � 19:23
# Derni�re modification: Mardi 06 Avril 2004 � 19:24
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
