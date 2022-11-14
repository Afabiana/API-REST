<?php
require_once './app/models/sticker.model.php';
require_once './app/views/api.view.php';
require_once './app/helpers/auth-api.helper.php';
class StickerApiController{
    private $model;
    private $view;
    private $data;
    private $authhelper;

    public function __construct()
    {
        $this->model= new StickerModel();
        $this->view= new ApiView();
        $this->authhelper= new AuthApiHelper;
        $this->data= file_get_contents("php://input");
    }

    private function getData(){
        return json_decode($this->data);
    }

    public function getStickers($params = null){
        //emprolijar codigo mucho MUY importante
        //antes de hacer explode de filter podria ver si el string contains > o = y modificar signo en la consulta
        //declaro valores por default
        $sort="numero";
        $filter="numero>0"; //no hay resultados que respondan a esa busqueda
        $page=1;
        $order="asc";
        $limit=$this->model->getTableSize();//esta funcion retorna el total de filas que tengo
        
        //si limit es mayor al numero de los resultados deberia decirlo?
        //verificar que para cambiar el valor de order, $_GET no esta vacio
        //si recibo parametros por get cambio el valor de las variables
        if(isset($_GET['sort'])&&!empty($_GET['sort'])&&$this->isColumn($_GET['sort']))
            $sort=$_GET['sort'];
        if(isset($_GET['filter'])&&!empty($_GET['filter']))
            $filter=$_GET['filter'];
        if(isset($_GET['page'])&&!empty($_GET['page'])&&is_numeric($_GET['page']))
            $page=$_GET['page'];
        if(isset($_GET['limit'])&&!empty($_GET['limit'])&&is_numeric($_GET['limit']))
            $limit=$_GET['limit']; 
        if(isset($_GET['order'])&&!empty($_GET['order'])&&($_GET['order']=="asc"||$_GET['order']=="desc"))
            $order=$_GET['order'];

        
        

        
        if(isset($_GET['user'])){
            $this->getStatusStickersByUser($_GET['user'],$limit, $page, $order, $sort, $filter);
        }else{
            $this->getPublicResults($limit, $page, $order, $sort, $filter);
        }
                  
    }

    public function getPublicResults($limit, $page, $order, $sort, $filter){
        //hago un explode del filtro. Tengo nombre columna por un lado, y valor por el otro
        $filters=preg_split('/[=|>|<]/', $filter);
        if($this->isColumn($filters[0])){
            $column=$filters[0];
            $value=$filters[1];
        }else{
            $this->view->response("Esa columna no existe", 404);
            die();
        }

        if(str_contains($filter, '>')||str_contains($filter, '<')){
            $column=substr($filter, 0, strlen($column)+1);
        }
            
        //evaluo variable page y limit para evitar inyeccion sql
        //calcular de manera que se pueda mostrar que ese numero de pagina no existe
        //calculo start. Ya chequee antes que los datos sean numericos
        $start = ($page -1) * $limit;
        $stickers=$this->model->getOrderedFilteredAndPaginated($column,$sort,$order,$limit,$start,$value);

        if($stickers)
            $this->view->response($stickers);
        else
            $this->view->response("No se encontraron resultados para esa peticion", 404);
        
    }

    //esto lo dejo en una funcion porque es una funcion que podria reutilizar
    public function getStatusStickersByUser($user,$limit, $page, $order, $sort, $filter){
        var_dump($filter);
        $filters=preg_split('/[=|>]/', $filter);
        $column=$filters[0];
        $value=$filters[1];
        //nomas le estoy pasando el filter completo para probar se que no estoy evitando inyeccion SQL
        //falta metodo que me retorne las columnas de la tabla status
        //falta metodo que me filte por igual, porque el que tengo filtra por >=
        $start = ($page -1) * $limit;
    $stickers=$this->model->getStickersByUser($user,$filter/*$column*/,$sort,$order,$limit,$start,/*$value*/);

        if($stickers)
            $this->view->response($stickers);
        else 
            $this->view->response("No hay figuritas con ese status", 404);
    }

    public function getSticker($params = null){
        var_dump($params);
        //traigo el id del arreglo de params
        $id = $params[':ID'];
        $sticker=$this->model->getById($id);

        //si no existe esa figurita devuelvo 404
        if($sticker)
            $this->view->response($sticker);
        else 
            $this->view->response("La figurita=$id no existe", 404);
    }

    public function addSticker($params = null) {
        //pido token para accionar
        if(!$this->authhelper->isLoggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        $sticker = $this->getData();
        if(empty($sticker->numero)||empty($sticker->nombre)||empty($sticker->apellido)||empty($sticker->id_pais)){
            $this->view->response("Complete los datos", 400);
        }else{ 
            //podria hacer q no devuelve el id, y en el string para la vista hacer sticker->numero
            $numero = $this->model->insert($sticker->numero,$sticker->nombre,$sticker->apellido,$sticker->id_pais); //insert devuelve id
            
            $this->view->response("La figurita numero $numero se agrego con exito", 201);
        }
    }

    public function deleteSticker($params = null){
        $id = $params[':ID'];

        $sticker = $this->model->getById($id);
        if($sticker){
            $this->model->delete($id);
            $this->view->response("La figurita=$id fue borrada con exito", $sticker);

        } else
            $this->view->response("La figurita $id no existe",404);
    }

    public function updateSticker($params = null){
        
        //pido token para accionar
        if(!$this->authhelper->isLoggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        //tomo id de params y me traigo la data de la figurita
        $id= $params[':ID'];
        $data = $this->getData();
        $sticker= $this->model->getById($id);

        if($sticker){
            $this->model->update($id, $data->nombre, $data->apellido,$data->id_pais);
            $this->view->response("La figurita $id se modifico con exito:");
        //podria armar el json como string y mandarlo todo como un mismo texto
        }else
            $this->view->response("La figurita $id no existe",404);
    }

    private function isColumn($newcol){
        //traigo el nombre de las columnas
        $result=[];
        $columns=$this->model->getColumnsNames();
        
        foreach($columns as $column){
            $value=$column->COLUMN_NAME;
            //el nombre de cada columna lo agrego a un array
            array_push($result,$value);
        }
        return in_array($newcol, $result);
    }
}