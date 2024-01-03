<?php
use Fpdf\Fpdf;
require_once('models/panier.php');
require_once('models/caisse.php');

class ControleurFacture extends FPDF
{
  // Header
  function Header()
  {
    // Logo : 20 >position à gauche du document (en mm), 15 >position en haut du document, 40 >largeur de l'image en mm). La hauteur est calculée automatiquement.
    $this->Image('static\img\Milk_and_Mocha_test.jpg', 20, 15, 45);
    

    // Titre gras (B) police Helvetica de 20
    $this->SetFont('Helvetica', 'B', 20);
    // Texte : 0 > largeur de la cellule, 10 >hauteur de la cellule, 'FACTURE' >texte à afficher, 0 >pas de bordure, 1 >retour à la ligne ensuite, R >alignement à droite, 0 >pas de couleur de fond
    $this->Cell(0, 15, 'FACTURE', 0, 1, 'R', 0);

    // Titre gras (B) police Helvetica de 11
    $this->SetFont('Helvetica', 'B', 11);
    // Texte : 0 > largeur de la cellule, 8 >hauteur de la cellule, 'ISI WEB SHOP 4' >texte à afficher, 0 >pas de bordure, 1 >retour à la ligne ensuite, R >alignement à droite, 0 >pas de couleur de fond
    $this->Cell(0, 8, 'ISI WEB SHOP 4', 0, 1, 'R', 0);

    // Titre police grise Helvetica de 9 pour l'adresse
    $this->SetFont('Helvetica', '', 9);
    $this->SetTextColor(128);
    $this->Cell(0, 6, utf8_decode('15 Boulevard André Latarjet'), 0, 1, 'R', 0);
    $this->Cell(0, 6, '69100 Villeurbanne', 0, 1, 'R', 0);
    $this->Cell(0, 6, 'France', 0, 1, 'R', 0);

    // Titre police Helvetica de 11
    $this->SetFont('Helvetica', '', 11);
    $this->SetTextColor(0);
    // Texte : 0 > largeur de la cellule, 8 >hauteur de la cellule, 'milkandmocha@gmail.com' >texte à afficher, 0 >pas de bordure, 1 >retour à la ligne ensuite, R >alignement à droite, 0 >pas de couleur de fond
    $this->Cell(0, 8, 'milkandmocha@gmail.com', 0, 1, 'R', 0);
  }

  // Footer
  function Footer()
  {
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Helvetica', 'I', 9);
    // Numéro de page, centré (C)
    $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
  }

  function generateFacture()
  {
    // Nouvelle page A4 (incluant ici logo, titre et pied de page)
    $this->AddPage();

    // Polices par défaut : Helvetica taille 9
    $this->SetFont('Helvetica', '', 9);
    // Couleur par défaut : noir
    $this->SetTextColor(0);
    // Compteur de pages {nb}
    $this->AliasNbPages();


    // Sous-titre calées à gauche, texte gras (Bold), police de caractère 11
    $this->SetFont('Helvetica', 'B', 11);
    // couleur de fond de la cellule blanc
    $this->setFillColor(255, 255, 255);
    // AFFICHAGE DES INFOS CLIENT
    $this->Ln(10);
    $this->info_client();


    // Saut de ligne 10 mm
    $this->Ln(10); 


    // AFFICHAGE DU TABLEAU
    $this->setFillColor(255, 255, 255);
    $this->SetFont('Helvetica', '', 9);
    $this->Cell(0, 6, utf8_decode('Récapitulatif de la commande :'), 0, 1, 'L', 1);

    // AFFICHAGE EN-TÊTE DU TABLEAU
    // Position du tableau 
    $position_entete = 115;
    $position = 123;
    // police des caractères
    $this->SetFont('Helvetica', 'B', 9);
    $this->SetTextColor(0);
    // on affiche les en-têtes du tableau
    $this->entete_table($position_entete);


    // AFFICHAGE DU DÉTAIL DU TABLEAU
    $this->SetFont('Helvetica', '', 9);
    $this->panier($position);


    //AFFICHAGE DES INSTRUCTIONS SUR LA PAGE SUIVANTE
    $this->SetFont('Helvetica', '', 9);
    $this->SetTextColor(0);
    $this->AddPage();
    $this->instruction_paiement();


    $this->Output('test.pdf', 'I'); // affichage à l'écran
  }

  // Fonction affichage des infos client
  function info_client()
  {
    $caisse = new Caisse();
    $data = $caisse->get_info_delivery();

    $this->setFont('Helvetica', 'B', 11);
    $this->Cell(0, 8, utf8_decode('Facturé à :'), 0, 1, 'L', 1);

    $this->setFont('Helvetica', '', 9);
    $this->Cell(0, 6, utf8_decode($data['firstname'] . ' ' . $data['lastname']), 0, 1, 'L', 1);
    $this->Cell(0, 6, utf8_decode($data['add1'] . ' ' . $data['add2']), 0, 1, 'L', 1);
    $this->Cell(0, 6, utf8_decode($data['postcode'] . ' ' . $data['city']), 0, 1, 'L', 1);
  }

