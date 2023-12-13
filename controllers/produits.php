<?php
require_once('models/products.php');
require_once('models/panier.php');
class ControleurProduits
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
    public function accueil()
    {
        if (isset($_POST['product_id'])) {
            $id = $_POST['product_id'];
            $this->panier->create_panier($id);
        }
        echo $this->twig->render('produits.twig', array(
            'products' =>$this->products->get_all_products()->fetchAll(),
            'page_name' => "Produits"
        ));
    }
}
?>