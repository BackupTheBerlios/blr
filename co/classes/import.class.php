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

// Inclusion des fichiers n�cessaires
require_once('db.php');
require_once('url.class.php');
require_once('dossier.class.php');
require_once('livre.class.php');

header("content-type: text/plain; charset=ISO-8859-15");

if(!$dom = domxml_open_file(realpath("test.xml"))) {
  echo "Erreur lors de l'analyse du document\n";
  exit;
}
$root = $dom->document_element();
$fils = $root->first_child();

/*function listeElementNoeudCourant ($noeud) {
    while($noeud) {
        //echo $noeud->node_name().$noeud->node_value()."\n";
        echo ajout($noeud)."\n";
        if ($noeud->has_child_nodes()) {
            $fils = $noeud->first_child();
            if ($fils->node_name() == 'dossier') {
                echo "\t".listeElementNoeudCourant($fils);
            } else {
                while($fils) {
                    echo "\t".$fils->node_name()."\n";
                    $fils = $fils->next_sibling();
                }
            }
        }
        $noeud = $noeud->next_sibling();
    }
}*/
function listeElementNoeudCourant ($noeud, $iter = 0) {
    $iter++;
    while($noeud) {
        switch ($noeud->node_name()) {
            case "dossier":
                echo $iter."-"."dossier ".$noeud->get_attribute('nom')."\n";
                $fils = $noeud->first_child();
                echo listeElementNoeudCourant($fils, $iter);
                break;
            case "lien":
                $langue = $noeud->get_attribute('langue');
                $url    = $noeud->get_attribute('url');
                $nom    = $noeud->get_attribute('nom');
                echo $iter."-"."lien [".$langue.
                    '] '.$url.' '.$nom."\n";
                break;
            case "livre":
                echo "livre\n";
                break;
        }
        //echo ajout($noeud)."\n";
        /*if ($noeud->has_child_nodes()) {
            $fils = $noeud->first_child();
            if ($fils->node_name() == 'dossier') {
                echo "\t".listeElementNoeudCourant($fils);
            } else {
                while($fils) {
                    echo "\t".$fils->node_name()."\n";
                    $fils = $fils->next_sibling();
                }
            }
        }*/
        $noeud = $noeud->next_sibling();
    }
}
function ajout ($noeud) {
    echo $noeud->node_name();    
}
echo listeElementNoeudCourant($fils);
?>