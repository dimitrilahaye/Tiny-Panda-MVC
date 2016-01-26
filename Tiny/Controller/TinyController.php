<?php
namespace Tiny\Controller;
use Tiny\Manager\TinyManager;
use Tiny\View\TinyView;

/**
 * Class Controller
 * @package Tiny\Controller
 *
 * Super class of all the controllers of the Project
 */
class TinyController {

    /**
     * @var TinyView
     *
     * View to instanciate in the browser
     */
    private $view;

    /**
     * @var TinyManager
     *
     * Provides the services for Project controllers :
     *      json serializer, request manager, response manager, etc...
     */
    private $manager;

    public function __construct(){
        $this->manager = new TinyManager();
    }

    /**
     * @return TinyManager
     *
     * Returns the TinyManager to get the differents services for controllers
     */
    public function getManager(){
        return $this->manager;
    }

    /**
     * @return TinyView : a view object
     *
     * Return the view associated to this controller
     */
    public function view(){
        $this->view = new TinyView();
        return $this->view;
    }
}