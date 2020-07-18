//Tabla para modal articulos (Accesorios y Productos)
var tablaArticulos;
var Ruta = $('#rutaServidor').val();
//Tablas para listar por estados
var tabla_general;
var tabla_pendiente;
var tabla_atendido;
var tabla_finalizado;
var tabla_rechazado;

var selectedTag;
var selectTable;
var url;

//Otras variables
var titulo_pregunta = '¿Está seguro de confirmar el pedido de cotización?';
var text_confirm = '';

if ($('#tbllistado_general').length == 1) {
   selectTable = tabla_general;
   selectedTag = $('#tbllistado_general');
   url = '../ajax/pedido.php?op=listar_general';
} else if ($('#tbllistado_pendiente').length == 1) {
   selectTable = tabla_pendiente;
   selectedTag = $('#tbllistado_pendiente');
   url = '../ajax/pedido.php?op=listar_pendientes';
   text_confirm = 'Atendido';
} else if ($('#tbllistado_atendido').length == 1) {
   selectTable = tabla_atendido;
   selectedTag = $('#tbllistado_atendido');
   url = '../ajax/pedido.php?op=listar_atendidos';
   text_confirm = 'Finalizado';
} else if ($('#tbllistado_finalizado').length == 1) {
   selectTable = tabla_finalizado;
   selectedTag = $('#tbllistado_finalizado');
   url = '../ajax/pedido.php?op=listar_finalizados';
} else {
   selectTable = tabla_rechazado;
   selectedTag = $('#tbllistado_rechazado');
   url = '../ajax/pedido.php?op=listar_rechazados';
   titulo_pregunta = '¿Está seguro de restablecer el pedido de cotización?';
   text_confirm = 'pendiente';
}

/*----------------*
| Funcion Inicial |
.----------------*/
function init() {


   loader();


   actualizarDatosFilas();


   $("#modal-pedido").on('hide.bs.modal', function () {

      detalles = 0;
      cont = 0;
      $('.filas').remove();

   });


   listar_todos_los_estados();


   movermodal();


   //Capturar evento submit para guardar registros o editarlos
   $("#formulario").on("submit", function (e) {
      e.preventDefault();

      var sending = true;
      var idpedidoCotizacion = $('#idpedido').val();
      var dataEstado = $("#state").val();


      $.confirm({
         icon: 'fa fa-question-circle',
         title: 'Confirmar Pedido!',
         content: '<b>' + titulo_pregunta + '</b>' + '<br>' +
            'Se cambiara el estado del pedido a <u><i>' + text_confirm + '</i></u> ',
         type: 'blue',
         typeAnimated: true,
         buttons: {
            aceptar: {
               icon: 'fa fa-warning',
               text: 'Confirmar',
               btnClass: 'btn-blue',
               keys: ['enter', 'shift'],
               action: function () {
                  guardaryeditar();

                  setTimeout(function () {

                     if (text_confirm == 'Atendido' || dataEstado == 0) {

                        $.ajax({
                           url: '../reportes/reportec.php?id=' + idpedidoCotizacion + '&sending=' + sending,
                           type: "POST",

                           beforeSend: function (jqXHR, options) {
                              $('#alertMsg').show();
                           },
                           success: function (datos) {
                              $('#alertMsg').hide();
                              console.log(datos);
                              $.amaran({
                                 'theme': 'awesome ok',
                                 'content': {
                                    title: datos,
                                    message: ' ',
                                    info: 'satisfactoriamente',
                                    icon: 'fa fa-check'
                                 },
                                 'position': 'top right',
                                 'inEffect': 'slideRight'
                              });
                           }
                        });
                     }
                  }, 1000);
               }
            },
            cancelar: {
               text: 'Cancelar',
               btnClass: 'btn-default',
               keys: ['enter', 'a'],
               isHidden: false,
               isDisabled: false,
            },
         }
      });
   })

}


