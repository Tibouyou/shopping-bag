<?php
require_once('models/products.php');
class ControleurFruitsSecs
{
    private $products;
    private $panier;
    private $twig;
    public function __construct($twig)
    {
        $this->products = new Products();
        $this->panier = new Panier();
        $this->twig = $twig;
    }
    public function render()
    {
        echo $this->twig->render('produits.twig', array(
            'products' =>$this->products->get_fruits_secs()->fetchAll(),
            'page_name' => "Fruits secs"
        ));
    }
}
?>