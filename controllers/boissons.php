<?php
require_once('models/products.php');
class ControleurBoissons
{
    private $products;
    private $twig;
    public function __construct($twig)
    {
        $this->products = new Products();
        $this->twig = $twig;
    }
    public function accueil()
    {
        echo $this->twig->render('accueil.twig', array(
            'products' =>$this->products->get_boissons()->fetchAll()));
    }
}
?>