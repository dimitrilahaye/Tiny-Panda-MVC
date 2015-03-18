<?php
namespace Project\Controllers;
use Tiny\Controller\Controller;
use Project\Models\Auteur;
use Tiny\Persistence\TinyPDO;

class AboutController extends Controller{

    public function afficher(){
        $u = new Auteur;
        $u->setNom('toto');
        $u->setPrenom('Tutu');
        $params = array('user' => $u);
        return $this->view()->render('About/afficher.php', $params);
    }
    public function lister(){
        //there -> Services -> DAO -> there !!
        //This is just for test, sorry :3
        $pdo = new TinyPDO();
        $query = $pdo->prepare('select * from auteur where id_auteur=1');
        $query->execute();
        $user = $query->fetch();
        $myUser = new Auteur();
        $myUser->setNom($user['nom']);
        $myUser->setPrenom($user['prenom']);
        $params = array('auteur' => $myUser);
//        var_dump($myUser);
        return $this->view()->render('About/afficher.php', $params);
//        echo "Display -> ".__METHOD__;
    }
}