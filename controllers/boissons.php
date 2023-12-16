<?php
require_once('models/products.php');
class ControleurBoissons
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
            'products' =>$this->products->get_boissons()->fetchAll(),
            'page_name' => "Boissons"
        ));
    }
}
?>