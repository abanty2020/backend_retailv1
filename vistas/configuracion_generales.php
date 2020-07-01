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
<link rel="stylesheet" href="../public/css/color-general.css">
<link rel="stylesheet" href="../public/css/pre_loader_infoproducto.css">
<!--Contenido-->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
        Gestor Plantilla
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard#"><i class="fa fa-dashboard"></i> Menu Principal</a></li>
      <li>Configuración</li>
      <li class="active">Gestor Plantilla</li>
    </ol>
  </section>
  <section class="content">
  <div class="box box-primary" id="preloaderdiv">
        <div id="loading">
            <center>
              <div class="pre-loader-spinner"></div>
              <div class="textloader">Cargando ....</div>
            </center>
        </div>
  </div>
  <form id="form_empresa" class="form-horizontal" style="display:none;">
      <div class="row">
        <div class="col-md-3">
          <!-- Logo Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <center class="title-profile"><span>  <label>Logo</label></span></center>
              <input type="file" onchange="readURL_logo(this);" class="form-control" name="logo" id="logo" style="display:none;">
              <input type="hidden" name="imagenactual_logo" id="imagenactual_logo">
              <img id="imagenmuestra_logo" class="profile-user-img-admintle img-responsive" src="" onclick="$('#logo').trigger('click'); return true;" style="cursor: pointer;" alt="User profile picture">
              <h3 class="profile-username text-center">Security Retail</h3>
              <p class="text-muted text-center">Mi logo principal</p>
            </div>
          </div>
             <!-- exta logo imagen -->
             <div class="box box-primary">
            <div class="box-body box-profile">
              <center class="title-profile"><span>  <label>Extra logo (Socio)</label></span></center>
              <input type="file" onchange="readURL_extralogo(this);" class="form-control" name="logo_extralogo" id="logo_extralogo" style="display:none;">
              <input type="hidden" name="imagenactual_extra" id="imagenactual_extra">
              <img id="imagenmuestra_extra" class="profile-user-img-admintle img-responsive" src="" onclick="$('#logo_extralogo').trigger('click'); return true;" style="cursor: pointer;width: 150px;" alt="User profile picture">
              <h3 class="profile-username text-center">Security Retail</h3>
              <p class="text-muted text-center">Mi Socio</p>
            </div>
          </div>
          <div class="box box-primary">
            <div class="box-body box-profile">
              <center class="title-profile"><span>  <label>Icono (favicon)</label></span></center>
              <input type="file" onchange="readURL_favicon(this);" class="form-control" name="logo_favicon" id="logo_favicon" style="display:none;">
              <input type="hidden" name="imagenactual_favicon" id="imagenactual_favicon">
              <img id="imagenmuestra_favicon" class="profile-user-img-admintle img-responsive" src="" onclick="$('#logo_favicon').trigger('click'); return true;" style="cursor: pointer;width: 50px;" alt="User profile picture">
              <h3 class="profile-username text-center">Security Retail</h3>
              <p class="text-muted text-center">Mi Favicon</p>
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#datos_empresa" data-toggle="tab">Datos de la Empresa</a></li>
              <li><a href="#datos_redes_sociales" data-toggle="tab">Redes Sociales de la Empresa</a></li>
              <li style="float: right; margin-right: 30px; margin-top: 8px;">
                <button type="submit" form="form_empresa" id="btnsubmit" class="btn btn-success"><i class="fa fa-save"></i> Guardar cambios </button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="datos_empresa">
                    <div class="form-group">
                      <label for="razsocial" class="col-sm-2 control-label">Razon Social</label>
                      <div class="col-sm-10">
                      <input type="hidden"id="idempresa" name="idempresa" value="1">
                      <input type="text" class="form-control" id="razsocial" name="razsocial" placeholder="Ingresa el nombre de la empresa">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="ruc" class="col-sm-2 control-label">RUC</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" id="ruc" name="ruc" placeholder="Ingresa RUC">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="direccion" class="col-sm-2 control-label">Dirección</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingresa ubicación">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="telefono1" class="col-sm-2 control-label">Telefono #1</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" id="telefono1" name="telefono1" placeholder="Ingresa telefono 1">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="telefono2" class="col-sm-2 control-label">Telefono #2 (fax)</label>
                      <div class="col-sm-10">
                          <input type="number" class="form-control" id="telefono2" name="telefono2" placeholder="Ingresa telefono 2">
                      </div>
                    </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="datos_redes_sociales">
              <div class="box box-primary">
              <br>
              <input type="hidden" name="redessociales" id="redessociales">
              <table id="t-ejemplo" class="table table-bordered">
                    <thead class="mbhead">
                        <tr class="mbrow">
                            <th style="width: 100px;">RED SOCIAL</th>
                            <th>ESTILO</th>
                            <th>URL</th>
                            <th>SELECCIONA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- FACEBOOK -->
                        <tr class="redessociales_tr">
                            <td>
                              <input type="hidden" id="redsocial0" name="redso" value="fa-facebook">
                              <a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                            </td>
                            <td>
                                <select class="form-control selectpicker show-tick" data-style="btn-default" id="estilo_0" name="estilo">
                                  <option data-icon="fa fa-check-square-o" value="facebookBlanco">Blancos</option>
                                  <option data-icon="fa fa-check-square-o" value="facebookColor">Color</option>
                              </select>
                            </td>
                            <td>
                                <input type="text" class="form-control url" name="url" id="ruta0" placeholder="URL">
                            </td>
                            <td>
                                <input  type="checkbox" class="minimal" id="selectionrs0" value="0" name="selectionrs">
                            </td>
                        </tr>
                        <!-- GOOGLE -->
                        <tr class="redessociales_tr">
                            <td>
                              <input type="hidden" id="redsocial1" name="redso" value="fa-google-plus-g">
                                <a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
                            </td>
                            <td>
                                <select class="form-control selectpicker show-tick" data-style="btn-default" id="estilo_1" name="estilo">
                                  <option data-icon="fa fa-check-square-o" value="googleblanco">Blancos</option>
                                  <option data-icon="fa fa-check-square-o" value="googleColor">Color</option>
                              </select>
                            </td>
                            <td>
                                <input type="text" class="form-control url" name="url" id="ruta1" placeholder="URL" value="">
                            </td>
                            <td>
                                <input  type="checkbox" class="minimal" id="selectionrs1" value="1" name="selectionrs">
                            </td>
                        </tr>
                        <!-- TWITTER -->
                        <tr class="redessociales_tr">
                          <td>
                            <input type="hidden" id="redsocial2" name="redso" value="fa-twitter">
                            <a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                          </td>
                          <td>
                              <select class="form-control selectpicker show-tick"  data-style="btn-default" id="estilo_1" name="estilo">
                                <option data-icon="fa fa-check-square-o" value="twitterblanco">Blancos</option>
                                <option data-icon="fa fa-check-square-o" value="twitterColor">Color</option>
                            </select>
                          </td>
                          <td>
                              <input type="text" class="form-control url" name="url" id="ruta2" placeholder="URL">
                          </td>
                          <td>
                              <input  type="checkbox" class="minimal" id="selectionrs2" value="2" name="selectionrs">
                          </td>
                      </tr>
                    <!-- INSTAGRAM -->
                    <tr class="redessociales_tr">
                          <td>
                             <input type="hidden" id="redsocial3" name="redso" value="fa-instagram">
                             <a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
                          </td>
                          <td>
                              <select class="form-control selectpicker show-tick" data-style="btn-default" id="estilo_1" name="estilo">
                                <option data-icon="fa fa-check-square-o" value="instagramblanco">Blancos</option>
                                <option data-icon="fa fa-check-square-o" value="instagramColor">Color</option>
                            </select>
                          </td>
                          <td>
                              <input type="text" class="form-control url" name="url" id="ruta3" placeholder="URL">
                          </td>
                          <td>
                              <input  type="checkbox" class="minimal" id="selectionrs3" value="3" name="selectionrs">
                          </td>
                      </tr>
                    <!-- YOUTUBE -->
                    <tr class="redessociales_tr">
                          <td>
                              <input type="hidden" id="redsocial4" name="redso" value="fa-youtube">
                              <a class="btn btn-social-icon btn-youtube"><i class="fa fa-youtube"></i></a>
                          </td>
                          <td>
                              <select class="form-control selectpicker show-tick" data-style="btn-default" id="estilo_1" name="estilo">
                                <option data-icon="fa fa-check-square-o" value="youtubeblanco">Blancos</option>
                                <option data-icon="fa fa-check-square-o" value="youtubeColor">Color</option>
                            </select>
                          </td>
                          <td>
                              <input type="text" class="form-control url" name="url" id="ruta4" placeholder="URL">
                          </td>
                          <td>
                              <input  type="checkbox" class="minimal" id="selectionrs4" value="4" name="selectionrs">
                          </td>
                      </tr>
                    </tbody>
                </table>
            </div>
              </div>
              <!-- /.tab-pane -->
            </div>
          </div>
          <div class="col-lg-6">
            <div class="box box-primary">
              <div class="panel">
                <div class="box-body">
                  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="form-group">
                      <button style="color:white;text-shadow:#000 2px 2px 2px;"id="agregarcolor_dominante" type="button" class="btn btn-default btn-block btn-lg">COLOR DOMINANTE DE LA PLANTILLA</button>
                    </div>
                    <div id="container-color-dominante">
                      <input type="hidden" name="color_dominante" id="color_dominante">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="box box-primary">
              <div class="panel">
                <div class="box-body">
                  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="form-group">
                      <button style="color:white;text-shadow:#000 2px 2px 2px;" id="agregarcolor_superior" type="button" class="btn btn-default btn-block btn-lg">TEXTO SUPERIOR DE LA PLANTILLA</button>
                    </div>
                    <div id="container-color-superior">
                        <input type="hidden" name="color_texto_superior" id="color_texto_superior">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </form>
  </section>
</div><!-- /.content-wrapper -->
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="../public/js/jquery.inputmask.bundle.js"></script>
<script type="text/javascript" src="scripts/conf_generales.js"></script>
<?php
}
ob_end_flush();
?>
