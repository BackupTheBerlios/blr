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
include_once('classes/commentaire.class.php');
include_once('classes/divers.php');

haut();

// Un peu d'HTML
?>
<h1><a href="index.php">Books &amp; Links Repository</a></h1>
<?php
// On récupère le numero du dossier et le crée l'objet correspondant
if (isset($_GET['numUrl'])) {
    $lien = new Url($_GET['numUrl']);
    echo '<h2>'.htmlentities($lien->nom).'</h2>';
    
    echo '<div class="dossier">';
    echo '<strong>Url</strong> : <a href="'.$lien->url.'" hreflang="'.$lien->langue.'" >'.$lien->url.'</a><br />';
    echo '</div>';
    
    // Déplacement du lien si on est administrateur et que le lien a
    // déjà été validé.
    if (isset($_SESSION['login']) && $lien->valider == 1)
    {
        echo '<div class="dossier">';
        $liste = Dossier::listeTousDossier();
        echo '<form name="form1" id="form1" method="post" action="deplacer.php">';
        echo 'Deplacer le livre vers le dossier : ';
        echo '<select name="numDossier">';
        
        foreach ($liste as $cle => $ligne) {
            echo '<option value="'.$cle.'">'.$ligne.'</option>';    
        }
        echo '</select>';
        echo '<input type="hidden" name="numUrl" value="'.$lien->numUrl.'" />';
        echo '<input type="hidden" name="objet" value="lien" />';
        echo '<input type="submit" name="go" value="D&eacute;placer" />';
        echo '</form>';  
        echo '</div>';
    }
    
    echo '<div class="arborescence">';
    echo '<a href="index.php?numDossier='.$lien->numDossierParent.'">Retour au dossier</a>';
    echo '</div>';
    
    // On affiche les liens pour la validation, si l'url n'a pas
    // encore été validé.
    if ($lien->valider == 0 && empty($lien->dossierSouhaite)) {
        echo '<div class="validation">';
        echo '<p><a href="moderation.php?objet=lien&amp;numUrl='.$lien->numUrl.'"><img src="icones/valider.png" />Valider</a>';
        echo ' | <a href="supprimer.php?objet=lien&amp;numUrl='.$lien->numUrl.'"><img src="icones/supprimer.png" />Supprimer</a></p>';
        echo '</div>';
    } elseif ($lien->valider == 0 && !empty($lien->dossierSouhaite)) {
        echo '<div class="validation">';
        echo '<p><a href="moderation.php?objet=lien&amp;numUrl='.$lien->numUrl.'"><img src="icones/valider.png" />Valider dans le dossier courant</a>';
        echo ' | <a href="moderation.php?objet=lienSousDossier&amp;numUrl='.$lien->numUrl.'"><img src="icones/valider.png" />Valider dans le sous-dossier <strong>'.$lien->dossierSouhaite.'</strong></a>';
        echo ' | <a href="supprimer.php?objet=lien&amp;numUrl='.$lien->numUrl.'"><img src="icones/supprimer.png" />Supprimer</a></p>';
        echo '</div>';
    }
    
    // Affichage des commentaires
    echo '<div class="commentaire">';
    echo 'Commentaire :<br /><br />';
    $lien->listeCommentaire();
    while ($lien->commentaireSuivantExiste()) {
        $commentaireCourant = $lien->commentaireSuivant();
        
        if (isset($_SESSION['login']))
        {
            echo '<a href="supprimer.php?objet=commentaire&numCommentaire='.$commentaireCourant->numCommentaire.'"><img src="icones/supprimer.png" /></a> ';    
        }
        
        echo  'Auteur : '.$commentaireCourant->auteur.' | Note : '.$commentaireCourant->note.'<br />';
        echo  $commentaireCourant->commentaire.'<br /><br />';
    }
    
    // Formulaire d'insertion de commentaire
    ?>
    <form id="ajoutCommentaire" method="post" action="ajouter.php?objet=commentaire">
        <p>
            Votre nom :<br />
            <input name="nom" type="text" id="nom" /><br />
            Votre commentaire concernant ce livre <br />    
            <textarea name="commentaire" cols="72" rows="5" id="commentaire"></textarea><br />
            La note &agrave; donner au livre.<br />
            <select name="note">
              <?php
              for ($i = 20; $i >= 0; $i--) {
                  echo '<option value="'.$i.'">'.$i.'</option>';
              }
              ?>
            </select>/20<br />
            <input type="hidden" name="numUrl" value="<?php echo $_GET['numUrl'];?>" />
            <input type="submit" name="Submit" value="Ajouter mon commentaire" />
        </p>
    </form>
    <?php
    echo '</div>';
    
    // Lien pour passer et quitter le mode Administrateur
    echo '<div class="ajout">';
    if (isset($_SESSION['login'])) {
        echo '<a href="administration.php">Administration</a> | <a href="logout.php">Quitter le mode <strong>Administrateur</strong></a>';
    } else {
        echo '<a href="administration.php">Passer en mode <strong>Administrateur</strong></a>';
    }
    echo '</div>';
} else {
    echo "Aucun lien selectionné";
}

bas();
?>