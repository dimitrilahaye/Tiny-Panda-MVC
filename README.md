![ ](http://dl-multimedias.net/img/tiny_panda.gif) Tiny-Panda-MVC PHP Framework
============================

MVC minimalist educational project in PHP

The purpose of this project is to practice my study of the MVC pattern in PHP.

-----

### ![ ](http://dl-multimedias.net/img/tiny_panda.gif) Table of contents

- [Tiny Panda MVC PHP Framework](#-tiny-panda-mvc-php-framework)
	- [Table of contents](#-table-of-contents)
- [Project tree](#-project-tree)
- [Installation](#--installation)
- [Project configuration](#--project-configuration)
	- [Routing configuration](#-routing-configuration)
	- [SQL DataBase configuration](#-sql-database-configuration)
  - [TinyPanda MVC Settings/options configuration](#-tinypanda-mvc-settingsoptions-configuration)
- [Project folder](#--project-folder)
	- [Create a Controller](#-create-a-controller)
	- [Create a method related to a route](#-create-a-method-related-to-a-route)
	- [Call PDO in Controller methods](#-call-pdo-in-controller-methods)
	- [Serializing and Deserializing](#-serializing-and-deserializing)
	- [Return View with parameters](#-return-view-with-parameters)
  	- [Redirect to another action/view with params](#-redirect-to-another-actionview-with-params)
	- [Use views template](#-use-views-template)
	- [Create a Model](#-create-a-model)
- [Coming Soon](#-coming-soon)

---
## ![ ](http://dl-multimedias.net/img/tiny_panda.gif) Project tree

There, the folders and subfolders of important elements of [Tiny-Panda]

```
|-- Assets
        |-- css
        |-- img
        |-- js
|-- Project
    |-- Controllers
        |-- AboutController.php
    |-- Models
         |-- User.php
    |-- Templates
        |-- About
                |-- afficher.php
                |-- lister.php
|-- Tiny
    |-- Configuration
        |-- db.init
        |-- routing.init
    |-- Controller
    |-- Handler
    |-- Model
    |-- Persistence
    |-- Router
    |-- Tiny
    |-- View
```
----------

## ![ ](http://dl-multimedias.net/img/tiny_panda.gif) <i class="icon-upload"></i> Installation
- Copy all files in a directory.

- Modify *`~/.htaccess`* file :
```apacheconf
RewriteEngine on
## add there the subfolders where you've copied Tiny Panda
RewriteBase /TinyProject/
##...
```

----------

### ![ ](http://dl-multimedias.net/img/tiny_panda.gif) <i class="icon-cog"></i> Project configuration
##### <i class="icon-cog"></i> Routing configuration
Modify *`~/Tiny/Configuration/routing.init`*
```ini
;;home route's definition : http://mysite.com/
[.]
;;home route's controller
controller = \Project\Controllers\AboutController
;;home route's action in this controller
method = toto
;;home route's name
name = root

;;route's definition : http://mysite.com/about/lister
[about/lister]
controller = \Project\Controllers\AboutController
method = lister
name = about lister

;;route's definition with one param : http://mysite.com/about/afficher/2
[about/afficher/$id]
controller = \Project\Controllers\AboutController
method = afficher
name = about afficher
;variable argument for about/afficher route
arguments[] = id
;... other routes
```
----------
##### <i class="icon-cog"></i> SQL DataBase configuration
Modify *`~/Tiny/Configuration/db.init`*
```ini
;something more to say ?
[database]
driver = mysql
host = localhost
port = null
dbname = tiny_panda_demo
username = root
password = root
```
----------
##### <i class="icon-cog"></i> TinyPanda MVC Settings/options configuration
Modify *`~/Tiny/Configuration/settings.init`*
```ini
[debug]
;;put 'enable' to true if you want to see WARNINGs in browser
enable = true

;;settings to be continued ;)
```
----------

### ![ ](http://dl-multimedias.net/img/tiny_panda.gif) <i class="icon-folder-open"></i> Project folder
> **IMPORTANT :**
>
> In *`~/Project`* folder, you can put all your application logic like *`~/Projet/Controllers/`*, *`~/Projet/Views/`* and/or *`~/Projet/Models/`*.

----------
#####  <i class="icon-file"></i> Create a Controller
- Create *`~/Project/Controllers`* folder
- Create *`~/Project/Controllers/AboutController.php`*
- Introduce this Controller class :

```php
<?php
namespace Project\Controllers;
use Tiny\Controller\TinyController;
//Controller class for [about/afficher] route (in configuration example)
class AboutController extends TinyController{
//...
}
```
----------
##### <i class="icon-pencil"></i> Create a method related to a route
```php
<?php
//Method for [about/afficher] route (in configuration example)
public function afficher($id){
//...
}
```
----------
##### <i class="icon-pencil"></i> Call PDO in Controller methods
```php
//...
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
//...
```
----------
##### <i class="icon-pencil"></i> Serializing and Deserializing

```php
//...

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
//...
foreach($myObjectsArray as $myObject) {
    echo $myObject->getId() . ' ' . $myObject->getName().'<br/>';
}
/*
12 John Doe
36 Jane Doe
56 Wade Wilson
*/

echo $myObject->getId() . ' ' . $myObject->getName().'<br/>';
/*
56 Wade Wilson
*/

echo $myJsonArray."<br/>";
/*
[  
   {  
      "id":12,
      "name":"John Doe"
   },
   {  
      "id":36,
      "name":"Jane Doe"
   },
   {  
      "id":56,
      "name":"Wade Wilson",
      "user":[  
         {  
            "id":12,
            "name":"John Doe"
         },
         {  
            "id":36,
            "name":"Jane Doe"
         }
      ]
   }
]
*/

echo $myJson."<br/>";
/*
{  
   "id":56,
   "name":"Wade Wilson",
   "user":[  
      {  
         "id":12,
         "name":"John Doe"
      },
      {  
         "id":36,
         "name":"Jane Doe"
      }
   ]
}
*/
```

----------
##### <i class="icon-pencil"></i> Return View with parameters
```php
$params = array('user' => $myUser);
return $this->view()->render('About/afficher.php', $params);
//in view, you'll be able to use $user variable !
```
----------
##### <i class="icon-pencil"></i> Redirect to another action/view with params
```ini
;;Tiny/Configuration/routing.ini
[test/$id1/redirect/$id2]
controller = \Project\Controllers\TestController
method = redirect
arguments[] = id1
arguments[] = id2
name = test redirect
```
```php
//Project/Controllers/TestController.php
public function home(){
//...
  $arguments = array("id1" => "Hello", "id2" => "World");
  $params = array("user" => "toto");
  // following line will redirect browser to route named "test redirect"
  // with two arguments in the uri ("Hello" and "World")
  // and $user = "toto" in parameters
  $this->view()->redirect("test redirect", $arguments, $params);
}
//...
public function redirect($request){
    // in action linked to the "test redirect" route, we can handle the arguments previously setted
    echo $request->getArgument("id1");
    /*
      Hello
    */
}
```
----------
#####  <i class="icon-file"></i> Use views template
eg. *`~/Project/Views/About/afficher.php`*
```php
<html>
    <head>
        // classical use of PHP language
        <title><?= $user->getName() ?></title>
    </head>
    <body>
        <h1><?= $user->getName() ?></h1>
    </body>
</html>
```
----------
>**WARNING**
- You **must** keep the *`~/Project/Templates/`* folder. You will place in this folder all your Views logic.

----------
##### <i class="icon-file"></i> Create a Model
- Create your Models folder in your *`~/Project/`* folder (eg. *`~/Project/Models/`*)
- Create your first Model class in it.
    - There, a simple example :
```php
<?php
//as you can see, it is a simple 'Entity like' class !
namespace Project\Models;
class User {
    private $id;
    private $name;
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
} 
```
----------
### ![ ](http://dl-multimedias.net/img/tiny_panda.gif) <i class="icon-cog"></i>Coming Soon

> - Update the README with TestController and the last updates
>
> - Finish wrapper for TinyRequest
>
> - Do wrapper for TinyResponse
>
> - Implement cookie and session wrappers
>
> - After PDO, a little bit of Mongo ?
>
> - Implement the configuration of method GET, POST, etc. for the route
>
> - Do dependency injection
>
> - Implement other php types object for TinyJson (Date, Time, DateTime, Null, ...)

----------

**TO BE CONTINUED**

I will improve and I will complete in this readme As my development!

![ ](http://dl-multimedias.net/img/tiny_panda.gif) **Thanks to use it ;)**

[Tiny-Panda]: <https://github.com/dimitrilahaye/Tiny-Panda-MVC>
