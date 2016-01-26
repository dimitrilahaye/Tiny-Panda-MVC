<?php
namespace Tiny\View;
use Exception;
use Tiny\Manager\TinyDirectory;

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
            throw new Exception('Le template '.$this->templatePath.' n\'a pas pu être trouvé...');
        }
        if($buffer == null){
            throw new Exception('Le template '.$this->templatePath.' n\'a pas pu être trouvé...');
        }
        return $buffer;
    }
}