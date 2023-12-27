<?php require_once 'modele.php';
class Admin extends Modele
{
    function get_all_orders() {
        $sql = "SELECT O.id, O.payment_type, O.date, D.firstname, D.lastname, D.add1, D.add2, D.city, D.postcode, D.phone, D.email FROM orders O JOIN delivery_addresses D ON O.delivery_add_id = D.id WHERE O.status = 2";
        $orders = $this->executerRequete($sql)->fetchAll();
        $orders = $this->get_all_products($orders);
        return $orders;
    }
    function get_all_products($orders) {
        for ($i = 0; $i < count($orders); $i++) {
            $order_id = $orders[$i]['id'];
            $sql = "SELECT OI.quantity, P.name FROM orderitems OI, products P WHERE OI.product_id = P.id AND OI.order_id = '$order_id'";
            $products = $this->executerRequete($sql)->fetchAll();
            $orders[$i]['products'] = $products;
        }
        return $orders;
    }
    function validate_order($order_id) {
        $sql = "UPDATE orders SET status = 10 WHERE id = '$order_id'";
        $this->executerRequete($sql);
    }
}