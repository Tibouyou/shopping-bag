<?php
require_once 'controllers\accueil.php';
require_once 'controllers\produits.php';
require_once 'controllers\boissons.php';
require_once 'controllers\biscuits.php';
require_once 'controllers\fruitssecs.php';
require_once 'controllers\account.php';
require_once 'controllers\panier.php';
class Routeur
{
    private $ctrlAccueil;
    private $ctrlProduits;
    private $ctrlBoissons;
    private $ctrlBiscuits;
    private $ctrlFruitsSecs;
    private $ctrlAccount;
    private $ctrlPanier;
    public function __construct($twig)
    {
        $this->ctrlAccueil = new ControleurAccueil($twig);
        $this->ctrlProduits = new ControleurProduits($twig);
        $this->ctrlBoissons = new ControleurBoissons($twig);
        $this->ctrlBiscuits = new ControleurBiscuits($twig);
        $this->ctrlFruitsSecs = new ControleurFruitsSecs($twig);
        $this->ctrlAccount = new ControleurAccount($twig);
        $this->ctrlPanier = new ControleurPanier($twig);
    }
    // Traite une requête entrante 
    public function routerRequete()
    {
        try {
            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'accueil':
                        $this->ctrlAccueil->accueil();
                        break;
                    case 'boissons':
                        $this->ctrlBoissons->accueil();
                        break;
                    case 'produits':
                        $this->ctrlProduits->accueil();
                        break;
                    case 'biscuits':
                        $this->ctrlBiscuits->accueil();
                        break;
                    case 'fruits-secs':
                        $this->ctrlFruitsSecs->accueil();
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
                $this->ctrlAccueil->accueil();
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