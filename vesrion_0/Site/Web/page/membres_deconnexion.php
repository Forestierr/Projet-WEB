<?php 
session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('pseudo', '');
setcookie('pass', '');

// Relaod la page
header('Location: membres_deconnexion.php');

print_r($_COOKIE); 

// Redirection du visiteur vers la page de connexion
header('Location: membres_connexion.php');
?>
