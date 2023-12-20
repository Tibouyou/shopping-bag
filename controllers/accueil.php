<?php
require_once('models/products.php');
class ControleurAccueil
{
    private $twig;
    private $categories;
    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->categories = new Products();
    }
    public function render()
    {
        echo $this->twig->render('accueil.twig' , array(
            'categories' => $this->categories->get_all_categories()->fetchAll()
        ));
    }
}
?>