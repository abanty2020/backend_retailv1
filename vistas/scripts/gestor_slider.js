// var guardarSlide = $(".guardarSlide");
// var slideOpciones = $(".slideOpciones");
/*--------------------*
| Funcion de Arranque |
.--------------------*/
function init(){


   //Listar Slider inicial
   listar_slider();


   //Metodo o funcion para loader
   loader();


   $(".agregarSlide").click(function() {
      guardarSlideDefault();
   });


}


/*------------------------*
| Funcion Refrescar Tabla |
.------------------------*/
function refrescar_tabla(){

   $("#ul_preloader").show();
   $(".todo-list").hide();
   $(".itemSlide").remove();
   listar_slider(1000);
}


/*----------------------------------*
| Funcion Guardar Slide por Default |
.----------------------------------*/
function guardarSlideDefault(){

   var imgFondo = "public/img/fondo.jpg";
   var tipoSlide = "slideOpcion1"
   var estiloTextoSlide = '{"top":"20","right":"","left":"15","width":"40"}';
   var estiloImgProducto = '{"top":"0","right":"0","left":"0","width":"0"}';
   var titulo1 = '{"texto":"Lorem Ipsum","color":"#333"}';
   var titulo2 = '{"texto":"Lorem Ipsum dolor sit","color":"#777"}';
   var titulo3 = '{"texto":"Lorem Ipsum dolor sit","color":"#888"}';
   var boton = 'VER PRODUCTO';
   var url = '#';

   var formData = new FormData();
   formData.append("imgFondo",imgFondo);
   formData.append("tipoSlide",tipoSlide);
   formData.append("estiloTextoSlide",estiloTextoSlide);
   formData.append("estiloImgProducto",estiloImgProducto);
   formData.append("titulo1",titulo1);
   formData.append("titulo2",titulo2);
   formData.append("titulo3",titulo3);
   formData.append("boton",boton);
   formData.append("url",url);

   $.ajax({
      url: "../ajax/gestor_slider.php?op=guardarSlideDefault",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(datos,options) {

         console.log(datos);

         $(".itemSlide").remove();
         listar_slider(1000);
         // alert('finalizo');
         $("#ul_preloader").show('slow');
         $(".todo-list").hide();

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
            $.ajax($.extend(options, {beforeSend: $.noop}));
          }, 1000);

      }
   });
}


