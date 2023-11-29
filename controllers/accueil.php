<?php
$products = new Products();
echo $twig->render('accueil.twig', array(
    'products' =>$products->get_all_products()->fetchAll()));
?>