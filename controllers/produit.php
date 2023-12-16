<?php
require_once('models/products.php');
require_once('models/panier.php');
class ControleurProduit
{
    private $product;
    private $panier;
    private $twig;
    public function __construct($twig)
    {
        $this->product = new Products();
        $this->panier = new Panier();
        $this->twig = $twig;
    }
    public function render()
    {
        if (isset($_GET['id'])) {
            if (isset($_POST['product_id'])) {
                $id = $_POST['product_id'];
                $this->panier->create_panier($id);
            }
            $id = $_GET['id'];
            echo $this->twig->render('produit.twig', array(
                'product' => $this->product->get_product($id)->fetch(),
                'page_name' => "Produit"
            ));
        }
        else {
            echo $this->twig->render('produits.twig' , array(
                'products' => $this->product->get_all_products()->fetchAll(),
                'page_name' => "Produits"
            ));
        }
    }
}
?>