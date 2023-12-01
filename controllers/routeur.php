<?php
require_once 'controllers\accueil.php';
class Routeur
{
    private $ctrlAccueil;
    public function __construct($twig)
    {
        $this->ctrlAccueil = new ControleurAcceuil($twig);
    }
    // Traite une requête entrante 
    public function routerRequete()
    {
        try {
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'test') {
                    echo "test";
                } else
                    throw new Exception("Action non valide");
            } else {
                // aucune action définie : affichage de l'accueil 
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