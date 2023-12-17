<?php require_once 'modele.php';
class Accounts extends Modele
{
    public function register($username, $password)
    {
        $crypted_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO logins (username, password) VALUES ('$username', '$crypted_password')";
        $this->executerRequete($sql);
        $sql = "SELECT id FROM logins WHERE username = '$username'";
        $id = $this->executerRequete($sql)->fetch()['id'];
        $sql = "INSERT INTO customers (id, registered) VALUES ('$id', 1)";
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
    public function get_account_info()
    {
        $id = $_SESSION['user_id'];
        $sql = "SELECT * from customers WHERE id = '$id'";
        return $this->executerRequete($sql);
    }
}