<?php
if (strlen(session_id()) < 1)
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Seguridad | Retail</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Icono de la pestaña -->
  <link rel="shortcut icon" type="text/css" href="../public/img/favicon.ico">
  <!-- Bootstrap library -->
  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
  <!-- Libreria Select box bootstrap -->
  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
  <!-- Libreria I Check -->
  <link rel="stylesheet" type="text/css" href="../public/css/all.css">
  <!-- Bootstrap library extra -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <!-- Libreria Datatable de bootstrap 3 -->
  <link rel="stylesheet" type="text/css" href="../public/css/dataTables.bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="../public/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" type="text/css" href="../public/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="../public/css/AdminLTE.css">
  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="../public/css/skin-blue.min.css">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" type="text/css" href="../public/css/estilos_forzados.css">
  <!-- Estilos del loader -->
  <link rel="stylesheet" type="text/css" href="../public/css/loader.css">
  <!-- Carview css-->
  <link rel="stylesheet" type="text/css" href="../public/css/cardview.css"/>
  <!-- Liberia de alertas jquery -->
  <link rel="stylesheet" type="text/css" href="../public/css/jquery-confirm.min.css">
  <!-- Botones de la libreria de datatables -->
  <link rel="stylesheet" type="text/css" href="../public/css/buttons.bootstrap.min.css"/>
  <!-- Amaran js -->
  <link rel="stylesheet" type="text/css" href="../public/css/amaran.min.css">
  <!-- Color Picker -->
  <link rel="stylesheet" type="text/css" href="../public/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css"/>
  <!-- Bootstrap Slide -->
  <link rel="stylesheet" type="text/css" href="../public/css/slider.css"/>
  <!-- CDN animated -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>  
  <!-- Swipper Slider -->
  <link rel="stylesheet" type="text/css" href="../public/css/swiper.min.css">
  <!-- Extra estilos para checkbox y radiobutton -->
  <link rel="stylesheet" type="text/css" href="../public/css/extra_estilos.css">
  <!-- API o libreria para editores textareas -->
  <script src="../public/ckeditor/ckeditor.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href="https://fonts.googleapis.com/css?family=Courgette&display=swap" rel="stylesheet">
  	<!-- FUENTES DE GOOGLES SUPER CHIDAS -->
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu|Ubuntu+Condensed" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cuprum&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;500&display=swap" rel="stylesheet">
</head>
<!-- <div class="loader-page"><h1 class="parpadea">Seguridad RETAIL</h1></div> -->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
    <a href="dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b><b>R</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Seguridad Retail</span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo $_SESSION['nombre']; ?>
                  <small>
                     <?php echo $_SESSION['cargo']; ?>
                  </small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                   <a href="usuario" class="btn btn-app">
                      <i class="fa fa-users"></i> Perfil
                   </a>
                  <!-- <a href="usuario" class="btn btn-default btn-flat">Perfil</a> -->
                </div>
                <div class="pull-right">
                   <a href="../ajax/usuario.php?op=salir" class="btn btn-app">
                      <i class="fa fa-sign-out"></i> Cerrar Sesion
                    </a>
                  <!-- <a href="#" class="btn btn-default btn-flat">Cerrar Sesión</a> -->
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
          <li>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['nombre']; ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- <br> -->
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU PRINCIPAL</li>
        <!-- Optionally, you can add icons to the links -->
        <!-- DASHBORAD -->
        <?php
         if ($_SESSION['dashboard']==1) {
            echo '<li class="active"><a href="dashboard"><i class="fa fa-fw fa fa-dashboard"></i><span>Dashboard</span></a></li>';
         }
         ?>
         <!-- PEDIDOS -->
         <?php
         if ($_SESSION['pedidos']==1) {
           echo ' <li class="treeview">
              <a href="#">
                <i class="fa fa-fw fa-table"></i><span>Pedidos de Cotización</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="pedido_general"><i class="fa fa-circle-o"></i>General</a></li>
               <li><a href="pedido_pendiente"><i class="fa fa-circle-o"></i>Pendientes</a></li>
               <li><a href="pedido_atendido"><i class="fa fa-circle-o"></i>Atendidos</a></li>
               <li><a href="pedido_finalizado"><i class="fa fa-circle-o"></i>Finalizado</a></li>
               <li><a href="pedido_rechazado"><i class="fa fa-circle-o"></i>Rechazado</a></li>
              </ul>
           </li>';
         }
         ?>
         <!-- PRODUCTOS -->
         <?php
         if ($_SESSION['productos']==1) {
           echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-fw fa-cube"></i><span>Categorias y Productos</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right abantybred"></i>
                </span>
              </a>
              <ul class="treeview-menu este">
                <li><a href="categoria"><i class="fa fa-circle-o"></i> Categorias </a></li>
                <li><a href="sub_categoria"><i class="fa fa-circle-o"></i> Sub-Categorias </a></li>
                <li><a href="producto"><i class="fa fa-circle-o"></i> Productos </a></li>
                <li><a href="accesorio"><i class="fa fa-circle-o"></i> Accesorios </a></li>
              </ul>
           </li>';
         }
         ?>
         <!-- ACCESOS -->
         <?php
         if ($_SESSION['accesos']==1) {
           echo '<li>
              <a href="usuario">
                <i class="fa fa-fw fa fa-user"></i><span>Gestion de Usuarios</span>
              </a>
           </li>';
         }
         ?>
     <!-- GESTION DE PLANTILLA -->
          <?php
          if ($_SESSION['plantilla']==1) {
          echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-fw fa fa-cog"></i><span>Configuracion</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">  
                    <li>
                      <a href="configuracion_generales">
                        <i class="fa fa-asterisk"></i>Gestor Plantilla           
                      </a>                     
                    </li>
                    <li>
                    <a href="gestor_slider">
                      <i class="fa fa-asterisk"></i>Gestor Sliders           
                    </a>                     
                  </li>                
              </ul>
            </li>';
          }
          ?>
         <!-- REPORTES -->
         <?php
         if ($_SESSION['reportes']==1) {
          echo '<li class="treeview">
             <a href="#">
               <i class="fa fa-fw fa-newspaper-o"></i><span>Reportes</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li><a href="#"><i class="fa fa-circle-o"></i> --- </a></li>
               <li><a href="#"><i class="fa fa-circle-o"></i> --- </a></li>
               <li><a href="#"><i class="fa fa-circle-o"></i> --- </a></li>
             </ul>
           </li>';
         }
         ?>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
