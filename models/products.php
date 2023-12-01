<?php require_once 'modele.php';
class Products extends Modele
{
    public function get_all_products()
	{
		$sql = "SELECT * from products";
		return $this->executerRequete($sql);
	}

    public function get_boissons()
    {
        $sql = "SELECT P.* from products P JOIN categories C ON P.cat_id = C.id WHERE C.name = 'boissons'";
        return $this->executerRequete($sql);
    }
}