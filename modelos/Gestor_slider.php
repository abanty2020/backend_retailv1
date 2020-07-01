<?php
require	"../config/Conexion.php"; 
Class Gestor_slider{ 

   public function __construct(){ 

   } 
   /*------------------------------
   |  GUARDAR INFORMACION EN BD   |
   ------------------------------*/
   public function insertar_slider($imgFondo,$tipoSlide,$imgProducto,$estiloImgProducto,$estiloTextoSlide,$titulo1,$titulo2,$titulo3,$boton,$url,$orden){ 
      $sql = "INSERT INTO slide (imgFondo,tipoSlide,imgProducto,estiloImgProducto,estiloTextoSlide,titulo1,titulo2,titulo3,boton,url,orden)
      VALUES ('$imgFondo','$tipoSlide','$imgProducto','$estiloImgProducto','$estiloTextoSlide','$titulo1','$titulo2','$titulo3','$boton','$url','$orden')"; 
      return ejecutarConsulta($sql); 
   } 

   /*-----------------------------
   |  ACTUALIZAR CAMPOS SLIDER   |
   ------------------------------*/
   public function actualizar_Slider($idslider,$nombre,$tipoSlide,$estiloImgProducto,$estiloTextoSlide,$rutaFondo,$rutaProducto,$titulo1,$titulo2,$titulo3){ 
      $sql = "UPDATE slide SET nombre='$nombre',tipoSlide='$tipoSlide',estiloImgProducto='$estiloImgProducto',estiloTextoSlide='$estiloTextoSlide',imgFondo='$rutaFondo',imgProducto='$rutaProducto',titulo1='$titulo1',titulo2='$titulo2',titulo3='$titulo3'
      WHERE idslide='$idslider'"; 
      return ejecutarConsulta($sql); 
   } 

   /*------------------------------
   |  ACTUALIZAR ORDEN DE DATOS   |
   ------------------------------*/
   public function actualizar_orden_slider($idslider,$orden){ 
      $sql = "UPDATE slide SET orden='$orden' WHERE idslide='$idslider'"; 
      return ejecutarConsulta($sql); 
   } 
   /*--------------------------------
   |  LISTAR INFORMACION DE SLIDER  |
   --------------------------------*/
   public function listar_sliders(){ 
      $sql = "SELECT * FROM slide ORDER BY orden ASC"; 
      return ejecutarConsulta($sql); 
   } 
 
 
} 
 

?>
