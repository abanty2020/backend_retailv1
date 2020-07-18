<?php
session_start();
require_once "../modelos/Accesorio.php";

//INSTANCIAR CLASE ACCESORIO
$accesorio = new Accesorio();
//DEFINICION Y DECLARACION DE VARIABLE CON POST & ISSET
$idaccesorio = isset($_POST["idaccesorio"])? limpiarCadena($_POST["idaccesorio"]):"";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$rango_option = isset($_POST["rango_option"])? limpiarCadena($_POST["rango_option"]):"";
$rango = isset($_POST["rango"])? limpiarCadena($_POST["rango"]):"";
$cantidad_min_option = isset($_POST["cantidad_min_option"])? limpiarCadena($_POST["cantidad_min_option"]):"";
$cantidad_min = isset($_POST["cantidad_min"])? limpiarCadena($_POST["cantidad_min"]):"";
$descripcion = isset($_POST["descripcion"])? limpiarCadenaEditor($_POST["descripcion"]):"";
$precio_base = isset($_POST["precio_base"])? limpiarCadenaEditor($_POST["precio_base"]):"";
$imagen = isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$color = isset($_POST["color"])? limpiarCadena($_POST["color"]):"";
$style = isset($_POST["style"])? limpiarCadena($_POST["style"]):"";

