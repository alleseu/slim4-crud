<?php namespace App\Controllers;

use App\Controllers\BaseController;


class MantenedorController extends BaseController {

	//FUNCIÓN PARA PROCESAR LA OBTENCIÓN DE LOS PRODUCTOS.
	public function obtenerProductos($request, $response, $args) {

		//LLAMA A LA FUNCIÓN QUE OBTIENE TODOS LOS PRODUCTOS. (SI NO HAY PRODUCTOS, RETORNA VACÍO).
		$data = $this->container->get('modelo_producto')->obtenerTodo();

		//Comprueba que el dato obtenido no está vacío.
		if (!empty($data)) {

			$respuesta = [
				'resultado' => 'EXITO',
				'data' => $data
			];

			$codigo = 200;  //Código de estado de respuesta HTTP, OK.
		}
		else {

			$respuesta = [
				'resultado' => 'ERROR_VALIDACION',
				'mensaje' => 'No existen productos.'
			];

			$codigo = 404;  //Código de estado de respuesta HTTP, Not Found.
		}
		
		$response->getBody()->write(json_encode($respuesta));
		return $response
			->withHeader('content-type', 'application/json')
			->withStatus($codigo);
	}


	//FUNCIÓN PARA PROCESAR LA OBTENCIÓN DE LAS CATEGORÍAS.
	public function obtenerCategorias($request, $response, $args) {

		//LLAMA A LA FUNCIÓN QUE OBTIENE TODAS LAS CATEGORÍAS. (SI NO HAY CATEGORÍAS, RETORNA VACÍO).
		$data = $this->container->get('modelo_categoria')->obtenerTodo();

		//Comprueba que el dato obtenido no está vacío.
		if (!empty($data)) {

			$respuesta = [
				'resultado' => 'EXITO',
				'data' => $data
			];

			$codigo = 200;  //Código de estado de respuesta HTTP, OK.
		}
		else {

			$respuesta = [
				'resultado' => 'ERROR_VALIDACION',
				'mensaje' => 'No existen categorías.'
			];

			$codigo = 404;  //Código de estado de respuesta HTTP, Not Found.
		}
		
		$response->getBody()->write(json_encode($respuesta));
		return $response
			->withHeader('content-type', 'application/json')
			->withStatus($codigo);
	}


	//FUNCIÓN PARA PROCESAR LA OBTENCIÓN DE UN PRODUCTO.
	public function obtenerProducto($request, $response, $args) {

		//Se obtiene el dato recibido por la URI.
		$id = $args['id'];

		//Comprueba que todos los caracteres del string, son numéricos.
		if (ctype_digit($id)) {

			//LLAMA A LA FUNCIÓN QUE OBTIENE UN PRODUCTO DE UN IDENTIFICADOR ESPECÍFICO. (SI NO HAY PRODUCTO, RETORNA VACÍO).
			$data = $this->container->get('modelo_producto')->obtener($id);

			//Comprueba que el dato obtenido no está vacío.
			if (!empty($data)) {

				$respuesta = [
					'resultado' => 'EXITO',
					'data' => $data
				];

				$codigo = 200;  //Código de estado de respuesta HTTP, OK.
			}
			else {

				$respuesta = [
					'resultado' => 'ERROR_VALIDACION',
					'mensaje' => 'El producto no existe.'
				];

				$codigo = 404;  //Código de estado de respuesta HTTP, Not Found.
			}
		}
		else {

			$respuesta = [
				'resultado' => 'ERROR_ENTRADA',
				'mensaje' => 'Dato no numérico.'
			];

			$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
		}
		
		$response->getBody()->write(json_encode($respuesta));
		return $response
			->withHeader('content-type', 'application/json')
			->withStatus($codigo);
	}


	//FUNCIÓN PARA PROCESAR LA CREACÍON DE UN PRODUCTO NUEVO.
	public function crearProducto($request, $response, $args) {

		//Se obtienen los datos recibidos.
		$post = $request->getQueryParams();
		$codigo = $post['codigo'];
		$nombre = $post['nombre'];
		$categoria = $post['categoria'];

		//Comprueba que los datos recibidos no están vacíos.
		if (!empty($codigo) && !empty($nombre) && !empty($categoria)) {

			//Comprueba que todos los caracteres en las strings entregadas, son numéricos.
			if (ctype_digit($codigo) && ctype_digit($categoria)) {

				//Comprueba la longitud de carácteres para las variables de tipo string.
				if (strlen($codigo) == 3 && strlen($nombre) <= 30) {

					//LLAMA A LA FUNCIÓN QUE BUSCA SI ESTÁ REGISTRADO EL IDENTIFICADOR DE LA CATEGORÍA.
					$busqueda = $this->container->get('modelo_categoria')->buscarId($categoria);

					if ($busqueda > 0) {

						//LLAMA A LA FUNCIÓN QUE BUSCA SI ESTÁ REGISTRADO EL CÓDIGO DEL PRODUCTO. (RETORNA LA CANTIDAD DE REGISTROS).
						$busqueda = $this->container->get('modelo_producto')->buscarCodigo($codigo);

						if ($busqueda == 0) {

							//LLAMA A LA FUNCIÓN PARA INSERTAR UN PRODUCTO NUEVO.
							$this->container->get('modelo_producto')->insertar($codigo, $nombre, $categoria);

							$respuesta = [
								'resultado' => 'EXITO',
								'mensaje' => 'El producto fue creado exitosamente.'
							];

							$codigo = 201;  //Código de estado de respuesta HTTP, Created.
						}
						else {

							$respuesta = [
								'resultado' => 'ERROR_VALIDACION',
								'mensaje' => 'El código del producto ya existe.'
							];

							$$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
						}
					}
					else {

						$respuesta = [
							'resultado' => 'ERROR_VALIDACION',
							'mensaje' => 'La categoría del producto no existe.'
						];

						$codigo = 404;  //Código de estado de respuesta HTTP, Not Found.
					}
				}
				else {

					$respuesta = [
						'resultado' => 'ERROR_ENTRADA',
						'mensaje' => 'Longitud inválida.'
					];

					$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
				}
			}
			else {

				$respuesta = [
					'resultado' => 'ERROR_ENTRADA',
					'mensaje' => 'Dato no numérico.'
				];

				$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
			}
		}
		else {

			$respuesta = [
				'resultado' => 'ERROR_ENTRADA',
				'mensaje' => 'Dato nulo.'
			];

			$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
		}
		
		$response->getBody()->write(json_encode($respuesta));
		return $response
			->withHeader('content-type', 'application/json')
			->withStatus($codigo);
	}


