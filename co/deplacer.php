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
    if ($_POST['objet'] == 'commentaire') {
        /*$commentaire = new Commentaire($_GET['numCommentaire']);
        $commentaire->supprimer();
        if (isset($commentaire->numLivre))
        {
            header("Location: http://".$_SERVER['HTTP_HOST']
                             .dirname($_SERVER['PHP_SELF'])
                             ."/livre.php?numLivre=".$commentaire->numLivre);
        } elseif (isset($commentaire->numUrl))
        {
            header("Location: http://".$_SERVER['HTTP_HOST']
                             .dirname($_SERVER['PHP_SELF'])
                             ."/lien.php?numUrl=".$commentaire->numUrl);    
        } */
    } elseif ($_POST['objet'] == 'livre') {
        $livre      = new Livre($_POST['numLivre']);
        $dossier    = new Dossier($_POST['numDossier']);
        
        $livre->deplacerVers($dossier);
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$dossier->numDossier);
    } elseif ($_POST['objet'] == 'lien') {
        $lien       = new Url($_POST['numUrl']);
        $dossier    = new Dossier($_POST['numDossier']);
        
        $lien->deplacerVers($dossier);
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$dossier->numDossier);
    } elseif ($_POST['objet'] == 'dossier') {
        $dossierCible   = new Dossier($_POST['numDossierCible']);
        $dossier        = new Dossier($_POST['numDossier']);
        $dossier->deplacerVers($dossierCible);
        
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$_POST['numDossierCible']);
    }

// Si la personne essayant d'accéder à la page n'est pas connecté en
// tant qu'administrateur on la renvoie à la page index
} else {
    header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php");
}


?>