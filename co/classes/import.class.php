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


//  do stuff with $mydoc...
if(!$dom = domxml_open_file(realpath("test.xml"))) {
  echo "Erreur lors de l'analyse du document\n";
  exit;
}

$root = $dom->document_element();
$fils = $root->first_child();

while($fils) {
   echo $fils->node_name()."<br />";
   $fils = $fils->next_sibling();
}
?>