/*---------------------------*
| Funcion Actualizar Slider |
.--------------------------*/
var subirFondo = null;
var subirImgProducto = null;
function actualizarSlide(event){

  $("#ul_preloader").show();
  $(".todo-list").hide();

   var indice_colapso = $(event).attr("indice_colapso");
   var idslide = $(event).attr("idslide");
   var nombre = $(event).attr("nombre");
   var tipoSlide = $(event).attr("tipoSlide");

   var estiloImgProductoTop = $(event).attr("estiloImgProductoTop");
   var estiloImgProductoRight = $(event).attr("estiloImgProductoRight");
   var estiloImgProductoLeft = $(event).attr("estiloImgProductoLeft");
   var estiloImgProductoWidth = $(event).attr("estiloImgProductoWidth");

   var estiloImgProducto = {"top":estiloImgProductoTop,
                            "right":estiloImgProductoRight,
                            "left":estiloImgProductoLeft,
                            "width":estiloImgProductoWidth};

   var estiloTextoSlideTop = $(event).attr("estiloTextoSlideTop");
   var estiloTextoSlideRight = $(event).attr("estiloTextoSlideRight");
   var estiloTextoSlideLeft = $(event).attr("estiloTextoSlideLeft");
   var estiloTextoSlideWidth = $(event).attr("estiloTextoSlideWidth");

   var estiloTextoSlide = {"top":estiloTextoSlideTop,
                            "right":estiloTextoSlideRight,
                            "left":estiloTextoSlideLeft,
                            "width":estiloTextoSlideWidth};

   // CAPTURAMOS EL CAMBIO DE FONDO
   var imgFondo = $(event).attr("imgFondo");

   if (imgFondo == "") {
      subirFondo =$(".subirFondo");
      imgFondo = $(event).attr("rutaImgFondo");
   }

   // CAPTURAMOS EL CAMBIO DE IMAGEN PRODUCTO
   var imgProducto = $(event).attr("imgProducto");

   if (imgProducto == "") {
      subirImgProducto =$(".subirImgProducto");
      imgProducto = $(event).attr("rutaImgProducto");
   }

   var titulo1Texto = $(event).attr("titulo1Texto");
   var titulo1Color = $(event).attr("titulo1Color");

   var titulo1 = {"texto":titulo1Texto,
                  "color":titulo1Color};

   var titulo2Texto = $(event).attr("titulo2Texto");
   var titulo2Color = $(event).attr("titulo2Color");

   var titulo2 = {"texto":titulo2Texto,
                  "color":titulo2Color};

   var titulo3Texto = $(event).attr("titulo3Texto");
   var titulo3Color = $(event).attr("titulo3Color");

   var titulo3 = {"texto":titulo3Texto,
                  "color":titulo3Color};


    var datos_slide = new FormData();
    datos_slide.append("idslide", idslide);
    datos_slide.append("nombre", nombre);
    datos_slide.append("tipoSlide", tipoSlide);
    datos_slide.append("estiloImgProducto", JSON.stringify(estiloImgProducto));
    datos_slide.append("estiloTextoSlide", JSON.stringify(estiloTextoSlide));

   //ENVIAMOS EL CAMBIO DE FONDO
   datos_slide.append("imgFondo",imgFondo);

    if (subirFondo != null) {
      datos_slide.append("subirFondo", subirFondo[indice_colapso].files[0]);
    }else{
      datos_slide.append("subirFondo", subirFondo);
    }

    //ENVIAMOS EL CAMBIO DE IMAGEN
   datos_slide.append("imgProducto",imgProducto);

   if (subirImgProducto != null) {
     datos_slide.append("subirImgProducto", subirImgProducto[indice_colapso].files[0]);
   }else{
     datos_slide.append("subirImgProducto", subirImgProducto);
   }

   datos_slide.append("titulo1", JSON.stringify(titulo1));
   datos_slide.append("titulo2", JSON.stringify(titulo2));
   datos_slide.append("titulo3", JSON.stringify(titulo3));
    $.ajax({
      url: "../ajax/gestor_slider.php?op=actualizar_slider",
      method: "POST",
      data: datos_slide,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta,options) {

         console.log(respuesta);

         $(".itemSlide").remove();
         listar_slider(1000,indice_colapso);

         setTimeout(function() {
            $.amaran({
               'theme'     :'awesome ok',
               'content'   :{
                   title: respuesta,
                   message:' ',
                   info:'satisfactoriamente',
                   icon:'fa fa-check'
               },
               'position'  :'top right',
               'inEffect'  :'slideRight'
           });
            $.ajax($.extend(options, {beforeSend: $.noop}));
          }, 1000);

      },
   });
}


