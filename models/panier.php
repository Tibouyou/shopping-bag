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
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM orders O WHERE O.customer_id = '$user_id' AND O.status = 0";
            if ($this->executerRequete($sql)->rowCount() == 0) {
                $sql = "INSERT INTO orders (customer_id, total) VALUES ('$user_id',0)";
                $this->executerRequete($sql);
            }
        } else {
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
        }
        $this->add_product($product_id, $quantity);
    }

    public function add_product($product_id, $quantity)
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            $user_id = $_SESSION['user_id'];
            $panier_id = $this->executerRequete("SELECT id FROM orders WHERE customer_id = '$user_id' AND status = 0")->fetch()['id'];
        } else {
            $panier_id = $_SESSION['SESS_ORDERNUM'];
        }
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

    public function modify_quantity($orderitem_id, $quantity)
    {
        $sql = "UPDATE products SET quantity = quantity + (SELECT quantity FROM orderitems WHERE id = '$orderitem_id') - '$quantity' WHERE id = (SELECT product_id FROM orderitems WHERE id = '$orderitem_id')";
        $this->executerRequete($sql);

        $sql = "SELECT price FROM products WHERE id = (SELECT product_id FROM orderitems WHERE id = '$orderitem_id')";
        $price = $this->executerRequete($sql)->fetch()['price'];
        $sql = "UPDATE orders SET total = total - '$price' * (SELECT quantity FROM orderitems WHERE id = '$orderitem_id') + '$price' * '$quantity' WHERE id = (SELECT order_id FROM orderitems WHERE id = '$orderitem_id')";
        $this->executerRequete($sql);

        $sql = "UPDATE orderitems SET quantity = '$quantity' WHERE id = '$orderitem_id'";
        $this->executerRequete($sql);
    }

    public function get_panier()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT OI.quantity, P.name, P.image, P.price FROM orderitems OI, products P, orders O WHERE OI.product_id = P.id AND OI.order_id = O.id AND O.customer_id = '$user_id' AND O.status = 0";
            return $this->executerRequete($sql)->fetchAll();
        } 
        else if (isset($_SESSION['SESS_ORDERNUM'])) {
            $panier_id = $_SESSION['SESS_ORDERNUM'];
            $sql = "SELECT OI.quantity, P.name, P.image, P.price, OI.id, P.quantity as max_quantity FROM orderitems OI, products P WHERE OI.product_id = P.id AND OI.order_id = '$panier_id'";
            return $this->executerRequete($sql)->fetchAll();
        }
        return array();
    }
}