<?php
require_once 'controllers\accueil.php';
require_once 'controllers\boissons.php';
require_once 'controllers\account.php';
class Routeur
{
    private $ctrlAccueil;
    private $ctrlBoissons;
    private $ctrlAccount;
    public function __construct($twig)
    {
        $this->ctrlAccueil = new ControleurAcceuil($twig);
        $this->ctrlBoissons = new ControleurBoissons($twig);
        $this->ctrlAccount = new ControleurAccount($twig);
    }
    // Traite une requête entrante 
    public function routerRequete()
    {
        try {
            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'boissons':
                        $this->ctrlBoissons->accueil();
                        break;
                    case 'acceuil':
                        $this->ctrlAccueil->accueil();
                        break;
                    case 'account':
                        $this->ctrlAccount->render();
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