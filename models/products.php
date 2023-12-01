<?php require_once 'modele.php';
class Products extends Modele
{
    public function get_all_products()
	{
		$sql = "SELECT * from products";
		return $this->executerRequete($sql);
	}
}