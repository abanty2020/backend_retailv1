<?php
require "../modelos/Gestor_slider.php"; /** Requerir clase, conexion */

/** Instanciar clase */
$gestorslider = new Gestor_slider();

/** Definir variables */
$idslider = isset($_POST["idslide"])?limpiarCadena($_POST["idslide"]):"";
$nombre = isset($_POST["nombre"])?limpiarCadena($_POST["nombre"]):"";
$imgFondo = isset($_POST["imgFondo"])?limpiarCadena($_POST["imgFondo"]):"";
// TIPO FILE FONDO
$subirFondo = isset($_FILES["subirFondo"])?$_FILES["subirFondo"]:null;
$imgProducto = isset($_POST["imgProducto"])?limpiarCadena($_POST["imgProducto"]):"";
// TIPO FILE IMGPRODUCTO
$tipoSlide= isset($_POST["tipoSlide"])?limpiarCadena($_POST["tipoSlide"]):"";
$subirImgProducto = isset($_FILES["subirImgProducto"])?$_FILES["subirImgProducto"]:null;
$estiloImgProducto = isset($_POST["estiloImgProducto"])?limpiarCadenaEditor($_POST["estiloImgProducto"]):"";
$estiloTextoSlide = isset($_POST["estiloTextoSlide"])?limpiarCadenaEditor($_POST["estiloTextoSlide"]):"";
$titulo1 = isset($_POST["titulo1"])?limpiarCadenaEditor($_POST["titulo1"]):"";
$titulo2 = isset($_POST["titulo2"])?limpiarCadenaEditor($_POST["titulo2"]):"";
$titulo3 = isset($_POST["titulo3"])?limpiarCadenaEditor($_POST["titulo3"]):"";
$boton = isset($_POST["boton"])?limpiarCadena($_POST["boton"]):"";
$url = isset($_POST["url"])?limpiarCadena($_POST["url"]):"";


switch ($_GET["op"]) {
   /*---------------------------*
   | Case para Guardar y Editar |
   .---------------------------*/
   case 'guardarSlideDefault':

      $traerSlide=$gestorslider->listar_sliders();
      $num_row = $traerSlide->num_rows;

      if ($num_row != 0) {
         foreach ($traerSlide as $key => $value) {}
      $orden = $value["orden"]+1;
      }else{
         $orden = 1;
      }

		$rspta=$gestorslider->insertar_slider($imgFondo,$tipoSlide,$imgProducto,$estiloImgProducto,$estiloTextoSlide,$titulo1,$titulo2,$titulo3,$boton,$url,$orden);
		echo $rspta ? "Slide agregado" : "Slide no se pudo agregar";

      break;


   /*-----------------------*
   | Case actualizar Slider |
   .-----------------------*/
   case 'actualizar_slider':

      $ruta1 = null;
      $ruta2 = null;

      // CAMBIO DE FONDO  -  Borrar antiguo fondo del slide
      if ($subirFondo != null) {

            if ($imgFondo != "public/img/fondo.jpg") {
               unlink("../".$imgFondo);
            }

            // Creamos directorio si no existe
            $directorio = "../public/recursos/slide".$idslider;
            if (!file_exists($directorio)) {
               mkdir($directorio, 0755);
            }
            // Capturamos el ancho y alto del fondo slide
            list($ancho,$alto) = getimagesize($subirFondo["tmp_name"]);

            $nuevoAncho = 1600;
            $nuevoAlto = 520;

            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

            if ($subirFondo["type"]=="image/jpeg") {

               $ruta1 = $directorio."/fondo".round(microtime(true)).".jpg";

               $origen = imagecreatefromjpeg($subirFondo["tmp_name"]);

               imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

               imagejpeg($destino, $ruta1);
            }

            if ($subirFondo["type"]=="image/png") {

               $ruta1 = $directorio."/fondo".round(microtime(true)).".png";

               $origen = imagecreatefrompng($subirFondo["tmp_name"]);

               imagealphablending($destino, FALSE);

               imagesavealpha($destino, TRUE);

               imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

               imagepng($destino, $ruta1);
            }

            $rutaFondo = substr($ruta1, 3);

      }else{

         $rutaFondo = $imgFondo;
      }

      // CAMBIO DE IMGPRODUCTO - Borramos imgproducto anterior
      if ($subirImgProducto != null) {

         if (!empty($imgProducto)) {
            unlink("../".$imgProducto);
         }

         // Creamos directorio si no existe
         $directorio = "../public/recursos/slide".$idslider;
         if (!file_exists($directorio)) {
            mkdir($directorio, 0755);
         }
         // Capturamos el ancho y alto del fondo slide
         $percent = 1;
         list($ancho,$alto)= getimagesize($subirImgProducto["tmp_name"]);

         $nuevoAncho = $ancho * $percent;
         $nuevoAlto = $alto * $percent;

         $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

         if ($subirImgProducto["type"]=="image/jpeg") {

            $ruta2 = $directorio."/producto".round(microtime(true)).".jpg";

            $origen = imagecreatefromjpeg($subirImgProducto["tmp_name"]);

            imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

            imagejpeg($destino, $ruta2, 100);
         }

         if ($subirImgProducto["type"]=="image/png") {

            $ruta2 = $directorio."/producto".round(microtime(true)).".png";

            $origen = imagecreatefrompng($subirImgProducto["tmp_name"]);

            imagealphablending($destino, FALSE);

            imagesavealpha($destino, TRUE);

            imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

            imagepng($destino, $ruta2,null, PNG_ALL_FILTERS);

            imagedestroy($destino);
         }

         $rutaProducto = substr($ruta2, 3);

   }else{

      $rutaProducto = $imgProducto;
   }

      $rspta=$gestorslider->actualizar_Slider($idslider,$nombre,$tipoSlide,$estiloImgProducto,$estiloTextoSlide,$rutaFondo,$rutaProducto,$titulo1,$titulo2,$titulo3);
      echo $rspta ? "Slide actualzado" : "Slide no se pudo actualizar";


      break;


   /*----------------------*
   | Case actualizar orden |
   .----------------------*/
   case 'actualizar_orden':
      $orden = isset($_POST["orden"])?limpiarCadena($_POST["orden"]):"";
      $rspta=$gestorslider->actualizar_orden_slider($idslider,$orden);
			echo $rspta ? "Orden cambiado" : "Orden no se pudo cambiar";

      break;


    /*-----------------------*
   | Case listar Informacion |
   .------------------------*/
   case 'listar_sliders':

   $rspta=$gestorslider->listar_sliders();
      $results_array = array();

      while ($slider=$rspta->fetch_assoc()) {
      $results_array[] = $slider;
      }

      echo json_encode($results_array);

	   break;


}



?>
