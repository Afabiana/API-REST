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

    public function getColumnsNames(){
        $query = $this->db->prepare("SELECT COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'figuritas'");
        $query->execute();
        $columns= $query->fetchAll(PDO::FETCH_OBJ);
        return $columns;
    }

    public function getStickersByUser($user,$filter/*$column*/,$sort,$order,$limit,$start,/*$value*/){
                                ///SELECT * FROM figuritas a INNER JOIN status b ON a.numero=b.fk_figurita WHERE faltante=1 AND fk_user=4 ORDER BY numero LIMIT 10 OFFSET 0;
        $query=$this->db->prepare("SELECT a.nombre,a.apellido,a.numero FROM figuritas a INNER JOIN status b ON a.numero=b.fk_figurita WHERE $filter AND fk_user=? ORDER BY $sort $order LIMIT $limit OFFSET $start");
        $query->execute([/*$value,*/$user]);
        $stickers=$query->fetchAll(PDO::FETCH_OBJ);
        return $stickers;
    }

    public function getTableSize(){
        $query = $this->db->prepare("SELECT count(*)  as count FROM figuritas");
        $query->execute([]);
        $size = $query->fetch(PDO::FETCH_OBJ);
        return $size->count;
    }

    public function getOrderedFilteredAndPaginated($column,$sort,$order,$limit,$start,$value){
        var_dump($column);
        $query=$this->db->prepare("SELECT * FROM figuritas a WHERE $column=? ORDER BY $sort $order LIMIT $limit OFFSET $start");
        var_dump($query);
        $query->execute([$value]);
        $stickers=$query->fetchAll(PDO::FETCH_OBJ);
        return $stickers;
    }

}