<?php
namespace Tiny\Router;

    class Router {

        private $controller;
        private $action;
        private $params;

        //TODO : Récupérer les params de la requête !
        public function __construct($request){
            $request = rtrim($request, '/');
            $request = ltrim($request, '/');
            $request = explode('/', $request);
            if(isset($request[0])) {
                $this->setController($request[0]);
            } else {
                $this->controller = "default";
            }
            if(isset($request[1])){
                $this->setAction($request[1]);
            } else {
                $this->action = "default";
            }
            if($this->controller != null){
                $this->matchController();
            }
        }
        public function getController(){
            return $this->controller;
        }
        public function setController($controller){
            $classController = ucfirst($controller)."Controller";
            $this->controller = 'Project\\Controllers\\'.$classController;
        }
        public function getAction() {
            return $this->action;
        }
        public function setAction($action){
            $this->action = lcfirst($action);
        }
        private function matchController() {
            $controller = $this->getController();
            if (class_exists($controller)) {
                $newController = new $controller();
                $this->matchAction($newController);
            }
        }
        private function matchAction($controller){
            $action = $this->getAction();
            if(method_exists($controller, $action)){
                $controller->$action();
            }
        }
}
