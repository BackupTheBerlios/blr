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

// Inclusion des fichiers nécessaires
include_once('classes/dossier.class.php');
include_once('classes/url.class.php');
include_once('classes/commentaire.class.php');
include_once('classes/divers.php');

haut();

// Un peu d'HTML
?>
<h1>Books & Links Repository</h1>
<?php
// On récupère le numero du dossier et le crée l'objet correspondant
if (isset($_GET['numUrl'])) {
    $lien = new Url($_GET['numUrl']);
    echo '<h2>'.$lien->nom.'</h2>';
    
    echo '<div class="dossier">';
    echo '<strong>Url</strong> : <a href="'.$lien->url.'">'.$lien->url.'</a><br />';
    echo '</div>';
    
    echo '<a href="index.php?numDossier='.$lien->numDossierParent.'">Retour au dossier</a>';
    
    // Affichage des commentaires
    echo '<div class="commentaire">';
    echo 'Commentaire :<br /><br />';
    $lien->listeCommentaire();
    while ($lien->commentaireSuivantExiste()) {
        $commentaireCourant = $lien->commentaireSuivant();
        echo  'Auteur : '.$commentaireCourant->auteur.' | Note : '.$commentaireCourant->note.'<br />';
        echo  $commentaireCourant->commentaire.'<br /><br />';
    }
    
    // Formulaire d'insertion de commentaire
    ?>
    <form name="ajoutCommentaire" id="ajoutCommentaire" method="post" action="ajouter.php?objet=commentaire">
        <p>
            Votre nom :<br />
            <input name="nom" type="text" id="nom" /><br />
            Votre commentaire concernant ce livre <br />    
            <textarea name="commentaire" cols="72" rows="5" id="commentaire"></textarea><br />
            La note &agrave; donner au livre.<br />
            <select name="note">
              <?php
              for ($i = 0; $i <= 20; $i++) {
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
} else {
    echo "Aucun lien selectionné";
}

bas();
?>