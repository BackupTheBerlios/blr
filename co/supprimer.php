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

// Inclusion des fichiers n�cessaires
include_once('classes/url.class.php');
include_once('classes/dossier.class.php');
include_once('classes/livre.class.php');
include_once('classes/commentaire.class.php');
include_once('classes/url.class.php');

if ($_SESSION['login']) {
    if ($_GET['objet'] == 'commentaire') {
        $commentaire = new Commentaire($_GET['numCommentaire']);
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
        } 
    } elseif ($_GET['objet'] == 'livre') {
        $livre = new Livre($_GET['numLivre']);
        $livre->supprimer();
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$livre->numDossierParent);
    } elseif ($_GET['objet'] == 'lien') {
        $url = new Url($_GET['numUrl']);
        $url->supprimer();
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$url->numDossierParent);
    } elseif ($_GET['objet'] == 'dossier') {
        $dossier = new Dossier($_GET['numDossier']);
        $dossier->supprimer();
               
        header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php?numDossier=".$dossier->numDossierParent);
    }

// Si la personne essayant d'acc�der � la page n'est pas connect� en
// tant qu'administrateur on la renvoie � la page index
} else {
    header("Location: http://".$_SERVER['HTTP_HOST']
                         .dirname($_SERVER['PHP_SELF'])
                         ."/index.php");
}


?>