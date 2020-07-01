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
             Categorias
             <small>Modulos</small>
           </h1>
           <ol class="breadcrumb">
             <li><a href="#"><i class="fa fa-dashboard"></i> Menu Principal</a></li>
             <li class="active">Categorias</li>
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
     <div class="modal fade" id="modal-categoria" data-backdrop="static">
      <div class="modal-dialog modal-sm">
       <div class="modal-content">
          <div class="modal-header" style="background: #3c8dbc; color:white;  cursor: move;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Registrar Categoria</h4>
          </div>
          <div class="modal-body">
             <form class="form-horizontal" name="formulario" id="formulario" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                  <div class="col-sm-9">
                    <input type="hidden" name="idcategoria" id="idcategoria">
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombres" required>
                  </div>
                </div>
                <!-- INICIO COLAPSO -->
                  <div class="panel" style="margin-bottom: -30px;">
                    <div class="box-header" style="text-align: end;">
                      <h4 class="box-title">
                        <a style="color: #333333;font-weight: 600;"data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                         <i class="fa fa-fw fa-hand-o-down"></i><sub style="bottom: 0.05em;font-size: 55%;">OPCIONES AVANZADAS</sub>
                        </a>
                      </h4>
                    </div>
                    <br>
                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                      <div class="box-body espetial">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                           <div class="form-group">
                              <label for="color" class="col-sm-3 control-label">Color: </label>
                               <div class="col-sm-9">
                               <input id="agregarcolor" type="button" class="btn btn-default" value="MI COLOR FAVORITO">
                               <input type="hidden" name="color" id="color">
                               <input type="hidden" name="style" id="style">
                            </div>
                         </div>
                         <div class="form-group">
                               <label for="color-chooser" class="col-sm-3 control-label">Selecciona: </label>
                            <div class="col-sm-9">
                               <ul class="fc-color-picker" id="color-chooser">
                                  <li data-value="bg-black"><a class="text-black" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-gray"><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-aqua"><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-blue"><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-navy"><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-teal"><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-green"><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-olive"><a class="text-olive" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-lime"><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-yellow"><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-orange"><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-red"><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-fuchsia"><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-purple"><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                  <li data-value="bg-maroon"><a class="text-maroon" href="#"><i class="fa fa-square"></i></a></li>
                               </ul>
                            </div>
                         </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
           </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button id="btn_modal_submit" type="submit" class="btn btn-primary" form="formulario">Guardar</button>
          </div>
       </div>
       <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   <!-- /.modal -->
  <!--Fin-Contenido-->
  <?php
  }
  else
  {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/categoria.js"></script>
  <?php
  }
  ob_end_flush();
  ?>
