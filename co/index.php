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
include_once('classes/dossier.class.php');
include_once('classes/url.class.php');
include_once('classes/livre.class.php');
include_once('classes/divers.php');
include_once('classes/message.class.php');

haut();
// Un peu d'HTML
?>
<h1><a href="index.php">Books &amp; Links Repository</a></h1>
<?php
// On récupère le numero du dossier et le crée l'objet correspondant
if (isset($_GET['numDossier'])) {
    $dossier = new Dossier($_GET['numDossier']);
} else {
    // On définit ici le numéro du dossier racine
    $dossier = new Dossier(3);
}
echo '<div class="arborescence">'.$dossier->arborescence().'</div>';

// Affichage d'un message concernant l'action effectué
if (isset($_GET['message'])) {
    $message = new Message();
    
    echo '<div class="commentaire">';
    echo htmlentities($message->recuperer($_GET['message']));
    echo '</div>';
}


echo '<div class="dossier">';
// Liste des sous dossiers
$dossier->listeSousDossier();
while ($dossier->dossierSuivantExiste()) {
    $dossierCourant = $dossier->sousDossierSuivant();
    echo  '<img src="icones/dossier.png" alt="icone d\'un dossier"/> <a href="'.$_SERVER['PHP_SELF'].'?numDossier='.$dossierCourant->numDossier.'">'.$dossierCourant->nom.'</a><br />'."\n";
}

// Liste des urls
$dossier->listeUrl();
while ($dossier->urlSuivanteExiste()) {
    $urlCourante = $dossier->urlSuivante();
    
    if ($urlCourante->valider == 1)
    {
        // Gestion des options administrateurs
        if (isset($_SESSION['login'])) {
            echo '<a href="supprimer.php?objet=lien&numUrl='.$urlCourante->numUrl.'"><img src="icones/supprimer.png" alt="icone pour la suppression"/></a>';
        }
        
        // Affichage du lien
        echo    '<img src="icones/lien.png" alt="icone d\'un lien"/> '.
                '<img src="icones/pays/'.$urlCourante->langue.'.png" alt="icone d\'un drapeau"/>'.
                ' <a href="lien.php?numUrl='.$urlCourante->numUrl.'">'.htmlentities($urlCourante->nom).'</a> '.
                '- '.$urlCourante->nombreCommentaire().' commentaire(s)';
        
        //Affichage de la note si elle existe (cad au moins 1 commentaire)
        if ($urlCourante->note() != '') {
            echo ' | Note :'.$urlCourante->note();
        }
        echo    '<br />'."\n";
    }
    // Sinon si il n'a pas été valider, on n'affiche que si l'utilisateur est admin
    elseif ($urlCourante->valider == 0 && isset($_SESSION['login']))
    {
        // Gestion des options administrateurs
        if (isset($_SESSION['login'])) {
            echo '<a href="supprimer.php?objet=lien&numUrl='.$urlCourante->numUrl.'"><img src="icones/supprimer.png" /></a>';
        }
        
        // Affichage du lien
        echo    '<img src="icones/lien.png" alt="icone d\'un lien"/> '.
                '<img src="icones/pays/'.$urlCourante->langue.'.png" alt="icone d\'un drapeau"/>'.
                ' <a href="lien.php?numUrl='.$urlCourante->numUrl.'">'.htmlentities($urlCourante->nom).'</a> '.
                '- '.$urlCourante->nombreCommentaire().' commentaire(s)';
        
        //Affichage de la note si elle existe (cad au moins 1 commentaire)
        if ($urlCourante->note() != '') {
            echo ' | Note :'.$urlCourante->note();
        }
        echo '<strong>'.htmlentities('[À valider]').'</strong>';
        echo    '<br />'."\n";
    }
}

// Liste des livres
$dossier->listeLivre();
while ($dossier->livreSuivantExiste()) {
    $livreCourant = $dossier->livreSuivant();
    
    // On affiche si le livre à été valider
    if ($livreCourant->valider == 1)
    {
        // Gestion des options administrateurs
        if (isset($_SESSION['login'])) {
            echo '<a href="supprimer.php?objet=livre&numLivre='.$livreCourant->numLivre.'"><img src="icones/supprimer.png" /></a>';
        }
        
        // Affichage du livre
        echo    '<img src="icones/livre.png" alt="icone d\'un livre"/> '.
                '<img src="icones/pays/'.$livreCourant->langue.'.png" alt="icone d\'un drapeau"/> '.
                '<a href="livre.php?numLivre='.$livreCourant->numLivre.'">'.htmlentities($livreCourant->titre).'</a> '.
                '- '.$livreCourant->nombreCommentaire().' commentaire(s) ';
        
        //Affichage de la note si elle existe (cad au moins 1 commentaire)
        if ($livreCourant->note() != '') {
            echo ' | Note :'.$livreCourant->note();
        }
        echo    '<br />'."\n";
    }
    // Sinon si il n'a pas été valider, on n'affiche que si l'utilisateur est admin
    elseif ($livreCourant->valider == 0 && isset($_SESSION['login']))
    {
        // Gestion des options administrateurs
        if (isset($_SESSION['login'])) {
            echo '<a href="supprimer.php?objet=livre&numLivre='.$livreCourant->numLivre.'"><img src="icones/supprimer.png" /></a>';
        }
        // Affichage du livre
        echo    '<img src="icones/livre.png" /> '.
                '<img src="icones/pays/'.$livreCourant->langue.'.png" /> '.
                '<a href="livre.php?numLivre='.$livreCourant->numLivre.'">'.htmlentities($livreCourant->titre).'</a> '.
                '- '.$livreCourant->nombreCommentaire().' commentaire(s) ';
        
        //Affichage de la note si elle existe (cad au moins 1 commentaire)
        if ($livreCourant->note() != '') {
            echo ' | Note :'.$livreCourant->note();
        }
        echo '<strong>'.htmlentities('[À valider]').'</strong>';
        echo    '<br />'."\n";    
    }
}
echo '</div>';

// Affichage de la scgnification des icones
echo '<div class="legende">';
echo '<img src="icones/lien.png" alt="icone d\'un lien"/> Liens | <img src="icones/livre.png" /> Livre';
if (isset($_SESSION['login'])) {
    echo ' | <img src="icones/supprimer.png" alt="icone pour supprimer"/> Supprimer';
}
echo '</div>';

// Affichage des liens pour ajouter des éléments
echo '<div class="ajout">';
echo '<a href="formulaire.php?action=ajoutLivre&numDossier='.$dossier->numDossier.'">Ajouter un livre</a> | <a href="formulaire.php?action=ajoutLien&numDossier='.$dossier->numDossier.'">Ajouter un lien</a> | <a href="formulaire.php?action=ajoutDossier&numDossier='.$dossier->numDossier.'">Ajouter un dossier</a>';

// Lien pour passer et quitter le mode Administrateur
if (isset($_SESSION['login'])) {
    echo '<br /><a href="administration.php">Administration</a> | <a href="logout.php">Quitter le mode <strong>Administrateur</strong></a>';
} else {
    echo '<br /><a href="administration.php">Passer en mode <strong>Administrateur</strong></a>';
}
// Lien pour l'exportation et l'importation en XML
if (isset($_SESSION['login'])) {
    echo '<br /><a href="io.php?action=export&numDossier='.$dossier->numDossier.'">'.htmlentities('Exporter depuis ce dossier').'</a>';
}
echo '</div>';
bas();
?>