Tiny-Panda-MVC PHP Framework
============================

![enter image description here](http://i943.photobucket.com/albums/ad275/nikennyyyyy/thththanimated-panda-1.gif)
MVC minimalist educational project in PHP

The purpose of this project is to practice my study of the MVC pattern in PHP.

-----

### Table of contents

- [Tiny Panda MVC PHP Framework](#tiny-panda-mvc-php-framework)
	- [Table of contents](#table-of-contents)
- [Project tree](#-project-tree)
- [Installation](#--installation)
- [Project configuration](#--project-configuration)
	- [Routing configuration](#-routing-configuration)
	- [SQL DataBase configuration](#-sql-database-configuration)
- [Project folder](#--project-folder)
	- [Create a Controller](#-create-a-controller)
	- [Create a method related to a route](#-create-a-method-related-to-a-route)
	- [Call PDO in Controller method](#-call-pdo-in-controller-method)
	- [Serialize object and objects array in a controller method](#-serialize-object-and-objects-array-in-a-controller-method)
	- [Return View with parameters](#-return-view-with-parameters)
	- [Use views template](#-use-views-template)
	- [Create a Model](#-create-a-model)

---
## ![enter image description here](http://i943.photobucket.com/albums/ad275/nikennyyyyy/thththanimated-panda-1.gif) Project tree

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
## ![enter image description here](http://i943.photobucket.com/albums/ad275/nikennyyyyy/thththanimated-panda-1.gif) <i class="icon-upload"></i> Installation
- Copy all files in a directory.

- Modify *`~/.htaccess`* file :
```apacheconf
RewriteEngine on
## add there the subfolders where you've copied Tiny Panda
RewriteBase /TinyProject/
##...
```
----------
> **COMING SOON**
>
> I will add a default controller for you to test the installation of the framework.

----------
### ![enter image description here](http://i943.photobucket.com/albums/ad275/nikennyyyyy/thththanimated-panda-1.gif) <i class="icon-cog"></i> Project configuration
##### <i class="icon-cog"></i> Routing configuration
Modify *`~/Tiny/Configuration/routing.init`*
```ini
;route definition
[about/lister]
;controller namespace for about/lister route
controller = \Project\Controllers\AboutController
;method name for controller
method = listerAction
[about/afficher]
controller = \Project\Controllers\AboutController
method = afficherAction
;variable argument for about/afficher route
param = id
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
### ![enter image description here](http://i943.photobucket.com/albums/ad275/nikennyyyyy/thththanimated-panda-1.gif) <i class="icon-folder-open"></i> Project folder
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
use Tiny\Controller\Controller;
//Controller class for [about/afficher] route (in configuration example)
class AboutController extends Controller{
//...
}
```
----------
##### <i class="icon-pencil"></i> Create a method related to a route
```php
<?php
//Method for [about/afficher] route (in configuration example)
public function afficherAction($id){
//...
}
```
----------
##### <i class="icon-pencil"></i> Call PDO in Controller method
```php
use Tiny\Persistence\TinyPDO;
//...
$pdo = new TinyPDO();
$query = $pdo->prepare('select * from user where id ='.$id);
$query->execute();
$user = $query->fetch();
//...
```
----------
##### <i class="icon-pencil"></i> Serialize object and objects array in a Controller method
```php
use Tiny\Handler\JsonHandler;
//...
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
echo $jsonArray;
/*[
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
]*/
$json = JsonHandler::serializeObject('Project\\Models\\User', $u3);
echo $json;
/*{
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
}*/
//...
```

----------
##### <i class="icon-pencil"></i> Return View with parameters
```php
$params = array('user' => $myUser);
return $this->view()->render('About/afficher.php', $params);
//in view, you'll be able to use $user variable !
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
>**TO BE CONTINUED**
>
> I will improve and I will complete in this readme As my development!

> ![enter image description here](http://i943.photobucket.com/albums/ad275/nikennyyyyy/thththanimated-panda-1.gif) **Thanks to use it ;)**

[Tiny-Panda]: <https://github.com/dimitrilahaye/Tiny-Panda-MVC>