/*---------------------*
| Funcion Listar Datos |
.---------------------*/
function listar_slider(time = 2000, indice_colapsing = null) {

   $.ajax({
      url: "../ajax/gestor_slider.php?op=listar_sliders",
      type: "GET",
      cache: true,
      dataType: "json",
      beforeSend:function(jqXHR, options) {
         setTimeout(function() {
                $("#ul_preloader").show();
                $(".todo-list").hide();
                $.ajax($.extend(options, {beforeSend: $.noop}));
          }, time);
          return false;
      },

      success: function(datos) {
         $("#ul_preloader").hide('slow');
         $(".todo-list").fadeIn('slow');

         if (datos.length == 0) {

            var li_nulo = `
            <div class="progress" width="20">
               <div class="progress progress-striped active">
                  <div id="demo" class="progress-bar progress-bar-danger" style="width: 100%">Sin Informacion para previsualizar</div>
               </div>
            </div>`
            $("#contenido_slide").append(li_nulo);

         }else{

            $(".progress").remove();

            datos.forEach((value,index) => {
               //checked input Radio
               var checked_izq = value["tipoSlide"] == "slideOpcion1" ? "checked" : "";
               var checked_der = value["tipoSlide"] == "slideOpcion2" ? "checked" : "";
               //Conversion datos
               var estiloImgProducto  =  value.estiloImgProducto != "" ? JSON.parse(value.estiloImgProducto):"";
               var estiloTextoSlide  =  value.estiloTextoSlide != "" ? JSON.parse(value.estiloTextoSlide):"";
               var titulo1  =  value.titulo1 != "" ? JSON.parse(value.titulo1):"";
               var titulo2  =  value.titulo2 != "" ? JSON.parse(value.titulo2):"";
               var titulo3  =  value.titulo3 != "" ? JSON.parse(value.titulo3):"";

               //Condiciones
               var contenido_nombre =  value.nombre != "" ? `<p class="text-uppercase">`+value.nombre+`</p>` : `Slide`+value.idslide;
               var boton_slide =  value.boton != "" ? `<a href="`+value.url+`"><button class="btn btn-default btn-lxs color-dominante-degree text-uppercase">`+value.boton+`<span class="fa fa-chevron-right"></span></button></a>` : "";

               var sliderInputHorizontal;
               if (value["tipoSlide"] == "slideOpcion1") {
                  sliderInputHorizontal = `<input type="text" indice="`+index+`" value="" class="slider form-control posHorizontal posHorizontal`+index+`" tipoSlide="`+value["tipoSlide"]+`" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="`+estiloImgProducto.right+`" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="blue">`;
               }else{
                  sliderInputHorizontal = `<input type="text" indice="`+index+`" value="" class="slider form-control posHorizontal posHorizontal`+index+`" tipoSlide="`+value["tipoSlide"]+`" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="`+estiloImgProducto.left+`" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="blue">`;
               }

               var li = `<li class="itemSlide" id="`+value.idslide+`">
                           <div class="box-group" id="accordion">
                              <div class="panel box box-info">
                                 <!-----------------
                                 |     CABECERA    |
                                 ------------------>
                                 <div class="box-header with-border">
                                    <span class="handle">
                                       <i class="fa fa-ellipsis-v"></i>
                                       <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <h4 class="box-title">
                                       <a data-toggle="collapse" data-parent="accordion" href="#collapse`+value.idslide+`">
                                          <span data-toggle="tooltip" title="Click aqui">`+contenido_nombre+`<span>
                                       </a>
                                    </h4>
                                    <div class="btn-group pull-right">
                                       <button class="btn btn-primary guardarSlide"
                                       indice_colapso="`+index+`"
                                       idslide="`+value.idslide+`"
                                       nombre="`+value.nombre+`"
                                       tipoSlide="`+value.tipoSlide+`"
                                       estiloImgProductoTop="`+estiloImgProducto.top+`"
                                       estiloImgProductoRight="`+estiloImgProducto.right+`"
                                       estiloImgProductoLeft="`+estiloImgProducto.left+`"
                                       estiloImgProductoWidth="`+estiloImgProducto.width+`"
                                       estiloTextoSlideTop="`+estiloTextoSlide.top+`"
                                       estiloTextoSlideRight="`+estiloTextoSlide.right+`"
                                       estiloTextoSlideLeft="`+estiloTextoSlide.left+`"
                                       estiloTextoSlideWidth="`+estiloTextoSlide.width+`"
                                       imgFondo="`+value.imgFondo+`"
                                       rutaImgFondo="`+value.imgFondo+`"
                                       imgProducto="`+value.imgProducto+`"
                                       rutaImgProducto="`+value.imgProducto+`"
                                       titulo1Texto="`+titulo1.texto+`"
                                       titulo1Color="`+titulo1.color+`"
                                       titulo2Texto="`+titulo2.texto+`"
                                       titulo2Color="`+titulo2.color+`"
                                       titulo3Texto="`+titulo3.texto+`"
                                       titulo3Color="`+titulo3.color+`"
                                       onclick="actualizarSlide(this);" disabled><i class="fa fa-floppy-o"></i></button>
                                       <button class="btn btn-danger eliminarSlide"><i class="fa fa-times"></i></button>
                                    </div>
                                 </div>
                                 <!------------------------
                                 |  MODULOS COLAPSABLES   |
                                 ------------------------->
                                 <div id="collapse`+value.idslide+`" class="panel-collapse collapse collapseSlide">
                                    <!----------------------------------
                                    |  EDITOR SLIDE CAMPOS EDITABLES   |
                                    ----------------------------------->
                                    <div class="row">
                                       <!--------------------
                                       |    PRIMER BLOQUE   |
                                       --------------------->
                                       <div class="col-md-4 col-xs-12">
                                          <div class="box-body">
                                             <!---------------
                                             |  CAMPO NOMBRE |
                                             ---------------->
                                             <div class="form-group">
                                                <label>Nombre del Slide:</label>
                                                <input type="text" class="form-control nombreSlide" indice="`+index+`" value="`+value.nombre+`">
                                             </div>
                                             <!-----------------------------------
                                             |  CAMPO POSICION IMG / TEXTO SLIDE |
                                             ------------------------------------>
                                             <div class="form-group">
                                                <label>Tipo de Slide:</label>
                                                <label class="checkbox-inline selTipoSlide">
                                                   <input `+checked_izq+` type="radio" class="minimal tipoSlideIzq" value="slideOpcion1" name="tipoSlide`+index+`" indice="`+index+`">
                                                   Izquierda
                                                </label>
                                                <label class="checkbox-inline selTipoSlide">
                                                   <input `+checked_der+` type="radio" class="minimal tipoSlideDer" value="slideOpcion2" name="tipoSlide`+index+`" indice="`+index+`">
                                                   Derecha
                                                </label>
                                             </div>
                                             <!------------------------------------
                                             |  CAMPO FILE CAMBIO DE IMAGEN SLIDE |
                                             ------------------------------------->
                                             <div class="form-group">
                                                <label>Cambiar Imagen Fondo:</label>
                                                <br>
                                                <p class="help-block">
                                                   <img src="../`+value.imgFondo+`" class="img-thumbnail previsualizarFondo" width="200px">
                                                </p>
                                                <input type="file" class="subirFondo" indice="`+index+`">
                                                <p class="help-block">Tamaño recomendado 1600px * 520px</p>
                                             </div>
                                          </div>
                                       </div>
                                       <!---------------------
                                       |    SEGUNDO BLOQUE   |
                                       ---------------------->
                                       <div class="col-md-4 col-xs-12">
                                          <div class="box-body">
                                          <!----------------------------------
                                          |  MODIFICAR LA IMG DEL PRODUCTO   |
                                          ----------------------------------->
                                             <div class="form-group">
                                                <label>Cambiar Imagen Producto:</label>
                                                <br>
                                                <p class="help-block">
                                                   <img src="../`+value.imgProducto+`" class="img-thumbnail previsualizarProducto" width="200px" alt = "">
                                                </p>
                                                <input type="file" class="subirImgProducto" indice="`+index+`">
                                                <p class="help-block">Tamaño recomendado 600px * 600px</p>
                                             </div>
                                          <!-------------------------------------------------
                                          |  MODIFICAR LA POSICION DE LA IMG DEL PRODUCTO   |
                                          -------------------------------------------------->
                                             <div class="form-group">

                                                <label>Posición VERTICAL de la imagen del Producto:</label>

                                                <input type="text" indice="`+index+`" value="" class="slider form-control posVertical posVertical`+index+`" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="`+estiloImgProducto.top+`" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="red">

                                                <label>Posición HORIZONTAL de la imagen del Producto:</label>
                                                `+sliderInputHorizontal+`

                                                <label>ANCHO de la imagen del Producto:</label>

                                                <input type="text" indice="`+index+`" value="" class="slider form-control anchoImagen anchoImagen`+index+`" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="`+estiloImgProducto.width+`" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="green">

                                             </div>
                                          </div>
                                       </div>
                                       <!--------------------
                                       |    TERCER BLOQUE   |
                                       --------------------->
                                       <div class="col-md-4 col-xs-12">
                                          <div class="box-body">
                                             <!--------------------
                                             |  CAMBIO TITULO 1   |
                                             --------------------->
                                             <div class="form-group">
                                                <label>Titulo 1:</label>
                                                <input type="text" class="form-control cambioTituloTexto1" indice="`+index+`" value="`+titulo1.texto+`">
                                                <div class="input-group my-colorpicker">
                                                   <input type="text" class="form-control cambioColorTexto1" indice="`+index+`" value="`+titulo1.color+`">
                                                   <div class="input-group-addon">
                                                      <i></i>
                                                   </div>
                                                </div>
                                             </div>
                                             <!--------------------
                                             |  CAMBIO TITULO 2   |
                                             --------------------->
                                             <div class="form-group">
                                                <label>Titulo 1:</label>
                                                <input type="text" class="form-control cambioTituloTexto2" indice="`+index+`" value="`+titulo2.texto+`">
                                                <div class="input-group my-colorpicker">
                                                   <input type="text" class="form-control cambioColorTexto2" indice="`+index+`" value="`+titulo2.color+`">
                                                   <div class="input-group-addon">
                                                      <i></i>
                                                   </div>
                                                </div>
                                             </div>
                                             <!--------------------
                                             |  CAMBIO TITULO 3   |
                                             --------------------->
                                             <div class="form-group">
                                                <label>Titulo 1:</label>
                                                <input type="text" class="form-control cambioTituloTexto3" indice="`+index+`" value="`+titulo3.texto+`">
                                                <div class="input-group my-colorpicker">
                                                   <input type="text" class="form-control cambioColorTexto3" indice="`+index+`" value="`+titulo3.color+`">
                                                   <div class="input-group-addon">
                                                      <i></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>

                                    </div>
                                    <!----------------------------------
                                    |  SLIDES SWIPPER SLIDE CONTENEDOR |
                                    ----------------------------------->
                                    <div class="container-fluid slide">
                                       <div class="swiper-container">
                                          <ul class="swiper-wrapper">
                                             <li class="swiper-slide">
                                                <!---------------
                                                |  FONDO SLIDE  |
                                                ---------------->
                                                <img class="cambiarFondo" src="../`+value.imgFondo+`">
                                                <!--------------
                                                |  TIPO SLIDE  |
                                                --------------->
                                                <div class="slideOpciones `+value.tipoSlide+`">
                                                   <!------------------------
                                                   |  IMG / POSICION SLIDE  |
                                                   ------------------------->
                                                   <img class="imgProducto" src="../`+value.imgProducto+`" style="top:`+estiloImgProducto.top+`%; right:`+estiloImgProducto.right+`%;width:`+estiloImgProducto.width+`%; left:`+estiloImgProducto.left+`%" alt="">
                                                   <!--------------------------
                                                   |  TEXTO / POSICION SLIDE  |
                                                   --------------------------->
                                                   <div class="textosSlide" style="top:`+estiloTextoSlide.top+`%; left:`+estiloTextoSlide.left+`%; width:`+estiloTextoSlide.width+`%; right:`+estiloTextoSlide.right+`%">
                                                      <h1 style="color:`+titulo1.color+`">`+titulo1.texto+`</h1>
                                                      <h2 style="color:`+titulo2.color+`">`+titulo2.texto+`</h2>
                                                      <h3 style="color:`+titulo3.color+`">`+titulo3.texto+`</h3>
                                                      `+boton_slide+`
                                                   </div>
                                                </div>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </li>`;

               $("#contenido_slide").append(li);
               var swiper = new Swiper('.swiper-container', {
                  slidesPerView: 1,
                  observer: true,
                  observeParents: true
               });
               PosicionamientosSlide(index);
               activarBotonGuardar(value.idslide,index);
               movimientoSlider(index);
               CambiarPos_text_img(index);


            }); //FIN FOREACH

            // LIBERIAS
            $('.input-group').colorpicker();  //ColorPicker
            $('[data-toggle="tooltip"]').tooltip(); //Tooltip
            // Instancia de libreria icheck
            $('.minimal').iCheck({
               checkboxClass: 'icheckbox_square',
               radioClass:'iradio_square-blue'
            })

            /*_____________________________________________________
            |# CODIGO PARA DESPLEGAR DIV POR PARAMETRO            */
            var colapsable = $('.collapse');
            if (indice_colapsing != null) {
               $(colapsable[indice_colapsing]).collapse('show');
            }
            /*___________________________________________________*/

            cambiar_orden_slide();
            NombreSlide();
            CambiarTextosColores();
            subirImgFondo();
            subirProductoImg();

        }
      }
   });

}


