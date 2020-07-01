/*-----------------------------------*
| INICIAMOS EL CODE JS PARA EMPRESA  |
.-----------------------------------*/
var tabla;

/*----------------*
| FUNCION INICIO  |
.----------------*/
function init() {


   //Metodo o funcion para loader
   loader();


   //Metodo o funcion para listar registros
   listar();


   // Mover modal
   movermodal();

   //Cancelar o esconder modal de categorías
   $('#modal-categoria').on('hidden.bs.modal', function () {
      limpiar();
   })


   //Capturar evento submit para guardar registros o editarlos
   $("#formulario").on("submit", function (e) {
      guardaryeditar(e);
   })


} /* Fin Funcion INIT */


/*------------------------------------*
| Funcion para mover el modal (DRAG)  |
.------------------------------------*/
function movermodal() {

   $(".modal-header").on("mousedown", function (mousedownEvt) {
      var $draggable = $(this);
      var x = mousedownEvt.pageX - $draggable.offset().left,
         y = mousedownEvt.pageY - $draggable.offset().top;
      $("body").on("mousemove.draggable", function (mousemoveEvt) {
         $draggable.closest(".modal-dialog").offset({
            "left": mousemoveEvt.pageX - x,
            "top": mousemoveEvt.pageY - y
         });
      });
      $("body").one("mouseup", function () {
         $("body").off("mousemove.draggable");
      });
      $draggable.closest(".modal").one("bs.modal.hide", function () {
         $("body").off("mousemove.draggable");
      });
   });
}


/*-------------------------------*
| Funcion para Limpiar refrescar |
.-------------------------------*/
function clearSearch() {

   $("#txtSearch").val('');
   tabla.search('').columns().search('').draw();
   $("#txtSearch").focus();
}


/*-----------------------------*
| Funcion para obtener Colores |
.-----------------------------*/
function cambiar_color_obtener() {

   $('#color-chooser > li > a').click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#agregarcolor').css({
         'background-color': currColor,
         'border-color': currColor,
         'color': 'white'
      })

      var value = $(this).closest('li').data('value');

      $('#color').val(value);
      $('#style').val(currColor);
   })
}


/*----------------------------------*
| Funcion para abrir modal registro |
.----------------------------------*/
function OpenModal() {

   limpiar();
   cambiar_color_obtener();
   $(".modal-title").text("Registrar Categoria");
   $('#modal-categoria').modal('show');
}


/*---------------------*
| Funcion para Limpiar |
.---------------------*/
function limpiar() {

   $('#collapseOne').removeClass('in');
   $("#nombre").val("");
   $("#idcategoria").val("");
   $("#color").val("");
   $("#style").val("");
   $("#agregarcolor").addClass("btn btn-default");
   $('#agregarcolor').css({
      'background-color': "",
      'border-color': "",
      'color': "black"
   })
}


/*----------------------------------*
| Funcion listar registros usuarios |
.----------------------------------*/
function listar() {

   $('#txtSearch').on('input', function () {
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
         url: '../ajax/categoria.php?op=listar',
         type: "get",
         dataType: "json",
         error: function (e) {
            console.log(e.responseText);
         }
      },
      "bDestroy": true,
      "iDisplayLength": 5, //Paginación
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

   var formData = new FormData($("#formulario")[0]);
   $('#modal-categoria').modal('hide');
   $.ajax({
      url: "../ajax/categoria.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function (datos) {
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


/*-----------------------------------------------*
| Funcion para mostrar valores de la DB en modal |
.-----------------------------------------------*/
function mostrar(idcategoria) {

   $.post("../ajax/categoria.php?op=mostrar", {
      idcategoria: idcategoria
   }, function (data, status) {
      data = JSON.parse(data);

      cambiar_color_obtener(data.style);
      $(".modal-title").text("Actualizar Categoria");
      $("#nombre").val(data.nombre);
      $("#idcategoria").val(data.idcategoria);
      $("#color").val(data.color);
      $("#style").val(data.style);

      $('#agregarcolor').css({
         'background-color': data.style,
         'border-color': data.style,
         'color': 'white'
      });
      $('#modal-categoria').modal('show');

   });


}


/*-------------------------------*
| Funcion para activar registros |
.-------------------------------*/
function activar(idcategoria) {

   $.confirm({
      icon: 'fa fa-question-circle',
      title: 'Advertencia!',
      content: '¿Está seguro de activar la categoría?',
      type: 'blue',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-blue',
            keys: ['enter', 'shift'],
            action: function () {
               $.post("../ajax/categoria.php?op=activar", {
                  idcategoria: idcategoria
               }, function (e) {

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
            isHidden: false,
            isDisabled: false,
         },
      }
   });
}


/*----------------------------------*
| Funcion para desactivar registros |
.----------------------------------*/
function desactivar(idcategoria) {

   $.confirm({
      icon: 'fa fa-warning',
      title: 'Advertencia!',
      content: '¿Está seguro de desactivar la categoría?',
      type: 'sisfar',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-sisfar',
            keys: ['enter', 'shift'],
            action: function () {
               $.post("../ajax/categoria.php?op=desactivar", {
                  idcategoria: idcategoria
               }, function (e) {

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
            isHidden: false,
            isDisabled: false,
         },
      }
   });
}

/*--------------------------------------*
| Funcion Extra para loader en pantalla |
.--------------------------------------*/
function loader() {
   $(window).on('load', function () {
      $('body').css({
         overflow: "hidden"
      })
      setTimeout(function () {
         $('body').css({
            overflow: "auto"
         })
         $(".loader-page").css({
            visibility: "hidden",
            opacity: "0"
         })
      }, 1000);
   });
}


init();