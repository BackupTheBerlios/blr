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

if ($_GET['objet'] == 'commentaire') {
    $numLivre       = $_POST['numLivre'];
    $numUrl         = $_POST['numUrl'];
    
    $commentaire = new Commentaire();
    $commentaire->auteur        = $_POST['nom']; 
    $commentaire->commentaire   = $_POST['commentaire'];
    $commentaire->note          = $_POST['note'];
    
    
    if ($numLivre != '') {
        $livre = new Livre($numLivre);
        $livre->ajouterCommentaire($commentaire);
        header("Location: http://".$_SERVER['HTTP_HOST']
                     .dirname($_SERVER['PHP_SELF'])
                     ."/livre.php?numLivre=".$numLivre);
    } elseif ($numUrl != '') {
        $lien = new Url($numUrl);
        $lien->ajouterCommentaire($commentaire);
        header("Location: http://".$_SERVER['HTTP_HOST']
                     .dirname($_SERVER['PHP_SELF'])
                     ."/lien.php?numUrl=".$numUrl);
    }
} elseif ($_GET['objet'] == 'livre') {
    $livre = new Livre();
    $livre->langue          = $_POST['langue'];
    $livre->titre           = $_POST['titre'];
    $livre->sousTitre       = $_POST['sousTitre'];
    $livre->auteur          = $_POST['auteur'];
    $livre->editeur         = $_POST['editeur'];
    $livre->prix            = $_POST['prix'];
    $livre->pages           = $_POST['pages'];
    $livre->numEdition      = $_POST['numEdition'];
    $livre->isbn            = $_POST['isbn'];
    $livre->dateParution    = $_POST['dateParution'];
    $livre->collection      = $_POST['collection'];
    $livre->niveau          = $_POST['niveau'];
    $livre->poids           = $_POST['poids'];
    $livre->format          = $_POST['format'];
    $livre->urlLivre        = $_POST['urlLivre'];
    $livre->resume          = $_POST['resume'];
    
    // Ajout d'un lien dans le dossier courant
    if ($_POST['dossier'] == 'courant') {
        $dossierParent = new Dossier($_POST['numDossier']);
        $dossierParent->ajouterLivre($livre, isset($_SESSION['login']));
    
    // Ajout avec proposition de dossier
    } elseif ($_POST['dossier'] == 'nouveau') {
        $dossierParent = new Dossier($_POST['numDossier']);
        $dossierParent->ajouterLivre($livre, 0);
        $livre->dossierSouhaite($_POST['nouveauDossier']);
    }
    
    header("Location: http://".$_SERVER['HTTP_HOST']
                     .dirname($_SERVER['PHP_SELF'])
                     ."/index.php?numDossier=".$_POST['numDossier']
                     ."&message=ajout_livre_ok");
} elseif ($_GET['objet'] == 'lien') {
    $url = new Url($_POST['numUrl']);
    $url->langue            = $_POST['langue'];
    $url->nom               = $_POST['nom'];
    $url->url               = $_POST['url'];
    
    $url->modifier();
    
    header("Location: http://".$_SERVER['HTTP_HOST']
                     .dirname($_SERVER['PHP_SELF'])
                     ."/lien.php?numUrl=".$_POST['numUrl']);
} elseif ($_GET['objet'] == 'dossier') {
    $dossier = new Dossier($_POST['numDossier']);
    $dossier->nom           = $_POST['nom'];
    
    $dossier->modifier();
    
    header("Location: http://".$_SERVER['HTTP_HOST']
                     .dirname($_SERVER['PHP_SELF'])
                     ."/index.php?numDossier=".$dossier->numDossierParent);
}

?>