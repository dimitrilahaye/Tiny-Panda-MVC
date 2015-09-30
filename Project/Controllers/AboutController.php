<?php
namespace Project\Controllers;
use Tiny\Controller\Controller;
use Project\Models\User;
use Tiny\Persistence\TinyPDO;

class AboutController extends Controller{

    public function afficherAction($id){
        $pdo = new TinyPDO();
        $query = $pdo->prepare('select * from user where id ='.$id);
        $query->execute();
        $user = $query->fetch();
        $myUser = new User();
        $myUser->setName($user['name']);
        $params = array('auteur' => $myUser);
        return $this->view()->render('About/afficher.php', $params);
    }
    public function listerAction(){
        $pdo = new TinyPDO();
        $query = $pdo->prepare('select * from user');
        $query->execute();
        $result = $query;
        $users = [];
        foreach($result as $user){
            $u = new User();
            $u->setName($user['name']);
            $users[] = $u;
        }
        $params = array('users' => $users);
        return $this->view()->render('About/lister.php', $params);
    }
}