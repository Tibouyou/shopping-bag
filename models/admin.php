<?php require_once 'modele.php';
class Admin extends Modele
{
    function get_all_orders() {
        $sql = "SELECT * FROM orders WHERE status = 2";
        $orders = $this->executerRequete($sql);
        return $orders;
    }
}