/*-----------------------------------*
| Funcion para decimales de modenas  |
.-----------------------------------*/
function number_format(number, decimals, dec_point, thousands_sep) {
   // Strip all characters but numerical ones.
   number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
   var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      s = '',
      toFixedFix = function (n, prec) {
         var k = Math.pow(10, prec);
         return '' + Math.round(n * k) / k;
      };
   // Fix for IE parseFloat(0.55).toFixed(0) = 0;
   s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
   if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
   }
   if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
   }
   return s.join(dec);
}


/*---------------------------------------*
| Funcion para abrir Modal de Articulos  |
.---------------------------------------*/
function abrirModalArticulos() {

   $("#MiModalArticulos").modal();
   listarArticulos();
}


/*---------------------------------------*
| Funcion para abrir Modal de Articulos  |
.---------------------------------------*/
function agregarDetalle(id, descripcion, imagen, identificador) {

   var idaccesorio = identificador == 'accesorio' ? id : null;
   var idproducto = identificador == 'producto' ? id : null;
   var cantidad = 0;
   var subtotal = 0;
   var precio = '';
   var trx = `<tr class="filas" id="fila` + cont + `">
                  <td><input type="hidden" name="iddetalle_pedido[]" value="">
                  <input type="hidden" name="idproducto[]" value="` + idproducto + `">
                  <input type="hidden" name="idaccesorio[]" value="` + idaccesorio + `"><b>Nº` + (detalles + 1) + `</b></td>
                  <td>
                     <figure class="">
                        <img src="` + Ruta + imagen + `" class="img-responsive">
                     </figure>
                  </td>
                  <td>
                     <div class="desc_retail">
                        <div>` + descripcion + ` </div>
                     </div>
                  </td>
                  <td><input type="number" min="0" max="999" class="form-control" name="cantidad[]" value="` + cantidad + `" onchange="modificarSubototales()" onkeyup="modificarSubototales()"></td> 
                  <td><span 
                  style="position: absolute;
                  margin-left: 4px;
                  margin-top: 6px;
                  font-size: 15px;
                  font-weight: bold;">$</span><input type="number" step="0.01" style="padding-left: 13px;" class="form-control moneda" name="precio[]" value="` + precio + `" onchange="modificarSubototales()" onkeyup="modificarSubototales()" placeholder="0.00"></td>
                  <td><b><span name="subtotal">` + subtotal + `</span></b></td>
                  <td><a type="button" class="btn btn-danger" data-toggle="tooltip" title="" data-original-title="Remover artículo" onclick="remover_item(` + cont + `)"><i class="fa fa-trash"></i></a></td>
            </tr>`;

   detalles = detalles + 1;
   $("#bodyaqui").append(trx);
   modificarSubototales();

   $(document).ready(function () {
      // $(".moneda").maskMoney({
      //    prefix: 'S/',
      //    thousands: ',',
      //    decimal: '.',
      //    allowZero: true
      // });

      $('[data-toggle="tooltip"]').tooltip();
   });

}


/*------------------------------*
| Funcion para guardar o editar |
.------------------------------*/
function guardaryeditar(noalerta = true) {

   var formData = new FormData($("#formulario")[0]);

   $.ajax({
      url: "../ajax/pedido.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function (datos) {

         selectTable.ajax.reload(null, false);

         if (noalerta == true) {

            $('#modal-pedido').modal('hide');
            $.amaran({
               'theme': 'awesome ok',
               'content': {
                  title: datos,
                  message: ' ',
                  info: 'satisfactoriamente',
                  icon: 'fa fa-check'
               },
               'position': 'top right',
               'inEffect': 'slideRight'
            });

         }
      }
   });

}


