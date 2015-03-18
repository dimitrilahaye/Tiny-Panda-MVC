<?php
namespace Project\Controllers;
use Tiny\Controller\Controller;
use Tiny\View\View;
use Project\Models\Auteur;

class AboutController extends Controller{

    public function afficher(){
        $u = new Auteur;
        $u->setNom('toto');
        $u->setPrenom('Tutu');
        $params = array('user' => $u);
        return $this->view()->render('About/afficher.php', $params);
    }
    public function lister(){
        echo "Display -> ".__METHOD__;
    }
}