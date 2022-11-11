<?php

class StickerModel{
    private $db;

    public function __construct()
    {
        $this->db= new PDO('mysql:host=localhost;'.'dbname=db_stickers;charset=utf8', 'root', '');
    }

    public function getAll(){
        $query = $this->db->prepare('SELECT * FROM figuritas');
        $query->execute();
        $stickers = $query->fetchAll(PDO::FETCH_OBJ);
        return $stickers;
    }

    public function getById($id){
        $query = $this->db->prepare("SELECT * FROM figuritas WHERE numero=?");
        $query->execute([$id]);
        $sticker = $query->fetchAll(PDO::FETCH_OBJ);
        return $sticker;
    }

    public function insert($numero, $nombre, $apellido, $id_pais)
    {
        $query = $this->db->prepare("INSERT INTO figuritas (numero, nombre, apellido, id_pais) VALUES (?,?,?,?)");
        $query->execute([$numero, $nombre, $apellido, $id_pais]);
        //retorno numero, porque lastInsertId() siempre retorna 0 porque no es autoincremental
        return $numero;
    }

    public function delete($numero)
    {
        $query = $this->db->prepare("DELETE FROM figuritas WHERE numero=?");
        $query->execute([$numero]);
    }

    public function update($id, $nombre, $apellido,$id_pais){
        $query = $this->db->prepare("UPDATE figuritas SET nombre=?, apellido=?, id_pais=? WHERE numero=?");
        $query->execute([$nombre, $apellido, $id_pais, $id]);
    }

    public function order($order,$sort){
        $query = $this->db->prepare("SELECT * FROM figuritas ORDER BY $sort $order");
        $query->execute();
        $ordered = $query->fetchAll(PDO::FETCH_OBJ);
        return $ordered;
    }

    public function getColumnsNames(){
        $query = $this->db->prepare("SELECT COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'figuritas'");
        $query->execute();
        $columns= $query->fetchAll(PDO::FETCH_OBJ);
        return $columns;
    }

    public function getPagination($page,$limit){
        $off = ($limit * $page) - $limit;
        $query = $this->db->prepare("SELECT nombre.*,apellido.*, pais.* FROM figuritas JOIN selecciones ON stickers.id_pais = selecciones.id_pais ORDER BY stickers.numero ASC LIMIT $limit OFFSET $off");
        $query->execute();
        $players = $query->fetchAll(PDO::FETCH_OBJ);
        return $players;
    }

    public function getFilteredStickers($column,$value)
    {
        $query=$this->db->prepare("SELECT * FROM figuritas WHERE $column=?");
        $query->execute([$value]);
        $stickers=$query->fetchAll(PDO::FETCH_OBJ);
        return $stickers;
    }
}