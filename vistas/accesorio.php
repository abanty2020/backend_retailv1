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
if ($_SESSION['productos']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <section class="content-header">
           <h1>
             Accesorios
             <small>Modulos</small>
           </h1>
           <ol class="breadcrumb">
             <li><a href="#"><i class="fa fa-dashboard"></i> Menu Principal</a></li>
             <li class="active">Accesorios</li>
           </ol>
         </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                         <div class="col-md-9">
                             <h1 class="box-title">
                                <button class="btn btn-primary" id="btnagregar" onclick="OpenModal();"><i class="fa fa-plus-circle"></i> Registrar</button>
                             </h1>
                         </div>
                         <div class="col-md-3">
                             <label for="buscar" id="labelsearch" class="col-sm-3 control-label">Buscar: </label>
                             <div class="col-sm-9 searching">
                               <input type="text" class="form-control" name="search" id="txtSearch" placeholder="Busqueda">
                             </div>
                         </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered">
                          <thead id="headuser">
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th style="width:60px;">Imagen</th>
                            <th>Estado</th>
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
     <div class="modal fade" id="modal-accesorio" data-backdrop="static" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header" style="background: #3c8dbc; color:white; cursor: move;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span></button>
            
             <!-- <button type="button" name="button"><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></button> -->
            <h4 class="modal-title">Registrar Accesorio</h4>
          </div>
          <div class="modal-body">
              <form name="formulario" id="formulario" method="POST">
                <div class="box-body setup-content" id="step-1">
                   <div class="row">
                   <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="container-abanty">
                           <center class="title-profile"><span>  <label>MI ACCESORIO</label></span></center>
                           <input type="file" onchange="readURL(this);" class="form-control" name="imagen" id="imagen" style="display:none;">
                           <input type="hidden" name="imagenactual" id="imagenactual">
                           <img id="imagenmuestra" class="profile-user-img img-responsive" src="" onclick="$('#imagen').trigger('click'); return true;" style="width: 180px;border-radius: 10px;border-color: #3c8dbc;cursor: pointer;height: 180px;" alt="User profile picture">
                           <button class="btn btn-dark dtext" style="margin-top: 10px;" type="button" data-toggle="modal" data-target="#modaltblproductos"><i class="fa fa-list"></i>
                              Relacionar Producto
                            </button>                      
                          </div>                     
                     </div>
                        <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
                           <label>Nombre:</label>
                          <input type="hidden" name="idaccesorio" id="idaccesorio">
                          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-5 col-sm-5 col-xs-12">
                           <label>Tipo accesorio:</label>
                           <select class="form-control selectpicker show-tick"  title="Selecciona..." data-style="btn-primary" id="tipo_accesorio" name="tipo_accesorio" data-live-search="true">
                             <option data-icon="fa fa-check-square-o" value="transmisora">Transmisora</option>
                             <option data-icon="fa fa-check-square-o" value="receptora">Receptora</option>
                             <option data-icon="fa fa-check-square-o" value="mono">Mono</option>
                           </select>
                        </div>                                                            
                        <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-4">
                           <label>Rango?</label><br>
                           <div class="classcheckbox">
                                 <input type="checkbox" id="rango_option" name="rango_option" data-off-active-cls="btn-danger" data-on-active-cls="btn-primary">
                           </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-5 col-sm-4 col-xs-8">
                           <label>Rango (cm)</label>
                         <input type="number" step="any" class="form-control" name="rango" id="rango" placeholder="Rango en centímetros">
                        </div>                     
                        <div class="form-group col-lg-3 col-md-5 col-sm-5 col-xs-12">
                           <label>Tipo producto:</label>
                           <select class="form-control select-picker show-tick"  title="Selecciona..." data-style="btn-primary" id="idtipo_producto" name="idtipo_producto[]" data-live-search="true" multiple>
                           </select>
                        </div>                                              
                        <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-4">
                           <label>Cantidad minima?</label><br>
                           <div class="classcheckbox">
                                  <input type="checkbox" id="cantidad_min_option" name="cantidad_min_option" data-off-active-cls="btn-danger" data-on-active-cls="btn-primary">
                           </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-5 col-sm-4 col-xs-8">
                           <label>Cantidad minima:</label>
                         <input type="number" class="form-control" name="cantidad_min" id="cantidad_min" placeholder="Cantidad minima">
                        </div>   
                   <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       <label>Detalle del accesorio(*):</label>
                       <textarea style="resize: none;" rows="7" cols="50" id="descripcion" name="descripcion" class="form-control col-md-7 col-xs-12"></textarea>
                     </div>
                </div>
              </div>                 
           
                
             </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button id="btn_modal_submit" type="button" class="btn btn-primary nextBtn" form="formulario">Guardar</button>
          </div>
       </div>
       <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   <!-- /.modal -->
  <!--Fin-Contenido modal -->
  <!-- - - - - - - - - - - - - -
   |  MODAL TABLA DE PRODUCTOS |
   - - - - - - - - - - - - ---->
  <div class="modal fade" id="modaltblproductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-header" style="background: #3c8dbc; color:white; cursor: move;">
                 <button type="button" class="close" data-dismiss-modal="modal2" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
                 <h4 class="modal-title"> Mis Productos <sub style="bottom: 0.05em;font-size: 65%;font-style: italic;">( Selecciona Productos )</sub></h4>
            </div>
            <div class="modal-body">
              <!-- TABLA DETALLE PRODUCTOS -->
              <div class="panel box box-primary">
                <div class="box-body espetial">
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <input type="text" class="form-control" id="mibuscador" onkeyup="mi_buscador_sensitivo()" placeholder="Busca por producto" title="Escribe un nombre de producto">
                     <table id="detalles_producto" class="table table-hover">
                     <thead style="background-color:#ff5722; color: white; width:100%">
                            <th>Elegir</th>
                            <th>Producto</th>
                            <th style="width:100px;">Obligatorio</th>
                         </thead>
                         <tbody id="mTableBody">
                         </tbody>
                     </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Aceptar</button>           
            </div>
        </div>
    </div>
</div>
  <?php
  }
  else
  {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/accesorio.js"></script>
  <script type="text/javascript" src="scripts/editor.js"></script>
  <?php
  }
  ob_end_flush();
  ?>
