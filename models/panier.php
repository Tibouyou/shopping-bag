<?php require_once 'modele.php';
class Panier extends Modele
{
    public function create_panier($product_id, $quantity)
	{
        $sql = "SELECT quantity FROM products WHERE id = '$product_id'";
        $quantity_tot = $this->executerRequete($sql)->fetch();
        if ($quantity_tot['quantity'] == 0) {
            return;
        }
        $session_id = session_id();
		$sql = "SELECT * FROM orders O WHERE O.session = '$session_id' AND O.status = 0";
        if ($this->executerRequete($sql)->rowCount() == 0) {
            $sql = "INSERT INTO orders (session, total) VALUES ('$session_id',0)";
            $this->executerRequete($sql);
        }
        if (!isset($_SESSION['SESS_ORDERNUM'])) {
            $sql = "SELECT id FROM orders O WHERE O.session = '$session_id' AND O.status = 0";
            $panier_id = $this->executerRequete($sql)->fetch();
            $_SESSION['SESS_ORDERNUM'] = $panier_id['id'];
        }
        $this->add_product($product_id, $quantity);
	}

    public function add_product($product_id,$quantity)
    {
        $panier_id = $_SESSION['SESS_ORDERNUM'];
        $sql = "SELECT * FROM orderitems WHERE product_id = '$product_id' AND order_id = '$panier_id'";
        if ($this->executerRequete($sql)->rowCount() == 0) {
            $sql = "INSERT INTO orderitems (product_id, order_id, quantity) VALUES ('$product_id', '$panier_id', '$quantity')";
            $this->executerRequete($sql);
        } else {
            $sql = "UPDATE orderitems SET quantity = quantity + '$quantity' WHERE product_id = '$product_id' AND order_id = '$panier_id'";
            $this->executerRequete($sql);
        }
        $sql = "UPDATE products SET quantity = quantity - '$quantity' WHERE id = '$product_id'";
        $this->executerRequete($sql);
        $sql = "SELECT price FROM products WHERE id = '$product_id'";
        $price = $this->executerRequete($sql)->fetch()['price'];
        $sql = "UPDATE orders SET total = total + '$price' * '$quantity' WHERE id = '$panier_id'";
        $this->executerRequete($sql);
    }

    public function get_panier()
    {
        $panier_id = $_SESSION['SESS_ORDERNUM'];
        $sql = "SELECT OI.quantity, P.name FROM orderitems OI, products P WHERE OI.product_id = P.id AND OI.order_id = '$panier_id'";
        return $this->executerRequete($sql);
    }
}