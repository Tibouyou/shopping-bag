<?php
require_once('models/products.php');
require_once('models/panier.php');
require_once('models/avis.php');
class ControleurProduit
{
    private $product;
    private $panier;
    private $avis;
    private $twig;
    public function __construct($twig)
    {
        $this->product = new Products();
        $this->panier = new Panier();
        $this->avis = new Avis();
        $this->twig = $twig;
    }
    public function render()
    {
        if (isset($_GET['id'])) {
            if (isset($_POST['product_id'])) {
                $id = $_POST['product_id'];
                $nb_quantity = $_POST['nb_quantity'];
                $this->panier->create_panier($id, $nb_quantity);
                $toast = true;
            }
            $id = $_GET['id'];
            echo $this->twig->render('produit.twig', array(
                'product' => $this->product->get_product($id)->fetch(),
                'avis' => $this->avis->get_avis($id)->fetchAll(), 
                'moyenne' => $this->avis->get_average($id)->fetch()['moyenne'], 
                'toast' => $toast ?? false
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