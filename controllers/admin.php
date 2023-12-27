<?php
require_once('models/admin.php');
class ControleurAdmin
{
    private $admin;
    private $twig;
    public function __construct($twig)
    {
        $this->admin = new Admin();
        $this->twig = $twig;
    }
    public function render()
    {
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != true) {
            header('Location: main.php');
            exit();
        } else if (isset($_POST['validate_order'])) {
            $this->admin->validate_order($_POST['order_id']);
            $all_orders = $this->admin->get_all_orders();
            echo $this->twig->render('admin.twig', array(
                'orders' => $all_orders
            ));
        } else {
            $all_orders = $this->admin->get_all_orders();
            echo $this->twig->render('admin.twig', array(
                'orders' => $all_orders
            ));
        }
    }
}
?>