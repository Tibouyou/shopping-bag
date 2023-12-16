<?php require_once 'modele.php';
class Avis extends Modele
{
    public function get_avis($id)
    {
        $sql = "SELECT * FROM reviews WHERE id_product = '$id'";
        $avis = $this->executerRequete($sql, array($id));
        return $avis;
    }
}