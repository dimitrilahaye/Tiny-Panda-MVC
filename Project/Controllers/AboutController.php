<?php
namespace Project\Controllers;
use Tiny\Controller\Controller;
use Project\Models\User;
use Tiny\Persistence\TinyPDO;
use Tiny\Handler\JsonHandler;

class AboutController extends Controller{

    public function afficherAction($id){
        $pdo = new TinyPDO();
        $query = $pdo->prepare('select * from user where id ='.$id);
        $query->execute();
        $user = $query->fetch();
        $myUser = new User();
        $myUser->setName($user['name']);
        $myUser->setId($user['id']);

        echo JsonHandler::serializeObject('Project\\Models\\User', $myUser);

        $params = array('auteur' => $myUser);
        return $this->view()->render('About/afficher.php', $params);
    }
    public function listerAction(){
        $pdo = new TinyPDO();
        $query = $pdo->prepare('select * from user');
        $query->execute();
        $result = $query;
        $users = [];
        $subUsers = [];
        $u1 = new User();
        $u1->setName('John Doe');
        $u1->setId(12);
        $u2 = new User();
        $u2->setName('Jane Doe');
        $u2->setId(36);
        $u3 = new User();
        $u3->setName('Wade Wilson');
        $u3->setId(56);
        $subUsers[] = $u1;
        $subUsers[] = $u2;
        $u3->setUser($subUsers);
        $users[] = $u1;
        $users[] = $u2;
        $users[] = $u3;
        $jsonArray = JsonHandler::serializeObjectsArray('Project\\Models\\User', $users);
        $json = JsonHandler::serializeObject('Project\\Models\\User', $u3);
        $object = JsonHandler::deserializeObject('Project\\Models\\User', $json);
        echo $object->getId().' '.$object->getName();
        $objectArray = JsonHandler::deserializeObjectsArray('Project\\Models\\User', $jsonArray);
        foreach($objectArray as $object) {
            echo $object->getId() . ' ' . $object->getName().'<br/>';
        }
        $params = array('users' => $users);
        return $this->view()->render('About/lister.php', $params);
    }
}