<?php
include_once('db.php');

function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
    }

function haut()
{
    $_SESSION['temps'] = getmicrotime();
    echo '<?xml version="1.0" encoding="iso-8859-15"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
  <head>
    <title>Books &amp; Links Repository</title>
    <link rel="stylesheet" type="text/css"  href="style.css" title="default" />
  </head>
  <body>';
}

function bas() {
    $diff = getmicrotime()-$_SESSION['temps'];
    ?>
    <div class="copyright">
        <a href="http://blr.berlios.de">Books &amp; Links Repository</a>
        | &copy; 2004 Fabien SCHWOB<br />
        Script sous licence GNU GPL.
        |  Page générée en <?php echo number_format($diff, 4, ',', ' ')."s"; ?>
    </div>
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