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

require_once('db.php');
require_once('document.class.php');

class Url extends Document{
    
    /*  
    *   Attributs de l'objet Dossier
    */
    var $nom;
    var $url;
    
    /*
    *   Variables concerant le fonctionnement de la classe    
    */
    var $numUrl;
    
    function Url($numUrl = 0) {
        $this->numUrl = $numUrl;
        if ($numUrl != 0) {
            // Requete SQL permettant de récupérer les infos concernant
            // le dossier courant (sauf pour le dossier racine)
            $sql_list   =  "SELECT nom, url, note, langue, nombreClick ".
                        "FROM `url` ".
                        "WHERE numUrl = ".$numUrl;
                                      
            // On se connecte et on effectue la requete
            connexion();
            $resultatReq = mysql_query($sql_list);
            $resultat = mysql_fetch_array($resultatReq);
            deconnexion();
            
            // On modifie les attributs de l'objet en fonction des
            // données venant de la BDD
            $this->nom          = $resultat['nom'];
            $this->url          = $resultat['url'];
            $this->note         = $resultat['note'];
            $this->langue       = $resultat['langue'];
            $this->nombreClick  = $resultat['nombreClick'];
            
        }
    }
}
?>