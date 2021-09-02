<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;


$app->group('/api', function(RouteCollectorProxy $group) {
	$group->get('/productos','App\Controllers\MantenedorController:obtenerProductos');

	$group->get('/categorias','App\Controllers\MantenedorController:obtenerCategorias');
});


$app->group('/api/producto', function(RouteCollectorProxy $group) {
	$group->get('/obtener/{id}','App\Controllers\MantenedorController:obtenerProducto');

	$group->post('/crear','App\Controllers\MantenedorController:crearProducto');

	$group->put('/actualizar/{id}','App\Controllers\MantenedorController:actualizarProducto');

	$group->delete('/eliminar/{id}','App\Controllers\MantenedorController:eliminarProducto');
});