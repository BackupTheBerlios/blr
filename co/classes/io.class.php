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

function export($dossier) {
    $export  = '<?xml version="1.0" encoding="iso-8859-15"?>';
    $export .= '<blr>';
    
    $export .= expo($dossier);
    $export .= '</blr>';
    return $export;
}

function urlDossier($dossier) {
    $dossier = new Dossier($dossier);
    $contenu = '';
    $dossier->listeUrl();
    while ($dossier->urlSuivanteExiste())
    {
        $urlCourante = $dossier->urlSuivante();
    
        if ($urlCourante->valider == 1)
        {         
            // Affichage du lien
            $contenu .=    '<lien langue="'.$urlCourante->langue.'">'.
                    '<url>'.$urlCourante->url.'</url>'.
                    '<nom>'.$urlCourante->nom.'</nom>'.
                    commentaireLien($urlCourante->numUrl).
                    '</lien>';
        }     
    }    
    return $contenu;
}

function livreDossier($dossier)
{
    $dossier = new Dossier($dossier);
    $contenu = '';
    // Liste des livres
    $dossier->listeLivre();
    while ($dossier->livreSuivantExiste()) {
        $livreCourant = $dossier->livreSuivant();
        
        // On affiche si le livre à été valider
        if ($livreCourant->valider == 1)
        {
            // Affichage du livre
            $contenu .=  '<livre langue="'.$livreCourant->langue.'">'.
                        '<titre>'.$livreCourant->titre.'</titre>'.
                        '<sousTitre>'.$livreCourant->sousTitre.'</sousTitre>'.
                        '<auteur>'.$livreCourant->auteur.'</auteur>'.
                        '<editeur>'.$livreCourant->editeur.'</editeur>'.
                        '<prix>'.$livreCourant->prix.'</prix>'.
                        '<pages>'.$livreCourant->pages.'</pages>'.
                        '<numEdition>'.$livreCourant->numEdition.'</numEdition>'.
                        '<lienCommercial>'.$livreCourant->lienCommercial.'</lienCommercial>'.
                        '<isbn>'.$livreCourant->isbn.'</isbn>'.
                        '<dateParution>'.$livreCourant->dateParution.'</dateParution>'.
                        '<collection>'.$livreCourant->collection.'</collection>'.
                        '<niveau>'.$livreCourant->niveau.'</niveau>'.
                        '<poids>'.$livreCourant->poids.'</poids>'.
                        '<format>'.$livreCourant->format.'</format>'.
                        '<urlLivre>'.$livreCourant->urlLivre.'</urlLivre>'.
                        '<resume>'.$livreCourant->resume.'</resume>'.
                        commentaireLivre($livreCourant->numLivre).
                        '</livre>';
                        
        }
    }
    return $contenu;    
}

function dossierDossier ($dossier)
{
    $dossier = new Dossier($dossier);

    // Liste des sous dossiers
    $dossier->listeSousDossier();
    while ($dossier->dossierSuivantExiste())
    {
        $dossierCourant = $dossier->sousDossierSuivant();
        $export .= '<dossier nom="'.$dossierCourant->nom.'">';
        $export .= urlDossier($dossierCourant->numDossier);
        $export .= livreDossier($dossierCourant->numDossier); 
        $export .=  '</dossier>';    
    }
}

function commentaireLien($numUrl)
{
    $listeCommentaire = '';
    $lien = new Url($numUrl);
    
    $lien->listeCommentaire();
    while ($lien->commentaireSuivantExiste()) {
        $commentaireCourant = $lien->commentaireSuivant();
        $listeCommentaire .= '<commentaire><auteur>'.$commentaireCourant->auteur.
                             '</auteur><note>'.$commentaireCourant->note.'</note>';
        $listeCommentaire .= '<texte>'.$commentaireCourant->commentaire.'</texte>';
        $listeCommentaire .= '</commentaire>';
    }
    return $listeCommentaire; 
}

function commentaireLivre($numLivre)
{
    $listeCommentaire = '';
    $livre = new Livre($numLivre);
    $livre->listeCommentaire();
    while ($livre->commentaireSuivantExiste()) {
        $commentaireCourant = $livre->commentaireSuivant();
        $listeCommentaire .= '<commentaire><auteur>'.$commentaireCourant->auteur.
                             '</auteur><note>'.$commentaireCourant->note.'</note>';
        $listeCommentaire .= '<texte>'.$commentaireCourant->commentaire.'</texte>';
        $listeCommentaire .= '</commentaire>';
    }
    return $listeCommentaire;    
}

function expo($numdossier)
{
    /*
    // algo
    function expo()
        
        recup liste livre
            dump livre
            recup liste comm
                dump comm
        recup liste url
            dump livre
            recup liste comm
                dump comm
        si (dossier est parent)
            recup liste dossier
                dump dossier
                exp(dossier);
    */
    
    $export .= livreDossier($numdossier);
    $export .= urlDossier($numdossier);
    if (estParent($numdossier))
    {
        $dossier = new Dossier($numdossier);
        $dossier->listeSousDossier();
        while ($dossier->dossierSuivantExiste())
        {
            $dossierCourant = $dossier->sousDossierSuivant();
            if ($dossierCourant->numDossierParent == $numdossier) {
                $export .= '<dossier nom="'.$dossierCourant->nom.'">';
                $export .= expo($dossierCourant->numDossier);
                $export .=  '</dossier>';
            }
        }
    }
    return $export; 
}
function estParent($dossier)
{
    $sql = 'SELECT COUNT(*) AS ok FROM dossier WHERE numDossierParent = '.$dossier;
    connexion();
    $resultat = mysql_query($sql);
    deconnexion();
    $donnee = mysql_fetch_array($resultat);
    
    if ($donnee['ok'] == 0)
    {
        return false;
    } else
    {
        return true;    
    }
}
?>