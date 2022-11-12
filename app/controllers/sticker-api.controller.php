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
        $sort = 'numero';
        $order = 'asc';
        if(isset($_GET['filter'])&&!empty($_GET['filter'])){
            $filter=preg_split('/[=|&|?]/', $_GET['filter']);
            if($this->isColumn($filter[0])){
                $column=$filter[0];
            }
            $value=$filter[1];
            $stickers= $this->model->getFilteredStickers($column,$value);
            $this->view->response($stickers);
        }
        /*if(empty($_GET['sort'])&&empty($_GET['order'])){
            //si no recibo parametros de ordenamiento por get muestro la lista normalmente
            $stickers= $this->model->getAll();
            $this->view->response($stickers);
        }/*else{
            $order=$_GET['order'];
            $columns=$this->getTableColumns();
            //en este if verifico que sort sea una de las columnas
            if(($order=="asc"||$order=="desc")&&in_array($_GET['sort'], $columns)){
                $this->getOrdered($_GET['sort'], $_GET['order']);
            }   
        }*/
    }

    public function getStatusStickersByUser($column, $user){
        $column=1;
        $value=0;
        $stickers=$this->model->getStickersByUser($column, $value, $user);
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
        var_dump($params);
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
            $this->view->response("La figurita=$id no existe",404);
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
            $this->view->response("La figurita=$id no existe",404);
    }

    private function getOrdered($sort, $order){
        //del model me traigo la lista de figuritas ORDENADAS
        $ordered= $this->model->order($order,$sort);
        $this->view->response($ordered);
    }

    private function isColumn($newcol){
        //traigo el nombre de las columnas
        $columns=$this->model->getColumnsNames();
        $result=[];
        foreach($columns as $column){
            $value=$column->COLUMN_NAME;
            //el nombre de cada columna lo agrego a un array
            array_push($result,$value);
        }
        return in_array($newcol, $result);
    }
}