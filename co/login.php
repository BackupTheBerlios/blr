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

// session login
include_once('classes/db.php');
session_start();

$login_form	=	$_POST['login'];
$password_form	=	$_POST['password'];

$login	=	htmlspecialchars(stripslashes($login_form));
$password	=	htmlspecialchars(stripslashes($password_form));


$sql = "SELECT password FROM `admin` WHERE login = '".$login."'";
connexion();
$resultat = mysql_query($sql);
deconnexion();
$info = mysql_fetch_array($resultat);
$_SESSION['login'] = $login;


if (($password == $info['password']))
	{
	header("Location: administration.php");
	}
else
	{
	unset($_SESSION['login']);
	header("Location: administration.php");
	}

?>