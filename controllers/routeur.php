<?php
require_once 'controllers\accueil.php';
require_once 'controllers\footerlink.php';
require_once 'controllers\produits.php';
require_once 'controllers\boissons.php';
require_once 'controllers\biscuits.php';
require_once 'controllers\fruitssecs.php';
require_once 'controllers\account.php';
require_once 'controllers\panier.php';
require_once 'controllers\produit.php';
require_once 'controllers\caisse.php';
require_once 'controllers\facture.php';
class Routeur
{
    private $twig;
    private $ctrlAccueil;
    private $ctrlFooterLink;
    private $ctrlProduits;
    private $ctrlBoissons;
    private $ctrlBiscuits;
    private $ctrlFruitsSecs;
    private $ctrlAccount;
    private $ctrlPanier;
    private $ctrlProduit;
    private $ctrlCaisse;
    private $ctrlFacture;
    public function __construct($twig)
    {
        $this->twig = $twig;
    }
    // Traite une requête entrante 
    public function routerRequete()
    {
        try {
            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'accueil':
                        $this->ctrlAccueil = new ControleurAccueil($this->twig);
                        $this->ctrlAccueil->render();
                        break;
                    case 'footerlink':
                        $this->ctrlFooterLink = new ControleurFooterLink($this->twig);
                        $this->ctrlFooterLink->render();
                        break;
                    case 'boissons':
                        $this->ctrlBoissons = new ControleurBoissons($this->twig);
                        $this->ctrlBoissons->render();
                        break;
                    case 'produits':
                        $this->ctrlProduits = new ControleurProduits($this->twig);
                        $this->ctrlProduits->render();
                        break;
                    case 'biscuits':
                        $this->ctrlBiscuits = new ControleurBiscuits($this->twig);
                        $this->ctrlBiscuits->render();
                        break;
                    case 'fruits-secs':
                        $this->ctrlFruitsSecs = new ControleurFruitsSecs($this->twig);
                        $this->ctrlFruitsSecs->render();
                        break;
                    case 'produit':
                        $this->ctrlProduit = new ControleurProduit($this->twig);
                        $this->ctrlProduit->render();
                        break;
                    case 'account':
                        $this->ctrlAccount = new ControleurAccount($this->twig);
                        $this->ctrlAccount->render();
                        break;
                    case 'panier':
                        $this->ctrlPanier = new ControleurPanier($this->twig);
                        $this->ctrlPanier->render();
                        break;
                    case 'caisse':
                        $this->ctrlCaisse = new ControleurCaisse($this->twig);
                        $this->ctrlCaisse->render();
                        break;
                    case 'facture':
                        $this->ctrlFacture = new ControleurFacture('P', 'mm', 'A4');
                        $this->ctrlFacture->render();
                        break;
                    default :
                        throw new Exception("Action non valide");
                }           
            } else {
                $this->ctrlAccueil = new ControleurAccueil($this->twig);
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