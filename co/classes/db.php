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

require_once('conf.inc.php');

function connexion()
{
	$serveur  = BLR_SERVER;
	$login    = BLR_LOGIN;
	$password = BLR_PASSWORD;

	$base     = BLR_BASE;
	
	$erreur   = "";

	if (!mysql_connect($serveur, $login, $password)) {
		$erreur .= "Erreur lors de la connexion au serveur\n";
		die();
	} else {
		if (!mysql_select_db($base)) {
			$erreur .= "Erreur lors de la connexion à la base\n";
		}
	}
	return nl2br(htmlentities($erreur));
}

function deconnexion()
{
	mysql_close();
}
?>