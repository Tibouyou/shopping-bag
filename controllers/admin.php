<?php
require_once('models/admin.php');
class ControleurAdmin
{
    private $admin;
    private $twig;
    public function __construct($twig)
    {
        $this->products = new Admin();
        $this->twig = $twig;
    }
    public function render()
    {
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != true) {
            header('Location: main.php');
            exit();
        } else {
            echo $this->twig->render('admin.twig');
        }
    }
}
?>