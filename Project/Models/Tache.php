<?php
namespace Project\Models;
use Tiny\Model\Model;

class Tache extends Model{
    private $libelle;
    private $isDone;

    public function getLibelle(){
        return $this->libelle;
    }
    public function setLibelle($libelle){
        $this->libelle = $libelle;
    }
    public function getIsDone(){
        return $this->isDone;
    }
    public function setIsDone($isDone){
        $this->isDone = $isDone;
    }
}