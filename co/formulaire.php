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
<h1><a href="index.php">Books &amp; Links Repository</a></h1>
<?php

/**
 *  Ajout d'un livre
 */

if ($_GET['action'] == 'ajoutLivre')
{
    $dossier = new Dossier($_GET['numDossier']);
    echo '<div class="arborescence">Ajout d\'un livre dans  <strong>'.$dossier->arborescence().'</strong></div>';
    echo '<div class="dossier">';
    ?>
    <form id="form1" method="post" action="ajouter.php?objet=livre">
        <p>
            <fieldset>
            <legend>S&eacute;l&eacute;ction du dossier</legend>            
            Vous pouvez ajouter ce livre dans le dossier courant, ou proposez un sous-dossier qui sera plus pertinent.<br />
            <input type="radio" name="dossier" value="courant" checked="checked" /> Dossier courant
            ou <input type="radio" name="dossier" value="nouveau" /> sous-dossier :
            <input type="text" name="nouveauDossier" />
            </fieldset>
        </p>        
        <p>
            <fieldset>
            <legend>Ajout d'un livre</legend>
            <label>Titre *</label>
            <input type="text" name="titre" /><br />
            <label>Sous-titre</label>
            <input type="text" name="sousTitre" /><br />
            <label>Auteur</label>
            <input type="text" name="auteur" /><br />
            <label>Editeur</label>
            <input type="text" name="editeur" /><br />
            <label>Prix</label>
            <input type="text" name="prix" /><br />
            <label>Pages</label>
            <input type="text" name="pages" /><br />
            <label>Edition</label>
            <input type="text" name="numEdition" /><br />
            <label>Site du livre</label>
            <input type="text" name="urlLivre" /><br />
            <label>ISBN</label>
            <input type="text" name="isbn" /><br />
            <label>Date de parution</label>
            <input type="text" name="dateParution" /><br />
            <label>Collection</label>
            <input type="text" name="collection" /><br />
            <label>Niveau</label>
            <select name="niveau">
                <option value="debutant">D&eacute;butant</option>
                <option value="experimente">Experiment&eacute;</option>
                <option value="specialiste">Specialiste</option>
            </select><br />
            <label>Poids</label>
            <input type="text" name="poids" /><br />
            <label>Format</label>
            <input type="text" name="format" /><br />
            <label>Langue *</label>
            <select name="langue">
              <option value="fr">Fran&ccedil;ais</option>
              <option value="us">Anglais</option>
            </select><br />
            R&eacute;sum&eacute; du livre <br />
            <textarea name="resume" cols="72" rows="5"></textarea><br />
            <input type="hidden" name="numDossier" value="<?php echo $_GET['numDossier'];?>" />
            <input type="submit" name="Submit" value="Ajouter le livre" />
            </fieldset>
        </p>
    </form>
    <?php

/**
 *  Modification d'un livre
 */

}if ($_GET['action'] == 'modifLivre')
{
    $livre = new Livre($_GET['numLivre']);
    $dossier = new Dossier($_GET['numDossier']);
    echo '<div class="arborescence">Modification d\'un livre dans  <strong>'.$dossier->arborescence().'</strong></div>';
    echo '<div class="dossier">';
    ?>
    <form id="form1" method="post" action="modifier.php?objet=livre">
        <p>
            <fieldset>
            <legend>Ajout d'un livre</legend>
            <label>Titre *</label>
            <input type="text" name="titre" value="<?php echo htmlentities($livre->titre); ?>" /><br />
            <label>Sous-titre</label>
            <input type="text" name="sousTitre" value="<?php echo htmlentities($livre->sousTitre); ?>" /><br />
            <label>Auteur</label>
            <input type="text" name="auteur" value="<?php echo htmlentities($livre->auteur); ?>" /><br />
            <label>Editeur</label>
            <input type="text" name="editeur" value="<?php echo htmlentities($livre->editeur); ?>" /><br />
            <label>Prix</label>
            <input type="text" name="prix" value="<?php echo htmlentities($livre->prix); ?>" /><br />
            <label>Pages</label>
            <input type="text" name="pages" value="<?php echo htmlentities($livre->pages); ?>" /><br />
            <label>Edition</label>
            <input type="text" name="numEdition" value="<?php echo htmlentities($livre->numEdition); ?>" /><br />
            <label>Site du livre</label>
            <input type="text" name="urlLivre" value="<?php echo htmlentities($livre->urlLivre); ?>" /><br />
            <label><acronym title="International Standard Book Number">ISBN</acronym></label>
            <input type="text" name="isbn" value="<?php echo htmlentities($livre->isbn); ?>" /><br />
            <label>Date de parution</label>
            <input type="text" name="dateParution" value="<?php echo htmlentities($livre->dateParution); ?>" /><br />
            <label>Collection</label>
            <input type="text" name="collection" value="<?php echo htmlentities($livre->collection); ?>" /><br />
            <label>Niveau</label>
            <select name="niveau">
                <option value="debutant">D&eacute;butant</option>
                <option value="experimente">Experiment&eacute;</option>
                <option value="specialiste">Specialiste</option>
            </select><br />
            <label>Poids</label>
            <input type="text" name="poids" value="<?php echo htmlentities($livre->poids); ?>" /><br />
            <label>Format</label>
            <input type="text" name="format" value="<?php echo htmlentities($livre->format); ?>" /><br />
            R&eacute;sum&eacute; du livre <br />
            <textarea name="resume" cols="72" rows="7"><?php echo htmlentities($livre->resume); ?></textarea><br />
            <label>Langue *</label>
            <select name="langue">
              <option value="fr" <?php if ($livre->langue == 'fr') echo 'selected="selected"'; ?>>Fran&ccedil;ais</option>
              <option value="us" <?php if ($livre->langue == 'us') echo 'selected="selected"'; ?>>Anglais</option>
            </select><br />
            <input type="hidden" name="numDossier" value="<?php echo $_GET['numDossier'];?>" />
            <input type="submit" name="Submit" value="Ajouter le livre" />
            </fieldset>
        </p>
    </form>
    <?php

/**
 *  Ajout d'un lien
 */

} elseif ($_GET['action'] == 'ajoutLien')
{
    $dossier = new Dossier($_GET['numDossier']);
    echo '<div class="arborescence">Ajout d\'un lien dans <strong>'.$dossier->arborescence().'</strong></div>';
    echo '<div class="dossier">';
    ?>
    <form id="form1" method="post" action="ajouter.php?objet=lien">
        <p>
            <fieldset>
            <legend>S&eacute;l&eacute;ction du dossier</legend>            
            Vous pouvez ajouter ce lien dans le dossier courant, ou proposez un sous-dossier qui sera plus pertinent.<br />
            <input type="radio" name="dossier" value="courant" checked="checked" /> Dossier courant
            ou <input type="radio" name="dossier" value="nouveau" /> sous-dossier :
            <input type="text" name="nouveauDossier" />
            </fieldset>
        </p>
        <p>
            <fieldset>
            <legend>Informations sur le lien</legend>            
            Nom *<br />
            <input type="text" name="nom" size="60"/><br />
            Url<br />
            <input type="text" name="url" size="60" /><br />
            Langue *<br />
            <select name="langue">
              <option value="fr">Fran&ccedil;ais</option>
              <option value="us">Anglais</option>
            </select><br />
            <input type="hidden" name="numDossier" value="<?php echo $_GET['numDossier'];?>" />
            <input type="submit" name="Submit" value="Ajouter le lien" />
            </fieldset>
        </p>
    </form>
    <?php
    
/**
 *  Modification d'un lien
 */
 
}elseif ($_GET['action'] == 'modifLien')
{
    $dossier = new Dossier($_GET['numDossier']);
    echo '<div class="arborescence">Ajout d\'un lien dans <strong>'.$dossier->arborescence().'</strong></div>';
    echo '<div class="dossier">';
    if (isset($_SESSION['login'])) {
        $lien = new Url($_GET['numUrl']);
        ?>
        <form id="form1" method="post" action="modifier.php?objet=lien">
            <p>
                Nom *<br />
                <input type="text" name="nom" value="<?php echo $lien->nom ?>" size="60"/><br />
                Url<br />
                <input type="text" name="url" value="<?php echo $lien->url ?>" size="60" /><br />
                Langue *<br />
                <select name="langue">
                  <option value="fr" <?php if ($lien->langue == 'fr') echo 'selected="selected"'; ?>>Fran&ccedil;ais</option>
                  <option value="us" <?php if ($lien->langue == 'us') echo 'selected="selected"'; ?>>Anglais</option>
                </select><br />
                <input type="hidden" name="numUrl" value="<?php echo $_GET['numUrl'];?>" />
                <input type="submit" name="Submit" value="Modifier le lien" />
            </p>
        </form>
        <?php  
    } else {
        echo htmlentities('Attention, cette page est réservé aux administrateurs.');
    }
    
/**
 *  Ajout d'un dossier
 */
 
} elseif ($_GET['action'] == 'ajoutDossier')
{
    if (isset($_SESSION['login'])) {
        $dossier = new Dossier($_GET['numDossier']);
        echo '<div class="arborescence">Ajout d\'un dossier dans <strong>'.$dossier->arborescence().'</strong></div>';
        echo '<div class="dossier">';
        ?>
        <form id="form1" method="post" action="ajouter.php?objet=dossier">
            <p>
                <fieldset>
                <legend>Information sur le nouveau dossier</legend>            
                <label>Nom *</label>
                <input type="text" name="nom" size="60"/><br />
                <input type="hidden" name="numDossier" value="<?php echo $_GET['numDossier'];?>" />
                <input type="submit" name="Submit" value="Ajouter le dossier" />
                </fieldset>
            </p>
        </form>
        <?php
    } else {
        echo '<div class="dossier">';
        echo htmlentities('Attention, cette page est réservé aux administrateurs.');
    }

/**
 *  Modification d'un dossier
 */
         
} elseif ($_GET['action'] == 'modifDossier')
{
    if (isset($_SESSION['login'])) {
        $dossier = new Dossier($_GET['numDossier']);
        echo '<div class="arborescence">Ajout d\'un dossier dans <strong>'.$dossier->arborescence().'</strong></div>';
        echo '<div class="dossier">';
        ?>
        <form id="form1" method="post" action="modifier.php?objet=dossier">
            <p>
            <fieldset>
                <legend>Modification du dossier</legend>    
                <label>Nom *</label>
                <input type="text" name="nom" value="<?php echo $dossier->nom; ?>" size="60"/><br />
                <input type="hidden" name="numDossier" value="<?php echo $_GET['numDossier'];?>" />
                <input type="submit" name="Submit" value="Modifier le nom du dossier" />
            </p>
        </form>
        <?php
    } else {
        echo '<div class="dossier">';
        echo htmlentities('Attention, cette page est réservé aux administrateurs.');
    }
            
}
echo '</div>';
bas();
?>