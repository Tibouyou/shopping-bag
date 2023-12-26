<?php require_once 'modele.php';
class Caisse extends Modele
{
    public function set_adress($firstname, $lastname, $add1, $add2, $city, $postcode, $email) {
        $sql = "INSERT INTO delivery_addresses (firstname, lastname, add1, add2, city, postcode, email) VALUES ('$firstname', '$lastname', '$add1', '$add2', '$city', '$postcode', '$email')";
        $this->executerRequete($sql);
        $id = $this->getConnexion()->lastInsertId(); 
        if (isset($_SESSION['SESS_ORDERNUM'])) {
            $order_id = $_SESSION['SESS_ORDERNUM'];
            $sql = "UPDATE orders SET delivery_add_id = '$id', status = 1 WHERE id = '$order_id'";
            $this->executerRequete($sql);
        }
    }
    public function payer($payment_type) {
        if (isset($_SESSION['SESS_ORDERNUM'])) {
            $order_id = $_SESSION['SESS_ORDERNUM'];
            $sql = "UPDATE orders SET status = 2, payment_type='$payment_type' WHERE id = '$order_id'";
            $this->executerRequete($sql);
        }
    }
}