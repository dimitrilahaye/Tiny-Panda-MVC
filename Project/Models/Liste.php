<?php
namespace Project\Models;

class Liste {
    private $titre;
    private $auteur;

    public function getTitre(){
        return $this->titre;
    }
    public function setTitre($titre){
        $this->titre = $titre;
    }
    public function getAuteur(){
        return $this->auteur;
    }
    public function setAuteur($auteur){
        $this->auteur = $auteur;
    }
}