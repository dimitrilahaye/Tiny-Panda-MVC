<?php
namespace Project\Controllers;
use Tiny\Controller\Controller;
use Tiny\View\View as View;

class AboutController extends Controller{

    public function __construct(){
        return "Je suis construis !";
    }
    public function afficher(){
        $params = array('user' => 'Test');
        $myView = new View('About/afficher.php', $params);
        return $myView->render();
    }
    public function lister(){
        echo "Display -> ".__METHOD__;
    }
}