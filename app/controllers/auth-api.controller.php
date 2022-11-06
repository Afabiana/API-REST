<?php
require_once './app/views/api.view.php';
require_once './app/models/sticker.model.php';
require_once './app/helpers/auth-api.helper.php';

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

class AuthApiController{
    private $model;
    private $view;

    private $data;

    public function __construct()
    {
        //$this->model= new StickerModel();
        $this->view= new ApiView();

        //lee el body del request
        $this->data= file_get_contents("php://input");
    }

    private function getData(){
        return json_decode($this->data);
    }

    /*public function getToken(params = null){
        //verificar el header, que tenga un Basic, usuario y contraseña
        //chequear con bbdd
        //devolver un token

    }*/
}