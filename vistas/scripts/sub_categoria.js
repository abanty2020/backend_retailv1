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


   //Cancelar o esconder modal de subcategorías
   $('#modal-subcategoria').on('hidden.bs.modal', function () {
      limpiar();
   })


   //Capturar evento submit para guardar registros o editarlos
   $("#formulario").on("submit", function (e) {
      guardaryeditar(e);
   })


   //Cargamos los items al select categoria
   $.post("../ajax/sub_categoria.php?op=selectcategoria", function (r) {
      $("#idcategoria").html(r);
      $('#idcategoria').selectpicker('refresh');
   });


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


/*----------------------------------*
| Funcion para abrir modal registro |
.----------------------------------*/
function OpenModal() {

   limpiar();
   $(".modal-title").text("Registrar Sub Categoria");
   $('#modal-subcategoria').modal('show');
}


/*---------------------*
| Funcion para Limpiar |
.---------------------*/
function limpiar() {

   $("#nombre").val("");
   $("#descripcion").val("");
   $("#idsubcategoria").val("");
   $("#idcategoria").val("");
   $('#idcategoria').selectpicker('refresh');
   $("#observador").prop("checked", false);

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
         url: '../ajax/sub_categoria.php?op=listar',
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
   $('#modal-subcategoria').modal('hide');
   $.ajax({
      url: "../ajax/sub_categoria.php?op=guardaryeditar",
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
function mostrar(idsubcategoria) {

   $.post("../ajax/sub_categoria.php?op=mostrar", {
      idsubcategoria: idsubcategoria
   }, function (data, status) {

      data = JSON.parse(data);

      $('#modal-subcategoria').modal('show');
      $(".modal-title").text("Actualizar Sub Categoria");
      $("#nombre").val(data.nombre);
      $("#idcategoria").val(data.idcategoria);
      $('#idcategoria').selectpicker('refresh');
      $("#descripcion").val(data.descripcion);
      $("#idsubcategoria").val(data.idsubcategoria);
      data.observador == 1 ? $("#observador").prop("checked", true) : '';


   });

}


/*-------------------------------*
| Funcion para activar registros |
.-------------------------------*/
function activar(idsubcategoria) {

   $.confirm({
      icon: 'fa fa-question-circle',
      title: 'Advertencia!',
      content: '¿Está seguro de activar la subcategoría?',
      type: 'blue',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-blue',
            keys: ['enter', 'shift'],
            action: function () {
               $.post("../ajax/sub_categoria.php?op=activar", {
                  idsubcategoria: idsubcategoria
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
function desactivar(idsubcategoria) {

   $.confirm({
      icon: 'fa fa-warning',
      title: 'Advertencia!',
      content: '¿Está seguro de desactivar la subcategoría?',
      type: 'sisfar',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-sisfar',
            keys: ['enter', 'shift'],
            action: function () {
               $.post("../ajax/sub_categoria.php?op=desactivar", {
                  idsubcategoria: idsubcategoria
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