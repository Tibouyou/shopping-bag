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
            if ($user_id != false) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $_POST['username'];
            } else {
                echo $this->twig->render('register.twig', array(
                    'error' => 'Nom d\'utilisateur déjà utilisé',
                ));
            }
        } elseif (isset($_POST['login'])) {
            $login = $this->account->login($_POST['username'], $_POST['password']);
            $login_admin = $this->account->login_admin($_POST['username'], $_POST['password']);
            if ($login["success"]) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $login["user_id"];
                $_SESSION['username'] = $_POST['username'];
                echo $this->twig->render('account.twig', array(
                    'account_info' => $this->account->get_account_info()->fetch(),
                ));
            } else if ($login_admin["success"]) {
                $_SESSION['logged_in'] = true;
                $_SESSION['is_admin'] = true;
                $_SESSION['user_id'] = $login_admin["user_id"];
                header('Location: main.php?page=admin');
                exit();
            }
            else {
                echo("Login failed");
            }
        } elseif (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            echo $this->twig->render('account.twig', array(
                'account_info' => $this->account->get_account_info()->fetch(),
            ));
        } else if (!isset($_POST['register']) && !isset($_POST['create_account'])){
            echo $this->twig->render('connexion.twig');
        } 
    }
}
?>