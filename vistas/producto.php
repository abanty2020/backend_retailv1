<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
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
             Productos
             <small>Modulos</small>
           </h1>
           <ol class="breadcrumb">
             <li><a href="#"><i class="fa fa-dashboard"></i> Menu Principal</a></li>
             <li class="active">Productos</li>
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
                        <table id="tbllistado" class="table table-striped table-bordered" style="width:100%;">
                          <thead id="headuser">
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>SubCategoria</th>
                            <th>Rango</th>
                            <th>Stock</th>
                            <th>Imagen</th>
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
     | MODAL REGISTRO USUARIOS |
     - - - - - - - - - - - - --->
     <div class="modal fade" id="modal-producto" data-backdrop="static">
      <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header" style="background: #3c8dbc; color:white; cursor: move;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Registrar Producto</h4>
          </div>
          <div class="modal-body">
              <form name="formulario" id="formulario" method="POST">
                <div class="box-body setup-content" id="step-1">
                   <div class="row">
                        <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                          <div class="container-abanty">
                            <center class="title-profile"><span>  <label>MI PRODUCTO</label></span></center>
                            <input type="file" onchange="readURL(this);" class="form-control" name="imagen" id="imagen" style="display:none;">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img id="imagenmuestra" class="profile-user-img img-responsive" src="" onclick="$('#imagen').trigger('click'); return true;" style="width: 180px;border-radius: 10px;border-color: #3c8dbc;cursor: pointer;height: 180px;" alt="User profile picture">
                          </div>
                        </div>
                        <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
                          <label>Nombre:</label>
                          <input type="hidden" name="idproducto" id="idproducto">
                          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-4 col-sm-4 col-xs-12">
                           <label>Stock:</label>
                         <input type="number" class="form-control" name="stock" id="stock" placeholder="Stock">
                        </div>   
                        <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-5">
                           <label>Rango?</label><br>
                           <div class="classcheckbox">
                                 <input type="checkbox" id="rango_option" name="rango_option" data-off-active-cls="btn-danger" data-on-active-cls="btn-primary">
                           </div>
                        </div>  
                        <div class="form-group col-lg-3 col-md-4 col-sm-4 col-xs-7">
                           <label>Rango (cm)</label>
                         <input type="number" step="any" class="form-control" name="rango" id="rango" placeholder="Rango en centímetros">
                        </div> 
                        <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                           <label>Categoría:</label>
                           <select class="form-control select-picker show-tick"  title="Elige una Categoría" data-style="btn-primary" id="idcategoria" name="idcategoria" data-live-search="true" required>
                           </select>
                        </div>                       
                        <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                           <label id="labelsubcat">SubCategoría:</label>
                           <select class="form-control select-picker show-tick" title="Elige una Subcategoría" data-style="btn-primary" id="idsubcategoria" name="idsubcategoria" data-live-search="true" required>
                           </select>
                        </div>    
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label>Detalle de Producto(*):</label>
                          <textarea name="descripcion" id="descripcion"></textarea>
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
  <?php
  }
  else
  {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?>   
<script type="text/javascript" src="scripts/producto.js"></script>
<script type="text/javascript" src="scripts/editor.js"></script>
  <?php
  }
  ob_end_flush();
  ?>
