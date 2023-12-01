<?php
require_once 'controllers\accueil.php';
require_once 'controllers\boissons.php';
class Routeur
{
    private $ctrlAccueil;
    private $ctrlBoissons;
    public function __construct($twig)
    {
        $this->ctrlAccueil = new ControleurAcceuil($twig);
        $this->ctrlBoissons = new ControleurBoissons($twig);
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