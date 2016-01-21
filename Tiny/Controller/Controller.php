<?php
namespace Tiny\Controller;
use Tiny\View\View;

class Controller {
    private $view;

    public function view(){
        $this->view = new View();
        return $this->view;
    }

    public function getBody(){
        return http_get_request_body();
    }
}