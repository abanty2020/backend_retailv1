function init(){



   mostrar();

   // $('.minimal').iCheck({
   //    checkboxClass: 'icheckbox_flat-blue'
   // })


   $('.url').inputmask({ regex: "https://.*" });


   loader();


   //Capturar evento submit para guardar registros o editarlos
   $("#form_empresa").on("submit", function(e) {
      validarcheckboxes();
      guardardatos(e);
   })


}


/*---------------------------*
| Funcion Validar checkboxes |
.---------------------------*/
function validarcheckboxes(){
   var rows = [];
   $('input:checked').each(function(){
      var row = $(this).parent().parent();
         var data = {};
            $(row).find("td").each(function(i,obj){
               if(i == 0){
                  data.red = $(this).find("input").val();
            }
               else if(i == 1){
                  data.estilo = $(this).find("select").val();
            }
               else if(i == 2){
                  data.url = $(this).find("input").val();
            }
            })
      rows.push(data);
   })

   $("#redessociales").val(JSON.stringify(rows, null, 4));
     console.log(rows);
}


/*---------------------------*
| Funcion para vaciar campos |
.---------------------------*/
function limpiar(){

   $("#imagenmuestra_logo").attr("src", "../public/img/logo-default.jpg");

   $("#imagenmuestra_favicon").attr("src", "../public/img/logo-default.jpg");

   $("#imagenmuestra_extra").attr("src", "../public/img/logo-default.jpg");

   cambio_colores('#d9534f','#5e5e5e');

   $('#agregarcolor_superior').css({
      'background':'#5e5e5e'
   })

   $('#agregarcolor_dominante').css({
      'background':'#d9534f'
   })


}


/*-------------------*
| Funcion para logo  |
.-------------------*/
function readURL_logo(input) {

  if (input.files[0]["type"]!= "image/png") {
      alert('Formato incorrecto solo PNG');
   }else if(input.files[0]["size"] > 2000000 ){
      alert('Peso excedido');
   }else{
      if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#imagenmuestra_logo')
               .attr('src', e.target.result)
               .width('auto');
         };
         reader.readAsDataURL(input.files[0]);
     }
   }
}

/*-------------------------*
| Funcion para extra_logo  |
.-------------------------*/
function readURL_extralogo(input) {

  if (input.files[0]["type"]!= "image/png") {
      alert('Formato incorrecto');
   }else if(input.files[0]["size"] > 2000000 ){
      alert('Peso excedido');
   }else{
       if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
             $('#imagenmuestra_extra')
                .attr('src', e.target.result)
                .width('250px');
          };
          reader.readAsDataURL(input.files[0]);
     }
  }
}


/*--------------------*
| Funcion para icono  |
.--------------------*/
function readURL_favicon(input) {

  if (input.files[0]["type"]!= "image/png") {
      alert('Formato incorrecto');
  }else if(input.files[0]["size"] > 2000000 ){
      alert('Peso excedido');
  }else{
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
         $('#imagenmuestra_favicon')
            .attr('src', e.target.result)
            .width('50px');
        };
        reader.readAsDataURL(input.files[0]);
    }
  }
}


/*---------------------------------*
| Funcion para GuardarInformacion  |
.----------------------------------*/
function guardardatos(e) {
  $("#form_empresa").hide();
  $("#preloaderdiv").show();
   e.preventDefault();

   var formData = new FormData($("#form_empresa")[0]);

   $.ajax({
      url: "../ajax/configuracion.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(datos,options) {

         setTimeout(function() {

            $.amaran({
               'theme'     :'awesome ok',
               'content'   :{
                   title: datos,
                   message:' ',
                   info:'satisfactoriamente',
                   icon:'fa fa-check'
               },
               'position'  :'top right',
               'inEffect'  :'slideRight'
           });




            mostrar();

            $.ajax($.extend(options, {beforeSend: $.noop}));
         }, 0);
         console.log(datos);
      },
      error: function(datos){
         console.log(datos);
      }
   });
}


