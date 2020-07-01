/*-----------------------------------*
| INICIAMOS EL CODE JS PARA EMPRESA  |
.-----------------------------------*/
var tabla;
var tabla_modal;
var cont=0;
/*----------------*
| FUNCION INICIO  |
.----------------*/
function init() {

   validationInputs();


   $("button[data-dismiss-modal=modal2]").click(function(){
        $('#modaltblproductos').modal('hide');
   });


   $("#modal-accesorio").on('hidden.bs.modal', function(e) {
      $('body').css({overflow:"auto"})
    });


   movermodal();


   //Listamos los registros de la BD
   listar();


   //Metodo o funcion para loader
   loader();


   // Ejecutamos la libreria checkbox de bootstrap
   $(':checkbox').checkboxpicker({
      onLabel: "SI",
      offLabel: "NO"
   });


   //Capturamos el valor del checkbox y desabilitamos el input rango
   $('#rango_option').on('change', function() {
      if ($('#rango_option').is(':checked')) {
         $("#rango").prop('disabled', false);
         $('#rango_option').val("1");
      } else {
         $("#rango").prop('disabled', true);
         $('#rango_option').val("0");
      }
   });


   //Capturamos el valor del checkbox y desabilitamos el input cantidad min
   $('#cantidad_min_option').on('change', function() {
      if ($('#cantidad_min_option').is(':checked')) {
         $("#cantidad_min").prop('disabled', false);
         $('#cantidad_min_option').val("1");
      } else {
         $("#cantidad_min").prop('disabled', true);
         $('#cantidad_min_option').val("0");
      }
   });


   //Cargamos los items al select categoria
   $.post("../ajax/accesorio.php?op=select_tipo_producto", function(r) {
      $("#idtipo_producto").html(r);
      $('#idtipo_producto').selectpicker('refresh');
   });


} /* Fin Funcion INIT */


/*------------------------------------*
| Funcion para mover el modal (DRAG)  |
.------------------------------------*/
function movermodal(){

   $(".modal-header").on("mousedown", function(mousedownEvt) {
     var $draggable = $(this);
     var x = mousedownEvt.pageX - $draggable.offset().left,
         y = mousedownEvt.pageY - $draggable.offset().top;
     $("body").on("mousemove.draggable", function(mousemoveEvt) {
         $draggable.closest(".modal-dialog").offset({
             "left": mousemoveEvt.pageX - x,
             "top": mousemoveEvt.pageY - y
         });
     });
     $("body").one("mouseup", function() {
         $("body").off("mousemove.draggable");
     });
     $draggable.closest(".modal").one("bs.modal.hide", function() {
         $("body").off("mousemove.draggable");
     });
   });
}


/*-----------------------------*
| Funcion para validar campos  |
.-----------------------------*/
function validationInputs(){

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
          }else {
            $(curInputs[i]).closest(".form-group").addClass("has-exito");
          }
      }

     if(isValid){
         for(var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
         }
         guardaryeditar();
     }
 });
}


/*-----------------------------*
| Funcion para imagen accesorio |
.-----------------------------*/
function readURL(input) {

   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
         $('#imagenmuestra')
            .attr('src', e.target.result)
            .width('auto');
      };
      reader.readAsDataURL(input.files[0]);
   }
}


