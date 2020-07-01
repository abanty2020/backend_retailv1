<!DOCTYPE html>
 <html>
 <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Sistema | Ingreso</title>
   <!-- Tell the browser to be responsive to screen width -->
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <link rel="shortcut icon" type="text/css" href="public/img/favicon.ico">
   <!-- Bootstrap 3.3.7 -->
   <link rel="stylesheet" href="public/css/bootstrap.min.css">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="public/css/font-awesome.min.css">
   <!-- Ionicons -->
   <link rel="stylesheet" href="public/css/ionicons.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="public/css/AdminLTE.min.css">
   <!-- iCheck -->
   <link rel="stylesheet" href="public/css/blue.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
   <!-- Google Font -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
 </head>
 <body class="hold-transition login-page">
 <div class="login-box">
   <div class="login-logo">
     <a href="#"><b>Seguridad</b>Retail</a>
   </div>
   <!-- /.login-logo -->
   <div class="login-box-body">
     <p class="login-box-msg">Logeate para iniciar sessión</p>
     <form action="" method="post" id="frmAcceso">
       <div class="form-group has-feedback">
         <input type="text" class="form-control" id="logina" name="logina" placeholder="Usuario" value="<?php echo (isset($_COOKIE['wdb_email'])?$_COOKIE['wdb_email']:'')?>"><!-- INPUT LOGIN -->
         <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
       </div>
       <div class="form-group has-feedback">
         <input type="password"  id="clavea" name="clavea" class="form-control" autocomplete="on" placeholder="Password" value="<?php echo (isset($_COOKIE['wdb_email'])?$_COOKIE['wdb_password']:'')?>"><!-- INPUT CLAVE -->
         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
       </div>
       <div class="row">
         <div class="col-xs-8">
           <div class="checkbox icheck">
             <!-- <label> -->
               <input type="checkbox" name="remember_me" id="remember_me" value="1" <?php echo (isset($_COOKIE['wdb_email'])?'checked':'')?>> <label> Recordar password</label>
             <!-- </label> -->
           </div>
         </div>
         <!-- /.col -->
         <div class="col-xs-4">
            <input type="submit" id="submit" name="submit" value="Ingresar" class="btn btn-primary btn-block btn-flat">
           <!-- <button type="submit" id="logeo" class="btn btn-primary btn-block btn-flat">Ingresar</button> -->
         </div>
         <!-- /.col -->
       </div>
     </form>
   </div>
   <!-- /.login-box-body -->
 </div>
 <!-- /.login-box -->
 <!-- jQuery 3 -->
 <script src="public/js/jquery.min.js"></script>
 <!-- Bootstrap 3.3.7 -->
 <script src="public/js/bootstrap.min.js"></script>
 <!-- iCheck -->
 <script src="public/js/icheck.min.js"></script>
 <!-- Login -->
 <script src="vistas/scripts/login.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
 <script>
   $(function () {
     $('input').iCheck({
       checkboxClass: 'icheckbox_square-blue',
       radioClass: 'iradio_square-blue',
       increaseArea: '20%' /* optional */
     });
   });
 </script>
 </body>
 </html>
