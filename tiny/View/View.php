<?php
namespace tiny\View;


class View {

    private $template;
    private $params=[];
    private $model;

    public function getTemplate(){
        return $this->template;
    }
    public function setTemplate($template){
        $this->template = $template;
    }
    public function getParams(){
        return $this->params;
    }
    public function setParams($params){
        $this->params = $params;
    }
    public function getModel(){
        return $this->model;
    }
    public function setModel($model){
        $this->model = $model;
    }

}