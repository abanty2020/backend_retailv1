<?php
session_start();
require_once "../modelos/Producto.php";

$producto = new Producto();

$idproducto = isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idcategoria = isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idsubcategoria = isset($_POST["idsubcategoria"])? limpiarCadena($_POST["idsubcategoria"]):"";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion = isset($_POST["descripcion"])?limpiarCadenaEditor($_POST["descripcion"]):"";
$rango = isset($_POST["rango"])? limpiarCadena($_POST["rango"]):"";
$rango_option = isset($_POST["rango_option"])? limpiarCadena($_POST["rango_option"]):"";
$stock = isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){

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
			$imagen = 'files/productos/'.round(microtime(true)) . '.' . end($ext);
			move_uploaded_file($_FILES["imagen"]["tmp_name"],'../'.$imagen);
		}
	}

		if (empty($idproducto)){
			$rspta=$producto->insertar($idcategoria,$idsubcategoria,$nombre,$descripcion,$rango,$rango_option,$stock,$imagen);
			echo $rspta ? "Producto registrado" : "Producto no se pudo registrar";
		}
		else {
			$rspta=$producto->editar($idproducto,$idcategoria,$idsubcategoria,$nombre,$descripcion,$rango,$rango_option,$stock,$imagen);
			echo $rspta ? "Producto actualizado" : "Producto no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$producto->desactivar($idproducto);
		echo $rspta ? "Producto Desactivado" : "Producto no se puede desactivar";
    break;

    case 'activar':
		$rspta=$producto->activar($idproducto);
		echo $rspta ? "Producto activado" : "Producto no se puede activar";
    break;

    case 'mostrar':
		$rspta=$producto->mostrar($idproducto);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;

    case 'listar':
		$rspta=$producto->listar();
		//Vamos a declarar un Array
		$data= Array();

		while ($reg=$rspta->fetch_object()) {

			$string_desc = strip_tags($reg->descripcion);
			$imagentest=(empty($reg->imagen))?"<img width='60' src='../public/img/vacio_extra.png'>":
			'<img style="cursor: pointer; width: 50px;" src="../'.$reg->imagen.'" onclick="mostrarclick(\''.$reg->nombre.'\',\''.limpiarCadena($reg->descripcion).'\',\''.$reg->imagen.'\')">';

			$data[]=array(
			"0"=>($reg->estado)?'<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
			' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>' :
			'<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
			' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>',
			"1"=>'<span class="spanproduct">'.$reg->nombre.'</span>',
			"2"=>'<span class="label '.$reg->color.'">'.$reg->categoria.'</span>',
			"3"=>$reg->subcategoria,
			"4"=>$reg->rango.' cm',
			"5"=>$reg->stock.' und',
			"6"=>$imagentest,
			"7"=>($reg->estado)?'<span class="label bg-primary">Activado</span>' :  '<span class="label bg-red">Desactivado</span>'
			);
		}
		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
		echo json_encode($results);

	break;


	case "selectCategoria":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->selectcat();

	while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idcategoria.'>'.$reg->nombre.'</option>';
		}

	break;


	case "selectSubCategoriaId":
		require_once "../modelos/Sub_categoria.php";

		$subcategoria = new Sub_categoria();

		$rspta = $subcategoria->selectsubcatid($_POST["idcat"]);

	while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idsubcategoria.'>'.$reg->nombre.'</option>';
		}

	break;
}
