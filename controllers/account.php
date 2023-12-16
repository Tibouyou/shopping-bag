<?php
require_once('models/accounts.php');
class ControleurAccount
{
    private $account;
    private $twig;
    public function __construct($twig)
    {
        $this->account = new Accounts();
        $this->twig = $twig;
    }
    public function render()
    {
        echo $this->twig->render('account.twig');
        if (isset($_POST['create_account'])) {
            $user_id = $this->account->register($_POST['username'], $_POST['password']);
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user_id;
            var_dump($_SESSION);
        } elseif (isset($_POST['login'])) {
            $login = $this->account->login($_POST['username'], $_POST['password']);
            if ($login["success"]) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $login["user_id"];
                var_dump($_SESSION);
            } else {
                echo("Login failed");
            }
        }
    }
}
?>