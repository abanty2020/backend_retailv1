/*-----------------------------------*
| INICIAMOS EL CODE JS PARA EMPRESA  |
.-----------------------------------*/
var tabla;

/*----------------*
| FUNCION INICIO  |
.----------------*/
function init() {


   validationInputs();


   movermodal();


   //Metodo cambio de color input stock
   $("#stock").bind('keyup mouseup', function () {
      if ($("#stock").val() == 0) {
         $("#stock").css({
            "color": 'red',
            "font-weight": 'bold'
         });
      } else {
         $("#stock").css({
            "color": 'blue',
            "font-weight": 'bold'
         });
      }
   });


   //Metodo o funcion para loader
   loader();


   //Ejecutamos la libreria checkbox de bootstrap
   $(':checkbox').checkboxpicker({
      onLabel: "SI",
      offLabel: "NO"
   });


   //Capturamos el valor del checkbox y desabilitamos el input rango
   $('#rango_option').on('change', function () {
      if ($('#rango_option').is(':checked')) {
         $("#rango").prop('disabled', false);
         $('#rango_option').val("1");
      } else {
         $("#rango").prop('disabled', true);
         $('#rango_option').val("0");
      }
   });


   //Listamos los registros de la BD
   listar();


   //Condicion al metodo limpiar al desaparecer o cancelar form en modal
   $('#modal-producto').on('hidden.bs.modal', function () {
      limpiar();
   })


   //Cargamos los items al select categoria
   $.post("../ajax/producto.php?op=selectCategoria", function (r) {
      $("#idcategoria").html(r);
      $('#idcategoria').selectpicker('refresh');
   });


   //Activamos el metodo para mostrar subcategoria
   $('#idcategoria').change(function () {
      mostrarSubCat();
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


/*-----------------------------*
| Funcion para validar campos  |
.-----------------------------*/
function validationInputs() {

   var allWells = $('.setup-content'),
      allNextBtn = $('.nextBtn');

   var allNextBtn = $('.nextBtn');

   allNextBtn.click(function () {

      var curStep = $(".setup-content"),
         curInputs = curStep.find("input[type='text'],input[type='number'],select"),
         isValid = true;

      $(".form-group").removeClass("has-error");

      for (var i = 0; i < curInputs.length; i++) {
         if (!curInputs[i].validity.valid) {

            isValid = false;

            $(curInputs[i]).closest(".form-group").addClass("has-error");

            $(curInputs[i]).notify(
               'Campo requerido', {
                  position: "bottom center",
                  className: "error",
                  arrowSize: 2,
                  autoHideDelay: 3000,
                  style: 'bootstrap'
               }
            );
         } else {
            $(curInputs[i]).closest(".form-group").addClass("has-exito");
         }
      }

      if (isValid) {
         for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
         }
         guardaryeditar();
      }
   });
}


/*-----------------------------------*
| Funcion para mostrar Subcategorias |
.-----------------------------------*/
function mostrarSubCat() {

   idcat = $("#idcategoria").val();
   $.post("../ajax/producto.php?op=selectSubCategoriaId", {
      idcat: idcat
   }, function (r) {
      $("#idsubcategoria").html(r);
      $('#idsubcategoria').selectpicker('refresh');
   });
}


/*-----------------------------*
| Funcion para imagen producto |
.-----------------------------*/
function readURL(input) {

   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
         $('#imagenmuestra')
            .attr('src', e.target.result)
            .width('auto');
      };
      reader.readAsDataURL(input.files[0]);
   }
}



/*-------------------------------*
| Funcion para resetear refrescar |
.-------------------------------*/
function clearSearch() {

   $("#txtSearch").val('');
   tabla.search('').columns().search('').draw();
   $("#txtSearch").focus();
}


/*---------------------------------------------*
| Funcion para ver imagenes accesorios en modal |
.---------------------------------------------*/
function mostrarclick(nombreproducto, descripcion, imagen) {

   $.confirm({
      title: '<span class="title_confirmjs">' + nombreproducto + '</span>',
      columnClass: 'col-md-6 col-md-offset-3',
      content: '' + `<div class='report-module'>
               <div class="text-center">
                 <img src="../` + imagen + `" class="imagepreview">
               </div>
               <div class='post-content'>
                 <p class='description'>` + descripcion + `</p>
               </div>
             </div>`,
      draggable: true,
      backgroundDismiss: true,
      buttons: {
         Cerrar: {
            btnClass: 'btn-blue',
            action: function () {}
         },
      }
   });
}


