/*-----------------------------------*
| INICIAMOS EL CODE JS PARA EMPRESA  |
.-----------------------------------*/
var tabla;

/*----------------*
| FUNCION INICIO  |
.----------------*/
function init() {


   $("#modal-usuario").on('hidden.bs.modal', function(e) {
      $('body').css({overflow:"auto"})
    });


   //Metodo o funcion para loader
   loader();


   //Listamos los registros de la BD
   listar();


   //Condicion al metodo limpiar al desaparecer o cancelar form en modal
   $('#modal-usuario').on('hidden.bs.modal', function() {
      limpiar();
   })


   //Capturamos el submit para guardar registros
   $("#formulario").on("submit", function(e) {
      guardaryeditar(e);
   })


   //Mostramos los permisos
   $.post("../ajax/usuario.php?op=permisos&id=", function(r) {
      $("#permisos").html(r);
   });


} /* Fin Funcion INIT */


/*-------------------------------*
| Funcion para Limpiar refrescar |
.-------------------------------*/
function clearSearch() {

   $("#txtSearch").val('');
   tabla.search('').columns().search('').draw();
   $("#txtSearch").focus();
}


/*---------------------------*
| Funcion para imagen perfil |
.---------------------------*/
function readURL(input) {

   if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
         $('#imagenmuestra')
            .attr('src', e.target.result)
            .width(150)
            .height(150);
      };

      reader.readAsDataURL(input.files[0]);
   }
}


/*----------------------------------*
| Funcion para abrir modal registro |
.----------------------------------*/
function OpenModal() {
   $('body').css({overflow:"hidden"})
   limpiar();
   $("#labelclave").text("Clave");
   $(".modal-title").text("Registrar Usuario");
   $('#clave').attr('placeholder', '');
   $('#modal-usuario').modal('show');
}


/*---------------------*
| Funcion para Limpiar |
.---------------------*/
function limpiar() {

   $("#nombre").val("");
   $("#num_documento").val("");
   $("#direccion").val("");
   $("#telefono").val("");
   $("#email").val("");
   $("#cargo").val("");
   $("#login").val("");
   $("#clave").val("");
   $("#imagenmuestra").attr("src", "../public/img/default.jpg");
   $("#imagenactual").val("");
   $("#idusuario").val("");
   $('input[type=checkbox]').prop('checked', false);
}


/*----------------------------------*
| Funcion listar registros usuarios |
.----------------------------------*/
function listar() {

   $('#txtSearch').on('input', function() {
      tabla.search($('#txtSearch').val()).draw();
   });

   tabla = $('#tbllistado').dataTable({
      "aProcessing": true, //Activamos el procesamiento del datatables
      "aServerSide": true, //Paginación y filtrado realizados por el servidor
      dom: 'rtip', //Definimos los elementos del control de tabla
      "language": {
         "url": "../public/css/Spanish.json"
      },
      buttons: [
         'copyHtml5',
         'excelHtml5',
         'csvHtml5',
         'pdf'
      ],
      "ajax": {
         url: '../ajax/usuario.php?op=listar',
         type: "get",
         dataType: "json",
         error: function(e) {
            console.log(e.responseText);
         }
      },
      "bDestroy": true,
      "iDisplayLength": 10, //Paginación
      "order": [
            [0, "desc"]
         ] //Ordenar (columna,orden)
   }).DataTable();
}


/*------------------------------*
| Funcion para guardar o editar |
.------------------------------*/
function guardaryeditar(e) {

   e.preventDefault(); //No se activará la acción predeterminada del evento
   $("#btnGuardar").prop("disabled", true);
   var formData = new FormData($("#formulario")[0]);
   $('#modal-usuario').modal('hide');
   $.ajax({
      url: "../ajax/usuario.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(datos) {
         tabla.ajax.reload(null, false);

         $.notify.defaults({
            className: "success"
         });
         $.notify.defaults({
            autoHideDelay: 5000
         });
         $.notify.defaults({
            style: 'bootstrap'
         });
         $("#btnagregar").notify(
            datos, {
               position: "right"
            }
         );
      }
   });
   limpiar();
}


/*------------------------------------*
| Funcion para mostrar password input |
.------------------------------------*/
function showpass() {

   var x = document.getElementById("clave");
   if (x.type === "password") {
      x.type = "text";
   } else {
      x.type = "password";
   }
}


