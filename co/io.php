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
include_once('classes/io.class.php');
include_once('classes/divers.php');

if (isset($_SESSION['login']) && $_GET['action'] == 'export')
{
    header('Content-Type: text/xml; charset=iso-8859-15');
    /*header('Content-Disposition: attachment; filename=export.xml');
    header('Pragma: no-cache');
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');*/
    if (isset($_GET['numDossier'])) {
        echo export($_GET['numDossier']);
    } else {
        echo export(3);
    }
} else {
    header("Location: index.php");    
}
?>