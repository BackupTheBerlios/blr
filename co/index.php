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

define('DOSSIER_RACINE', 1);

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
    $dossier = new Dossier(DOSSIER_RACINE);
}
echo '<p class="arborescence"><strong>R&eacute;pertoire</strong> : '.$dossier->arborescence().'</p>';

// Affichage d'un message concernant l'action effectué
if (isset($_GET['message'])) {
    $message = new Message();
    
    echo '<div class="commentaire">';
    echo htmlentities($message->recuperer($_GET['message']));
    echo '</div>';
}


echo '<div class="dossier">';

/**
 *  Affichage des sous-dossier du dossier courant
 **/

$dossier->listeSousDossier();
while ($dossier->dossierSuivantExiste()) {
    $dossierCourant = $dossier->sousDossierSuivant();
    
    // Gestion des options administrateurs
        if (isset($_SESSION['login'])) {
            echo '<a href="supprimer.php?objet=dossier&amp;numDossier='.$dossierCourant->numDossier.'" onClick="return validerSuppression()"><img src="icones/supprimer.png" alt="Supprimer "/></a>';
            echo '<a href="formulaire.php?action=modifDossier&amp;numDossier='.$dossierCourant->numDossier.'" ><img src="icones/modifier.png" alt="Editer "/></a> ';
        }
    
    echo  '<img src="icones/dossier.png" alt="[Dossier]"/> <a href="'.$_SERVER['PHP_SELF'].'?numDossier='.$dossierCourant->numDossier.'">'.htmlentities($dossierCourant->nom).'</a><br />'."\n";
}

/**
 *  Affichage des URLs contenu dans le dossier courant
 **/
 
$dossier->listeUrl();
while ($dossier->urlSuivanteExiste()) {
    $urlCourante = $dossier->urlSuivante();
    
    if ($urlCourante->valider == 1)
    {
        // Gestion des options administrateurs
        if (isset($_SESSION['login'])) {
            echo '<a href="supprimer.php?objet=lien&numUrl='.$urlCourante->numUrl.'"><img src="icones/supprimer.png" alt="Supprimer "/></a>';
            echo '<a href="formulaire.php?action=modifLien&numUrl='.$urlCourante->numUrl.'&numDossier='.$urlCourante->numDossierParent.'"><img src="icones/modifier.png" alt="Editer "/><a/>';
        }
        
        // Affichage du lien
        echo    '<a href="'.$urlCourante->url.'" title="'.$urlCourante->nom.'"><img src="icones/lien.png" alt="[lien]"/></a> '.
                '<img src="icones/pays/'.$urlCourante->langue.'.png" alt="['.$urlCourante->langue.']"/>'.
                ' <a href="lien.php?numUrl='.$urlCourante->numUrl.'" title="'.$urlCourante->url.'">'.htmlentities($urlCourante->nom).'</a> ';
        $nombreDeCommentaire = $urlCourante->nombreCommentaire();
        if ($nombreDeCommentaire > 0) {
            echo    '- '.$nombreDeCommentaire.' commentaire(s)';
        }
        
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
            echo '<a href="supprimer.php?objet=lien&numUrl='.$urlCourante->numUrl.'"><img src="icones/supprimer.png" alt="Supprimer"/></a>';
        }
        
        // Affichage du lien
        echo    '<img src="icones/lien.png" alt="[Lien]"/> '.
                '<img src="icones/pays/'.$urlCourante->langue.'.png" alt="[Drapeau]"/>'.
                ' <a href="lien.php?numUrl='.$urlCourante->numUrl.'" title="'.$urlCourante->url.'">'.htmlentities($urlCourante->nom).'</a> '.
                '- '.$urlCourante->nombreCommentaire().' commentaire(s)';
        
        //Affichage de la note si elle existe (cad au moins 1 commentaire)
        if ($urlCourante->note() != '') {
            echo ' | Note :'.$urlCourante->note();
        }
        echo '<strong>'.htmlentities('[À valider]').'</strong>';
        echo    '<br />'."\n";
    }
}

/**
 *  Affichage des livres contenu dans le dossier courant
 **/

$dossier->listeLivre();
while ($dossier->livreSuivantExiste()) {
    $livreCourant = $dossier->livreSuivant();
    
    // On affiche si le livre à été valider
    if ($livreCourant->valider == 1)
    {
        // Gestion des options administrateurs
        if (isset($_SESSION['login'])) {
            echo '<a href="supprimer.php?objet=livre&numLivre='.$livreCourant->numLivre.'"><img src="icones/supprimer.png" alt="Supprimer" /></a>';
            echo '<a href="formulaire.php?action=modifLivre&amp;numLivre='.$livreCourant->numLivre.'&amp;numDossier='.$livreCourant->numDossierParent.'"><img src="icones/modifier.png" alt="Editer "/></a>';
        }
        
        // Affichage du livre
        echo    '<img src="icones/livre.png" alt="[Livre]"/> '.
                '<img src="icones/pays/'.$livreCourant->langue.'.png" alt="['.$livreCourant->langue.']"/> '.
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

// Déplacement du dossier
if (isset($_SESSION['login']) && $dossier->numDossier != DOSSIER_RACINE)
{
    echo '<div class="dossier">';
    $liste = Dossier::listeTousDossier($dossier->numDossier);
    echo '<form name="form1" id="form1" method="post" action="deplacer.php">';
    echo 'Deplacer le dossier <em>'.$dossier->nom.'</em> dans le dossier : ';
    echo '<select name="numDossierCible">';
    
    foreach ($liste as $cle => $ligne) {
        echo '<option value="'.$cle.'">'.$ligne.'</option>';    
    }
    echo '</select>';
    echo '<input type="hidden" name="numDossier" value="'.$dossier->numDossier.'" />';
    echo '<input type="hidden" name="objet" value="dossier" />';
    echo '<input type="submit" name="go" value="D&eacute;placer" />';
    echo '</form>';  
    echo '</div>';
}

// Affichage de la signification des icones
echo '<p class="legende" title="L&eacute;gende des icones">';
echo '<img src="icones/lien.png" alt="[Lien]"/> Liens | <img src="icones/livre.png" alt="[Livre]"/> Livre';
if (isset($_SESSION['login'])) {
    echo ' | <img src="icones/supprimer.png" alt="[Supprimer]"/> Supprimer';
}
echo '</p>';

// Affichage des liens pour ajouter des éléments
echo '<div class="ajout"><p>';
echo    '<a href="formulaire.php?action=ajoutLivre&amp;numDossier='.$dossier->numDossier.'">Ajouter un livre</a> | '.
        '<a href="formulaire.php?action=ajoutLien&amp;numDossier='.$dossier->numDossier.'">Ajouter un lien</a>';

// Lien pour passer et quitter le mode Administrateur
if (isset($_SESSION['login'])) {
    echo ' | <a href="formulaire.php?action=ajoutDossier&amp;numDossier='.$dossier->numDossier.'">Ajouter un dossier</a>';
    echo '<br /><a href="administration.php">Administration</a> | <a href="logout.php">Quitter le mode <strong>Administrateur</strong></a>';
} else {
    echo '<br /><a href="administration.php">Passer en mode <strong>Administrateur</strong></a>';
}
// Lien pour l'exportation et l'importation en XML
/*if (isset($_SESSION['login'])) {
    echo '<br /><a href="io.php?action=export&amp;numDossier='.$dossier->numDossier.'">'.htmlentities('Exporter depuis ce dossier').'</a>';
}*/
echo '</p></div>';
bas();
?>