/*-----------------------------*
| Funcion para obtener Colores |
.-----------------------------*/
function cambiar_color_obtener() {

   $('#color-chooser > li > a').click(function(e) {
      e.preventDefault();

      currColor = $(this).css('color')

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
function mostrarclick(nombreaccesorio, descripcion, imagen) {

       $.confirm({
         title: '<span class="title_confirmjs">'+nombreaccesorio+'</span>',
         columnClass: 'col-md-6 col-md-offset-3',
         content: ''+`<div class='report-module'>
                   <div class="text-center">
                     <img src="../`+imagen+`" class="imagepreview">
                   </div>
                   <div class='post-content'>
                     <p class='description'>`+descripcion+`</p>
                   </div>
                 </div>`,
         draggable: true,
         backgroundDismiss: true,
         buttons: {
            Cerrar: {
                btnClass: 'btn-blue',
                action: function(){}
            },
         }
   });
}


/*---------------------------*
| Funcion para vaciar inputs |
.---------------------------*/
function limpiar() {
   cont=0;
   $("#tipo_accesorio").val("").selectpicker('refresh');
   $("#idtipo_producto").val("").selectpicker('refresh');
   $('#ctrl').removeClass('control-sidebar-open');
   $('#ctrl').css('display','none');
   $("#nombre").val("");
   $("#mibuscador").val("");
   $("#idaccesorio").val("");
   $("#rango").val("");
   $("#cantidad_min").val("");
   CKEDITOR.instances.descripcion.setData("");
   $("#imagenmuestra").attr("src", "../public/img/product-default.jpg");
   $("#imagenactual").val("");
   $("#imagen").val("");
   $("#rango").prop('disabled', true);
   $("#rango_option").prop('checked', false);
   $("#cantidad_min").prop('disabled', true);
   $("#cantidad_min_option").prop('checked', false);
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
| Funcion para abrir modal registro |
.----------------------------------*/
function OpenModal() {

   $('body').css({overflow:"hidden"})

   $(".modal-body").click(function() {
      $('#ctrl').removeClass('control-sidebar-open');
      $('#ctrl').css('display','none');
   });

      $("#ctrl, .control-sidebar-bg").click(function(event) {
       event.stopPropagation();
   });

      cambiar_color_obtener();
      limpiar();
      $("#modal-accesorio .modal-title").html('<i class="fa fa-cube" aria-hidden="true"></i> Registrar Accesorio');
      $('#modal-accesorio').modal('show');


      listar_table_detail();

}


/*----------------------------------*
| Funcion listar registros usuarios |
.----------------------------------*/
function listar() {

   // HERRAMIENTAS TOOLTIP
   // $('[data-toggle="tooltip"]').tooltip();

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
      columnDefs: [
        { "sWidth": "200px", "aTargets": [1] }
      ],

      "ajax": {
         url: '../ajax/accesorio.php?op=listar',
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

   $('#tbllistado').on('draw.dt', function() {
      $('[data-toggle="tooltip"]').tooltip(); // Or your function for tooltips
 });


}


/*------------------------------*
| Funcion para guardar o editar |
.------------------------------*/
function guardaryeditar() {

   var formData = new FormData($("#formulario")[0]);
   $('#modal-accesorio').modal('hide');
   $.ajax({
      url: "../ajax/accesorio.php?op=guardaryeditar",
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


/*-----------------------------------------------*
| Funcion para mostrar valores de la DB en modal |
.-----------------------------------------------*/
function mostrar(idaccesorio) {

   $(".modal-body").click(function() {
      $('#ctrl').removeClass('control-sidebar-open');
      $('#ctrl').css('display','none');
   });

   $.post("../ajax/accesorio.php?op=mostrar_tipoproductos_seleccionados", {
      idaccesorio: idaccesorio
   }, function(r){
         data = JSON.parse(r);
         //  console.log(data)
         $("#idtipo_producto").val(data);
         $("#idtipo_producto").selectpicker('refresh');

   });

   $.post("../ajax/accesorio.php?op=mostrar", {
      idaccesorio: idaccesorio
   }, function(data, status) {
      data = JSON.parse(data);

      $('#modal-accesorio').modal('show');
      $("#ctrl, .control-sidebar-bg").click(function(event) {
       event.stopPropagation();
      });


      if (data.rango_option == "1") {
         $("#rango_option").prop('checked', true);
         $("#rango").prop('disabled', false);
      } else {
         $("#rango_option").prop('checked', false);
         $("#rango").prop('disabled', true);
      }

      if (data.cantidad_min_option == "1") {
         $("#cantidad_min_option").prop('checked', true);
         $("#cantidad_min").prop('disabled', false);
      } else {
         $("#cantidad_min_option").prop('checked', false);
         $("#cantidad_min").prop('disabled', true);
      }

      cambiar_color_obtener();

      $("#modal-accesorio .modal-title").html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar Accesorio');
      $("#nombre").val(data.nombre);
      $("#idaccesorio").val(data.idaccesorio);

      $("#tipo_accesorio").val(data.tipo_accesorio);
      $("#tipo_accesorio").selectpicker('refresh');

      $("#rango").val(data.rango);
      $("#cantidad_min").val(data.cantidad_min);
      CKEDITOR.instances.descripcion.setData(data.descripcion);
      $("#color").val(data.color);
      $("#style").val(data.style);
      $('#agregarcolor').css({'background-color': data.style,'border-color': data.style,'color': 'white'});

      if (data.imagen == "") {
         $("#imagenmuestra").attr("src", "../public/img/product-default.jpg");
      } else {
          $("#imagenmuestra").attr("src", "../" + data.imagen).width('auto');

         $("#imagenactual").val(data.imagen);
      }
   });

   cont = 0;
   listar_table_detail(idaccesorio);

}


/*----------------------------------*
| Funcion listar registros usuarios |
.----------------------------------*/
function listar_table_detail(valor = null) {

       $.get("../ajax/accesorio.php?op=listarproducto_detalle&id="+valor, function(data, status){

         mydata = JSON.parse(data);
         $("#mTableBody").html("");

         //Ejecutamos la libreria checkbox de bootstrap
         $(document).ready(function() {

            $('input').on('ifChanged', function (event) { $(event.target).trigger('change'); });

            $('.minimal').iCheck({
              checkboxClass: 'icheckbox_flat-blue'
           })
            $('.micheckajax').checkboxpicker({
               onLabel: "SI",
               offLabel: "NO",
               offCls: 'btn-default btn-sm',
               onCls: 'btn-default btn-sm'
            });

            recorrercheckbox();
      });

         if (valor != null) { //SI HAY UN IDACCESORIO

            var arr10 = mydata.informacion_lista_accesorios_productos;
            var arr20 = mydata.informacion_lista_producto;


               map = new Map,
               result = arr10.concat(arr20).reduce(function (r, o) {

                  var temp;
                  if (map.has(o.idproducto)) {
                      Object.assign(map.get(o.idproducto), o);
                  } else {
                      temp = Object.assign({}, o);
                      map.set(temp.idproducto, temp);
                      r.push(temp);
                  }
                  return r;
               }, []);

            result.sort((a, b) => Number(a.idproducto) - Number(b.idproducto));
            result.forEach((a) => {

               if (a.uso_option === undefined) {
                     a.uso_option = '';
               }

               var checked =  (a.uso_option != '') ? 'checked' : '' ;
               var checked_uop =  (a.uso_option != 0) ? 'checked' : '' ;

               var tr = `<tr class="filas">
                           <td><input form="formulario" type="checkbox" `+checked+` onchange="recorrercheckbox();" class="minimal" id="check`+cont+`" name="idproducto[]" value="`+a.idproducto+`"></td>
                           <td class="spanproduct">`+a.nombre+`</td>
                           <td><input form="formulario" type="hidden" name="uso_option[]" value="`+a.uso_option+`"><input type="checkbox" `+checked_uop+` onchange="recorrercheckbox();" class="micheckajax" name="uso_option_validation[]" id="checkx`+cont+`" data-off-active-cls="btn-warning btn-sm" data-on-active-cls="btn-success btn-sm"></td>
                         </tr>`;
               $("#mTableBody").append(tr);

               cont++;

            })


         }else{ //SI NO HAY UN IDACCESORIO

            mydata.informacion_lista_producto.forEach((v) => {

               var tr = `<tr class="filas">
                           <td><input form="formulario" type="checkbox" onchange="recorrercheckbox();" class="minimal" id="check`+cont+`" name="idproducto[]" value="`+v.idproducto+`"></td>
                           <td class="spanproduct">`+v.nombre+`</td>
                           <td><input form="formulario" type="hidden" name="uso_option[]"><input type="checkbox" onchange="recorrercheckbox();" name="uso_option_validation[]" class="micheckajax" id="checkx`+cont+`" data-off-active-cls="btn-warning btn-sm" data-on-active-cls="btn-success btn-sm"></td>
                         </tr>`;

               $("#mTableBody").append(tr);
               cont++;

            })
         }
    })
}


/*--------------------------------------*
| Funcion para cambiar estado checkbox  |
.--------------------------------------*/
function recorrercheckbox() {

      var usop = document.getElementsByName("uso_option[]");

      for (var i = 0; i <usop.length; i++) {
         var inpUSOP=usop[i];

         if ($('#check'+i).is(':checked')){
                 $('#checkx'+i).prop('disabled', false);
                 inpUSOP.value = 0;
         }else {
                 $('#checkx'+i).prop('disabled', true);
                 $('#checkx'+i).prop('checked', false);
                  inpUSOP.value = null;
         }

         if ($('#checkx'+i).is(':checked')){
               inpUSOP.value = 1;
         }
   }
}


/*---------------------------------*
| Funcion para Busqueda sensitiva  |
.---------------------------------*/
function mi_buscador_sensitivo() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("mibuscador");
  filter = input.value.toUpperCase();
  table = document.getElementById("detalles_producto");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
   }
  }
}


/*-------------------------------*
| Funcion para activar registros |
.-------------------------------*/
function activar(idaccesorio) {
   $.confirm({
      icon: 'fa fa-question-circle',
      title: 'Advertencia!',
      content: '¿Está seguro de activar el accesorio?',
      type: 'blue',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-blue',
            keys: ['enter', 'shift'],
            action: function() {
               $.post("../ajax/accesorio.php?op=activar", {
                  idaccesorio: idaccesorio
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
function desactivar(idaccesorio) {
   $.confirm({
      icon: 'fa fa-warning',
      title: 'Advertencia!',
      content: '¿Está seguro de desactivar el accesorio?',
      type: 'sisfar',
      typeAnimated: true,
      buttons: {
         somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-sisfar',
            keys: ['enter', 'shift'],
            action: function() {
               $.post("../ajax/accesorio.php?op=desactivar", {
                  idaccesorio: idaccesorio
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
