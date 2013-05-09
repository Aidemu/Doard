<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
<?php
//Si le titre est indiqué, on l'affiche entre les balises <title>
echo (!empty($titre))?'<title>'.$titre.'</title>':'<title> Forum </title>';
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="./assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./includes/scripts/ckeditor/ckeditor.js"></script>
</head>
<?php
 
//Attribution des variables de session
$lvl=(isset($_SESSION['level']))?(int) $_SESSION['level']:1;
$id=(isset($_SESSION['id']))?(int) $_SESSION['id']:0;
$pseudo=(isset($_SESSION['pseudo']))?$_SESSION['pseudo']:'';
 
//On inclue les 2 pages restantes
include("./includes/functions.php");
include("./includes/constants.php");
?>

<div class="navbar navbar-static-top" style="margin: -1px -1px 0;">
              <div class="navbar-inner">
                <div class="container" style="width: auto; padding: 0 20px;">
                  <a class="brand" href="#">Forum</a>
                  <ul class="nav">
                    <li><a href="./index.php">Index</a></li>
                    <li><a href="#">Membres</a></li>
                    <li><a href="#">FAQ</a></li>
					<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mon compte <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="nav-header">Non connecté(e)</li>
                          <li><a href="connexion.php">Connexion</a></li>
                          <li><a href="register.php">S'enregistrer</a></li>
                          <li class="divider"></li>
                          <li class="nav-header">Bienvenue Derezzed</li>
                          <li><a href="./voirprofil.php?action=modifier">Mon compte</a></li>
                          <li><a href="./deconnexion.php">Déconnexion</a></li>
                        </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div>