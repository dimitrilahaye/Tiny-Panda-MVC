<?php
namespace Tiny\Controller;
use Tiny\View\View;

/**
 * Class Controller
 * @package Tiny\Controller
 *
 * Super class of all the controllers of the Project
 */
class Controller {
    private $view;

    /**
     * @return View : a view object
     * Return the view associated to this controller
     */
    public function view(){
        $this->view = new View();
        return $this->view;
    }
}