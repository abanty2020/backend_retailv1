<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';
  if ($_SESSION['productos'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Sub Categorias
          <small>Modulos</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Menu Principal</a></li>
          <li class="active">Sub Categorias</li>
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
                    <th>Categoría</th>
                    <th>Descripción</th>
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
    <div class="modal fade" id="modal-subcategoria" data-backdrop="static">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header" style="background: #3c8dbc; color:white; cursor: move;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Registrar Sub Categoria</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" name="formulario" id="formulario" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                  <div class="col-sm-9">
                    <input type="hidden" name="idsubcategoria" id="idsubcategoria">
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombres" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="idcategoria" class="col-sm-3 control-label">Categoria: </label>
                  <div class="col-sm-9">
                    <select class="form-control select-picker show-tick" title="Elige una Sub categoría" id="idcategoria" data-style="btn-primary" name="idcategoria" required>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="descripcion" class="col-sm-3 control-label">Descripcion: </label>
                  <div class="col-sm-9">
                    <textarea name="descripcion" id="descripcion" rows="4" cols="39"></textarea>
                  </div>
                </div>

                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="observador" name="observador">
                  <span><em>Mostrar en mi tienda de Comercio Electrónico<em></span>
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
  } else {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/sub_categoria.js"></script>
<?php
}
ob_end_flush();
?>