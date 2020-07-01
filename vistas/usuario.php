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
if ($_SESSION['accesos']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <section class="content-header">
           <h1>
             Usuario
             <small>Modulos</small>
           </h1>
           <ol class="breadcrumb">
             <li><a href="#"><i class="fa fa-dashboard"></i> Menu Principal</a></li>
             <li class="active">Usuarios</li>
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
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
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
     <div class="modal fade" id="modal-usuario" data-backdrop="static">
      <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header" style="background: #3c8dbc; color:white;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Registrar Usuarios</h4>
          </div>
          <div class="modal-body">
             <form class="form-horizontal" name="formulario" id="formulario" method="POST">
              <div class="box-body">
               <div class="form-group">
                 <center class="title-profile"><span>MI FOTO DE PERFIL</span></center>
                 <img id="imagenmuestra" class="profile-user-img img-responsive img-circle" src="" onclick="$('#imagen').trigger('click'); return true;" style="width: 150px;cursor: pointer;" alt="User profile picture">
               </div>
               <br>
                <div class="form-group">
                  <label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                  <div class="col-sm-9">
                    <input type="hidden" name="idusuario" id="idusuario">
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombres" required>
                  </div>
                </div>
                <div class="form-group">
                 <label for="tipo_documento" class="col-sm-3 control-label">Tipo documento: </label>
                 <div class="col-sm-9">
                    <select class="form-control select-picker" id="tipo_documento" name="tipo_documento" required>
                       <option>DNI</option>
                       <option>RUC</option>
                       <option>CARNET</option>
                     </select>
                 </div>
               </div>
               <div class="form-group">
                  <label for="num_documento" class="col-sm-3 control-label">N° documento: </label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="num_documento" name="num_documento" placeholder="Numero Documento" required>
                  </div>
               </div>
              <div class="form-group">
                 <label for="direccion" class="col-sm-3 control-label">Dirección: </label>
                 <div class="col-sm-9">
                   <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion" required>
                 </div>
              </div>
              <div class="form-group">
                  <label for="telefono" class="col-sm-3 control-label">Telefono: </label>
                  <div class="col-sm-9">
                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Telefono o celular">
                  </div>
              </div>
               <div class="form-group">
                   <label for="email" class="col-sm-3 control-label">Email: </label>
                   <div class="col-sm-9">
                     <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                   </div>
               </div>
                <div class="form-group">
                    <label for="cargo" class="col-sm-3 control-label">Cargo: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Ocupación" required>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="login" class="col-sm-3 control-label">Login: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" onkeyup="validarlogin()" id="login" name="login" placeholder="Id Login" required>
                    </div>
                 </div>
                 <div class="form-group">
                    <label id="labelclave" for="clave" class="col-sm-3 control-label">Clave: </label>
                    <div class="col-sm-7">
                      <input type="password" autocomplete="on" class="form-control" id="clave" name="clave" placeholder="">
                    </div>
                    <div class="col-sm-2">
                      <input type="checkbox" onclick="showpass()"> Show
                    </div>
                 </div>
                 <div class="form-groug">
                   <input type="file" onchange="readURL(this);" class="form-control" name="imagen" id="imagen" style="display:none;">
                   <input type="hidden" name="imagenactual" id="imagenactual">
                 </div>
                 <div class="form-group">
                    <label for="permisos" class="col-sm-3 control-label">Permisos: </label>
                    <div class="col-sm-9">
                       <ul style="list-style: none; padding:0;" id="permisos">
                      </ul>
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
  <script type="text/javascript" src="scripts/usuario.js"></script>
  <?php
  }
  ob_end_flush();
  ?>