/*--------------------------------------------------------------*
| Funcion para Rechazar Cotizacion (Cambiar Estado a rechazado) |
.--------------------------------------------------------------*/
function ActualizarCotizacion() {
   $('#state').val('soloEditar');
   $.confirm({
      icon: 'fa fa-question-circle',
      title: 'Actualizar Pedido!',
      content: '<b>¿Está seguro de actualizar la informacion del pedido de cotización?</b>',
      type: 'dark',
      typeAnimated: true,
      buttons: {
         aceptar: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-dark',
            keys: ['enter', 'shift'],
            action: function () {
               guardaryeditar();
            }
         },
         cancelar: {
            text: 'Cancelar',
            btnClass: 'btn-default',
            keys: ['enter', 'a'],
            isHidden: false,
            isDisabled: false,
         },
      }
   });
}


/*--------------------------------------------------------------*
| Funcion para Rechazar Cotizacion (Cambiar Estado a rechazado) |
.--------------------------------------------------------------*/
function rechazarCotizacion() {

   var idpedidoCotizacion = $('#idpedido').val();

   $.confirm({
      icon: 'fa fa-question-circle',
      title: 'Rechazar Pedido!',
      content: '<b>¿Está seguro de rechazar el pedido de cotización?</b>' + '<br>' +
         'Se cambiara el estado del pedido a <u><i>Rechazado</i></u> ',
      type: 'red',
      typeAnimated: true,
      buttons: {
         aceptar: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-red',
            keys: ['enter', 'shift'],
            action: function () {
               $.post("../ajax/pedido.php?op=estado_rechazar", {
                  idpedido: idpedidoCotizacion
               }, function (e) {
                  $('#modal-pedido').modal('hide');

                  selectTable.ajax.reload(null, false);

                  $.amaran({
                     'theme': 'colorful',
                     'content': {
                        bgcolor: '#b92c21',
                        color: '#fff',
                        message: ' <i class="fa fa-times" aria-hidden="true"></i> ¡Cotizacion Rechazada!'
                     },
                     'position': 'top right',
                     'inEffect': 'slideRight'
                  });
               });
            }
         },
         cancelar: {
            text: 'Cancelar',
            btnClass: 'btn-default',
            keys: ['enter', 'a'],
            isHidden: false,
            isDisabled: false,
         },
      }
   });

}