/*---------------------------*
| Funcion para vaciar inputs |
.---------------------------*/
function limpiar() {

   $('#idsubcategoria').on('show.bs.select', function () {
      if (idsubcategoria.length <= 1) {
         $("#labelsubcat").notify(
            'Selecciona una categoria antes', {
               position: "top",
               className: "warn",
               autoHideDelay: 3000,
               style: 'bootstrap'
            }
         );
      }
   });
   $("#idcategoria").val("").selectpicker('refresh');
   $("#idsubcategoria").val("").selectpicker('refresh');
   $("#idsubcategoria").html('');
   $("#idproducto").val("");
   $("#nombre").val("");
   $("#rango").val("");
   $("#stock").val("0");
   if ($("#stock").val() == 0) {
      $("#stock").css({
         "color": 'red',
         "font-weight": 'bold'
      });
   } else {
      $("#stock").css({
         "color": 'blue',
         "font-weight": 'bold'
      });
   }
   CKEDITOR.instances.descripcion.setData("");
   $("#imagenmuestra").attr("src", "../public/img/product-default.jpg");
   $("#imagenactual").val("");
   $("#imagen").val("");
   $("#rango").prop('disabled', true);
   $("#rango_option").prop('checked', false);
}


/*----------------------------------*
| Funcion para abrir modal registro |
.----------------------------------*/
function OpenModal() {
   limpiar();
   $(".modal-title").html('<i class="fa fa-product-hunt"></i> Registrar Producto');
   $('#modal-producto').modal('show').on('shown.bs.modal', function (e) {
      $('input:visible:enabled:first', e.target).focus();
   });
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
         url: '../ajax/producto.php?op=listar',
         type: "get",
         dataType: "json",
         error: function (e) {
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
function guardaryeditar() {
   // e.preventDefault();

   var formData = new FormData($("#formulario")[0]);
   $('#modal-producto').modal('hide');
   $.ajax({
      url: "../ajax/producto.php?op=guardaryeditar",
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
function mostrar(idproducto) {
   $.post("../ajax/producto.php?op=mostrar", {
      idproducto: idproducto
   }, function (data, status) {
      data = JSON.parse(data);

      // console.log(data.descripcion);

      $.post("../ajax/producto.php?op=selectSubCategoriaId", {
         idcat: data.idcategoria
      }, function (r) {
         $("#idsubcategoria").html(r).selectpicker('refresh');
         $("#idsubcategoria").val(data.idsubcategoria).selectpicker('refresh');
      });

      if (data.rango_option == "1") {
         $("#rango_option").prop('checked', true);
         $("#rango").prop('disabled', false);
      } else {
         $("#rango_option").prop('checked', false);
         $("#rango").prop('disabled', true);
      }

      $(".modal-title").html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar producto');
      $("#nombre").val(data.nombre);
      $("#idproducto").val(data.idproducto);
      $("#idcategoria").val(data.idcategoria);
      $('#idcategoria').selectpicker('refresh');
      $("#rango").val(data.rango);
      $("#stock").val(data.stock);
      CKEDITOR.instances.descripcion.setData(data.descripcion);

      if (data.imagen == "") {
         $("#imagenmuestra").attr("src", "../public/img/product-default.jpg");
      } else {
         $("#imagenmuestra").attr("src", "../" + data.imagen).width('auto');

         $("#imagenactual").val(data.imagen);
      }
      $('#modal-producto').modal('show');
   });

}


/*-------------------------------*
| Funcion para activar registros |
.-------------------------------*/
function activar(idproducto) {
   $.confirm({
      icon: 'fa fa-question-circle',
      title: 'Advertencia!',
      content: '¿Está seguro de activar el producto?',
      type: 'blue',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-blue',
            keys: ['enter', 'shift'],
            action: function () {
               $.post("../ajax/producto.php?op=activar", {
                  idproducto: idproducto
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
function desactivar(idproducto) {
   $.confirm({
      icon: 'fa fa-warning',
      title: 'Advertencia!',
      content: '¿Está seguro de desactivar el producto?',
      type: 'sisfar',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-sisfar',
            keys: ['enter', 'shift'],
            action: function () {
               $.post("../ajax/producto.php?op=desactivar", {
                  idproducto: idproducto
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
      // $('body').css({overflow:"hidden"})
      setTimeout(function () {
         //  $('body').css({overflow:"hidden"})
         $(".loader-page").css({
            visibility: "hidden",
            opacity: "0"
         })
      }, 1000);
   });
}


init();