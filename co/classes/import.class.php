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

header("content-type: text/plain; charset=utf-8");

if(!$dom = domxml_open_file(realpath("test.xml"))) {
  echo "Erreur lors de l'analyse du document\n";
  exit;
}
$root = $dom->document_element();
$fils = $root->first_child();

function tab($taille) {
    $chaine = '';
    for ($i = 1; $i <= $taille; $i++) {
        $chaine .= "\t";
    }
    return $chaine;
}
        

function listeElementNoeudCourant ($noeud, $numDossier, $iter = 0) {
    $iter++;
    while($noeud) {
        switch ($noeud->node_name()) {
            case "dossier":
                
                // Ajout d'un dossier 
                $nom = $noeud->get_attribute('nom');
                echo tab($iter).$iter."-"."dossier ".$nom."\n";
                $dossierParent = new Dossier($numDossier);
                $dossier = new Dossier();
                $dossier->nom = $nom;
                $numNouveauDossier = $dossierParent->ajouterDossier($dossier);
                
                $fils = $noeud->first_child();
                listeElementNoeudCourant($fils, $numNouveauDossier, $iter);
                break;
            case "lien":
            
                // On récupère les variables
                $langue = $noeud->get_attribute('langue');
                $url    = $noeud->get_attribute('url');
                $nom    = $noeud->get_attribute('nom');
                
                // On crée les objets Dossier et Url
                $dossierParent  = new Dossier($numDossier);
                $lien           = new Url();
                
                // On définit les attributs de l'Url
                $lien->langue   = $langue;
                $lien->url      = $url;
                $lien->nom      = $nom;
                
                // On ajoute le lien
                $dossierParent->ajouterLien($lien, 1);
                
                echo tab($iter).$iter."-"."lien [".$langue.
                    '] '.$url.' '.$nom."\n";
                break;
            case "livre":
                echo tab($iter)."livre\n";
                break;
        }
        $noeud = $noeud->next_sibling();
    }
}
function ajout ($noeud) {
    echo $noeud->node_name();    
}
echo listeElementNoeudCourant($fils, 16);
?>