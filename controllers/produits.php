<?php
require_once('models/products.php');
class ControleurProduits
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
        echo $this->twig->render('produits.twig', array(
            'products' =>$this->products->get_all_products()->fetchAll(),
            'page_name' => "Produits"
        ));
    }
}
?>