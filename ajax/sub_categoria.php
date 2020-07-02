<?php
require_once "../modelos/Sub_categoria.php";
$subcategoria=new Sub_categoria();
$idsubcategoria=isset($_POST["idsubcategoria"])? limpiarCadena($_POST["idsubcategoria"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$observador = isset($_POST['observador']) ? $_POST['observador']: null ;

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idsubcategoria)){
			$rspta=$subcategoria->insertar($idcategoria,$nombre,$descripcion,$observador);
			echo $rspta ? "Subcategoria registrada" : "Subcategoria no se pudo registrar";
		}
		else {
			$rspta=$subcategoria->editar($idsubcategoria,$idcategoria,$nombre,$descripcion,$observador);
			echo $rspta ? "Subcategoria actualizada" : "Subcategoria no se pudo actualizar";
		}
	break;
	case 'desactivar':
		$rspta=$subcategoria->desactivar($idsubcategoria);
		echo $rspta ? "Subcategoria Desactivada" : "Subcategoria no se puede desactivar";
    break;
    case 'activar':
		$rspta=$subcategoria->activar($idsubcategoria);
		echo $rspta ? "Subcategoria activada" : "Subcategoria no se puede activar";
    break;
    case 'mostrar':
		$rspta=$subcategoria->mostrar($idsubcategoria);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;
    case 'listar':
		$rspta=$subcategoria->listar();
		//Vamos a declarar un Array
		$data= Array();
		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>($reg->estado)?'<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idsubcategoria.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idsubcategoria.')"><i class="fa fa-close"></i></button>' :
            '<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idsubcategoria.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idsubcategoria.')"><i class="fa fa-check"></i></button>',
            "1"=>'<span class="spanproduct">'.$reg->nombre.'</span>',
            "2"=>'<span class="label '.$reg->color.'" style="letter-spacing: 0.5px; font-weight: bold; text-transform: uppercase;">'.$reg->categoria.'</span>',
            "3"=>$reg->descripcion,
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
   case "selectcategoria":
      require_once "../modelos/Categoria.php";
      $categoria = new Categoria();
      $rspta = $categoria->selectcat();
   while ($reg = $rspta->fetch_object())
      {
         echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
      }
   break;
}
?>