function PosicionamientosSlide(index){
   var guardarSlide = $(".guardarSlide");
   var slideOpciones = $(".slideOpciones");

   var posVertical = new Slider('.posVertical'+index, {
      formatter: function(value){

         $(".posVertical").change(function(){

            var indiceSlide = $(this).attr("indice");
            $(slideOpciones[indiceSlide]).children('img').css({"top":value+"%"});
            $(guardarSlide[indiceSlide]).attr("estiloImgProductoTop", value);

         })

         return value;
      }
   })

   var posHorizontal = new Slider('.posHorizontal'+index, {
      formatter: function(value){

         $(".posHorizontal").change(function(){

            var indiceSlide = $(this).attr("indice");
            var tipoSlide = $(this).attr("tipoSlide");

            if(tipoSlide == "slideOpcion1"){

               $(slideOpciones[indiceSlide]).children('img').css({"right":value+"%"});
               $(guardarSlide[indiceSlide]).attr("estiloImgProductoRight", value);
               $(guardarSlide[indiceSlide]).attr("estiloImgProductoLeft", "");

            }else{

               $(slideOpciones[indiceSlide]).children('img').css({"left":value+"%"});
               $(guardarSlide[indiceSlide]).attr("estiloImgProductoLeft", value);
               $(guardarSlide[indiceSlide]).attr("estiloImgProductoRight", "");
            }

         })

         return value;
      }
   })

   var anchoImagen = new Slider('.anchoImagen'+index, {
      formatter: function(value){

         $(".anchoImagen").change(function(){

            var indiceSlide = $(this).attr("indice");

               $(slideOpciones[indiceSlide]).children('img').css({"width":value+"%"});
               $(guardarSlide[indiceSlide]).attr("estiloImgProductoWidth", value);


         })

         return value;
      }
   })
}


