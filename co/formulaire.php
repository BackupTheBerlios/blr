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
<a href="index.php"><h1>Books & Links Repository</h1></a>
<?php
echo '<div class="dossier">';
if ($_GET['action'] == 'ajoutLivre')
{
    ?>
    <form name="form1" id="form1" method="post" action="ajouter.php?objet=livre">
        <p>
            Titre *<br />
            <input type="text" name="titre" /><br />
            Sous-titre<br />
            <input type="text" name="sousTitre" /><br />
            Auteur<br />
            <input type="text" name="auteur" /><br />
            Editeur<br />
            <input type="text" name="editeur" /><br />
            Prix<br />
            <input type="text" name="prix" /><br />
            Pages<br />
            <input type="text" name="pages" /><br />
            Edition<br />
            <input type="text" name="numEdition" /><br />
            Site du livre <br />
            <input type="text" name="urlLivre" /><br />
            ISBN<br />
            <input type="text" name="isbn" /><br />
            Date de parution <br />
            <input type="text" name="dateParution" /><br />
            Collection<br />
            <input type="text" name="collection" /><br />
            Niveau<br />
            <select name="niveau">
                <option value="debutant">D&eacute;butant</option>
                <option value="experimente">Experiment&eacute;</option>
                <option value="specialiste">Specialiste</option>
            </select><br />
            Poids<br />
            <input type="text" name="poids" /><br />
            Format<br />
            <input type="text" name="format" /><br />
            R&eacute;sum&eacute; du livre <br />
            <textarea name="resume"></textarea><br />
            Langue *<br />
            <select name="langue">
              <option value="fr">Fran&ccedil;ais</option>
              <option value="us">Anglais</option>
            </select><br />
            <input type="hidden" name="numDossier" value="<?php echo $_GET['numDossier'];?>" />
            <input type="submit" name="Submit" value="Ajouter le livre" />
        </p>
    </form>
    <?php
} elseif ($_GET['action'] == 'ajoutLien')
{
    ?>
    <form name="form1" id="form1" method="post" action="ajouter.php?objet=lien">
        <p>
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
        </p>
    </form>
    <?php    
} elseif ($_GET['action'] == 'ajoutDossier')
{
    ?>
    <form name="form1" id="form1" method="post" action="ajouter.php?objet=dossier">
        <p>
            Nom *<br />
            <input type="text" name="nom" size="60"/><br />
            <input type="hidden" name="numDossier" value="<?php echo $_GET['numDossier'];?>" />
            <input type="submit" name="Submit" value="Ajouter le dossier" />
        </p>
    </form>
    <?php    
}
echo '</div>';
bas();
?>