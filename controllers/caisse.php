<?php
require_once('models/caisse.php');
class ControleurCaisse
{
    private $caisse;
    private $twig;
    public function __construct($twig)
    {
        $this->caisse = new Caisse();
        $this->twig = $twig;
    }
    public function render()
    {
        if (isset($_POST['payer'])) {
            $this->caisse->set_adress($_POST['firstname'],$_POST['lastname'],$_POST['add1'], $_POST['add2'], $_POST['city'], $_POST['postcode'], $_POST['email']);
            echo $this->twig->render('paiement.twig', array('is_paid' => false));
        } elseif (isset($_POST['paypal'])) {
            ?>
            <script type="text/javascript">
                window.open('https://www.paypal.com/', '_blank');
            </script>
            <?php
            $this->caisse->payer('paypal');
            echo $this->twig->render('paiement.twig', array('is_paid' => true));
        } else {
            echo $this->twig->render('info_achat.twig');
        }
    }
}
?>