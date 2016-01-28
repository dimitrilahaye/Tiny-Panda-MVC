<?php
namespace Tiny\View;
use Exception;
use Tiny\Manager\TinyDirectory;
use Tiny\Manager\TinyCache;
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
     * @param type $params : the parameters we want to pass to the template view
     * @param type $args : the arguments we want to pass to the redirection url
     * @throws Exception
     * 
     * Search into routeCache.ini for the section corresponding to the $routeName
     * then redirect to the url corresponding.
     */
    public function redirect($routeName, $params, $args){
        $tinyDir = new TinyDirectory();
        $tinyCache = new TinyCache();
        $tinyCache->regenerateRouteCacheFile();
        $routeCacheFile = $tinyDir->getRouteCacheIni();
        if($routeCacheFile != null){
            $routeCacheIni = parse_ini_file($routeCacheFile, true);
            if(isset($routeCacheIni[$routeName])){
                $redirectionURL = $this->getRedirectionURL($routeCacheIni[$routeName]["route"]);
                if($args != null){
                    $redirectionURL .= "/".$args;
                }
                if($params != null){
                    //TODO : construct header with params in it !!
                    //And manage params in Router.php
                }
                header("Location: ".$redirectionURL);
            } else {
                throw new Exception("Route name : ". $routeName. " doesn't exist !");
            }
        } else {
            throw new Exception('Unable to find or read routeCache.ini...');
        }
    }
    
    /**
     * 
     * @param type String routeURL : route url returned by the routeCache.ini
     * @return type String : the url for the redirection
     */
    private function getRedirectionURL($routeURL){
        return $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]
                .$_SERVER["CONTEXT_PREFIX"]."/".$routeURL;
    }
}