/*---------------------------------------------*
| Funcion para validar login con base de datos |
.---------------------------------------------*/
function validarlogin() {

   $.post("../ajax/usuario.php?op=verificar_login", function(data, status) {
      data = JSON.parse(data);

      var mivarlogin = $('#login').val();

      if ($.inArray(mivarlogin, data) != -1) {
         $("#login").notify(
            "Ya existe este login", {
               position: "botton",
               className: 'error'
            }
         );
         $("#login").val('');
      }
   });
}


/*-----------------------------------------------*
| Funcion para mostrar valores de la DB en modal |
.-----------------------------------------------*/
function mostrar(idusuario) {

   $.post("../ajax/usuario.php?op=mostrar", {
      idusuario: idusuario
   }, function(data, status) {
      data = JSON.parse(data);

      $("#nombre").val(data.nombre);
      $("#tipo_documento").val(data.tipo_documento);
      $("#tipo_documento").selectpicker('refresh');
      $("#num_documento").val(data.num_documento);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#email").val(data.email);
      $("#cargo").val(data.cargo);
      $("#login").val(data.login);
      $(".modal-title").text("Actualizar Usuario");
      $("#labelclave").text("Restablece Clave");
      $('#clave').attr('placeholder', 'Restablece un nueva contraseña');
      $("#imagenmuestra").show();
      $("#imagenmuestra").attr("src", "../files/usuarios/" + data.imagen);
      $("#imagenactual").val(data.imagen);
      $("#idusuario").val(data.idusuario);

   });
   $.post("../ajax/usuario.php?op=permisos&id=" + idusuario, function(r) {
      $("#permisos").html(r);
   });
   $('#modal-usuario').modal('show');
}


/*-------------------------------*
| Funcion para activar registros |
.-------------------------------*/
function activar(idusuario) {

   $.confirm({
      icon: 'fa fa-question-circle',
      title: 'Advertencia!',
      content: '¿Está seguro de activar al Usuario?',
      type: 'blue',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-blue',
            keys: ['enter', 'shift'],
            action: function() {
               $.post("../ajax/usuario.php?op=activar", {
                  idusuario: idusuario
               }, function(e) {

                  $('#tbllistado').DataTable().ajax.reload(null, false);

                  $.notify.defaults({
                     className: "success"
                  });
                  $.notify.defaults({
                     autoHideDelay: 2000
                  });

                  $("#btnagregar").notify(
                     e, {
                        position: "right"
                     }
                  );

               });

            }
         },
         heyThere: {
            text: 'Cancelar',
            btnClass: 'btn-default',
            keys: ['enter', 'a'],
            isHidden: false, //
            isDisabled: false, //
            // action: function(){
            //       $.alert('Cancelado!');
            // }
         },
      }
   });
}


/*----------------------------------*
| Funcion para desactivar registros |
.----------------------------------*/
function desactivar(idusuario) {

   $.confirm({
      icon: 'fa fa-warning',
      title: 'Advertencia!',
      content: '¿Está seguro de desactivar el usuario actual?',
      type: 'sisfar',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-sisfar',
            keys: ['enter', 'shift'],
            action: function() {
               $.post("../ajax/usuario.php?op=desactivar", {
                  idusuario: idusuario
               }, function(e) {

                  $('#tbllistado').DataTable().ajax.reload(null, false);

                  $.notify.defaults({
                     className: "warn"
                  });
                  $.notify.defaults({
                     autoHideDelay: 2000
                  });

                  $("#btnagregar").notify(
                     e, {
                        position: "right"
                     }
                  );
               });
            }
         },
         heyThere: {
            text: 'Cancelar',
            btnClass: 'btn-default',
            keys: ['enter', 'a'],
            isHidden: false, //
            isDisabled: false, //
            // action: function(){
            //       $.alert('Cancelado!');
            // }
         },
      }
   });
}


/*--------------------------------------*
| Funcion Extra para loader en pantalla |
.--------------------------------------*/
function loader() {
   $(window).on('load', function () {
      $('body').css({overflow:"hidden"})
       setTimeout(function () {
       $('body').css({overflow:"auto"})
     $(".loader-page").css({visibility:"hidden",opacity:"0"})
   }, 1000);
   });
}


init();
