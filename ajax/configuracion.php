<?php
require_once "../modelos/Configuracion.php";

$configuracion=new Configuracion();

// DATOSW EMPRESA
$razsocial = isset($_POST["razsocial"])? limpiarCadena($_POST["razsocial"]):"";
$ruc = isset($_POST["ruc"])? limpiarCadena($_POST["ruc"]):"";
$direccion = isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono1 = isset($_POST["telefono1"])? limpiarCadena($_POST["telefono1"]):"";
$telefono2 = isset($_POST["telefono2"])? limpiarCadena($_POST["telefono2"]):"";

// DATOS PLANTILLA
$textoSuperior = isset($_POST["color_texto_superior"])? limpiarCadena($_POST["color_texto_superior"]):"";
$colorDominante = isset($_POST["color_dominante"])? limpiarCadena($_POST["color_dominante"]):"";
$logo = isset($_POST["logo"])? limpiarCadena($_POST["logo"]):"";
$extra_logo = isset($_POST["logo_extralogo"])? limpiarCadena($_POST["logo_extralogo"]):"";
$icono = isset($_POST["logo_favicon"])? limpiarCadena($_POST["logo_favicon"]):"";
$redesSociales = isset($_POST["redessociales"])? limpiarCadenaEditor($_POST["redessociales"]):"";



switch ($_GET["op"]) {
   /*-----------------------------------------------------
	|	INSERTAR DATOS EMPRESA Y PLANTILLA SIMULTANEAMENTE	|
	-----------------------------------------------------*/
  case 'guardaryeditar':
  //LOGO
  if (!file_exists($_FILES['logo']['tmp_name']) || !is_uploaded_file($_FILES['logo']['tmp_name'])){
        $logo_resized=$_POST["imagenactual_logo"];
  }else{
     if (!empty($_POST["imagenactual_logo"])) {
        unlink("../".$_POST["imagenactual_logo"]);
     }
     $ext = explode(".", $_FILES["logo"]["name"]);
     list($ancho,$alto)= getimagesize($_FILES['logo']["tmp_name"]);
     $radio = $ancho / $alto;
     $nuevoAncho = 240;
     $nuevoAlto = 240 / $radio;
     $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        if ($_FILES['logo']['type'] == "image/png")
        {
           $logo = '../public/logos/logos_plantilla/'.round(microtime(true)) . '.' . end($ext);
           $origen = imagecreatefrompng($_FILES['logo']["tmp_name"]);
           imagealphablending($destino, FALSE);
           imagesavealpha($destino, TRUE);
           imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
           imagepng($destino, $logo, 9, PNG_ALL_FILTERS);
           // move_uploaded_file($_FILES["logo"]["tmp_name"],'../'.$logo);
           $logo_resized = substr($logo, 3);
        }
  }


  //EXTRA LOGO
  if (!file_exists($_FILES['logo_extralogo']['tmp_name']) || !is_uploaded_file($_FILES['logo_extralogo']['tmp_name'])){
     $extra_logo_resized=$_POST["imagenactual_extra"];
  }else{
     if (!empty($_POST["imagenactual_extra"])) {
       unlink("../".$_POST["imagenactual_extra"]);
     }
     $ext = explode(".", $_FILES["logo_extralogo"]["name"]);
     list($ancho,$alto)= getimagesize($_FILES['logo_extralogo']["tmp_name"]);
     $radio = $ancho / $alto;
     $nuevoAncho = 240;
     $nuevoAlto = 240 / $radio;
     $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        if ($_FILES['logo_extralogo']['type'] == "image/png")
        {
           $extra_logo = '../public/logos/logos_extra/'.round(microtime(true)) . '0.' . end($ext);
           $origen = imagecreatefrompng($_FILES['logo_extralogo']["tmp_name"]);
           imagealphablending($destino, FALSE);
           imagesavealpha($destino, TRUE);
           imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
           imagepng($destino, $extra_logo, 9, PNG_ALL_FILTERS);
           // move_uploaded_file($_FILES["logo_extralogo"]["tmp_name"],'..'.$extra_logo);
           $extra_logo_resized = substr($extra_logo, 3);
        }
  }

  // ICONO
  if (!file_exists($_FILES['logo_favicon']['tmp_name']) || !is_uploaded_file($_FILES['logo_favicon']['tmp_name'])){
        $icono_resized=$_POST["imagenactual_favicon"];
     }
     else
     {
        $ext_fav = explode(".", $_FILES["logo_favicon"]["name"]);
        if (!empty($_POST["imagenactual_favicon"])) {
          unlink("../".$_POST["imagenactual_favicon"]);
        }
        $ext = explode(".", $_FILES["logo_favicon"]["name"]);
        list($ancho,$alto)= getimagesize($_FILES['logo_favicon']["tmp_name"]);
        $radio = $ancho / $alto;
        $nuevoAncho = 240;
        $nuevoAlto = 240 / $radio;
        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

          if ($_FILES['logo_favicon']['type'] == "image/png")
          {
             $icono = '../public/logos/logos_favicon/'.round(microtime(true)) . '1.' . end($ext_fav);
             $origen = imagecreatefrompng($_FILES['logo_favicon']["tmp_name"]);
             imagealphablending($destino, FALSE);
             imagesavealpha($destino, TRUE);
             imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
             imagepng($destino, $icono, 9, PNG_ALL_FILTERS);
             // move_uploaded_file($_FILES["logo_favicon"]["tmp_name"],'..'.$icono);
             $icono_resized = substr($icono, 3);
          }
  }

  $list = $configuracion->obtener_idempresa();
  while ($reg=$list->fetch_object()) {
     $idempresa = $reg->idempresa;
  }

  $list_plantilla = $configuracion->obtener_idplantilla();
  while ($reg_plantilla=$list_plantilla->fetch_object()) {
     $idplantilla = $reg_plantilla->idplantilla;
  }

  if (empty($idempresa)) {
     $rspta=$configuracion->insertar_empresa($razsocial,$ruc,$direccion,$telefono1,$telefono2,$textoSuperior,$colorDominante,$logo_resized,$extra_logo_resized,$icono_resized,$redesSociales);
     echo $rspta ? "Información Guardada" : "No se pudo guardar";

  }else {
     $rspta=$configuracion->editar_empresa($idempresa,$idplantilla,$razsocial,$ruc,$direccion,$telefono1,$telefono2,$textoSuperior,$colorDominante,$logo_resized,$extra_logo_resized,$icono_resized,$redesSociales);
     echo $rspta ? "Información Modificada" : "Producto no se pudo modificar";
  }


break;



   /*----------------------------------------
	|	 MOSTRAR CAMPOS EMPRESA Y PLANTILLA   |
	----------------------------------------*/
   case 'mostrar_informacion_entidad':

      $list = $configuracion->obtener_idempresa();
      while ($reg=$list->fetch_object()) {
         $idempresa = $reg->idempresa;
      }

      $list_plantilla = $configuracion->obtener_idplantilla();
      while ($reg_plantilla=$list_plantilla->fetch_object()) {
         $idplantilla = $reg_plantilla->idplantilla;
      }

      $show_data_emp = !empty($idempresa) ? $configuracion->mostrar_empresa($idempresa) : null;
      $show_data_plan = !empty($idplantilla) ? $configuracion->mostrar_plantilla($idplantilla) : null;

      $results = array(
         "datos_empresa"=>$show_data_emp,
         "datos_plantilla"=>$show_data_plan);
      echo json_encode($results);

    break;


}











?>
