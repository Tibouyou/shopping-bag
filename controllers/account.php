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
            $this->account->register($_POST['username'], $_POST['password']);
        } elseif (isset($_POST['login'])) {
            $this->account->login($_POST['username'], $_POST['password']);
        }
    }
}
?>