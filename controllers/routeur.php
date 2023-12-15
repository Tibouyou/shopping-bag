<?php
require_once 'controllers\accueil.php';
require_once 'controllers\produits.php';
require_once 'controllers\boissons.php';
require_once 'controllers\biscuits.php';
require_once 'controllers\fruitssecs.php';
require_once 'controllers\account.php';
require_once 'controllers\panier.php';
require_once 'controllers\produit.php';
class Routeur
{
    private $ctrlAccueil;
    private $ctrlProduits;
    private $ctrlBoissons;
    private $ctrlBiscuits;
    private $ctrlFruitsSecs;
    private $ctrlAccount;
    private $ctrlPanier;
    private $ctrlProduit;
    public function __construct($twig)
    {
        $this->ctrlAccueil = new ControleurAccueil($twig);
        $this->ctrlProduits = new ControleurProduits($twig);
        $this->ctrlBoissons = new ControleurBoissons($twig);
        $this->ctrlBiscuits = new ControleurBiscuits($twig);
        $this->ctrlFruitsSecs = new ControleurFruitsSecs($twig);
        $this->ctrlAccount = new ControleurAccount($twig);
        $this->ctrlPanier = new ControleurPanier($twig);
        $this->ctrlProduit = new ControleurProduit($twig);
    }
    // Traite une requête entrante 
    public function routerRequete()
    {
        try {
            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'accueil':
                        $this->ctrlAccueil->render();
                        break;
                    case 'boissons':
                        $this->ctrlBoissons->render();
                        break;
                    case 'produits':
                        $this->ctrlProduits->render();
                        break;
                    case 'biscuits':
                        $this->ctrlBiscuits->render();
                        break;
                    case 'fruits-secs':
                        $this->ctrlFruitsSecs->render();
                        break;
                    case 'produit':
                        $this->ctrlProduit->render();
                        break;
                    case 'account':
                        $this->ctrlAccount->render();
                        break;
                    case 'panier':
                        $this->ctrlPanier->render();
                        break;
                    default :
                        throw new Exception("Action non valide");
                }           
            } else {
                $this->ctrlAccueil->render();
            }
        } catch (Exception $e) {
            $this->erreur($e->getMessage());
        }
    }
    // Affiche une erreur 
    private function erreur($msgErreur)
    {
       echo $msgErreur;
    }
}
?>