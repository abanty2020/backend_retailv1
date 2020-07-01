$("#frmAcceso").on('submit', function(e) {
   e.preventDefault();

   logina = $("#logina").val();
   clavea = $("#clavea").val();
   remember_me = $('#remember_me:checked').val();

   $.post("ajax/usuario.php?op=verificar", {
         "logina": logina,
         "clavea": clavea,
         "remember_me": remember_me
      },
      function(data) {

         console.log(data);

         if (data != "null") {
            $(location).attr("href", "vistas/dashboard");
         } else {
            // $.alert('Usuario y/o Password incorrectos');
            $.alert({
               title: '<i class="fa fa-close" style="color:#dd4b39;"></i> Alerta!',
               type: 'red',
               typeAnimated: true,
               draggable: true,
               animateFromElement: true,
               theme: 'material',
               buttons: {
                  somethingElse: {
                     icon: 'fa fa-warning',
                     text: 'OK',
                     keys: ['enter', 'shift']
                  }
               },
               content: 'Usuario y/o Password incorrectos',
            });
         }
      });
})
