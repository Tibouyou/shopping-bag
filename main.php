<?php
session_start();
/* inclure l'autoloader */
require_once 'vendor/autoload.php';

/* templates chargés à partir du système de fichiers (répertoire vue) */
$loader = new Twig\Loader\FilesystemLoader('vue');

/* options : prod = cache dans le répertoire cache, dev = pas de cache */
$options_prod = array('cache' => 'cache', 'autoescape' => true);
$options_dev = array('cache' => false, 'autoescape' => true);

/* stocker la configuration */
$twig = new Twig\Environment($loader);
$twig->addGlobal('session', $_SESSION);

/* charger+compiler le template, exécuter, envoyer le résultat au navigateur */
require 'controllers\routeur.php';
$routeur = new Routeur($twig);
$routeur->routerRequete();
?>

