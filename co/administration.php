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
echo '<div class="dossier">';

if (isset($_SESSION['login'])) {
    echo '<h2>Tableau de bord</h2>';
    
    echo '<h3>Mod&eacute;ration :</h3>';
    echo '<strong>'.nbLivreAValider().'</strong> livre(s) et ';
    echo '<strong>'.nbLienAValider().'</strong> lien(s) &agrave; valider.';
    
    echo '<h3>Importation / Exportation</h3>';
    //echo '<a href="io.php?action=export">'.htmlentities('Télécharger l\'intégralité de la base de connaissance.').'</a>';
    echo htmlentities('Télécharger l\'intégralité de la base de connaissance.');
    
    echo '<h3>Statistiques</h3>';
    
    echo '<a href="index.php">Sommaire</a> | <a href="logout.php">Quitter le mode administrateur</a>';
} else {
    ?>
    <p>
        <form method="post" action="login.php" name="login">
            Nom d'utilisateur :<br />
            <input type="text" name="login" /><br />
            Mot de passe :<br />
            <input type="password" name="password" /><br />
            <input type="submit" value="S'identifer" name="logger" />
        </form>
    </p>
    <?php
}

echo '</div>';
bas();
?>