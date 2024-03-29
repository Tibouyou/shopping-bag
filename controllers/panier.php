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
        if (isset($_POST['product_id'])) {
            $id = $_POST['product_id'];
            $nb_quantity = $_POST['nb_quantity'];
            $this->panier->modify_quantity($id, $nb_quantity);
        }
        
        if (isset($_POST['delete'])) {
            $id = $_POST['delete'];
            $this->panier->modify_quantity($id, 0);
        }
        
        echo $this->twig->render('panier.twig', array('panier' => $this->panier->get_panier(), 'total' => $this->panier->get_total()));
    }
}
?>