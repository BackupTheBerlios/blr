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
require_once('db.php');
require_once('url.class.php');
require_once('dossier.class.php');
require_once('livre.class.php');
require_once('divers.php');

function export($dossier) {
    $export  = '<?xml version="1.0" encoding="iso-8859-15"?>';
    $export .= '<blr>';
    
    if (isset($dossier))
    {
        $dossier = new Dossier($dossier);
    } else
    {
        // On définit ici le numéro du dossier racine
        $dossier = new Dossier(3);
    }

    // Liste des sous dossiers
    $dossier->listeSousDossier();
    while ($dossier->dossierSuivantExiste()) {
        $dossierCourant = $dossier->sousDossierSuivant();
        $export .= '<dossier nom="'.$dossierCourant->nom.'"></dossier>';
    }
    
    $export .= '</blr>';
    return $export;
}
header("Content-Type: text/xml");
echo export(3);
?>