<?php require_once 'modele.php';
class Avis extends Modele
{
    public function get_avis($id)
    {
        $sql = "SELECT * FROM reviews WHERE id_product = '$id'";
        $avis = $this->executerRequete($sql);
        return $avis;
    }

    public function get_average($id)
    {
        $sql = "SELECT ROUND(AVG(stars),1) as moyenne FROM reviews WHERE id_product = '$id'";
        $moyenne = $this->executerRequete($sql);
        return $moyenne;
    }

    public function get_all_avis()
    {
        $sql = "SELECT * FROM reviews";
        $avis = $this->executerRequete($sql);
        return $avis;
    }
}