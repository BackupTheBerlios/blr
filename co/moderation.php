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

session_start();

// Inclusion des fichiers nécessaires
include_once('classes/url.class.php');
include_once('classes/dossier.class.php');
include_once('classes/livre.class.php');
include_once('classes/commentaire.class.php');
include_once('classes/url.class.php');

if ($_SESSION['login']) {
    if ($_GET['objet'] == 'commentaire') {
        /*$numLivre       = $_POST['numLivre'];
        
        $commentaire = new Commentaire();
        $commentaire->auteur        = $_POST['nom']; 
        $commentaire->commentaire   = $_POST['commentaire'];
        $commentaire->note          = $_POST['note'];
        
        $livre = new Livre($numLivre);
        $livre->ajouterCommentaire($commentaire);
        
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/livre.php?numLivre=".$numLivre);*/
    } elseif ($_GET['objet'] == 'livre') {
        $livre = new Livre($_GET['numLivre']);
        $livre->valider();
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$livre->numDossierParent);
                         
    } elseif ($_GET['objet'] == 'livreSousDossier') {
        $livre = new Livre($_GET['numLivre']);
        $livre->valider();
        
        // On crée le dossier parent
        $dossierParent = new Dossier($livre->numDossierParent);
        // On crée l'objet correspondant au dossier proposé
        $dossierTemp = new Dossier();
        $dossierTemp->nom = $livre->dossierSouhaite;
        $dossier = new Dossier($dossierParent->ajouterDossier($dossierTemp));
        $livre->deplacerVers($dossier);
                
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$livre->numDossierParent);   
    
    } elseif ($_GET['objet'] == 'lien') {
        $url = new Url($_GET['numUrl']);
        $url->valider();
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$url->numDossierParent);
    } elseif ($_GET['objet'] == 'lienSousDossier') {
        $url = new Url($_GET['numUrl']);
        $url->valider();
        
        // On crée le dossier parent
        $dossierParent = new Dossier($url->numDossierParent);
        // On crée l'objet correspondant au dossier proposé
        $dossierTemp = new Dossier();
        $dossierTemp->nom = $url->dossierSouhaite;
        $dossier = new Dossier($dossierParent->ajouterDossier($dossierTemp));
        $url->deplacerVers($dossier);
                
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$url->numDossierParent);
    } elseif ($_GET['objet'] == 'dossier') {
        /*$dossier = new Dossier();
        $dossier->nom           = $_POST['nom'];
        
        $dossierParent = new Dossier($_POST['numDossier']);
        $dossierParent->ajouterDossier($dossier);
        
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$_POST['numDossier']);*/
    }

// Si la personne essayant d'accéder à la page n'est pas connecté en
// tant qu'administrateur on la renvoie à la page index
} else {
    header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php");
}


?>