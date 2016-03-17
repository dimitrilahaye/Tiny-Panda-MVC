<?php
namespace Project\Controllers;
use Tiny\Controller\TinyController;
use Project\Models\User;

class TestController extends TinyController{

    public function home(){
        $params = array("user" => "toto");
        $this->view()->redirect("test redirect1", array("id1" => 1223, "id2" => "Dimitri"), $params);
    }
    
    public function json(){
        // prepare objects of class User
        $users = [];
        $subUsers = [];
        $u1 = new User();
        $u1->setName("John Doe");
        $u1->setId(12);
        $u2 = new User();
        $u2->setName("Jane Doe");
        $u2->setId(36);
        $u3 = new User();
        $u3->setName("Wade Wilson");
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
        $myObjectsArray = $tinyJson->jsonToObject("Project\\Models\\User", $jsonArray);
        // get user from json
        $myObject = $tinyJson->jsonToObject("Project\\Models\\User", $json);
        // get json array from users array
        $myJsonArray = $tinyJson->objectToJson("Project\\Models\\User", $users);
        // get json object from an user
        $myJson = $tinyJson->objectToJson("Project\\Models\\User", $u3);
        // echo results
        foreach($myObjectsArray as $myObject) {
            echo $myObject->getId() . " " . $myObject->getName()."<br/>";
        }
        echo $myObject->getId() . " " . $myObject->getName()."<br/>";
        echo $myJsonArray."<br/>";
        echo $myJson."<br/>";
    }
    
    public function redirect($request){
        echo $request->getArgument("id1");
    }

    public function pdo(){
        $pdo = $this->getManager()->get("pdo");
        
        // INSERT datas
        /* will generate this query :
            INSERT INTO pandas (name) VALUES (?)
        */
        $pdo->post("pandas", array("name"=>"Kiwi"));
        $pdo->post("pandas", array("name"=>"Ananas"));
        
        // SELECT * datas
        /* will generate this query :
            UPDATE pandas SET name = ? WHERE id = ?
        */
        $pandas = $pdo->getAll("pandas");
        foreach ($pandas as $key => $panda) {
            echo $panda["name"]."<br/>";
        }
        
        // SELECT datas
        /* will generate this query :
            SELECT * FROM pandas WHERE id = ?
        */
        $pandas = $pdo->get("pandas", array("id"=>1));
        foreach ($pandas as $key => $panda) {
            echo $panda["name"]."<br/>";
        }
        
        // UPDATE datas
        /* will generate this query :
            UPDATE pandas SET name = ? WHERE id = ?
        */
        $pdo->put("pandas", array("name"=>"Cassis"), array("id"=>1));
        
        // UPDATE datas on all lines of the table
        /* will generate this query :
            UPDATE pandas SET name = ?
        */
        $pdo->putAll("pandas", array("name"=>"ohohohohohoh"));
        
        // DELETE one element
        /* will generate this query :
             DELETE FROM pandas WHERE id = ?
        */
        $pdo->delete("pandas", array("id"=>2));
        
        // DELETE all !
        /* will generate this query :
            DELETE FROM pandas
        */
        $pdo->deleteAll("pandas");
        
        // Close connection
        $pdo->close($pdo);
    }


    /*


    */
}