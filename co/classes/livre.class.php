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
require_once('document.class.php');
require_once('commentaire.class.php');

class Livre extends Document{
    
    /*  
    *   Attributs de l'objet Dossier
    */

    var $note;
    var $nombreNote;
    var $langue;
    var $nombreClick;
    var $titre;
    var $sousTitre;
    var $auteur;
    var $editeur;
    var $prix;
    var $pages;
    var $numEdition;
    var $lienCommercial;
    var $isbn;
    var $dateParution;
    var $collection;
    var $niveau;
    var $poids;
    var $format;
    var $urlLivre;
    var $resume;
    var $valider;
    
    /*
    *   Variables concerant le fonctionnement de la classe    
    */
    var $numLivre;
    var $numDossierParent;
    var $listeCommentaire;
    var $cleCouranteCommentaire = 0;
    
    function Livre($numLivre = 0) {
        $this->numLivre = $numLivre;
        if ($numLivre != 0) {
            // Requete SQL permettant de récupérer les infos concernant
            // le dossier courant (sauf pour le dossier racine)
            $sql_list = "SELECT `note`, `nombreNote` , `langue` , `nombreClick` ,".
                        " `titre` , `sousTitre` , `auteur` , `editeur`".
                        " , `prix` , `pages` , `numEdition` , ".
                        "`lienCommercial` , `isbn` , `dateParution` , ".
                        "`collection` , `niveau` , `poids` , `format` ".
                        ", `urlLivre` , `resume`, `numDossierParent`, `valider` ".
                        "FROM `livre` ".
                        "WHERE numLivre = ".$numLivre;
                                       
            // On se connecte et on effectue la requete
            connexion();
            $resultatReq = mysql_query($sql_list);
            $resultat = mysql_fetch_array($resultatReq);
            deconnexion();
            
            // On modifie les attributs de l'objet en fonction des
            // données venant de la BDD
            $this->note             = $resultat['note'];
            $this->nombreNote       = $resultat['nombreNote'];
            $this->langue           = $resultat['langue'];
            $this->nombreClick      = $resultat['nombreClick'];
            $this->titre            = $resultat['titre'];
            $this->sousTitre        = $resultat['sousTitre'];
            $this->auteur           = $resultat['auteur'];
            $this->editeur          = $resultat['editeur'];
            $this->prix             = $resultat['prix'];
            $this->pages            = $resultat['pages'];
            $this->numEdition       = $resultat['numEdition'];
            $this->lienCommercial   = $resultat['lienCommercial'];
            $this->isbn             = $resultat['isbn'];
            $this->dateParution     = $resultat['dateParution'];
            $this->collection       = $resultat['collection'];
            $this->niveau           = $resultat['niveau'];
            $this->poids            = $resultat['poids'];
            $this->format           = $resultat['format'];
            $this->urlLivre         = $resultat['urlLivre'];
            $this->resume           = $resultat['resume'];
            $this->numDossierParent = $resultat['numDossierParent'];
            $this->valider          = $resultat['valider'];
        }
    }
    
    function listeCommentaire() {
        $sql = "SELECT numCommentaire FROM commentaire WHERE numLivre = ".$this->numLivre;
        
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        
        // On parcours le résultat et on crée les dossier correspondant
        while ($commentaire = mysql_fetch_array($resultat)) {
            $this->listeCommentaire[] = new Commentaire($commentaire['numCommentaire']);
        }
    }

    function commentaireSuivantExiste() {
        $nbCommentaire = count($this->listeCommentaire);
        if ($this->cleCouranteCommentaire == $nbCommentaire) {
            return false;
        } else {
            return true;
        }
    }
    
    function commentaireSuivant() {
        
        $commentaire = $this->listeCommentaire[$this->cleCouranteCommentaire];
        $this->cleCouranteCommentaire++;
        return $commentaire;
    }
    
    function ajouterCommentaire($commentaire) {
        $sql_ajout  =  "INSERT INTO `commentaire` (`numLivre` , `auteur` , `commentaire` , `note` ) ".
                        "VALUES ('".$this->numLivre."', '".$commentaire->auteur."', '".$commentaire->commentaire."', '".$commentaire->note."')";
        connexion();
        mysql_query($sql_ajout);
        deconnexion();     
    }
    
    function nombreCommentaire() {
        $sql = "SELECT COUNT(*) AS nbCo FROM commentaire WHERE numLivre = ".$this->numLivre;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        $nbCommentaire = mysql_fetch_array($resultat);
        return $nbCommentaire['nbCo'];
    }

    function supprimer() {
        $sql = "DELETE FROM livre WHERE numLivre = ".$this->numLivre;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
    }
    
    function note() {
        $sql =  "SELECT ROUND((SUM( note ) / COUNT( note )),1) AS moyenne ".
                "FROM `commentaire` ".
                "WHERE numLivre = ".$this->numLivre;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        $note = mysql_fetch_array($resultat);
        return $note['moyenne'];
    }
    function valider() {
        $sql =  "UPDATE livre ".
                "SET valider = 1 ".
                "WHERE numLivre = ".$this->numLivre;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
    }
    
    function deplacerVers($dossier)
    {
        $sql =  "UPDATE livre ".
                "SET numDossierParent  = ".$dossier->numDossier." ".
                "WHERE numLivre = ".$this->numLivre;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
    }
}
?>