/*--------------------------------*
| Funcion para agregar Articulos  |
.--------------------------------*/
function listarArticulos() {

   selectTable = $('#MiTablaAccesorio').dataTable({
      "aProcessing": true, //Activamos el procesamiento del datatables
      "aServerSide": true, //Paginación y filtrado realizados por el servidor
      dom: 'frtip', //Definimos los elementos del control de tabla
      "language": {
         "url": "../public/css/Spanish.json"
      },

      "ajax": {
         url: '../ajax/pedido.php?op=listar_accesorios',
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

   tablaArticulos = $('#MiTablaProducto').dataTable({
      "aProcessing": true, //Activamos el procesamiento del datatables
      "aServerSide": true, //Paginación y filtrado realizados por el servidor
      dom: 'frtip', //Definimos los elementos del control de tabla
      "language": {
         "url": "../public/css/Spanish.json"
      },

      "ajax": {
         url: '../ajax/pedido.php?op=listar_productos',
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


/*---------------------------------------------*
| FUNCION JS PARA ABRIR CON DOBLE CLICK LA ROW |
.---------------------------------------------*/
function listenForDoubleClick(element) {
   element.contentEditable = true;
   setTimeout(function () {
      if (document.activeElement !== element) {
         element.contentEditable = false;
      }
   }, 300);
}


/*--------------------------------------------*
| FUNCION JS PARA EDITAR DATOS DEL COMPROMISO |
.--------------------------------------------*/
function actualizarDatosFilas() {
   var primer_valor;
   $(document).on('focusin', '.update', function () {
      primer_valor = $(this).text();
   })

   $(document).on('focusout', '.update', function (e) {

      var id = $(this).data("id");
      var columna_nombre = $(this).data("column");
      var valorcol = $(this).text();

      if (primer_valor !== valorcol && valorcol !== "") {
         $.confirm({
            icon: 'fa fa-question-circle',
            title: 'Realizar Cambios!',
            content: '<b>¿Está seguro de actualizar esta información?</b>',
            type: 'blue',
            typeAnimated: true,
            buttons: {
               aceptar: {
                  icon: 'fa fa-warning',
                  text: 'Confirmar',
                  btnClass: 'btn-blue',
                  keys: ['enter', 'shift'],
                  action: function () {
                     $.ajax({
                        url: "../ajax/pedido.php?op=editardatos",
                        method: "POST",
                        data: {
                           id: id,
                           columna_nombre: columna_nombre,
                           valorcol: valorcol
                        },

                        success: function (datos) {
                           $.amaran({
                              'theme': 'awesome ok',
                              'content': {
                                 title: datos,
                                 message: ' ',
                                 info: 'satisfactoriamente',
                                 icon: 'fa fa-check'
                              },
                              'position': 'top right',
                              'inEffect': 'slideRight'
                           });
                           selectTable.ajax.reload(null, false);
                        }

                     });

                  }
               },
               cancelar: {
                  text: 'Cancelar',
                  btnClass: 'btn-default',
                  keys: ['enter', 'a'],
                  isHidden: false,
                  isDisabled: false,
               },
            }
         });
      }
   });

}

/*-------------------------*
| Funcion listar registros |
.-------------------------*/
function listar_todos_los_estados() {


   $('#txtSearch').on('input', function () {
      selectTable.search($('#txtSearch').val()).draw();
   });

   selectTable = selectedTag.dataTable({
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
      "drawCallback": function () {
         $(".selectRow").selectpicker();
      },
      columnDefs: [{
         "sWidth": "200px",
         "aTargets": [1]
      }],

      "ajax": {
         url: url,
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

   selectedTag.on('draw.dt', function () {
      $('[data-toggle="tooltip"]').tooltip(); // Or your function for tooltips
   });

}


/*-----------------------------*
| Funcion Cambiar Estado Tabla |
.-----------------------------*/
function cambiarEstadoTabla(info, idpedido) {

   var estadoData = info.value;
   var text_confirm_table;
   var bg;
   var btn_bg;

   switch (info.value) {
      case '0':
         text_confirm_table = 'Pendientes';
         bg = 'green';
         btn_bg = 'btn-green';

         break;

      case '1':
         text_confirm_table = 'Atendidos';
         bg = 'blue';
         btn_bg = 'btn-primary';
         break;

      case '3':
         text_confirm_table = 'Rechazados';
         bg = 'red';
         btn_bg = 'btn-danger';
         break;

      default:

         break;
   }

   $.confirm({
      icon: 'fa fa-question-circle',
      title: 'Cambiar Estado!',
      content: '<b>¿Está seguro de cambiar el estado del pedido?</b>' + '<br>' +
         'Se cambiara el estado del pedido a <u><i>' + text_confirm_table + '</i></u> ',
      type: bg,
      typeAnimated: true,
      buttons: {
         aceptar: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: btn_bg,
            keys: ['enter', 'shift'],
            action: function () {
               $.post("../ajax/pedido.php?op=cambiar_estado_dinamico", {
                  idpedido: idpedido,
                  estadoData: estadoData
               }, function (e) {

                  selectTable.ajax.reload(null, false);

                  $.amaran({
                     'theme': 'awesome ok',
                     'content': {
                        title: e,
                        message: ' ',
                        info: 'satisfactoriamente',
                        icon: 'fa fa-check'
                     },
                     'position': 'top right',
                     'inEffect': 'slideRight'
                  });
               });
            }
         },
         cancelar: {
            text: 'Cancelar',
            btnClass: 'btn-default',
            keys: ['enter', 'a'],
            action: function () {
               selectTable.ajax.reload(null, false)
            },
            isHidden: false,
            isDisabled: false,
         },
      }
   });

   // console.log(estadoData + ',' + idpedido);

}


var cont = 0;
var detalles = 0;
/*--------------------------*
| Funcion Mostrar Registros |
.--------------------------*/
function mostrar(idpedido) {

   $('#modal-pedido').modal("show");

   $.post("../ajax/pedido.php?op=mostrar", {
      idpedido: idpedido
   }, function (r) {
      data = JSON.parse(r);

      $("#idpedido").val(data.idpedido);
      $("#nombre_empresa").val(data.nombre_empresa);
      $("#tipo_negocio").val(data.tipo_negocio);
      $("#state").val(data.estado);

      switch (data.estado) {

         case '0':
            $("#estado").text("Pendiente");
            $('.mi-clase-pendiente').css({
               background: "#00a65a2e"
            });
            $('#estado').removeClass('bg-aqua');
            $('#estado').removeClass('bg-maroon');
            $('#estado').removeClass('bg-red');
            $('#estado').addClass('bg-green');
            $('#btn_modal_submit').show();
            $('#btn_modal_submit').text('Enviar Cotización');
            $("#btn_modal_edit").hide();
            $("#enviarReporte").hide();
            text_confirm = 'Atendido';
            $('#txtTitle').html('<i class="fa fa-book"></i> Pedidos Pendientes');
            desabledInput(false);
            $("#addArt").show();

            break;

         case '1':
            $("#estado").text("Atendido");
            $('.mi-clase-pendiente').css({
               background: "#1ad1ff4f"
            });
            $('#estado').removeClass('bg-green');
            $('#estado').removeClass('bg-maroon');
            $('#estado').removeClass('bg-red');
            $('#estado').addClass('bg-aqua');
            $('#btn_modal_submit').show();
            $('#btn_modal_submit').text('Finalizar Cotización');
            $("#btn_modal_edit").show();
            $("#enviarReporte").show();
            text_confirm = 'Finalizado';
            $('#txtTitle').html('<i class="fa fa-book"></i> Pedidos Atendidos');
            desabledInput(false);
            $("#addArt").show();
            $('#btn_modal_rechazar').show();

            break;

         case '2':
            $("#estado").text("Finalizado");
            $('.mi-clase-pendiente').css({
               background: "#ffb4d5a1"
            });
            $('#estado').removeClass('bg-green');
            $('#estado').removeClass('bg-aqua');
            $('#estado').removeClass('bg-red');
            $('#estado').addClass('bg-maroon ');
            $('#btn_modal_submit').hide();
            $("#btn_modal_edit").hide();
            $("#enviarReporte").hide();
            // text_confirm = 'Rechazados';
            $('#txtTitle').html('<i class="fa fa-book"></i> Pedidos Finalizados');
            desabledInput();
            $("#addArt").hide();
            $('#btn_modal_rechazar').show();

            break;

         case '3':
            $("#estado").text("Rechazado");
            $('.mi-clase-pendiente').css({
               background: "#ff00003b"
            });
            $('#estado').removeClass('bg-green');
            $('#estado').removeClass('bg-maroon');
            $('#estado').removeClass('bg-aqua');
            $('#estado').addClass('bg-red ');
            $('#btn_modal_submit').text('Restaurar Cotización');
            $('#btn_modal_submit').show();
            $('#btn_modal_rechazar').hide();
            $("#btn_modal_edit").hide();
            $("#enviarReporte").hide();
            desabledInput();
            text_confirm = 'Pendientes restaurados';
            $('#txtTitle').html('<i class="fa fa-book"></i> Pedidos Rechazados');
            $("#addArt").hide();

            break;

         default:
            $('.mi-clase-pendiente').css({
               background: "#00a65a2e"
            });
            $('#estado').addClass('bg-green ');
            desabledInput(false);
            break;

      }

      $("#ruc").val(data.ruc);
      $("#representante").val(data.nombre_representante);
      $("#cantidad_productos").val(data.cantidad_aprox_productos);
      $("#telefono").val(data.telefono);
      $("#email").val(data.email);
      $("#cantidad_entradas").val(data.num_entradas);

   });

   $.post("../ajax/pedido.php?op=listar_detalle", {
      idpedido: idpedido
   }, function (datos) {
      data_detalle = JSON.parse(datos);

      data_detalle.forEach((datos, index) => {

         // CONFICIONES
         var desc = datos.descripcion_accesorio == null ? datos.descripcion_producto : datos.descripcion_accesorio;
         var imagen = datos.imagen_accesorio == null ? datos.imagen_producto : datos.imagen_accesorio;

         console.log(datos);
         var subtotal = 0;
         var precio_local = datos.precio == 0 ? '' : datos.precio;
         var desactivadoI;

         if (datos.estado == 2 || datos.estado == 3) {
            desactivadoI = 'disabled';
         } else {
            desactivadoI = '';
         }

         var tr = `<tr class="filas" id="fila` + cont + `">
                     <td><input type="hidden" name="iddetalle_pedido[]" value="` + datos.iddetalle_pedido + `">
                     <input type="hidden" name="idproducto[]" value="` + datos.idproducto + `">
                     <input type="hidden" name="idaccesorio[]" value="` + datos.idaccesorio + `"><b>Nº` + (index + 1) + `</b></td>
                     <td>
                        <figure class="">
                           <img src="` + Ruta + imagen + `" class="img-responsive">
                        </figure>
                     </td>
                     <td>
                        <div class="desc_retail">
                           <div>` + desc + ` </div>
                        </div>
                     </td>
                     <td style="width: 100px;"><input type="number" min="0" class="form-control" name="cantidad[]" value="` + datos.cantidad + `" onchange="modificarSubototales()" onkeyup="modificarSubototales()" onfocus="this.select();" onmouseup="return true;" ` + desactivadoI + `></td>                  
                     <td><span 
                     style="position: absolute;
                     margin-left: 4px;
                     margin-top: 6px;
                     font-size: 15px;
                     font-weight: bold;">$</span><input type="number" step="0.01" style="padding-left: 13px;" class="form-control moneda" name="precio[]" value="` + precio_local + `" onchange="modificarSubototales()" onkeyup="modificarSubototales()" placeholder="0.00" ` + desactivadoI + `></td>
                     <td><b><span name="subtotal">` + subtotal + `</span></b></td>
                     <td><a type="button" class="btn btn-danger" data-toggle="tooltip" title="" data-original-title="Remover artículo" onclick="remover_item(` + cont + `)" ` + desactivadoI + `><i class="fa fa-trash"></i></a></td>
                  </tr>`;

         cont++
         detalles = detalles + 1;
         $("#bodyaqui").append(tr);
         modificarSubototales();


         $(document).ready(function () {
            // $(".moneda").maskMoney({
            //    prefix: 'S/',
            //    thousands: ',',
            //    decimal: '.',
            //    allowZero: true

            // });
            $('[data-toggle="tooltip"]').tooltip();
         });

      });

   });
}

/*--------------------------------*
| Funcion para desactivar inputs  |
---------------------------------*/
function desabledInput(istrue = true) {

   $('#nombre_empresa').attr("disabled", istrue);
   $('#tipo_negocio').attr("disabled", istrue);
   $('#ruc').attr("disabled", istrue);
   $('#representante').attr("disabled", istrue);
   $('#cantidad_productos').attr("disabled", istrue);
   $('#telefono').attr("disabled", istrue);
   $('#email').attr("disabled", istrue);
   $('#cantidad_entradas').attr("disabled", istrue);
}




/*-------------------------------------*
| Funcion para generar cursor en input |
--------------------------------------*/
function onBlur(el) {
   if (el.value == '') {
      el.value = el.defaultValue;
   }
}

function onFocus(el) {
   if (el.value == el.defaultValue) {
      el.value = '';
   }
}


/*----------------------------*
| Funcion calcular Subtotales |
.----------------------------*/
function modificarSubototales() {
   var cant = document.getElementsByName("cantidad[]");
   var prec = document.getElementsByName("precio[]");
   var sub = document.getElementsByName("subtotal");


   for (var i = 0; i < cant.length; i++) {
      var inpC = cant[i];
      var inpP = prec[i];
      var inpS = sub[i];

      // var num = $('.moneda').maskMoney('unmasked')[i];

      inpP.style.background = "#d8e6ff";
      if (inpP.value == 0) {
         inpP.style.background = "#ffd8d8";
         inpP.style.color = "red";
      } else {
         inpP.style.color = "black";
      }


      inpS.value = inpC.value * inpP.value;
      var valuesubt = parseFloat(Math.round(inpS.value * 100) / 100).toFixed(2);
      document.getElementsByName("subtotal")[i].innerHTML = "$ " + number_format(valuesubt, 2, '.', ',');
   }
   calcularTotales();

}


/*--------------------------*
| Funcion calcular Totales  |
.--------------------------*/
function calcularTotales() {
   var sub = document.getElementsByName("subtotal");
   var total = 0.0;

   for (var i = 0; i < sub.length; i++) {
      total += document.getElementsByName("subtotal")[i].value;
      totales = parseFloat(Math.round(total * 100) / 100).toFixed(2);

   }

   $("#mitotal").html("$ " + number_format(totales, 2, '.', ','));
   $("#total_cotizacion").val(total);
   evaluar();
}


/*--------------------------*
| Funcion evaluar Detalles  |
.--------------------------*/
function evaluar() {
   if (detalles > 0) {
      $("#btnGuardar").show();
   } else {
      $("#btnGuardar").hide();
      cont = 0;
   }
}



/*-----------------------*
| Funcion Eliminar Filas |
.-----------------------*/
function remover_item(fila) {
   $("#fila" + fila).remove();
   calcularTotales();
   detalles = detalles - 1;

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


/*-------------------------------*
| Funcion para generar decimales |
.-------------------------------*/

$.fn.currencyInput = function () {
   this.each(function () {
      var wrapper = $("<div class='currency-input' />");
      $(this).wrap(wrapper);
      $(this).before("<span class='currency-symbol'>S/.</span>");
      $(this).change(function () {
         var min = parseFloat($(this).attr("min"));
         var max = parseFloat($(this).attr("max"));
         var value = this.valueAsNumber;
         if (value < min)
            value = min;
         else if (value > max)
            value = max;
         $(this).val(value.toFixed(2));
      });
   });
};

/*---------------------------------------*
| Funcion para Ver Reporte pedido en PDF |
.---------------------------------------*/
function enviarPdf() {

   var sending = true;
   var idpedidoCotizacion = $('#idpedido').val();
   $('#state').val('soloEditar');
   $.confirm({
      icon: 'fa fa-question-circle',
      title: 'Advertencia!',
      content: 'Se enviará un PDF de la cotización vía correo electrónico <b> ¿Estás de acuerdo? </b>',
      type: 'dark',
      typeAnimated: true,
      buttons: {
         confirmar: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-dark',
            keys: ['enter', 'shift'],
            action: function () {
               var noalerta = false;
               guardaryeditar(noalerta);

               setTimeout(function () {

                  $.ajax({
                     url: '../reportes/reportec.php?id=' + idpedidoCotizacion + '&sending=' + sending,
                     type: "POST",

                     beforeSend: function (jqXHR, options) {
                        $('#alertMsg_in_modal').show();

                     },
                     success: function (datos) {

                        $('#alertMsg_in_modal').hide();
                        console.log(datos);
                        $.amaran({
                           'theme': 'awesome ok',
                           'content': {
                              title: datos,
                              message: ' ',
                              info: 'satisfactoriamente',
                              icon: 'fa fa-check'
                           },
                           'position': 'top right',
                           'inEffect': 'slideRight'
                        });
                     }
                  });


               }, 1000);


            }
         },
         cancelar: {
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

init();