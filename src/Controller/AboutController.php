<?php
namespace src\Controller;

class AboutController {

    public function __construct(){
        return "Je suis construis !";
    }

    public function afficher(){
        return "Display -> ".__METHOD__;
    }

}