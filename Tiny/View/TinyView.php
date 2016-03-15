<?php
namespace Tiny\View;
use Exception;
use Tiny\Manager\TinyDirectory;
use Tiny\Manager\TinyCache;
use Tiny\Manager\TinyRoute;
/**
 * Class TinyView
 * @package Tiny\View
 *
 * Super class of all the View of the Project
 */
class TinyView {

    /**
     * @var string
     *
     * Path to the template.html
     */
    protected $templatePath;

    /**
     * @var array
     *
     * Array of parameters for the view
     */
    protected $parameters;

    /**
     * @param $templatePath
     * @param $params
     * @return null|string
     * @throws Exception
     *
     * Return to the client the template with the params if exist
     */
    public function render($templatePath, $params) {
        $buffer = null;
        $tinyDir = new TinyDirectory();
        $templatesDir = $tinyDir->getProjectDir(__DIR__, 'Templates');
        $templatePath = $templatesDir.$templatePath;
        $this->templatePath = $templatePath;
        $this->parameters = $params;

        if(file_exists($this->templatePath)){
            if($this->parameters != null){
                extract($this->parameters);
            }
            ob_start();
            include ($this->templatePath);
            $buffer = ob_get_contents();
            ob_get_flush();
        } else {
            throw new Exception('Template '.$this->templatePath.' has not been found...');
        }
        if($buffer == null){
            throw new Exception('Template '.$this->templatePath.' has not been found...');
        }
        return $buffer;
    }
    
    /**
     * 
     * @param type $routeName : name of the route for the redirection
     * @param type $args : the arguments we want to pass to the redirection url
     * @param type $params : the parameters we want to pass to the template view
     * @throws Exception
     * 
     * Search into routeCache.ini for the section corresponding to the $routeName
     * then redirect to the url corresponding.
     */
    public function redirect($routeName, $args, $params){
        $tinyDir = new TinyDirectory();
        $tinyCache = new TinyCache();
        $tinyCache->regenerateRouteCacheFile();
        $routeCacheFile = $tinyDir->getRouteCacheIni();
        if($routeCacheFile != null){
            $routeCacheIni = parse_ini_file($routeCacheFile, true);
            $this->generateRedirection($routeCacheIni, $routeName, $args, $params);
        } else {
            throw new Exception('Unable to find or read routeCache.ini...');
        }
    }
    
    /**
     * @param type String $routeCacheIni : parsed routeCache.ini
     * @param type String $routeName : the name of the route to the redirection
     * @param type String $args : arguments for the redirection, can be null
     * @param type String $params : params for the redirection, can be null
     * @throws Exception
     * 
     * Provides the redirection for the $routeName find in the routeCache.ini
     */
    private function generateRedirection($routeCacheIni, $routeName, $args, $params){
        if(isset($routeCacheIni[$routeName])){
            $redirectionURL = $this->getRedirectionURL($routeCacheIni[$routeName]["route"], $args);
            if($params != null){
                //TODO : construct header with params in it !!
                //And manage params in Router.php
            }
            header("Location: ".$redirectionURL);
        } else {
            throw new Exception("Route name : ". $routeName. " doesn't exist !");
        }
    }
    
    /**
     * 
     * @param type String routeURL : route url returned by the routeCache.ini
     * @return type String : the url for the redirection
     */
    private function getRedirectionURL($routeURL, $args){
        $tinyRoute = new TinyRoute();
        $routeURL = $tinyRoute->generateRouteWithArguments($routeURL, $args);
        return "http".(($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://")
            .$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].$routeURL;
    }
}