<?php require_once 'modele.php';
class Accounts extends Modele
{
    public function register($username, $password)
    {
        $crypted_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO logins (username, password) VALUES ('$username', '$crypted_password')";
        $this->executerRequete($sql);
        $sql = "SELECT id FROM logins WHERE username = '$username'";
        return $this->executerRequete($sql)->fetch()['id'];
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
        $sql = "SELECT * from customers";
        return $this->executerRequete($sql);
    }
}