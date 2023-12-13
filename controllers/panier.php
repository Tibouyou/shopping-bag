<?php
require_once('models/panier.php');
class ControleurPanier
{
    private $panier;
    private $twig;
    public function __construct($twig)
    {
        $this->panier = new Panier();
        $this->twig = $twig;
    }
    public function render()
    {
        echo $this->twig->render('panier.twig');
    }
}
?>