<?php
namespace Tiny\View;
use Exception;
use Tiny\Handler\DirectoryHandler;

class View {

    protected $templatePath;
    protected $params;

	public function render($templatePath, $params) {
        $buffer = null;
        $templatesDir = DirectoryHandler::getProjectDir(__DIR__, 'Templates');
        $templatePath = $templatesDir.$templatePath;
        $this->templatePath = $templatePath;
        $this->params = $params;

        if(file_exists($this->templatePath)){
            extract($this->params);
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