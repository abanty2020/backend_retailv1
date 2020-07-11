<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["nombre"])) {
   header("Location: admin");
} else {
   require 'header.php';
   if ($_SESSION['productos'] == 1) {
?>

      <link rel="stylesheet" href="../public/css/moduloscss/detallepedido.css">
 
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <section class="content-header">
            <h1>
               Pedidos General
               <small>Modulos</small>
            </h1>
            <ol class="breadcrumb">
               <li><a href="#"><i class="fa fa-dashboard"></i> Menu Principal</a></li>
               <li class="active">General</li>
            </ol>
         </section>
         <!-- Main content -->
         <section class="content">
            <div class="row">
               <div class="col-md-12">
                  <div class="box box-primary">
                     <div class="box-header with-border">
                        <div class="col-md-offset-9 col-md-3 ">
                           <label for="buscar" id="labelsearch" class="col-sm-3 control-label">Buscar: </label>
                           <div class="col-sm-9 searching">
                              <input type="text" class="form-control" name="search" id="txtSearch" placeholder="Busqueda">
                           </div>
                        </div>
                     </div>
                     <!-- /.box-header -->
                     <!-- centro -->
                     <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado_general" class="table table-striped table-bordered">
                           <thead id="headuser">
                              <th>Nº Pedido</th>
                              <th>Fecha</th>
                              <th>Cliente</th>
                              <th>Empresa</th>
                              <th>Telf.</th>
                              <th>Estado</th>
                              <th>Opciones</th>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                     </div>
                     <!--Fin centro -->
                  </div><!-- /.box -->
               </div><!-- /.col -->
            </div><!-- /.row -->
         </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!-- - - - - - - - - - - - -
     | MODAL REGISTRO ACCESORIO |
     - - - - - - - - - - - - --->
      <div class="modal fade" id="modal-pedido" data-backdrop="static" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header" style="background: #3c8dbc; color:white; cursor: move;">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>

                  <!-- <button type="button" name="button"><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></button> -->
                  <h4 class="modal-title">Pedidos pendientes</h4>
               </div>
               <div class="modal-body">
                  <form name="formulario" id="formulario" method="POST">
                     <div class="box-body setup-content" id="step-1">
                        <div class="row">

                           <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                              <label>Empresa:</label>
                              <input type="hidden" name="idpedido" id="idpedido">
                              <input type="hidden" name="state" id="state">
                              <input type="text" class="form-control" name="nombre_empresa" id="nombre_empresa" placeholder="Nombre de la empresa" required>
                           </div>


                           <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                              <label>Tipo Negocio:</label>
                              <input type="text" class="form-control" name="tipo_negocio" id="tipo_negocio" placeholder="Tipo de negocio" required>
                           </div>

                           <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12 text-center mi-clase-pendiente">
                              <br>
                              <label>Estado:</label>
                              <span id="estado" class="label" style="font-size:14px;"></span>
                           </div>

                           <div class="clearfix"></div>

                           <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                              <label>RUC:</label>
                              <input type="number" class="form-control" name="ruc" id="ruc" placeholder="Ruc de la empresa" required>
                           </div>


                           <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                              <label>Nombre del Representante:</label>
                              <input type="text" class="form-control" name="representante" id="representante" placeholder="Representante de la empresa" required>
                           </div>

                           <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                              <label>Cantidad de Productos (Aprox.):</label>
                              <input type="text" class="form-control" name="cantidad_productos" id="cantidad_productos" placeholder="Tipo de negocio" required>
                           </div>

                           <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                              <label>Telefono:</label>
                              <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Telefono de la empresa" required>
                           </div>


                           <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                              <label>Email:</label>
                              <input type="email" class="form-control" name="email" id="email" placeholder="Correo Electrónico " required>
                           </div>

                           <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                              <label>Cantidad de Entradas:</label>
                              <input type="number" class="form-control" name="cantidad_entradas" id="cantidad_entradas" placeholder="Cantidad de accesos" required>
                           </div>

                        </div>
                     </div>

                     <div class="well">
                        <div class="row">
                           <div class="col-lg-9">
                              <b>DETTALLE DE PEDIDO</b>
                           </div>
                           <div class="col-lg-3">
                              <button type="button" class="btn btn-success" onclick="abrirModalArticulos()"><span class="fa fa-plus"></span> Agregar artículo</button>
                           </div>
                        </div>
                        <br>

                        <div class="container" style="width:100%;">

                           <table id="mytabla" class="table table-hover shopping-cart-wrap">
                              <thead id="headuser">
                                 <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col" style="width: 115px;">Producto</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th style="width: 150px;" scope="col">SubTotal</th>
                                    <th scope="col">Opcion</th>
                                 </tr>
                              </thead>

                              <tbody id="bodyaqui">

                              </tbody>

                              <tfoot style="border-top: solid 2px #c7c7c7;">
                                 <tr>
                                    <td colspan="5" style="text-align: right;"><b>TOTAL :</b></td>
                                    <td><span id="mitotal" class="mitotal">S/. 00.0</span> <input type="hidden" name="total_cotizacion" id="total_cotizacion"> </td>
                                 </tr>
                              </tfoot>

                           </table>

                        </div>

                     </div>


                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>     
                  <button id="btn_modal_rechazar" type="button" class="btn btn-danger" form="formulario" onclick="rechazarCotizacion()">Rechazar Cotización</button>
                  <button id="btn_modal_submit" type="submit" class="btn btn-primary" form="formulario">Enviar Cotización</button>
               </div>
            </div>
            <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!--Fin-Contenido modal -->


      <!-- Modal Productos y Accesorios -->
      <div id="MiModalArticulos" class="modal fade" role="dialog">
         <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header" style="background: #3c8dbc; color:white; cursor: move;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Lista de Artículos</h4>
               </div>
               <div class="modal-body">

                  <div class="col-md-12">
                     <!-- Custom Tabs -->
                     <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#accesoriosTabla" data-toggle="tab" aria-expanded="true">Accesorios</a></li>
                           <li class=""><a href="#productosTabla" data-toggle="tab" aria-expanded="false">Productos</a></li>
                        </ul>
                        <div class="tab-content">
                           <!-- ACCESORIOS TAB -->
                           <div class="tab-pane active" id="accesoriosTabla">
                              <div class="table-responsive">   
                                 <table id="MiTablaAccesorio" class="table table-hover" width="100%">
                                    <thead id="headuser">
                                       <tr>
                                          <th scope="col">Seleccionar</th>
                                          <th scope="col">Accesorio</th>
                                          <th scope="col">Imagen</th>
                                       </tr>
                                    </thead>

                                    <tbody id="bodyAccesorio">

                                    </tbody>

                                 </table>
                              </div>
                           </div>
                           <!-- PRODUCTOS TAB -->
                           <div class="tab-pane" id="productosTabla">
                              <div class="table-responsive">   
                                 <table id="MiTablaProducto" class="table table-hover" width="100%">
                                    <thead id="headuser">
                                       <tr>
                                          <th scope="col">Opciones</th>
                                          <th scope="col">Producto</th>
                                          <th scope="col">Imagen</th>
                                       </tr>
                                    </thead>

                                    <tbody id="bodyProducto">

                                    </tbody>

                                 </table>
                              </div>
                           </div>
                        </div>
                        <!-- /.tab-content -->
                     </div>
                     <!-- nav-tabs-custom -->
                  </div>

               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>

         </div>
      </div>



   <?php
   } else {
      require 'noacceso.php';
   }
   require 'footer.php';
   ?>

   <script type="text/javascript" src="scripts/pedido.js"></script>

<?php
}
ob_end_flush();
?>