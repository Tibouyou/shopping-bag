<?php
require_once('models/products.php');
require_once('models/avis.php');
class ControleurAccueil
{
    private $twig;
    private $categories;
    private $avis;
    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->categories = new Products();
        $this->avis = new Avis();
    }
    public function render()
    {
        $all_categories = $this->categories->get_all_categories()->fetchAll();
        $all_avis = $this->avis->get_all_avis()->fetchAll();

        for ($i = 0; $i < count($all_categories); $i++) {
           $all_categories[$i]['link'] = strtolower(str_replace(' ', '-', $all_categories[$i]['name']));
        }

        echo $this->twig->render('accueil.twig' , array(
            'categories' => $all_categories,
            'avis' => $all_avis
        ));
    }
}
?>