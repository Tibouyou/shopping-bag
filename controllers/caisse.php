<?php
require_once('models/caisse.php');
require_once('static/pdf.php');
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
            $this->caisse->set_adress($_POST['firstname'], $_POST['lastname'], $_POST['add1'], $_POST['add2'], $_POST['city'], $_POST['postcode'], $_POST['email']);
            echo $this->twig->render('paiement.twig', array('is_paid' => false));
        } elseif (isset($_POST['paypal'])) {
            ?>
            <script type="text/javascript">
                window.open('https://www.paypal.com/', '_blank');
            </script>
            <?php
            $this->caisse->payer('paypal');
            echo $this->twig->render('paiement.twig', array('is_paid' => true));
        } elseif (isset($_POST['cheque'])) {
            // On active la classe une fois pour toutes les pages suivantes
            // Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
            ?>
            <script type="text/javascript">
                var pdfPage = window.open('main.php?page=facture');
                $(pdfPage).bind('beforeunload', function () {
                    location.reload(); // redirect to your custom page
                });
            </script>
            <?php
            $this->caisse->payer('cheque');
            echo $this->twig->render('paiement.twig', array('is_paid' => true));
        } else {
            echo $this->twig->render('info_achat.twig');
        }
    }
}
?>