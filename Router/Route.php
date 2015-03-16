<?php
namespace Router;
    class Route {

        private $controller;
        private $action;
        private $params;

        /**
         * @param $request
         *  Décompose l'uri pour récupérer le controlleur visé et son action visée
         * Plus tard, récupérera les paramètres et les passera au controller !
         */
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
                $this->action = $request[1];
            } else {
                $this->action = "default";
            }
            if($this->controller != null){
                    $this->matchController();
            }
        }

        /**
         * @return string $controller retourné par l'uri
         */
        public function getController(){
            return $this->controller;
        }

        /**
         * @param $controller
         * La route possède le controller visé par l'uri
         * => http://localhost/[controller]/[action]
         * Le champ $controller est setté sous la forme 'Controller\[NomDuController]Controller'
         * Controller\ étant le namespace comportant la classe en question
         */
        public function setController($controller){
            $classController = ucfirst($controller)."Controller";
            $this->controller = 'Controller\\'.$classController;
        }

        /**
         * @return string $action retournée par l'uri
         */
        public function getAction()
        {
            return $this->action;
        }

        /**
         * @param $action
         * La route possède une action, correspondante à une méthode du controlleur visé par l'uri
         *  => http://localhost/[controller]/[action]
         * Le champ $action est setté sous la forme "action()"
         */
        public function setAction($action){
            $this->action = lcfirst($action).'()';
        }

        /**
         * Créer le controlleur visé par l'uri
         */
        private function matchController() {
                $controller = $this->getController();
                if (class_exists($controller)) {
                    $newController = new $controller();
                    $this->matchAction($newController);
                }
        }

        /**
         * @param $controller
         * Appel la méthode correspondante à l'action du controlleur visé par l'uri
         */
        private function matchAction($controller){
            $action = $this->getAction();
            if(method_exists($controller, $action)){
                echo $controller->$action();
            }
        }
}