function mostrar(){

   $.ajax({
      url: "../ajax/configuracion.php?op=mostrar_informacion_entidad",
      type: "GET",
      dataType: "json",
      beforeSend:function(jqXHR, options) {
         setTimeout(function() {
                $("#preloaderdiv").show();

                $.ajax($.extend(options, {beforeSend: $.noop}));
          }, 2000);
          return false;
      },
      success: function(data) {

         $("#preloaderdiv").hide();
         $("#form_empresa").show('fade');

         data_decode = data;



         if (data_decode.datos_empresa == null && data_decode.datos_plantilla == null) {

            limpiar();

         }else{

            // DATOS EMPRESA
            if (data_decode.datos_empresa["razon_social"] == "") {
               $("#razsocial").val("");
            }else{
               $("#razsocial").val(data_decode.datos_empresa["razon_social"]);
            }

            if (data_decode.datos_empresa["ruc"] == 0) {
               $("#ruc").val("");
            }else{
               $("#ruc").val(data_decode.datos_empresa["ruc"]);
            }

            if (data_decode.datos_empresa["direccion"] == "") {
               $("#direccion").val("");
            }else{
               $("#direccion").val(data_decode.datos_empresa["direccion"]);
            }

            if (data_decode.datos_empresa["telefono1"] == 0) {
               $("#telefono1").val("");
            }else{
               $("#telefono1").val(data_decode.datos_empresa["telefono1"]);
            }

            if (data_decode.datos_empresa["telefono2"] == 0) {
               $("#telefono2").val("");
            }else{
               $("#telefono2").val(data_decode.datos_empresa["telefono2"]);
            }

            // DATOS PLANTILLA
            if (data_decode.datos_plantilla["logo"] == "") {
               $("#imagenmuestra_logo").attr("src", "../public/img/logo-default.jpg");
            } else {
               $("#imagenmuestra_logo").attr("src", "../" + data_decode.datos_plantilla["logo"]).width('auto');
               $("#imagenactual_logo").val(data_decode.datos_plantilla["logo"]);
            }

            if (data_decode.datos_plantilla["extra_logo"] == "") {
               $("#imagenmuestra_extra").attr("src", "../public/img/logo-default.jpg");
            } else {
               $("#imagenmuestra_extra").attr("src", "../" + data_decode.datos_plantilla["extra_logo"]).width('250px');
               $("#imagenactual_extra").val(data_decode.datos_plantilla["extra_logo"]);
            }

            if (data_decode.datos_plantilla["icono"] == "") {
               $("#imagenmuestra_favicon").attr("src", "../public/img/logo-default.jpg");
            } else {
               $("#imagenmuestra_favicon").attr("src", "../" + data_decode.datos_plantilla["icono"]).width('50px');
               $("#imagenactual_favicon").val(data_decode.datos_plantilla["icono"]);
            }

            $('#agregarcolor_superior').css({
               'background': data_decode.datos_plantilla["textoSuperior"]
            })

            $('#agregarcolor_dominante').css({
               'background': data_decode.datos_plantilla["colorDominante"]
            })

            cambio_colores(data_decode.datos_plantilla["colorDominante"],data_decode.datos_plantilla["textoSuperior"]);

            // ALGORITMO PARA OBTENER DATOS UN ARRAY JSON REDES SOCIALES
            data_redes = JSON.parse(data_decode.datos_plantilla["redesSociales"]);

            var rs_red = document.getElementsByName("redso");
            var rs_estilo = document.getElementsByName("estilo");
            var rs_url = document.getElementsByName("url");

            $('input[type=checkbox]').each(function (i) {

               if (i == data_redes.length) { return false; }

               if (rs_red[i].value = data_redes[i]["red"]) {
                  this.checked = true;
                  rs_estilo[i].value = data_redes[i]["estilo"];
                  rs_url[i].value = data_redes[i]["url"];

               }else{
                  this.checked = false;
               }
            });
         }

      }
   });
}


/*--------------------------------------------*
| Funcion para cambiar de colores COLORPICKER |
.--------------------------------------------*/
function cambio_colores(color,color2){


   $('#container-color-dominante').colorpicker({
      color: color,
      container: true,
      inline: true,
      customClass: 'colorpicker-2x',
      format: 'hex',
      sliders: {
         saturation: {
            maxLeft: 184,
            maxTop: 184
         },
         hue: {
            maxTop: 184
         },
         alpha: {
            maxTop: 184
         }
      },
      colorSelectors: {
         'black': '#000000',
         'white': '#ffffff',
         'red': '#FF0000',
         'default': '#777777',
         'primary': '#337ab7',
         'success': '#5cb85c',
         'info': '#5bc0de',
         'warning': '#f0ad4e',
         'danger': '#d9534f'
     }
   }).on('changeColor', function(e) {
            $('#agregarcolor_dominante')[0].style.backgroundColor = e.color.toString('rgba');
   });


   $('#container-color-superior').colorpicker({
      color: color2,
      container: true,
      inline: true,
      customClass: 'colorpicker-2x',
      format: 'hex',
      sliders: {
         saturation: {
            maxLeft: 184,
            maxTop: 184
         },
         hue: {
            maxTop: 184
         },
         alpha: {
            maxTop: 184
         }
      },
      colorSelectors: {
         'black': '#000000',
         'white': '#ffffff',
         'red': '#FF0000',
         'default': '#777777',
         'primary': '#337ab7',
         'success': '#5cb85c',
         'info': '#5bc0de',
         'warning': '#f0ad4e',
         'danger': '#d9534f'
     }
   }).on('changeColor', function(e) {
            $('#agregarcolor_superior')[0].style.backgroundColor = e.color.toString('rgba');
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