$uso_option = isset($_POST['uso_option'])? $_POST['uso_option']: null;
$idproducto = isset($_POST['idproducto'])? $_POST['idproducto']: null;
$idtipo_producto = isset($_POST['idtipo_producto'])? $_POST['idtipo_producto']: null;
$tipo_accesorio = isset($_POST['tipo_accesorio'])? $_POST['tipo_accesorio']: null;
/*-----------------------------
| SWITCH DE METODOS DINAMICOS |
-----------------------------*/
switch ($_GET["op"]){ //Creacion de variable op con metodo get para crear url de acceso en js

	/*--------------------
	| CASE GUARDAR DATOS |
	--------------------*/
	case 'guardaryeditar':

	if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
	{
		$imagen=$_POST["imagenactual"];
	}
	else
	{
		$ext = explode(".", $_FILES["imagen"]["name"]);
		if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
		{
			$imagen = 'files/accesorios/'.round(microtime(true)) . '.' . end($ext);
			move_uploaded_file($_FILES["imagen"]["tmp_name"],'../'.$imagen);
		}
	}

		if (empty($idaccesorio)){

				if (empty($idproducto)||empty($uso_option))
				{

						if (empty($idtipo_producto))
						{
							$rspta=$accesorio->insertar_solo_accesorio_sin_tp($nombre,$precio_base,$tipo_accesorio,$rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,
							$style);
							echo $rspta ? "Accesorio registrado" : "Accesorio no se pudo registrar";
						}
						else
						{
							$rspta=$accesorio->insertar_solo_accesorio_con_tp($nombre,$precio_base,$tipo_accesorio,$rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,
							$style,$idtipo_producto);
							echo $rspta ? "Accesorio registrado" : "Accesorio no se pudo registrar";
						}

				}
				else
				{

						if (empty($idtipo_producto))
						{
							$rspta=$accesorio->insertar_full_sin_tp($nombre,$precio_base,$tipo_accesorio,$rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,
							$style,$_POST['idproducto'],array_values(array_filter($uso_option,'strlen')));
							echo $rspta ? "Accesorio registrado" : "Accesorio no se pudo registrar";
						}
						else
						{
							$rspta=$accesorio->insertar_full($nombre,$precio_base,$tipo_accesorio,$rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,
							$style,$_POST['idproducto'],array_values(array_filter($uso_option,'strlen')),$idtipo_producto);
							echo $rspta ? "Accesorio registrado" : "Accesorio no se pudo registrar";
						}

				}

		}else {

				if (empty($idproducto)||empty($uso_option))
				{

						if (empty($idtipo_producto))
						{
							$rspta=$accesorio->editar3($idaccesorio,$nombre,$precio_base,$tipo_accesorio,$rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,
							$style);
							echo $rspta ? "Accesorio actualizado" : "Accesorio no se pudo actualizar";
						}
						else
						{
							$rspta=$accesorio->editar2($idaccesorio,$nombre,$precio_base,$tipo_accesorio,$rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,
							$style,$idtipo_producto);
							echo $rspta ? "Accesorio actualizado" : "Accesorio no se pudo actualizar";
						}

				}
				else
				{

					if (empty($idtipo_producto))
					{
						$rspta=$accesorio->editar4($idaccesorio,$nombre,$precio_base,$tipo_accesorio,$rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,
						$style,$idproducto,array_values(array_filter($uso_option,'strlen')));
						echo $rspta ? "Accesorio actualizado" : "Accesorio no se pudo actualizar";
					}
					else
					{
						$rspta=$accesorio->editar($idaccesorio,$nombre,$precio_base,$tipo_accesorio,$rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,
						$style,$idproducto,array_values(array_filter($uso_option,'strlen')),$idtipo_producto);
						echo $rspta ? "Accesorio actualizado" : "Accesorio no se pudo actualizar";
					}

				}
		}
	break;

	/*-----------------
	| CASE DESACTIVAR |
	-----------------*/
	case 'desactivar':
		$rspta=$accesorio->desactivar($idaccesorio);
		echo $rspta ? "Accesorio Desactivado" : "Accesorio no se puede desactivar";
   break;

	/*--------------
 	| CASE ACTIVAR |
 	--------------*/
  case 'activar':
		$rspta=$accesorio->activar($idaccesorio);
		echo $rspta ? "Accesorio activado" : "Accesorio no se puede activar";
   break;

  /*--------------
	| CASE MOSTRAR |
	--------------*/
  case 'mostrar':
		$rspta=$accesorio->mostrar($idaccesorio);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
   break;

	/*----------------------------------------------
	| CASE MOSTRAR TIPO DE PRODUCTOS SELECCIONADOS |
	----------------------------------------------*/
	 case 'mostrar_tipoproductos_seleccionados':
		$rspta=$accesorio->listar_tipoproductos_seleccionados($idaccesorio);

		$valores=array();
		while ($reg = $rspta->fetch_object())
			{
				array_push($valores, $reg->idtipo_producto);
			}

		echo json_encode($valores);

		break;

	/*----------------------------------
 	| CASE LISTAR DETALLE DE PRODUCTOS |
 	----------------------------------*/
	case 'listarproducto_detalle':
		 require_once "../modelos/Producto.php";
		 $producto=new Producto();
		 $rspta=$producto->listar_solo();

		 // Obtener los de productos y opciones asignados al usuario
		 $id=$_GET['id'];
		 $marcados_producto_opciones = $accesorio->listar_marcados_productos_opciones($id);

		 //Vamos a declarar un Array
		 $data_marcados= Array();
		 // 	 //Almacenar los permisos asignados al usuario en el array
			 while ($marcados = $marcados_producto_opciones->fetch_object())
				 {
					 $data_marcados[]=array(
					 "idproducto"=>$marcados->idproducto,
					 "uso_option"=>$marcados->uso_option
					 );
				 }

		 //Vamos a declarar un Array
		 $data= Array();

		 while ($reg=$rspta->fetch_object()) {

				 $data[]=array(
				 "idproducto"=>$reg->idproducto,
				 "nombre"=>$reg->nombre
				 );
		 }
		 $results = array(
			 "informacion_lista_accesorios_productos"=>$data_marcados,
			 "informacion_lista_producto"=>$data);
		 echo json_encode($results);
	break;

	/*------------------------
 	| CASE LISTAR ACCESORIOS |
 	------------------------*/
	case 'listar':
		$rspta=$accesorio->listar();
		//Vamos a declarar un Array
		$data= Array();

		while ($reg=$rspta->fetch_object()) {
			$string_desc = strip_tags($reg->descripcion);
				$imagentest=(empty($reg->imagen))?"<img width='60' src=http://localhost/backend_retail/files/productos/vacio.png>":
			'<img style="cursor: pointer; width: 50px;" src="../'.$reg->imagen.'" onclick="mostrarclick(\''.$reg->nombre.'\',\''.limpiarCadena($reg->descripcion).'\',\''.$reg->imagen.'\')" data-toggle="tooltip" data-html="true" title="<em>Ver</em> <u>detalles del</u> <b>Accesorio</b>">';

				$data[]=array(
				"0"=>($reg->estado)?'<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idaccesorio.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idaccesorio.')"><i class="fa fa-close"></i></button>' :
            '<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idaccesorio.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idaccesorio.')"><i class="fa fa-check"></i></button>',
				"1"=>'<span class="spanproduct">'.$reg->nombre.'</span>',
				"2"=>'<span class="myspandatatable">'.$string_desc.'</span>',
				"3"=>$imagentest,
				"4"=>($reg->estado)?'<span class="label bg-primary">Activado</span>' :  '<span class="label bg-red">Desactivado</span>'
				);
		}

		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
		echo json_encode($results);

	break;


	/*----------------------------
 	| CASE SELECCIONAR CATEGORIA |
 	----------------------------*/
	case "selectCategoria":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();
		$rspta = $categoria->selectcat();

	while ($reg = $rspta->fetch_object())
		{
			echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
		}

	break;

	/*-------------------------------
 	| CASE SELECCIONAR SUBCATEGORIA |
 	-------------------------------*/
	case "selectSubCategoriaId":
		require_once "../modelos/Sub_categoria.php";

		$subcategoria = new Sub_categoria();
		$rspta = $subcategoria->selectsubcatid($_POST["idcat"]);

	while ($reg = $rspta->fetch_object())
		{
			echo '<option value=' . $reg->idsubcategoria . '>' . $reg->nombre . '</option>';
		}

	break;

	/*-------------------------------
	| CASE SELECCIONAR TIPOPRODUCTO |
	-------------------------------*/
	case 'select_tipo_producto':

	$rspta = $accesorio->select_tipo_producto();

		while ($reg = $rspta->fetch_object())
			{
				echo '<option data-icon="fa fa-cube" value=' . $reg->idtipo_producto . '>' . $reg->descripcion . '</option>';
			}

	 break;
}

 ?>
