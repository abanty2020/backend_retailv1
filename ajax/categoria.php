<?php
require_once "../modelos/Categoria.php";
$categoria=new Categoria();
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$nombre=isset($_POST["nombre"])? htmlspecialchars_decode(limpiarCadena($_POST["nombre"])):"";
$color=isset($_POST["color"])? limpiarCadena($_POST["color"]):"";
$style=isset($_POST["style"])? limpiarCadena($_POST["style"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcategoria)){
			$rspta=$categoria->insertar($nombre,$color,$style);
			echo $rspta ? "Categoria registrada" : "Categoria no se pudo registrar";
		}
		else {
			$rspta=$categoria->editar($idcategoria,$nombre,$color,$style);
			echo $rspta ? "Categoria actualizada" : "Categoria no se pudo actualizar";
		}
	break;
	case 'desactivar':
		$rspta=$categoria->desactivar($idcategoria);
		echo $rspta ? "Categoria Desactivada" : "Categoria no se puede desactivar";
    break;
    case 'activar':
		$rspta=$categoria->activar($idcategoria);
		echo $rspta ? "Categoria activada" : "Categoria no se puede activar";
    break;
    case 'mostrar':
		$rspta=$categoria->mostrar($idcategoria);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;
    case 'listar':
		$rspta=$categoria->listar();
		//Vamos a declarar un Array
		$data= Array();
		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>($reg->estado)?'<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idcategoria.')"><i class="fa fa-close"></i></button>' :
            '<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idcategoria.')"><i class="fa fa-check"></i></button>',
				"1"=>'<span class="spanproduct">'.$reg->nombre.'</span>',
				"2"=>($reg->estado)?'<span class="label bg-primary">Activado</span>' :  '<span class="label bg-red">Desactivado</span>'
				);
		}
		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
		echo json_encode($results);
	break;
}
?>
