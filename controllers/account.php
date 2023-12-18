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
        if (isset($_POST['log_out'])) {
            session_destroy();
            header('Location: main.php');
        } 
        if (isset($_POST['register'])) {
            echo $this->twig->render('register.twig');
        }
        if (isset($_POST['update_account'])) {
            $this->account->update_account($_POST['forname'], $_POST['surname'], $_POST['email'], $_POST['phone'], $_POST['add1'], $_POST['add2'], $_POST['add3'], $_POST['postcode']);
        }
        if (isset($_POST['create_account'])) {
            $user_id = $this->account->register($_POST['username'], $_POST['password1'], $_POST['email'], $_POST['forname'], $_POST['surname']);
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user_id;
        } elseif (isset($_POST['login'])) {
            $login = $this->account->login($_POST['username'], $_POST['password']);
            if ($login["success"]) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $login["user_id"];
            } else {
                echo("Login failed");
            }
        }
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            echo $this->twig->render('account.twig', array(
                'account_info' => $this->account->get_account_info()->fetch(),
            ));
        } else if (!isset($_POST['register'])){
            echo $this->twig->render('connexion.twig');
        } 
    }
}
?>