/*-------------------------------*
| Funcion para subir ImgProducto |
.-------------------------------*/
function subirProductoImg(){
   var guardarSlide = $(".guardarSlide");
   $(".subirImgProducto").change(function(){
      var slideOpciones = $(".slideOpciones");
      var previsualizarProducto = $(".previsualizarProducto");
      var imagenProducto = this.files[0];
      var indiceSlide_change_imgPro = $(this).attr("indice");

      if (imagenProducto["type"] != "image/jpeg" && imagenProducto["type"] != "image/png") {

         $(".subirImgProducto").val("");
         alert('error al subir');

      }else if(imagenProducto["size"] > 2000000 ){

         $(".subirImgProducto").val("");
         alert('pesa demasiado');

      }else{

         var datosImagen = new FileReader;
         datosImagen.readAsDataURL(imagenProducto);

         $(datosImagen).on("load", function(event){

            var rutaImagen = event.target.result;
            $(previsualizarProducto[indiceSlide_change_imgPro]).attr("src", rutaImagen);
            $(slideOpciones[indiceSlide_change_imgPro]).children('.imgProducto').attr("src", rutaImagen);

            // Cuando Tipo slide izquierda

            var tiposlide_condition = $(guardarSlide[indiceSlide_change_imgPro]).attr("tipoSlide");

            if (tiposlide_condition == "slideOpcion1") {
               $(slideOpciones[indiceSlide_change_imgPro]).children('.imgProducto').css({"top":"15%", "right": "10%", "left": "", "width": "30%"});

               $(guardarSlide[indiceSlide_change_imgPro]).attr("estiloImgProductoTop", "15");
               $(guardarSlide[indiceSlide_change_imgPro]).attr("estiloImgProductoRight", "10");
               $(guardarSlide[indiceSlide_change_imgPro]).attr("estiloImgProductoLeft", "");
               $(guardarSlide[indiceSlide_change_imgPro]).attr("estiloImgProductoWidth", "30");
            }else if(tiposlide_condition == "slideOpcion2"){
               $(slideOpciones[indiceSlide_change_imgPro]).children('.imgProducto').css({"top":"15%", "right": "", "left": "10%", "width": "30%"});

               $(guardarSlide[indiceSlide_change_imgPro]).attr("estiloImgProductoTop", "15");
               $(guardarSlide[indiceSlide_change_imgPro]).attr("estiloImgProductoRight", "");
               $(guardarSlide[indiceSlide_change_imgPro]).attr("estiloImgProductoLeft", "10");
               $(guardarSlide[indiceSlide_change_imgPro]).attr("estiloImgProductoWidth", "30");
            }

            $(guardarSlide[indiceSlide_change_imgPro]).attr("imgProducto", "");

         })
      }
   })
}


