<?php
namespace Project\Models;
use Tiny\Model\Model;

class Auteur extends Model{
    private $nom;
    private $prenom;

    public function getPrenom(){
        return $this->prenom;
    }
    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }
    public function getNom(){
        return $this->nom;
    }
    public function setNom($nom){
        $this->nom = $nom;
    }
}