	//FUNCIÓN PARA PROCESAR LA ACTUALIZACÍON DE UN PRODUCTO.
	public function actualizarProducto($request, $response, $args) {

		//Se obtiene el dato recibido por la URI.
		$id = $args['id'];

		//Se obtienen los otros datos recibidos.
		$post = $request->getQueryParams();
		$codigo = $post['codigo'];
		$nombre = $post['nombre'];
		$categoria = $post['categoria'];

		//Comprueba que los datos recibidos no están vacíos.
		if (!empty($codigo) && !empty($nombre) && !empty($categoria)) {

			//Comprueba que todos los caracteres en las strings entregadas, son numéricos.
			if (ctype_digit($id) && ctype_digit($codigo) && ctype_digit($categoria)) {

				//Comprueba la longitud de carácteres para las variables de tipo string.
				if (strlen($codigo) == 3 && strlen($nombre) <= 30) {

					//LLAMA A LA FUNCIÓN QUE BUSCA SI ESTÁ REGISTRADO EL IDENTIFICADOR DE LA CATEGORÍA.
					$busqueda = $this->container->get('modelo_categoria')->buscarId($categoria);

					if ($busqueda > 0) {

						//LLAMA A LA FUNCIÓN QUE BUSCA SI ESTÁ REGISTRADO EL CÓDIGO DEL PRODUCTO, DESCARTANDO UN IDENTIFICADOR ESPECÍFICO. (RETORNA LA CANTIDAD DE REGISTROS).
						$busqueda = $this->container->get('modelo_producto')->buscarCodigoFiltrado($id, $codigo);

						if ($busqueda == 0) {

							//LLAMA A LA FUNCIÓN PARA ACTUALIZAR UN PRODUCTO.
							$this->container->get('modelo_producto')->actualizar($id, $codigo, $nombre, $categoria);

							$respuesta = [
								'resultado' => 'EXITO',
								'mensaje' => 'El producto fue actualizado exitosamente.'
							];

							$codigo = 201;  //Código de estado de respuesta HTTP, Created.
						}
						else {

							$respuesta = [
								'resultado' => 'ERROR_VALIDACION',
								'mensaje' => 'El código del producto ya existe.'
							];

							$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
						}
					}
					else {

						$respuesta = [
							'resultado' => 'ERROR_VALIDACION',
							'mensaje' => 'La categoría del producto no existe.'
						];

						$codigo = 404;  //Código de estado de respuesta HTTP, Not Found.
					}
				}
				else {

					$respuesta = [
						'resultado' => 'ERROR_ENTRADA',
						'mensaje' => 'Longitud inválida.'
					];

					$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
				}
			}
			else {

				$respuesta = [
					'resultado' => 'ERROR_ENTRADA',
					'mensaje' => 'Dato no numérico.'
				];

				$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
			}
		}
		else {

			$respuesta = [
				'resultado' => 'ERROR_ENTRADA',
				'mensaje' => 'Dato nulo.'
			];

			$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
		}
		
		$response->getBody()->write(json_encode($respuesta));
		return $response
			->withHeader('content-type', 'application/json')
			->withStatus($codigo);
	}


	//FUNCIÓN PARA PROCESAR LA ELIMINACÍON DE UN PRODUCTO.
	public function eliminarProducto($request, $response, $args) {

		//Se obtiene el dato recibido por la URI.
		$id = $args['id'];

		//Comprueba que todos los caracteres del string, son numéricos.
		if (ctype_digit($id)) {

			//LLAMA A LA FUNCIÓN QUE BUSCA SI ESTÁ REGISTRADO EL IDENTIFICADOR DEL PRODUCTO.
			$busqueda = $this->container->get('modelo_producto')->buscarId($id);

			if ($busqueda > 0) {

				//LLAMA A LA FUNCIÓN PARA ELIMINAR UN PRODUCTO. (NO ELIMINA EL REGISTRO, SOLO ACTUALIZA LA FECHA).
				$this->container->get('modelo_producto')->eliminar($id);

				$respuesta = [
					'resultado' => 'EXITO',
					'mensaje' => 'El producto fue eliminado exitosamente.'
				];

				$codigo = 200;  //Código de estado de respuesta HTTP, OK.
			}
			else {

				$respuesta = [
					'resultado' => 'ERROR_VALIDACION',
					'mensaje' => 'El producto no existe.'
				];

				$codigo = 404;  //Código de estado de respuesta HTTP, Not Found.
			}
		}
		else {

			$respuesta = [
				'resultado' => 'ERROR_ENTRADA',
				'mensaje' => 'Dato no numérico.'
			];

			$codigo = 400;  //Código de estado de respuesta HTTP, Bad Request.
		}
		
		$response->getBody()->write(json_encode($respuesta));
		return $response
			->withHeader('content-type', 'application/json')
			->withStatus($codigo);
	}
}