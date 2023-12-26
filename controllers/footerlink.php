<?php
class ControleurFooterLink
{
    private $twig;
    public function __construct($twig)
    {
        $this->twig = $twig;
    }
    public function render()
    {
        echo $this->twig->render('footerlink.twig');
    }
}
?>