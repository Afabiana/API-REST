<?php

class UserModel{
    private $db;
    function __construct(){
        $this->db= new PDO ('mysql:host=localhost;'.'dbname=db_stickers;charset=utf8','root','');
    }

    public function getUserByUsername($user){
        $query=$this->db->prepare('SELECT * FROM usuarios WHERE user=?');
        $query->execute([$user]);
        $usuario=$query->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }

}