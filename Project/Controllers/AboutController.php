<?php
namespace Project\Controllers;
use Tiny\Controller\Controller;
use Tiny\View\View;
use Project\Models\Auteur;

class AboutController extends Controller{

    public function __construct(){
        return "Je suis construis !";
    }
    public function afficher(){
        $u = new Auteur;
        $u->setNom('toto');
        $u->setPrenom('Tutu');
        $params = array('user' => $u);
        $myView = new View('About/afficher.php', $params);
        return $myView->render();
    }
    public function lister(){
        echo "Display -> ".__METHOD__;
    }
}