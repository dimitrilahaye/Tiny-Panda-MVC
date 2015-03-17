<?php
namespace Project\Controller;

class AboutController {

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