  // Fonction en-tête des tableaux en 3 colonnes de largeurs variables
  function entete_table($position_entete)
  {
    $this->SetDrawColor(183); // Couleur du fond RVB
    $this->SetFillColor(221); // Couleur des filets RVB
    $this->SetTextColor(0); // Couleur du texte noir
    $this->SetY($position_entete);
    // position de colonne 1 (10mm à gauche)	
    $this->SetX(10);
    $this->Cell(60, 8, 'Produit', 1, 0, 'C', 1);	// 60 >largeur colonne, 8 >hauteur colonne
    // position de la colonne 2 (70 = 10+60)
    $this->SetX(70);
    $this->Cell(30, 8, utf8_decode('Quantité'), 1, 0, 'C', 1);
    // position de la colonne 3 (130 = 70+30)
    $this->SetX(100);
    $this->Cell(60, 8, iconv('UTF-8', 'windows-1252', 'Prix total pour chaque article (€)'), 1, 0, 'C', 1); 

    $this->Ln(); // Retour à la ligne
  }

  function panier($position) {
    $panier = new Panier();
    $data = $panier->get_panier();
    $position_detail = $position;
    for ($i = 0; $i < count($data); $i++) {
        // position abcisse de la colonne 1 (10mm du bord)
        $this->SetY($position_detail);
        $this->SetX(10);
        $this->MultiCell(60, 8, utf8_decode($data[$i]['name']), 1, 'C');
        // position abcisse de la colonne 2 (70 = 10 + 60)	
        $this->SetY($position_detail);
        $this->SetX(70); 
        $this->MultiCell(30, 8, utf8_decode($data[$i]['quantity']), 1, 'C');
        // position abcisse de la colonne 3 (130 = 70+ 60)
        $this->SetY($position_detail);
        $this->SetX(100); 
        $this->MultiCell(60, 8, utf8_decode($data[$i]['price']), 1, 'C');
    
        // on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)	
        $position_detail += 8; 

        // on teste si le curseur est arrivé à la fin de la page
        // si c'est le cas, on ajoute une nouvelle page et on réaffiche l'en-tête
        if ($position_detail == 280) {
            $this->AddPage();
            $this->entete_table(115);
            $position_detail = 123;
        }  
    }

    // on affiche le prix total de la commande
    $this->SetFillColor(255, 255, 255);
    $this->SetFont('Helvetica', 'B', 9);
    $this->SetY($position_detail);
    $this->SetX(100);

    $total = $panier->get_total();
    $this->Cell(60,8,'Total :',1,0,'C',1);
    $this->SetX(160);
    $this->Cell(20,8, iconv('UTF-8', 'windows-1252', $total . '0 €'), 1, 0, 'C', 1);      

  }

  function instruction_paiement() {
    $this->SetFont('Helvetica', 'B', 20);
    $this->Ln(15);
    $this->Cell(0, 15, utf8_decode('Instructions pour le paiement par chèque'), 0, 1, 'L', 1);

    $this->SetFont('Helvetica', '', 9);
    $this->Write(6, utf8_decode('Nous vous remercions de votre choix de régler votre transaction par chèque. Afin de garantir un traitement rapide et efficace de votre paiement, veuillez adresser votre chèque à la société Milk and Mocha du montant indiqué après la case total du récapitulatif de la commande.'));
    $this->Ln(10);
    $this->Write(6, utf8_decode("Veuillez envoyer le chèque par voie postale à l'adresse suivante :"));
    $this->Ln(10);
    $this->Cell(0, 6, utf8_decode("15 Boulevard André Latarjet"), 0, 1, 'L', 0);
    $this->Cell(0, 6, '69100 Villeurbanne', 0, 1, 'L', 0);
    $this->Cell(0, 6, 'France', 0, 1, 'L', 0);

    $this->Ln(10);
    $this->Write(6, utf8_decode("Il est important de noter que le chèque doit être libellé à l'ordre du bénéficiaire spécifié ci-dessus. Assurez-vous également d'inclure toute information supplémentaire requise, telle que la référence de la facture, afin d'assurer un traitement précis de votre paiement."));
    $this->Ln(10);
    $this->Write(6, utf8_decode("Nous vous recommandons d'envoyer le chèque par courrier recommandé ou avec suivi pour garantir sa sécurité pendant le transit. Une fois que le paiement aura été reçu et traité, nous vous enverrons une confirmation par e-mail."));
    $this->Ln(10);
    $this->Write(6, utf8_decode("Nous vous remercions de votre coopération et restons à votre disposition pour toute question supplémentaire. Veuillez nous contacter par e-mail à milkandmocha@gmail.com si vous avez besoin d'assistance."));
  }

  function render()
  {
    $this->generateFacture();
    unset($_SESSION['SESS_ORDERNUM']);
    unset($_SESSION['order_id']);
  }
}
?>