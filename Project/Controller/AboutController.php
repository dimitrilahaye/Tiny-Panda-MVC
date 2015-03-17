<?php
namespace Project\Controller;
use Tiny\Controller\Controller;

class AboutController extends Controller{

    public function __construct(){
        return "Je suis construis !";
    }
    public function afficher(){
        echo "Display -> ".__METHOD__;
    }
    public function lister(){
        echo "Display -> ".__METHOD__;
    }

}