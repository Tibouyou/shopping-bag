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
        $all_categories = $this->categories->get_all_categories()->fetchAll();
        for ($i = 0; $i < count($all_categories); $i++) {
           $all_categories[$i]['link'] = strtolower(str_replace(' ', '-', $all_categories[$i]['name']));
        }
        echo $this->twig->render('accueil.twig' , array(
            'categories' => $all_categories
        ));
    }
}
?>