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

haut();
// Un peu d'HTML
?>
<h1>Books & Links Repository</h1>
<?php
// On récupère le numero du dossier et le crée l'objet correspondant
if (isset($_GET['numDossier'])) {
    $dossier = new Dossier($_GET['numDossier']);
} else {
    // On définit ici le numéro du dossier racine
    $dossier = new Dossier(3);
}
echo '<div class="arborescence">'.$dossier->arborescence().'</div>';

echo '<div class="dossier">';
// Liste des sous dossiers
$dossier->listeSousDossier();
while ($dossier->dossierSuivantExiste()) {
    $dossierCourant = $dossier->sousDossierSuivant();
    echo  '<img src="icones/dossier.png" /> <a href="'.$_SERVER['PHP_SELF'].'?numDossier='.$dossierCourant->numDossier.'">'.$dossierCourant->nom.'</a><br />'."\n";
}

// Liste des urls
$dossier->listeUrl();
while ($dossier->urlSuivanteExiste()) {
    $urlCourante = $dossier->urlSuivante();
    
    // Gestion des options administrateurs
    if (isset($_SESSION['login'])) {
        echo '<a href="supprimer.php?objet=lien&numUrl='.$urlCourante->numUrl.'"><img src="icones/supprimer.png" /></a>';
    }
    
    // Affichage du lien
    echo    '<img src="icones/lien.png" /> '.
            '<img src="icones/pays/'.$urlCourante->langue.'.png" />'.
            ' <a href="lien.php?numUrl='.$urlCourante->numUrl.'">'.htmlentities($urlCourante->nom).'</a> - '.$urlCourante->nombreCommentaire().' commentaire(s)'.
            $urlCourante->note.' '.$urlCourante->nombreClick.'<br />'."\n";
}

// Liste des livres
$dossier->listeLivre();
while ($dossier->livreSuivantExiste()) {
    $livreCourant = $dossier->livreSuivant();
    
    // Gestion des options administrateurs
    if (isset($_SESSION['login'])) {
        echo '<a href="supprimer.php?objet=livre&numLivre='.$livreCourant->numLivre.'"><img src="icones/supprimer.png" /></a>';
    }
    
    // Affichage du livre
    echo  '<img src="icones/livre.png" /> <img src="icones/pays/'.$livreCourant->langue.'.png" /> <a href="livre.php?numLivre='.$livreCourant->numLivre.'">'.htmlentities($livreCourant->titre).'</a> - '.$livreCourant->nombreCommentaire().' commentaire(s)<br />'."\n";
}

// Affichage de la scgnification des icones
echo '</div>';
echo '<div class="legende">';
echo '<img src="icones/lien.png" /> Liens | <img src="icones/livre.png" /> Livre';
if (isset($_SESSION['login'])) {
    echo ' | <img src="icones/supprimer.png" /> Supprimer';
}
echo '</div>';

// Affichage des liens pour ajouter des éléments
echo '<div class="ajout">';
echo '<a href="formulaire.php?action=ajoutLivre&numDossier='.$dossier->numDossier.'">Ajouter un livre</a> | <a href="formulaire.php?action=ajoutLien&numDossier='.$dossier->numDossier.'">Ajouter un lien</a> | <a href="formulaire.php?action=ajoutDossier&numDossier='.$dossier->numDossier.'">Ajouter un dossier</a>';

// Lien pour passer et quitter le mode Administrateur
if (isset($_SESSION['login'])) {
    echo '<br /><a href="logout.php">Quitter le mode <strong>Administrateur</strong></a>';
} else {
    echo '<br /><a href="administration.php">Passer en mode <strong>Administrateur</strong></a>';
}
echo '</div>';
bas();
?>