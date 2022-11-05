<?php
require_once './libs/Router.php';
require_once './app/controllers/sticker-api.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('stickers', 'GET', 'StickerApiController', 'getStickers');
$router->addRoute('stickers/:ID', 'GET', 'StickerApiController', 'getSticker');
$router->addRoute('stickers/:ID', 'DELETE', 'StickerApiController', 'deleteSticker');
$router->addRoute('stickers', 'POST', 'StickerApiController', 'addSticker'); 

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);

//http://localhost/TPE_webII/api/stickers