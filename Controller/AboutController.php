<?php
namespace Controller;


class AboutController extends Controller {

    public function __construct(){
        return "Je suis construis !";
    }

    public function afficher(){
        return "Display -> ".__METHOD__;
    }

}