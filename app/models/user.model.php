<?php

class UserModel{
    private $db;
    function __construct(){
        $this->db= new PDO ('mysql:host=localhost;'.'dbname=db_stickers;charset=utf8','root','');
    }

    public function getUserByEmail($email){
        var_dump($email);
        $query=$this->db->prepare('SELECT * FROM usuarios WHERE email=?');
        $query->execute([$email]);
        $usuario=$query->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }

}