<?php
require_once './app/models/sticker.model.php';
require_once './app/view/sticker.view.php';

class StickerApiController{
    private $model;
    private $view;

    private $data;

    public function __construct()
    {
        $this->model= new StickerModel();
        $this->view= new StickerView();

        //lee el body del request
        $this->data= file_get_contents("php://input");
    }

    private function getData(){
        return json_decode($this->data);
    }

    public function getStickers($params = null){
        $stickers= $this->model->getAll();
        $this->view->response($stickers);       
    }

    public function getSticker($params = null){
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
        $sticker = $this->getData();

        if(empty($sticker->numero)||empty($sticker->nombre)||empty($sticker->apellido)||empty($sticker->id_pais)){
            $this->view->response("Complete los datos", 400);
        }else{ 
            $numero = $this->model->insert($sticker->numero,$sticker->nombre,$sticker->apellido,$sticker->id_pais); //insert devuelve id
            $sticker= $this->model->getById($numero);
            $this->view->response("La figurita numero $numero se agregó con exito", 201);
        }
    }

    public function deleteSticker($params = null){
        $id = $params[':ID'];

        $sticker = $this->model->getById($id);
        if($sticker){
            $this->model->delete($id);
            $this->view->response($sticker);
        } else
            $this->view->response("La figurita=$id no existe",404);
    }

    public function updateSticker($params = null){
        //tomo id de params y me traigo la data de la figurita
        $id= $params[':ID'];
        $data = $this->getData();
        $sticker= $this->model->getById($id);

        if($sticker){
            $this->model->update($id, $data->nombre, $data->apellido,$data->id_pais);
            $updtSticker = $this->model->getById($id);
            $this->view->response($updtSticker);
        }
    }

    public function getOrdered($params = null){
        //VERIFICARRRRR
        //sort= que criterio quiero usar para que se ordenen
        $sort = $_GET['sort']; 
        //en order va a venir si es desc o asc
        $order = $_GET['order']; 

        if($sort == null){
            //por defecto si sort es null las voy a ordenar por numero/id
            $sort = 'numero';
        }
        if($order == null){
            //por defecto si sort es null las voy a ordenar por numero/id
            $order = 'asc';
        }

        //del model me traigo la lista de figuritas ORDENADAS
        $ordered= $this->model->order($order,$sort);
        $this->view->response($ordered);
    }
}