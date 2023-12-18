<?php require_once 'modele.php';
class Accounts extends Modele
{
    public function register($username, $password, $email, $forname, $surname)
    {
        $crypted_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO logins (username, password) VALUES ('$username', '$crypted_password')";
        $this->executerRequete($sql);
        $sql = "SELECT id FROM logins WHERE username = '$username' AND password = '$crypted_password'";
        $id = $this->executerRequete($sql)->fetch()['id'];
        $sql = "INSERT INTO customers (id, forname, surname, email, registered) VALUES ('$id', '$forname', '$surname', '$email',  1)";
        $this->executerRequete($sql);
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
            $sql = "SELECT id FROM logins WHERE username = '$username'";
            return array('success' => true, 'user_id' => $this->executerRequete($sql)->fetch()['id']);
        } else {
            return array('success' => false);
        }
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