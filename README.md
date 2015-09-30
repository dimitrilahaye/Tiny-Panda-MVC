# Tiny-Panda-MVC
MVC minimalist educational project in PHP

The purpose of this project is to practice my study of the MVC pattern in PHP.

### Project tree

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

### Installation
- Copy all files in a directory.

- Modify *`~/.htaccess`* file :
```apacheconf
RewriteEngine on
## add there the subfolders where you've copied Tiny Panda
RewriteBase /TinyProject/
##...
```
- Soon I will add a default controller for you to test the installation of the framework.

##### Project configuration
###### Routing configuration
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
###### SQL DataBase configuration
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
##### Project folder
In *`~/Project`* folder, you can put all your application logic like *`~/Projet/Controllers/`*, *`~/Projet/Views/`* and/or *`~/Projet/Models/`*.
###### Create a Controller
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
- Create a method related to a route :
```php
<?php
//Method for [about/afficher] route (in configuration example)
public function afficherAction($id){
//...
}
```
- Call PDO in Controller method :
```php
use Tiny\Persistence\TinyPDO;
//...
$pdo = new TinyPDO();
$query = $pdo->prepare('select * from user where id ='.$id);
$query->execute();
$user = $query->fetch();
```
- Return View with parameters
```php
$params = array('user' => $myUser);
return $this->view()->render('About/afficher.php', $params);
//in view, you'll be able to use $user variable !
```
- Use views template :
    - eg. *`~/Project/Views/About/afficher.php`*
```html
<html>
    <head>
        <!-- classical use of PHP language -->
        <title><?= $user->getName() ?></title>
    </head>
    <body>
        <h1><?= $user->getName() ?></h1>
    </body>
</html>
```
##### WARNING
- You **must** keep the *`~/Project/Templates/`* folder. You will place in this folder all your Views logic.

###### Create a Model
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
I will improve and I will complete in this readme As my development!

Thanks to use it ;)

[Tiny-Panda]: <https://github.com/dimitrilahaye/Tiny-Panda-MVC>