/*----------------------------*
| Funcion para subir ImgFondo |
.----------------------------*/
function subirImgFondo(){

   $(".subirFondo").change(function(){
      var slideOpciones = $(".slideOpciones");
      var previsualizarFondo = $(".previsualizarFondo");
      var imagenFondo = this.files[0];
      var indiceSlide_change_img = $(this).attr("indice");

      if (imagenFondo["type"] != "image/jpeg" && imagenFondo["type"] != "image/png") {

         $(".subirFondo").val("");

         alert('error al subir');

      }else if(imagenFondo["size"] > 2000000 ){

         $(".subirFondo").val("");

         alert('pesa demasiado');

      }else{

         var datosImagen = new FileReader;
         datosImagen.readAsDataURL(imagenFondo);

         $(datosImagen).on("load", function(event){

            var rutaImagen = event.target.result;


            $(previsualizarFondo[indiceSlide_change_img]).attr("src", rutaImagen);

            // console.log(event.target.result)

            $(slideOpciones[indiceSlide_change_img]).parent().children('.cambiarFondo').attr("src", rutaImagen);
            $($(".guardarSlide")[indiceSlide_change_img]).attr("imgFondo", "");

         })
      }
   })
}


/*--------------------------------------------*
| Funcion para cambiar posiciones texto y Img |
.--------------------------------------------*/
function NombreSlide(){
   $(".nombreSlide").change(function(){
      var nombre = $(this).val();
      var indiceSlide_change = $(this).attr("indice");
      $($(".guardarSlide")[indiceSlide_change]).attr("nombre", nombre);
   })
}


