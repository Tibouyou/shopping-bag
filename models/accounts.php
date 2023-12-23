<?php require_once 'modele.php';
class Accounts extends Modele
{
    public function register($username, $password, $email, $forname, $surname)
    {
        $crypted_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO logins (username, password) VALUES ('$username', '$crypted_password')";
        $this->executerRequete($sql);
        $sql = "INSERT INTO customers ( forname, surname, email, registered) VALUES ('$forname', '$surname', '$email',  1)";
        $this->executerRequete($sql);
        $id = $this->getConnexion()->lastInsertId();
        $sql = "UPDATE logins SET customer_id = '$id' WHERE id = '$id'";
        $this->executerRequete($sql);
        return $id;
    }

    public function login($username, $password)
    {
        $sql = "SELECT password FROM logins WHERE username = '$username'";
        $data = $this->executerRequete($sql);
        $result = $data->fetchAll();
        if (password_verify($password, $result[0]['password'])) {
            $sql = "SELECT customer_id FROM logins WHERE username = '$username'";
            $user_id = $this->executerRequete($sql)->fetch()['customer_id'];
            if (isset($_SESSION['SESS_ORDERNUM'])) {
                $sql = "SELECT id FROM orders WHERE customer_id = '$user_id' AND status = 0";
                if ($this->executerRequete($sql)->rowCount() == 0) {
                    $order_id = $_SESSION['SESS_ORDERNUM'];
                    $sql = "UPDATE orders SET customer_id = '$user_id' WHERE id = '$order_id' AND status = 0";
                    $this->executerRequete($sql);
                } else {
                    $this->fusion_panier($user_id, $_SESSION['SESS_ORDERNUM']);
                }
            }
            return array('success' => true, 'user_id' => $user_id);
        } else {
            return array('success' => false);
        }
    }

    public function fusion_panier($user_id, $session_id)
    {
        $sql = "SELECT * FROM orderitems WHERE order_id = '$session_id'";
        $panier_session = $this->executerRequete($sql)->fetchAll();
        $sql = "SELECT id FROM orders WHERE customer_id = '$user_id'";
        $order_id = $this->executerRequete($sql)->fetch()['id'];
        $sql = "SELECT * FROM orderitems WHERE order_id = '$order_id'";
        $panier_user = $this->executerRequete($sql)->fetchAll();
        for ($i = 0; $i < count($panier_session); $i++) {
            for ($j = 0; $j < count($panier_user); $j++) {
                if ($panier_session[$i]['product_id'] == $panier_user[$j]['product_id']) {
                    $quantity = $panier_session[$i]['quantity'] + $panier_user[$j]['quantity'];
                    $product_id = $panier_session[$i]['product_id'];
                    var_dump($quantity);
                    $sql = "UPDATE orderitems SET quantity = $quantity WHERE product_id = '$product_id' AND order_id = '$order_id'";
                    $this->executerRequete($sql);
                    $sql = "DELETE FROM orderitems WHERE product_id = '$product_id' AND order_id = '$session_id'";
                    $this->executerRequete($sql);
                    $sql = "SELECT price FROM products WHERE id = '$product_id'";
                    $price = $this->executerRequete($sql)->fetch()['price'];
                    $diff = $panier_session[$i]['quantity'];
                    $sql = "UPDATE orders SET total = total + '$price' * '$diff' WHERE id = '$order_id'";
                    $this->executerRequete($sql);
                }
           }
        }
        $sql = "SELECT * FROM orderitems WHERE order_id = '$session_id'";
        $panier_session = $this->executerRequete($sql)->fetchAll();
        for ($i = 0; $i < count($panier_session); $i++) {
            $product_id = $panier_session[$i]['product_id'];
            $quantity = $panier_session[$i]['quantity'];
            $sql = "UPDATE orderitems SET order_id = '$order_id' WHERE product_id = '$product_id' AND order_id = '$session_id'";
            $this->executerRequete($sql);
            $sql = "SELECT price FROM products WHERE id = '$product_id'";
            $price = $this->executerRequete($sql)->fetch()['price'];
            $sql = "UPDATE orders SET total = total + '$price' * '$quantity' WHERE id = '$order_id'";
            $this->executerRequete($sql);
        }
        $sql = "DELETE FROM orders WHERE id = '$session_id'";
        $this->executerRequete($sql);
    }
    public function update_account($forname, $surname, $email, $phone, $add1, $add2, $add3, $postcode)
    {
        $id = $_SESSION['user_id'];
        $sql = "UPDATE customers SET forname = '$forname', surname = '$surname', email = '$email', phone = '$phone', add1 = '$add1', add2 = '$add2', add3 = '$add3', postcode = '$postcode' WHERE id = '$id'";
        $this->executerRequete($sql);
    }
    public function get_account_info()
    {
        $id = $_SESSION['user_id'];
        $sql = "SELECT * from customers WHERE id = '$id'";
        return $this->executerRequete($sql);
    }
}