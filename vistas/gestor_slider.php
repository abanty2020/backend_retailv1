<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["nombre"]))
{
  header("Location: admin");
}
else
{
require 'header.php';
if ($_SESSION['plantilla']==1)
{
?>
<link rel="stylesheet" href="../public/css/modulo_slide.css">
<link rel="stylesheet" href="../public/css/pre_loader_infoproducto.css">
<style>
  .btn-group-lxs>.btn, .btn-lxs {
      padding: 1px 5px;
      font-size: 10.4px;
      line-height: 1.5;
      border-radius: 3px;
  }
   ul#ul_preloader {
    border-top: solid #f0ad4e;
   }
   h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
    font-family: inherit;
   }
   ul li{
      list-style:none;
   }
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
        Gestor Slide <button type="button" onclick="refrescar_tabla();" class="btn btn-warning btn-lxs refrescarSlide">Refrescar</button>
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard"><i class="fa fa-dashboard"></i> Menu Principal</a></li>
      <li>Configuración</li>
      <li class="active">Gestor Slider</li>
    </ol>
  </section>
  <section class="content">
      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
            <button type="button" class="btn btn-primary agregarSlide">Agregar Slide</button>
        </div>
        <div class="box-body">
            <ul id="ul_preloader">
               <div id="loading">
                  <center>
                     <div class="pre-loader-spinner"></div>
                     <div class="textloader">Cargando sliders ....</div>
                  </center>
               </div>
            </ul>
            <ul class="todo-list" id="contenido_slide">
            </ul>
        </div>
      </div>
    </section>
</div>
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/gestor_slider.js"></script>
<?php
}
ob_end_flush();
?>
