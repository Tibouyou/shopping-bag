<?php require_once 'modele.php';
class Avis extends Modele
{
    public function get_avis($id)
    {
        $sql = "SELECT * FROM reviews WHERE id_product = '$id'";
        $avis = $this->executerRequete($sql, array($id));
        return $avis;
    }

    public function get_average($id)
    {
        $sql = "SELECT ROUND(AVG(stars),1) as moyenne FROM reviews WHERE id_product = '$id'";
        $moyenne = $this->executerRequete($sql);
        return $moyenne;
    }
}