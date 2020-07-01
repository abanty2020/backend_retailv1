 CKEDITOR.replace('descripcion', {
    enterMode: CKEDITOR.ENTER_DIV
    // shiftEnterMode: CKEDITOR.ENTER_BR 
 });

 CKEDITOR.on('dialogDefinition', function (e) {

    dialogName = e.data.name;
    dialogDefinition = e.data.definition;
    console.log(dialogDefinition);
    if (dialogName == 'image') {
       dialogDefinition.removeContents('Link');
       dialogDefinition.removeContents('advanced');
       var tabContent = dialogDefinition.getContents('info');
       console.log(tabContent);
       tabContent.remove('txtHSpace');
       tabContent.remove('txtVSpace');

    }
 })


 // CKEDITOR.replace (' descripcion ', { 

 // }); 