/*--------------------------------------*
| Funcion para cambiar textos y colores |
.--------------------------------------*/
function CambiarTextosColores(){
   var slideOpciones = $(".slideOpciones");

   // Cambio Texto 1
   $(".cambioTituloTexto1").change(function(){
      var text1 = $(this).val();
      var indiceSlide_changeT1 = $(this).attr("indice");

      $(slideOpciones[indiceSlide_changeT1]).children('.textosSlide').children("h1").html(text1);

      $($(".guardarSlide")[indiceSlide_changeT1]).attr("titulo1Texto", text1);
   })

   $(".cambioColorTexto1").change(function(){
      var color1 = $(this).val();
      var indiceSlide_changeT1 = $(this).attr("indice");

      $(slideOpciones[indiceSlide_changeT1]).children('.textosSlide').children("h1").css({"color":color1});

      $($(".guardarSlide")[indiceSlide_changeT1]).attr("titulo1Color", color1);
   })

   // Cambio Texto 2
   $(".cambioTituloTexto2").change(function(){
      var text2 = $(this).val();
      var indiceSlide_changeT2 = $(this).attr("indice");

      $(slideOpciones[indiceSlide_changeT2]).children('.textosSlide').children("h2").html(text2);

      $($(".guardarSlide")[indiceSlide_changeT2]).attr("titulo2Texto", text2);
   })

   $(".cambioColorTexto2").change(function(){
      var color2 = $(this).val();
      var indiceSlide_changeT2 = $(this).attr("indice");

      $(slideOpciones[indiceSlide_changeT2]).children('.textosSlide').children("h2").css({"color":color2});

      $($(".guardarSlide")[indiceSlide_changeT2]).attr("titulo2Color", color2);
   })

      // Cambio Texto 3
      $(".cambioTituloTexto3").change(function(){
         var text3 = $(this).val();
         var indiceSlide_changeT3 = $(this).attr("indice");

         $(slideOpciones[indiceSlide_changeT3]).children('.textosSlide').children("h3").html(text3);

         $($(".guardarSlide")[indiceSlide_changeT3]).attr("titulo3Texto", text3);
      })

      $(".cambioColorTexto3").change(function(){
         var color3 = $(this).val();
         var indiceSlide_changeT3 = $(this).attr("indice");

         $(slideOpciones[indiceSlide_changeT3]).children('.textosSlide').children("h3").css({"color":color3});

         $($(".guardarSlide")[indiceSlide_changeT3]).attr("titulo3Color", color3);
      })

}


/*--------------------------------------------*
| Funcion para cambiar posiciones texto y Img |
.--------------------------------------------*/
function CambiarPos_text_img(index){

   $("input[name='tipoSlide"+index+"']").on("ifChecked",function(){
      var slideOpciones = $(".slideOpciones");
      var tipoSlides = $(this).val();
      var indiceSlide = $(this).attr("indice")

      var slide = $(".swiper-slide");

      $(slideOpciones[indiceSlide]).addClass(tipoSlides);

      var anchoslide = $(slide[indiceSlide]).css("width").replace(/px/," ");


      if (tipoSlides=='slideOpcion1') {
            // ORGANIZAR IMAGEN PRODUCTO
            var posHImagen = $(slideOpciones[indiceSlide]).children("img").css("left").replace(/px/, " ");
            var nuevaPosHImagen = posHImagen*100/anchoslide;

            $(slideOpciones[indiceSlide]).children("img").css({"left":"", "right":nuevaPosHImagen+"%"})
            // ORGANIZAR IMAGEN PRODUCTO Recogiendo values imgProducto para guardar
            $($(".guardarSlide")[indiceSlide]).attr("estiloImgProductoLeft", "");
            $($(".guardarSlide")[indiceSlide]).attr("estiloImgProductoRight", nuevaPosHImagen);
            // ORGANIZAR TEXTO SLIDE
            var posHtexto = $(slideOpciones[indiceSlide]).children(".textosSlide").css("right").replace(/px/, " ");
            var nuevaPosHTexto = posHtexto*100/anchoslide;
            $(slideOpciones[indiceSlide]).children(".textosSlide").css({"left":nuevaPosHTexto+"%", "right":"", "text-align":"left"})
            // ORGANIZAR IMAGEN PRODUCTO Recogiendo values textos img para guardar
            $($(".guardarSlide")[indiceSlide]).attr("estiloTextoSlideRight", "");
            $($(".guardarSlide")[indiceSlide]).attr("estiloTextoSlideLeft", nuevaPosHTexto);
      }else{
            // ORGANIZAR IMAGEN PRODUCTO
            var posHImagen = $(slideOpciones[indiceSlide]).children("img").css("right").replace(/px/, " ");
            var nuevaPosHImagen = posHImagen*100/anchoslide;

            $(slideOpciones[indiceSlide]).children("img").css({"left":nuevaPosHImagen+"%", "right":""})
             // ORGANIZAR IMAGEN PRODUCTO Recogiendo values imgProducto para guardar
             $($(".guardarSlide")[indiceSlide]).attr("estiloImgProductoRight", "");
             $($(".guardarSlide")[indiceSlide]).attr("estiloImgProductoLeft", nuevaPosHImagen);
            // ORGANIZAR TEXTO SLIDE
            var posHtexto = $(slideOpciones[indiceSlide]).children(".textosSlide").css("left").replace(/px/, " ");
            var nuevaPosHTexto = posHtexto*100/anchoslide;
            $(slideOpciones[indiceSlide]).children(".textosSlide").css({"left":"", "right":nuevaPosHTexto+"%", "text-align":"right"})
            // ORGANIZAR IMAGEN PRODUCTO Recogiendo values textos img para guardar
            $($(".guardarSlide")[indiceSlide]).attr("estiloTextoSlideLeft", "");
            $($(".guardarSlide")[indiceSlide]).attr("estiloTextoSlideRight", nuevaPosHTexto);
      }
      $($(".guardarSlide")[indiceSlide]).attr("TipoSlide", tipoSlides);
      $($(".posHorizontal")[indiceSlide]).attr("TipoSlide", tipoSlides);

   })

}


