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
echo '<div class="dossier">';

if (isset($_SESSION['login'])) {
    echo 'loggué<br />';
    echo '<a href="logout.php">Quitter le mode administrateur</a>';
} else {
    ?>
    <form method="post" action="login.php" name="login">
        <input type="text" name="login" />
        <input type="password" name="password" />
        <input type="submit" value="S'identifer" name="logger" />
    </form>
    <?php
}

echo '</div>';
bas();
?>