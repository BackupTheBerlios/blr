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

class Url extends Document{
    
    /*  
    *   Attributs de l'objet Dossier
    */
    var $nom;
    var $url;
    var $valider;
    
    /*
    *   Variables concerant le fonctionnement de la classe    
    */
    var $numUrl;
    var $numDossierParent;
    var $dossierSouhaite;
    var $listeCommentaire;
    var $cleCouranteCommentaire = 0;
    
    function Url($numUrl = 0) {
        $this->numUrl = $numUrl;
        if ($numUrl != 0) {
            // Requete SQL permettant de récupérer les infos concernant
            // le dossier courant (sauf pour le dossier racine)
            $sql_list   =  "SELECT nom, url, note, langue, nombreClick, numDossierParent, valider, dossierSouhaite ".
                        "FROM `url` ".
                        "WHERE numUrl = ".$numUrl;
                                      
            // On se connecte et on effectue la requete
            connexion();
            $resultatReq = mysql_query($sql_list);
            $resultat = mysql_fetch_array($resultatReq);
            deconnexion();
            
            // On modifie les attributs de l'objet en fonction des
            // données venant de la BDD
            $this->nom              = $resultat['nom'];
            $this->url              = $resultat['url'];
            $this->note             = $resultat['note'];
            $this->langue           = $resultat['langue'];
            $this->nombreClick      = $resultat['nombreClick'];
            $this->numDossierParent = $resultat['numDossierParent'];
            $this->valider          = $resultat['valider'];
            $this->dossierSouhaite  = $resultat['dossierSouhaite'];
        }
    }
    
    function listeCommentaire() {
        $sql = "SELECT numCommentaire FROM commentaire WHERE numUrl = ".$this->numUrl;
        
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
        $sql_ajout  =  "INSERT INTO `commentaire` (`numUrl` , `auteur` , `commentaire` , `note` ) ".
                        "VALUES ('".$this->numUrl."', '".$commentaire->auteur."', '".$commentaire->commentaire."', '".$commentaire->note."')";
        connexion();
        mysql_query($sql_ajout);
        deconnexion();     
    }
    
    function nombreCommentaire() {
        $sql = "SELECT COUNT(*) AS nbCo FROM commentaire WHERE numUrl = ".$this->numUrl;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        $nbCommentaire = mysql_fetch_array($resultat);
        return $nbCommentaire['nbCo'];
    }
    
    function supprimer() {
        $sql = "DELETE FROM url WHERE numUrl = ".$this->numUrl;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
    }
    
    function note() {
        $sql =  "SELECT ROUND((SUM( note ) / COUNT( note )),1) AS moyenne ".
                "FROM `commentaire` ".
                "WHERE numUrl = ".$this->numUrl;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
        $note = mysql_fetch_array($resultat);
        return $note['moyenne'];
    }
    
    function valider() {
        $sql =  "UPDATE url ".
                "SET valider = 1 ".
                "WHERE numUrl = ".$this->numUrl;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
    }
    
    function deplacerVers($dossier)
    {
        $sql =  "UPDATE url ".
                "SET numDossierParent  = ".$dossier->numDossier." ".
                "WHERE numUrl = ".$this->numUrl;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();
    }
    
    function dossierSouhaite ($dossierSouhaite) {
        $sql =  "UPDATE url ".
                "SET dossierSouhaite = '".$dossierSouhaite."' ".
                "WHERE numUrl = ".$this->numUrl;
        connexion();
        $resultat = mysql_query($sql);
        deconnexion();                
    }
}
?>