# phpMyAdmin SQL Dump
# version 2.5.3
# http://www.phpmyadmin.net
#
# Serveur: localhost
# Généré le : Mercredi 04 Février 2004 à 22:45
# Version du serveur: 4.0.16
# Version de PHP: 4.3.2
# 
# Base de données: `blr`
# 

# --------------------------------------------------------

#
# Structure de la table `admin`
#

CREATE TABLE `admin` (
  `numAdmin` int(10) unsigned NOT NULL auto_increment,
  `login` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`numAdmin`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Structure de la table `commentaire`
#

CREATE TABLE `commentaire` (
  `numCommentaire` int(10) unsigned NOT NULL auto_increment,
  `numLivre` int(10) unsigned default NULL,
  `numUrl` int(10) unsigned default NULL,
  `auteur` varchar(255) NOT NULL default '',
  `commentaire` text NOT NULL,
  `note` decimal(5,2) NOT NULL default '0.00',
  PRIMARY KEY  (`numCommentaire`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Structure de la table `dossier`
#

CREATE TABLE `dossier` (
  `numDossier` int(10) unsigned NOT NULL auto_increment,
  `numDossierParent` int(10) unsigned default '0',
  `nom` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`numDossier`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Structure de la table `livre`
#

CREATE TABLE `livre` (
  `numLivre` int(10) unsigned NOT NULL auto_increment,
  `numDossierParent` int(10) unsigned NOT NULL default '0',
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
  PRIMARY KEY  (`numLivre`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Structure de la table `url`
#

CREATE TABLE `url` (
  `numUrl` int(10) unsigned NOT NULL auto_increment,
  `numDossierParent` int(10) unsigned NOT NULL default '0',
  `nom` varchar(100) NOT NULL default '',
  `url` text NOT NULL,
  `note` decimal(4,2) NOT NULL default '0.00',
  `langue` varchar(5) NOT NULL default '',
  `nombreClick` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`numUrl`)
) TYPE=MyISAM;
