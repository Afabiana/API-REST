# API REST para el recurso de tareas
Una API REST sencilla para manejar un CRUD de tareas

## Importar la base de datos
- importar desde PHPMyAdmin (o cualquiera) database/db_stickers.php


## Pueba con postman
El endpoint de la API es: http://localhost/TPE_webII/api/stickers

## filtrado mayor o igual : se puede filtrar por cualquiera de los campos buscando resultados de igual o mayor valor
http://localhost/TPE_webII/api/stickers?filter=columna>valor
## filtrado igual : se puede filtrar por cualquiera de los campos buscando resultados de igual valor
http://localhost/TPE_webII/api/stickers?filter=columna=valor

## orden : se puede ordenar ascendente o descendentemente (si no se especifica una columna se ordenaran segun su id(en este caso el numero de figurita))
http://localhost/TPE_webII/api/stickers?order=asc
http://localhost/TPE_webII/api/stickers?order=desc

## sort: ordenar por determinada columna. Si no se le asigna un orden a seguir, se ordenaran de manera ascendente 
http://localhost/TPE_webII/api/stickers?sort=columna

## paginado: paso pagina y limit(cantidad de elementos que quiero mostrar) 
http://localhost/TPE_webII/api/stickers?page=number&limit=number

## todas las funciones combinadas
http://localhost/TPE_webII/api/stickers?page=numero&limit=numero&filter=columna=valor&order=asc&sort=nombre