/*----------------------------------------*
| Funcion para cambiar el orden del slide |
.----------------------------------------*/
function cambiar_orden_slide(){

   var itemSlide = $(".itemSlide");

   $('.todo-list').sortable({
      placeholder         : 'sort-highlight',
      handle              : '.handle',
      forcePlaceholderSize: true,
      zIndex              : 999999,
      stop: function(event){

         for (var i = 0; i < itemSlide.length; i++) {

            var datos = new FormData();
            datos.append("idslide", event.target.children[i].id);
            datos.append("orden", (i+1));

            $.ajax({
               url: "../ajax/gestor_slider.php?op=actualizar_orden",
               type: "POST",
               data: datos,
               cache: false,
               contentType: false,
               processData: false,

               success: function(respuesta) {
                  console.log(respuesta);
               }
            });

         }

         $.amaran({
                  'theme'     :'awesome ok',
                  'content'   :{
                        title: 'Orden cambiado',
                        message:' ',
                        info:'satisfactoriamente',
                        icon:'fa fa-check'
                  },
                  'position'  :'top right',
                  'inEffect'  :'slideRight'
         });
      }
    });
}


/*------------------------*
| Funcion Animacion Slide |
.------------------------*/
function movimientoSlider(item){

   var imgProducto = $(".imgProducto");
   var titulos1 = $(".slide h1");
   var titulos2 = $(".slide h2");
   var titulos3 = $(".slide h3");
   var btnVerProducto = $(".slide button");
   var counting = $(".collapseSlide");
   var imagen = $(".slide ul li img");

   // $(imgProducto[item]).animate({"top":-50 +"%", "opacity": 0},300)
   // $(imgProducto[item]).animate({"top": $(imgProducto[item]).css("top"), "opacity": 1},1000)

   // $(titulos1[item]).animate({"left":-40 +"%", "opacity": 0},300)
   // $(titulos1[item]).animate({"left": $(titulos1[item]).css("left"), "opacity": 1},1000)

   // $(titulos2[item]).animate({"left":-20 +"%", "opacity": 0},300)
   // $(titulos2[item]).animate({"left": $(titulos2[item]).css("left"), "opacity": 1},1000)

   // $(titulos3[item]).animate({"right":-20 +"%", "opacity": 0},300)
   // $(titulos3[item]).animate({"right": $(titulos3[item]).css("right"), "opacity": 1},1000)

   // $(btnVerProducto[item]).animate({"top":-10 +"%", "opacity": 0},300)
   // $(btnVerProducto[item]).animate({"top":$(btnVerProducto[item]).css("top"), "opacity": 1},1000)

}


/*--------------------------------*
| Funcion habilitar boton Guardar |
.--------------------------------*/
function activarBotonGuardar(idslide,index){

   $("#collapse"+idslide).on("show.bs.collapse", function(){
      $($(".guardarSlide")[index]).prop("disabled", false);
    });

   $("#collapse"+idslide).on("hide.bs.collapse", function(){
      $($(".guardarSlide")[index]).prop("disabled", true);
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
