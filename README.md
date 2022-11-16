# API REST para el recurso de tareas
Una API REST sencilla para manejar un CRUD de tareas

## Importar la base de datos
- importar desde PHPMyAdmin (o cualquiera) database/db_stickers.php


## Pueba con postman
El endpoint de la API es: http://localhost/TPE_webII/api/stickers

## GET - POST 
http://localhost/TPE_webII/api/stickers

## GET by id - PUT by id- 
http://localhost/TPE_webII/api/stickers/id



## filtrado mayor o igual :
Se puede filtrar por cualquiera de los campos buscando resultados de igual o mayor valor
http://localhost/TPE_webII/api/stickers?filter=columna>valor
## filtrado igual : 
Se puede filtrar por cualquiera de los campos buscando resultados de igual valor
http://localhost/TPE_webII/api/stickers?filter=columna=valor

## orden : 
se puede ordenar ascendente o descendentemente (si no se especifica una columna se ordenaran segun su id(en este caso el numero de figurita))
http://localhost/TPE_webII/api/stickers?order=asc
http://localhost/TPE_webII/api/stickers?order=desc

## sort: 
Ordenar por determinada columna. Si no se le asigna un orden a seguir, se ordenaran de manera ascendente 
http://localhost/TPE_webII/api/stickers?sort=columna

## paginado: 
Paso pagina y limit(cantidad de elementos que quiero mostrar) 
http://localhost/TPE_webII/api/stickers?page=number&limit=number

## todas las funciones combinadas
http://localhost/TPE_webII/api/stickers?page=numero&limit=numero&filter=columna=valor&order=asc&sort=columna

## filtrado de figuritas por usuario
http://localhost/TPE_webII/api/stickers?user=id