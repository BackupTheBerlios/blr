<?php
/*
    Copyright 2004 Fabien SCHWOB
    
    This file is part of BLR - Books & Links Repository.

    BLR is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    BLR is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once('db.php');
require_once('url.class.php');
require_once('livre.class.php');

class Dossier {
    
    /*  
    *   Attributs de l'objet Dossier
    */
    var $nom;
    
    /*
    *   Variables concerant le fonctionnement de la classe    
    */
    var $numDossier;
    var $numDossierParent;
    var $listeSousDossier;
    var $listeUrl;
    var $listeLivre;
    var $cleCouranteDossier = 0;
    var $cleCouranteUrl = 0;
    var $cleCouranteLivre = 0;
    
    function Dossier($numDossier = 0)
    {
        $this->numDossier = $numDossier;
        if ($numDossier != 0) {
            // Requete SQL permettant de récupérer les infos concernant
            // le dossier courant (sauf pour le dossier racine)
            $sql =  "SELECT nom, numDossierParent ".
                    "FROM dossier ".
                    "WHERE numDossier = '".$numDossier."'";
                                       
            // On se connecte et on effectue la requete
            connexion();
            $resultatReq = mysql_query($sql);
            $resultat = mysql_fetch_array($resultatReq);
            deconnexion();
            
            // On modifie les attributs de l'objet en fonction des
            // données venant de la BDD
            $this->nom = $resultat['nom'];
            $this->numDossierParent = $resultat['numDossierParent'];
        }
    }
    
    function listeSousDossier()
    {
        // Requete SQL permettant de récupérer les infos concernant
        // le dossier courant (sauf pour le dossier racine)
        $sql =  "SELECT `numDossier`".
                "FROM `dossier`".
                "WHERE `numDossierParent` = ".$this->numDossier.
                " ORDER BY nom ASC";
        
        // On se connecte et on effectue la requete
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        
        // On ajoute le dossier parent à la liste des dossiers
        if ($this->numDossierParent != 0) {
            $this->listeSousDossier[] = new Dossier($this->numDossierParent);
        }
        
        // On parcours le résultat et on crée les dossier correspondant
        while ($dossier = mysql_fetch_array($resultat)) {
            $this->listeSousDossier[] = new Dossier($dossier['numDossier']);
        }
    }

    function dossierSuivantExiste()
    {
        $nbSousDossier = count($this->listeSousDossier);
        if ($this->cleCouranteDossier == $nbSousDossier) {
            return false;
        } else {
            return true;
        }
    }
    
    function sousDossierSuivant()
    {
        
        $sousDossier = $this->listeSousDossier[$this->cleCouranteDossier];
        $this->cleCouranteDossier++;
        return $sousDossier;
    }
    
    function listeUrl()
    {
        // Requete SQL permettant de récupérer les infos concernant
        // le dossier courant (sauf pour le dossier racine)
        $sql =  "SELECT `numUrl`".
                "FROM `url`".
                "WHERE `numDossierParent` = ".$this->numDossier.
                " ORDER BY nom ASC";
        
        // On se connecte et on effectue la requete
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        
        // On parcours le résultat et on crée les dossier correspondant
        while ($url = mysql_fetch_array($resultat)) {
            $this->listeUrl[] = new Url($url['numUrl']);
        }
    }

    function urlSuivanteExiste()
    {
        $nbUrl = count($this->listeUrl);
        if ($this->cleCouranteUrl == $nbUrl) {
            return false;
        } else {
            return true;
        }
    }
    
    function urlSuivante()
    {
        
        $url = $this->listeUrl[$this->cleCouranteUrl];
        $this->cleCouranteUrl++;
        return $url;
    }
    
    function listeLivre()
    {
        // Requete SQL permettant de récupérer les infos concernant
        // le dossier courant (sauf pour le dossier racine)
        $sql =  "SELECT `numLivre`".
                "FROM `livre`".
                "WHERE `numDossierParent` = ".$this->numDossier.
                " ORDER BY titre ASC";
        
        // On se connecte et on effectue la requete
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        
        // On parcours le résultat et on crée les dossier correspondant
        while ($livre = mysql_fetch_array($resultat)) {
            $this->listeLivre[] = new Livre($livre['numLivre']);
        }
    }

    function livreSuivantExiste()
    {
        $nbLivre = count($this->listeLivre);
        if ($this->cleCouranteLivre == $nbLivre) {
            return false;
        } else {
            return true;
        }
    }
    
    function livreSuivant()
    {
        
        $livre = $this->listeLivre[$this->cleCouranteLivre];
        $this->cleCouranteLivre++;
        return $livre;
    }
    
    function arborescence($separateur = '/')
    {
        $arbo = "";
        $numDossierParent = $this->numDossier;
        do {
            $sql = "SELECT nom, numDossierParent, numDossier FROM dossier WHERE numDossier = ".$numDossierParent;
            connexion();
            $resultat = mysql_query($sql);
            deconnexion();
            $doss = mysql_fetch_array($resultat);
            
            // On récupère les données venant de la base MySQL
            $nom = $doss['nom'];
            $numDossierParent = $doss['numDossierParent'];
            $numDossier = $doss['numDossier'];
            
            // On construit l'arborescence
            $arbo = $separateur.'<a href="index.php?numDossier='.$numDossier.'">'.$nom.'</a>'.$arbo;
        } while ($nom != "..");
        return $arbo;
    }
    
    function arborescenceSansLien($separateur = '>')
    {
        $arbo = "";
        $numDossierParent = $this->numDossier;
        do {
            $sql = "SELECT nom, numDossierParent, numDossier FROM dossier WHERE numDossier = ".$numDossierParent;
            connexion();
            $resultat = mysql_query($sql);
            deconnexion();
            $doss = mysql_fetch_array($resultat);
            
            // On récupère les données venant de la base MySQL
            $nom = $doss['nom'];
            $numDossierParent = $doss['numDossierParent'];
            $numDossier = $doss['numDossier'];
            
            // On construit l'arborescence
            $arbo = ' '.htmlentities($separateur).' '.''.$nom.''.$arbo;
        } while ($nom != "..");
        return $arbo;
    }
    
    function ajouterLivre($livre)
    {
        $sql =  "INSERT INTO livre (numDossierParent, langue, titre, sousTitre, auteur, ".
                "editeur, prix, pages, numEdition, isbn, dateParution, collection, ".
                "niveau, poids, format, urlLivre, resume) VALUES ('".$this->numDossier."', ".
                "'".$livre->langue."', '".$livre->titre."', '".$livre->sousTitre."', '".$livre->auteur."', ".
                "'".$livre->editeur."', '".$livre->prix."', '".$livre->pages."', '".$livre->numEdition."', ".
                "'".$livre->isbn."', '".$livre->dateParution."', '".$livre->collection."', '".$livre->niveau."', ".
                "'".$livre->poids."', '".$livre->format."', '".$livre->urlLivre."', '".$livre->resume."')";
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
    }
    
    function ajouterLien($lien)
    {
        $sql =  "INSERT INTO url (numDossierParent, langue, nom, url)".
                " VALUES ('".$this->numDossier."', '".$lien->langue.
                "', '".$lien->nom."', '".$lien->url."')";
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
    }
    
    function ajouterDossier($dossier)
    {
        $sql =  "INSERT INTO dossier (numDossierParent, nom)".
                " VALUES ('".$this->numDossier."', '".$dossier->nom."')";
        connexion();
        $resultat = mysql_query($sql);
        $id = mysql_insert_id();
        deconnexion();
        return $id;        
    }
    
    function listeTousDossier($dossierExclu = null)
    {
        /*$liste = array();
        $sql = "SELECT numDossier FROM dossier";
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        while ($numDossier = mysql_fetch_array($resultat)) {
            if ($dossierExclu != null) {
                if ($numDossier['numDossier'] != $dossierExclu) {
                    $dossier = new Dossier($numDossier['numDossier']);
                    $liste[$dossier->numDossier] = $dossier->arborescenceSansLien();
                }
            } else {
                $dossier = new Dossier($numDossier['numDossier']);
                $liste[$dossier->numDossier] = $dossier->arborescenceSansLien();
            }
        }
        asort($liste);
        return $liste;*/
        $liste = array();
        
        // On sélectionne tous les dossiers
        $sql = "SELECT numDossier FROM dossier";
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        
        // On remplit la liste avec l'arborescence de tous les dossiers
        while ($numDossier = mysql_fetch_array($resultat)) {
            $dossier = new Dossier($numDossier['numDossier']);
            $liste[$dossier->numDossier] = $dossier->arborescenceSansLien();
        }
        
        // On traite le cas ou il faut exclure un dossier et ses sous dossiers
        if ($dossierExclu != null) {
            $listeFinale = array();
            foreach ($liste as $cle => $ligne) {
                // Si la ligne 
                if (!stristr($ligne, $liste[$dossierExclu])) {
                    $listeFinale[$cle] = $ligne;
                }
            }
            asort($listeFinale);
            return $listeFinale;
        } else {
            asort($liste);
            return $liste;
        }
        
    }
    
    function deplacerVers($dossier)
    {
        $sql =  "UPDATE dossier ".
                "SET numDossierParent  = ".$dossier->numDossier." ".
                "WHERE numDossier = ".$this->numDossier;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
    }
}
?>