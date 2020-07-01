<?php
session_start();
require_once "../modelos/Pedido.php";

//INSTANCIAR CLASE ACCESORIO
$pedido = new Pedido();
$idpedido = isset($_POST["idpedido"]) ? limpiarCadena($_POST["idpedido"]) : "";
$empresa = isset($_POST["nombre_empresa"]) ? limpiarCadena($_POST["nombre_empresa"]) : "";
$tipo_negocio = isset($_POST["tipo_negocio"]) ? limpiarCadena($_POST["tipo_negocio"]) : "";
$ruc = isset($_POST["ruc"]) ? limpiarCadena($_POST["ruc"]) : "";
$representante = isset($_POST["representante"]) ? limpiarCadena($_POST["representante"]) : "";
$cantidad_productos = isset($_POST["cantidad_productos"]) ? limpiarCadena($_POST["cantidad_productos"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cantidad_entradas = isset($_POST["cantidad_entradas"]) ? limpiarCadena($_POST["cantidad_entradas"]) : "";
$total = isset($_POST["total_cotizacion"]) ? limpiarCadena($_POST["total_cotizacion"]) : "";
$estado = isset($_POST["state"]) ? limpiarCadena($_POST["state"]) : "";
$idproducto = isset($_POST["idproducto"]) ? $_POST["idproducto"] : '';
$idaccesorio = isset($_POST["idaccesorio"]) ? $_POST["idaccesorio"] : '';


switch ($estado) {

	case '1':
		$estado = '2';
		break;
	case '2':
		$estado = '3';
		break;
	case '3':
		$estado = '0';
		break;
	case 'soloEditar':
		$estado = '1';
		break;
	default:
		$estado = '1';
		break;
		
}


/*-----------------------------
| SWITCH DE METODOS DINAMICOS |
-----------------------------*/
switch ($_GET["op"]) { //Creacion de variable op con metodo get para crear url de acceso en js
		/*------------------------
	| CASE GUARDAR O EDITAR  |
	------------------------*/
	case 'guardaryeditar':
		if (empty($idpedido)) {
			// $rspta=$pedido->insertar($nombre,$color,$style);
			// echo $rspta ? "Categoria registrada" : "Categoria no se pudo registrar";
		} else {	

			$rspta = $pedido->actualizar_pedido($idpedido, $empresa, $tipo_negocio, $ruc, $representante, $cantidad_productos, $telefono, $email, $cantidad_entradas, $total, $estado, $idaccesorio, $idproducto, $_POST['cantidad'], $_POST['precio']);
			echo $rspta ? "Pedido actualizado" : "Pedido no se pudo actualizar";
		}
		break;


		/*--------------------------------------*
	| CASE PARA EDITAR DATOS DEL DATATABLE |
	.--------------------------------------*/
	case 'editardatos':
		$rspta = $pedido->modificardatos($_POST["id"], $_POST["columna_nombre"], $_POST["valorcol"]);
		echo $rspta ? "Pedido modificado" : "Pedido no se puede modificar";
		break;


		/*-----------------------
	| CASE ESTADO RECHAZADO |
	-----------------------*/
	case 'estado_rechazar':
		$rspta = $pedido->rechazar_pedido($idpedido);
		echo $rspta ? "Pedido rechazado" : "Pedido no se puede rechazar";
		break;


		/*--------------
	| CASE MOSTRAR |
	--------------*/
	case 'mostrar':
		$rspta = $pedido->mostrar($idpedido);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
		break;


		/*-----------------------------
 	| CASE LISTAR PEDIDOS GENERAL |
 	-----------------------------*/
	case 'listar_general':
		$rspta = $pedido->listar_general();
		//Vamos a declarar un Array
		$data = array();

		while ($reg = $rspta->fetch_object()) {

			switch ($reg->estado) {
				case 0:
					$estado = '<span class="label bg-green">Pendiente</span>';
					$btn_pdf = '';
					break;
				case 1:
					$estado = '<span class="label bg-aqua">Atendido</span>';
					$btn_pdf = '<button class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Visualizar PDF"><i class="fa fa-file-pdf-o"></i></button>';
					break;
				case 2:
					$estado = '<span class="label bg-maroon">Finalizado</span>';
					$btn_pdf = '<button class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Visualizar PDF"><i class="fa fa-file-pdf-o"></i></button>';
					break;
				case 3:
					$estado = '<span class="label bg-red">Rechazado</span>';
					$btn_pdf = '';
					break;
			}

			$data[] = array(
				"0" => '<span class="spanproduct">P-' . $reg->idpedido . '</span>',
				"1" => '<span class="spanproduct">' . date('d/m/Y', strtotime($reg->fecha_orden)) . '</span>',
				"2" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_representante">' . $reg->nombre_representante . '</div>',
				"3" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_empresa"><b>' . strtoupper($reg->nombre_empresa) . '</b></div>',
				"4" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="telefono">' . $reg->telefono . '</div>',
				"5" => $estado,
				"6" => '<button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->idpedido . ')" data-toggle="tooltip" data-placement="top" title="Visualizar Detalle"><i class="fa fa-eye"></i></button> '.$btn_pdf 
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;


	/*--------------------------------
 	| CASE LISTAR PEDIDOS PENDIENTES |
 	--------------------------------*/
	case 'listar_pendientes':
		$rspta = $pedido->listar_pendientes();
		//Vamos a declarar un Array
		$data = array();

		while ($reg = $rspta->fetch_object()) {

			$data[] = array(
				"0" => '<span class="spanproduct">P-' . $reg->idpedido . '</span>',
				"1" => '<span class="spanproduct">' . date('d/m/Y', strtotime($reg->fecha_orden)) . '</span>',
				"2" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_representante">' . $reg->nombre_representante . '</div>',
				"3" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_empresa"><b>' . strtoupper($reg->nombre_empresa) . '</b></div>',
				"4" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="telefono">' . $reg->telefono . '</div>',
				"5" => ($reg->estado == '0') ? '<span class="label bg-green">Pendiente</span>' :  '',
				"6" => '<button class="btn btn-success btn-sm" onclick="mostrar(' . $reg->idpedido . ')" data-toggle="tooltip" data-placement="top" title="Visualizar Detalle"><i class="fa fa-eye"></i></button>'
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;


	/*-------------------------------
 	| CASE LISTAR PEDIDOS ATENDIDOS |
 	-------------------------------*/
	case 'listar_atendidos':
		$rspta = $pedido->listar_atendidos();
		//Vamos a declarar un Array
		$data = array();

		while ($reg = $rspta->fetch_object()) {

			$btn_pdf = '<a class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Visualizar PDF"><i class="fa fa-file-pdf-o"></i></a>';

			$data[] = array(
				"0" => '<span class="spanproduct">P-' . $reg->idpedido . '</span>',
				"1" => '<span class="spanproduct">' . date('d/m/Y', strtotime($reg->fecha_orden)) . '</span>',
				"2" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_representante">' . $reg->nombre_representante . '</div>',
				"3" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_empresa"><b>' . strtoupper($reg->nombre_empresa) . '</b></div>',
				"4" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="telefono">' . $reg->telefono . '</div>',
				"5" => ($reg->estado == '1') ? '<span class="label bg-aqua">Atendido</span>' :  '',
				"6" => '<button class="btn btn-info btn-sm" onclick="mostrar(' . $reg->idpedido . ')" data-toggle="tooltip" data-placement="top" title="Visualizar Detalle"><i class="fa fa-eye"></i></button> '.$btn_pdf
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;


	/*---------------------------------
 	| CASE LISTAR PEDIDOS FINALIZADOS |
 	---------------------------------*/
	case 'listar_finalizados':
		$rspta = $pedido->listar_finalizados();
		//Vamos a declarar un Array
		$data = array();

		while ($reg = $rspta->fetch_object()) {

			$url='../reportes/reportec.php?id=';
			// $url2='../reportes/Pics/example1.php';
//
			$btn_pdf = '<a class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Visualizar PDF" target="_blank" href="'.$url.$reg->idpedido.'"><i class="fa fa-file-pdf-o"></i></a>';

			$data[] = array(
				"0" => '<span class="spanproduct">P-' . $reg->idpedido . '</span>',
				"1" => '<span class="spanproduct">' . date('d/m/Y', strtotime($reg->fecha_orden)) . '</span>',
				"2" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_representante">' . $reg->nombre_representante . '</div>',
				"3" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_empresa"><b>' . strtoupper($reg->nombre_empresa) . '</b></div>',
				"4" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="telefono">' . $reg->telefono . '</div>',
				"5" => ($reg->estado == '2') ? '<span class="label bg-maroon">Finalizado</span>' :  '',
				"6" => '<button class="btn bg-maroon btn-sm" onclick="mostrar(' . $reg->idpedido . ')" data-toggle="tooltip" data-placement="top" title="Visualizar Detalle"><i class="fa fa-eye"></i></button> '.$btn_pdf
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;


		/*--------------------------------
 	| CASE LISTAR PEDIDOS RECHAZADOS |
 	--------------------------------*/
	case 'listar_rechazados':
		$rspta = $pedido->listar_rechazados();
		//Vamos a declarar un Array
		$data = array();

		while ($reg = $rspta->fetch_object()) {

			$data[] = array(
				"0" => '<span class="spanproduct">P-' . $reg->idpedido . '</span>',
				"1" => '<span class="spanproduct">' . date('d/m/Y', strtotime($reg->fecha_orden)) . '</span>',
				"2" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_representante">' . $reg->nombre_representante . '</div>',
				"3" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="nombre_empresa"><b>' . strtoupper($reg->nombre_empresa) . '</b></div>',
				"4" => '<div onclick="listenForDoubleClick(this);" onblur="this.contentEditable=true;" class="update" data-id="' . $reg->idpedido . '" data-column="telefono">' . $reg->telefono . '</div>',
				"5" => ($reg->estado == '3') ? '<span class="label bg-red">Rechazado</span>' :  '',
				"6" => '<button class="btn btn-danger btn-sm" onclick="mostrar(' . $reg->idpedido . ')" data-toggle="tooltip" data-placement="top" title="Visualizar Detalle"><i class="fa fa-eye"></i></button>'
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;

		/*----------------------------
	| CASE LISTAR DETALLE PEDIDO |
	----------------------------*/
	case 'listar_detalle':
		$rspta = $pedido->mostrar_detalle_pedido($idpedido);
		$results_array = array();

		while ($reg = $rspta->fetch_assoc()) {
			$results_array[] = $reg;
		}

		echo json_encode($results_array);

		break;


		/*------------------------
 	| CASE LISTAR ACCESORIOS |
 	------------------------*/
	case 'listar_accesorios':
		require_once "../modelos/Accesorio.php";
		$accesorio = new Accesorio();

		$rspta = $accesorio->listar();
		/** LISTAR ACCESORIOS */
		//Vamos a declarar un Array
		$data = array();
		//Identificador
		$identificador = 'accesorio';
		while ($reg = $rspta->fetch_object()) {

			$data[] = array(
				"0" => '<button class="btn btn-dark" onclick="agregarDetalle(' . $reg->idaccesorio . ',\'' . $reg->descripcion . '\',\'' . $reg->imagen . '\',\'' . $identificador . '\')"><span class="fa fa-plus"></span></button>',
				"1" => $reg->nombre,
				"2" => '<td><img src="http://localhost/backend_retailv1/' . $reg->imagen . '" class="img-thumbnail" width="150"></td>'
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;


		/*-----------------------
 	| CASE LISTAR PRODUCTOS |
 	-----------------------*/
	case 'listar_productos':
		require_once "../modelos/Producto.php";
		$producto = new Producto();
		$rspta = $producto->listar_solo();
		//Vamos a declarar un Array
		$data = array();
		$identificador = 'producto';
		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => '<button class="btn btn-dark" onclick="agregarDetalle(' . $reg->idproducto . ',\'' . $reg->descripcion . '\',\'' . $reg->imagen . '\',\'' . $identificador . '\')"><span class="fa fa-plus"></span></button>',
				"1" => $reg->nombre,
				"2" => '<td><img src="http://localhost/backend_retailv1/' . $reg->imagen . '" class="img-thumbnail" width="150"></td>'
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;
}
