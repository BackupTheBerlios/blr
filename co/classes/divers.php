<?php
include_once('db.php');

function haut(){
    ?>
<!DOCTYPE html 
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Books & Links Repository</title>
    <link rel="stylesheet" type="text/css"  href="style.css" title="default" />
  </head>
  <body>
<?php
}

function bas() {
    ?>
    <div class="copyright">Books & Links Repository | &copy; 2004 Fabien SCHWOB | Script sous licence GNU GPL.</div>
      </body>
</html>
<?php
}

function nbLivreAValider()
{
    $sql = "SELECT COUNT(*) AS nblivre FROM livre WHERE valider = 0";
    connexion();
    $resultat = mysql_query($sql);
    deconnexion();
    $livre = mysql_fetch_array($resultat);
    return $livre['nblivre'];        
}

function nbLienAValider()
{
    $sql = "SELECT COUNT(*) AS nblien FROM url WHERE valider = 0";
    connexion();
    $resultat = mysql_query($sql);
    deconnexion();
    $lien = mysql_fetch_array($resultat);
    return $lien['nblien'];        
}
?>