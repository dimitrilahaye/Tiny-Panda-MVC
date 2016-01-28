<?php
namespace Project\Controllers;
use Tiny\Controller\TinyController;
use Project\Models\User;
use Tiny\Handler\JsonHandler;

class AboutController extends TinyController{
    
    public function jsonAction(){
        // prepare objects of class User
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
        // get the json service into manager
        $tinyJson = $this->getManager()->get("json");
        // prepare json and json array
        $jsonArray = '[{"id":12,"name":"John Doe"},{"id":36,"name":"Jane Doe"},{"id":56,"name":"Wade Wilson","user":[{"id":12,"name":"John Doe"},{"id":36,"name":"Jane Doe"}]}]';
        $json = '{"id":56,"name":"Wade Wilson","user":[{"id":12,"name":"John Doe"},{"id":36,"name":"Jane Doe"}]}';
        // get users object array from json array
        $myObjectsArray = $tinyJson->jsonToObject('Project\\Models\\User', $jsonArray);
        // get user from json
        $myObject = $tinyJson->jsonToObject('Project\\Models\\User', $json);
        // get json array from users array
        $myJsonArray = $tinyJson->objectToJson('Project\\Models\\User', $users);
        // get json object from an user
        $myJson = $tinyJson->objectToJson('Project\\Models\\User', $u3);
        // echo results
        foreach($myObjectsArray as $myObject) {
            echo $myObject->getId() . ' ' . $myObject->getName().'<br/>';
        }
        echo $myObject->getId() . ' ' . $myObject->getName().'<br/>';
        echo $myJsonArray."<br/>";
        echo $myJson."<br/>";
    }
}