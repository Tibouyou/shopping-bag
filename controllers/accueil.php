<?php
require_once('models/products.php');
class ControleurAccueil
{
    private $twig;
    public function __construct($twig)
    {
        $this->twig = $twig;
    }
    public function accueil()
    {
        echo $this->twig->render('accueil.twig');
    }
}
?>