<?php
namespace Tiny\View;

class View {

    protected $templatePath;
    protected $params;

	public function __construct($templatePath, $params) {
        $templatePath = $_SERVER['DOCUMENT_ROOT']
            .DIRECTORY_SEPARATOR.'Project'
            .DIRECTORY_SEPARATOR.'Templates'
            .DIRECTORY_SEPARATOR.$templatePath;
        $this->templatePath = $templatePath;
        $this->params = $params;
    }

	public function render() {
        if(file_exists($this->templatePath)){
            extract($this->params);
            ob_start();
            include ($this->templatePath);
            $buffer = ob_get_contents();
            ob_get_flush();
            return $buffer;
        } else {
            //throw exception...
        }
    }
}