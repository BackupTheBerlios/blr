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
include_once('classes/commentaire.class.php');
include_once('classes/divers.php');

haut();

// Un peu d'HTML
?>
<h1><a href="index.php">Books &amp; Links Repository</a></h1>
<?php
// On récupère le numero du dossier et le crée l'objet correspondant
if (isset($_GET['numLivre'])) {
    $livre = new Livre($_GET['numLivre']);
    echo "<h2>".htmlentities($livre->titre)." - ";
    echo htmlentities($livre->sousTitre)."</h2>";
    
    echo '<div class="dossier">';
    echo '<strong>Auteur</strong> : '.htmlentities($livre->auteur).'<br />';
    echo '<strong>Editeur</strong> : '.htmlentities($livre->editeur).'<br />';
    
    echo '<strong>Pages</strong> : '.htmlentities($livre->pages)." - ";
    echo '<strong>Prix</strong> : '.htmlentities($livre->prix)." &euro;<br />";
    echo '<strong>ISBN</strong> : '.htmlentities($livre->isbn)."<br />";
    
    echo '<strong>Note</strong> : '.htmlentities($livre->note)."<br />";
    echo '<strong>Langue</strong> : '.htmlentities($livre->langue)."<br />";
        
    echo '<strong>Edition</strong> : '.htmlentities($livre->numEdition)."<br />";
    echo '<strong>Site du livre</strong> : <a href="'.$livre->urlLivre.'">'.htmlentities($livre->urlLivre).'</a><br />';
    
    echo htmlentities($livre->lienCommercial)."<br />";
    
    echo htmlentities($livre->dateParution)."<br />";
    echo htmlentities($livre->collection)."<br />";
    echo htmlentities($livre->niveau)."<br />";
    echo htmlentities($livre->poids)."<br />";
    echo htmlentities($livre->format)."<br />";
    
    echo nl2br(htmlentities($livre->resume));
    echo '</div>';
    
    // Déplacement du livre
    if (isset($_SESSION['login']))
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
        echo '<input type="hidden" name="numLivre" value="'.$livre->numLivre.'" />';
        echo '<input type="hidden" name="objet" value="livre" />';
        echo '<input type="submit" name="go" value="D&eacute;placer" />';
        echo '</form>';  
        echo '</div>';
    }
    
    echo '<div class="arborescence">';
    echo '<a href="index.php?numDossier='.$livre->numDossierParent.'">Retour au dossier</a>';
    echo '</div>';
    
    // On affiche les liens pour la validation, si le livre n'a pas
    // encore été validé.
    if ($livre->valider == 0) {
        echo '<div class="validation">';
        echo '<p><a href="moderation.php?objet=livre&numLivre='.$livre->numLivre.'"><img src="icones/valider.png" />Valider</a>';
        echo ' | <a href="supprimer.php?objet=livre&numLivre='.$livre->numLivre.'"><img src="icones/supprimer.png" />Supprimer</a></p>';
        echo '</div>';
    }
    
    // Affichage des commentaires
    echo '<div class="commentaire">';
    echo 'Commentaire :<br /><br />';
    $livre->listeCommentaire();
    while ($livre->commentaireSuivantExiste()) {
        $commentaireCourant = $livre->commentaireSuivant();
        
        if (isset($_SESSION['login']))
        {
            echo '<a href="supprimer.php?objet=commentaire&numCommentaire='.$commentaireCourant->numCommentaire.'"><img src="icones/supprimer.png" /></a> ';    
        }
        
        echo  'Auteur : '.htmlentities($commentaireCourant->auteur).' | Note : '.htmlentities($commentaireCourant->note).'<br />';
        echo  htmlentities($commentaireCourant->commentaire).'<br /><br />';
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
            <input type="hidden" name="numLivre" value="<?php echo $_GET['numLivre'];?>" />
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
    echo "Aucun livre selectionné";
}

bas();
?>