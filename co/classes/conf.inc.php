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


/**
 *  Configuration de l'application
 **/

// Base de données
define('BLR_SERVER','localhost');
define('BLR_BASE','blr');
define('BLR_LOGIN','root');
define('BLR_PASSWORD','');
define('BLR_PREFIX','');

// Nom des tables
define('BLR_TABLE_URL','url');
define('BLR_TABLE_LIVRE','livre');
define('BLR_TABLE_DOSSIER','dossier');
define('BLR_TABLE_COMMENTAIRE','commentaire');
define('BLR_TABLE_ADMIN','admin');
?>