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
            $pdf = new PDF('P', 'mm', 'A4');
            // Nouvelle page A4 (incluant ici logo, titre et pied de page)
            $pdf->AddPage();
            // Polices par défaut : Helvetica taille 9
            $pdf->SetFont('Helvetica', '', 9);
            // Couleur par défaut : noir
            $pdf->SetTextColor(0);
            // Compteur de pages {nb}
            $pdf->AliasNbPages();
            // Sous-titre calées à gauche, texte gras (Bold), police de caractère 11
            $pdf->SetFont('Helvetica', 'B', 11);
            // couleur de fond de la cellule : gris clair
            $pdf->setFillColor(230, 230, 230);
            // Cellule avec les données du sous-titre sur 2 lignes, pas de bordure mais couleur de fond grise
            $pdf->Cell(75, 6, 'DU ' . 'datedeb' . ' AU ' . 'datefin', 0, 1, 'L', 1);
            $pdf->Cell(75, 6, strtoupper('prénom' . ' ' . 'nom'), 0, 1, 'L', 1);
            $pdf->Ln(10); // saut de ligne 10mm
            // AFFICHAGE EN-TÊTE DU TABLEAU
            // Position ordonnée de l'entête en valeur absolue par rapport au sommet de la page (60 mm)
            $position_entete = 70;
            // police des caractères
            $pdf->SetFont('Helvetica', '', 9);
            $pdf->SetTextColor(0);
            // on affiche les en-têtes du tableau
            $pdf->entete_table($position_entete);
            $pdf->Output('test.pdf','I'); // affichage à l'écran
        } else {
            echo $this->twig->render('info_achat.twig');
        }
    }
}
?>