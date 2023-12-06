<?php require_once 'modele.php';
class Accounts extends Modele
{
    public function register($username, $password)
    {
        $crypted_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO logins (username, password) VALUES ('$username', '$crypted_password')";
        $this->executerRequete($sql);
    }

    public function login($username, $password)
    {
        $sql = "SELECT password FROM logins WHERE username = '$username'";
        $data = $this->executerRequete($sql);
        $result = $data->fetchAll();
        if (password_verify($password, $result[0]['password'])) {
            echo "You are logged in";
        } else {
            echo "Wrong password";
        }
    }
    public function get_account_info()
    {
        $sql = "SELECT * from customers";
        return $this->executerRequete($sql);
    }
}