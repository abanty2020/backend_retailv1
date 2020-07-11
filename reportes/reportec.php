<?php
ob_start ();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PhpMailer/Exception.php';
require 'PhpMailer/PHPMailer.php';
require 'PhpMailer/SMTP.php';


include '../fpdf182/fpdf.php';
include 'exfpdf.php';
include 'easyTable.php';

require_once "../modelos/Pedido.php";
$pedido= new Pedido();
$rsptap = $pedido->mostrar($_GET["id"]);

$rspta_detalle =  $pedido->mostrar_detalle_pedido($_GET["id"]);

$sending = isset($_GET["sending"])?$_GET["sending"]:false;

$data = array();
$descripcion;
$imagen;
$ruta = '../';
$ruta1 = 'http://localhost/backend_retailv1/';

while ($reg = $rspta_detalle->fetch_object()) {
   
   if ($reg->idaccesorio !== null && $reg->idproducto !== null) {
      $descripcion = $reg->descripcion_accesorio;
      $imagen =  $reg->imagen_accesorio;
   }else if($reg->idaccesorio !== null && $reg->idproducto == null){
      $descripcion = $reg->descripcion_accesorio;
      $imagen =  $reg->imagen_accesorio;
   }else{
      $descripcion = $reg->descripcion_producto;
      $imagen =  $reg->imagen_producto;
   }

   $data[] = array(
      'iddp' =>$reg->iddetalle_pedido,
      'descripcion' =>strip_tags($descripcion),
      'cantidad' =>$reg->cantidad,
      'articulo' =>$imagen,      
      'precio' =>number_format($reg->precio, 2, '.', ','),
      'subtotal' =>number_format(($reg->cantidad*$reg->precio) , 2, '.', ',')              
    ); 
}

// var_dump($data);

$fecha = date("d/m/Y", strtotime($rsptap['fecha_orden']));     

$pdf = new exFPDF('P','mm','A4');

$pdf->AliasNbPages();
$pdf->SetMargins(18, 10, 20);
$pdf->AddPage();

$pdf->Image('logo_socio.png', 20, 8, 65, 20);

$pdf->SetFont('Arial','B',15);
$pdf->SetFillColor(230,230,230);

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetXY($x + 128, $y+5);
$pdf->SetFont('Arial','B',24);
$pdf->SetTextColor(150,150,150);
$pdf->MultiCell(45 ,10,utf8_decode('Cotización'),0,'R',false,0);
$pdf->SetXY($x + 128, $y+15);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(45 ,5,utf8_decode('Nº '.$rsptap['idpedido']),0,'R',false,0);


// DETALLE CABECERA
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x, $y+20);
$pdf->MultiCell(85 ,5,utf8_decode('Sres.'),0,'L',false,0);
$pdf->SetXY($x, $y+25);
$pdf->MultiCell(85 ,5,utf8_decode($rsptap['nombre_empresa']),0,'L',false,0);
$pdf->SetXY($x, $y+30);
$pdf->MultiCell(85 ,5,utf8_decode('Atención: George Paredo.'),0,'L',false,0);
$pdf->SetXY($x, $y+35);
$pdf->MultiCell(85 ,5,utf8_decode('Fecha: '.$fecha),0,'L',false,0);

// ESPACIADO
$pdf->Ln(10);
$pdf->SetFont('Arial','',11);
$pdf->SetXY($x, $y+55);
$pdf->MultiCell(170 ,5,utf8_decode('Por medio de la presente, nos es muy grato saludarles y entregarles la siguiente propuesta:'),0,'L',false,0);

$pdf->SetXY($x, $y+65);
$pdf->SetTextColor(18,45,73);
$pdf->MultiCell(170 ,5,utf8_decode('Descripción del proyecto:'),0,'L',false,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x, $y+75);
$pdf->MultiCell(170 ,5,utf8_decode('Adquisición de sistemas de seguridad retail RF para 1 tienda con acceso de 2m'),0,'L',false,0);

$pdf->Ln(5);

$pdf->SetFont('Arial','',10);


$tableB=new easyTable($pdf,'%{8,25,15,22,15,15}','align:C{LC}; border:1; border-color:#A8A8A8; font-color:#000; border-width:0.1;');

$tableB->easyCell(utf8_decode("Ítem"), 'valign:M; align:C; font-style:B');
$tableB->easyCell(utf8_decode("Descripción"), 'valign:M; align:C; font-style:B');
$tableB->easyCell(utf8_decode("Cantidad"), 'valign:M; align:C; font-style:B');
$tableB->easyCell(utf8_decode("Árticulo"), 'valign:M; align:C; font-style:B');
$tableB->easyCell(utf8_decode("Precio Unitario US$"), 'valign:M; align:C; font-style:B');
$tableB->easyCell(utf8_decode("Sub Total US$"), 'valign:M; align:C; font-style:B');
$tableB->printRow();

$tableB->endTable(0);

$tableB=new easyTable($pdf, '%{8,25,15,22,15,15}', 'align:C{LC}; border:1; border-color:#A8A8A8;  bgcolor:#EDF1E3; font-color:#000; border-width:0.1;');

foreach ($data as $key => $value) {
   $style='';
   if($key%2)
   {
      $style='bgcolor:#DFE0D1;';
   }
   $tableB->rowStyle($style);
   $tableB->easyCell(utf8_decode($value['iddp']), 'valign:M; align:C;');
   $tableB->easyCell(utf8_decode($value['descripcion']), 'valign:M; align:C;font-style:B');
   $tableB->easyCell(utf8_decode($value['cantidad']).' unid', 'valign:M; align:C;');
   $tableB->easyCell("", 'img:'.$ruta.$value['articulo'].',w50');
   // $tableB->easyCell($ruta.$value['articulo'], 'valign:M; align:C;');   
   $tableB->easyCell('$'.$value['precio'], 'valign:M; align:C;');
   $tableB->easyCell('$'.$value['subtotal'], 'valign:M; align:C;');
   $tableB->printRow();
}

$tableB->endTable(5);

/**------------------
   DETALLE NOTAS:   |
-------------------*/
$tableB=new easyTable($pdf,'%{5,14,4.5,46.5,15,15}','align:C{LC}; border:1; border-color:#A8A8A8; font-color:#000; border-width:0.1;');
/** ********************************************************************************************************* */
$tableB->easyCell(utf8_decode("NOTAS"), 'colspan:4; valign:M; align:C; font-style:B');
$tableB->easyCell(utf8_decode("TOTAL + IGV"), 'rowspan:8; valign:M; align:C; font-style:B');
$tableB->easyCell(utf8_decode(number_format(($rsptap['total']) , 2, '.', ',')." US$"), 'rowspan:8; valign:M; align:C; font-style:B');
$tableB->printRow(); //FILA 1
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:L;');
$tableB->easyCell(
   iconv("UTF-8", "CP1252", '•') . utf8_decode(" Los precios están expresados en dólares"), 'border:0; colspan:3; valign:M; align:L; font-style:B');
$tableB->printRow(); //FILA 2
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:L;');
$tableB->easyCell(
   iconv("UTF-8", "CP1252", '•') . utf8_decode(" Garantía de 1 año (Por defectos de fabricación)"), 'border:0; colspan:3; valign:M; align:L; font-style:B');
$tableB->printRow(); //FILA 3
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:L;');
$tableB->easyCell(
   iconv("UTF-8", "CP1252", '•') . utf8_decode(" Modalidad:"), 'border:0; colspan:1; valign:M; align:L; font-style:B');
$tableB->easyCell(utf8_decode(" Al Contado:"), 'border:0; colspan:2; valign:M; align:L; ');
$tableB->printRow(); //FILA 4
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:L;');
$tableB->easyCell(
   iconv("UTF-8", "CP1252", '•') . utf8_decode(" Forma de pago:"), 'border:0; colspan:2; valign:M; align:L; font-style:B');
$tableB->easyCell(utf8_decode(" Depósito en Cuenta Corriente"), 'border:0; colspan:1; valign:M; align:L; ');
$tableB->printRow(); //FILA 5
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:L;');
$tableB->easyCell( iconv("UTF-8", "CP1252", '•') . utf8_decode(" CUENTA BCP DOLARES: \n").'- 191-2489065-1-79', 'border:0; colspan:3; valign:M; align:L; font-style:B');
$tableB->printRow(); //FILA 6
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:L;');
$tableB->easyCell(
   iconv("UTF-8", "CP1252", '•') . utf8_decode(" Tipo de cambio:"), 'border:0; colspan:2; valign:M; align:L; font-style:B');
$tableB->easyCell(utf8_decode(" S/ 3.38"), 'border:0; colspan:1; valign:M; align:L; ');
$tableB->printRow(); //FILA 7
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:LB;');
$tableB->easyCell( iconv("UTF-8", "CP1252", '•') . utf8_decode(" CUENTA BCP SOLES: \n").'- 191-2498559-0-67', 'border:B; colspan:3; valign:M; align:L; font-style:B');
$tableB->printRow(); //FILA 8
/** ********************************************************************************************************* */
$tableB->endTable(0); //FIN TABLA DE NOTAS

/**------------------
    OTRAS NOTAS:    |
-------------------*/
$tableB=new easyTable($pdf,'%{3,97}','align:C{L}; border:0; font-color:#000;');

$tableB->easyCell("No incluye obras civiles", 'colspan:2; border:0; font-style:B; align:C;');
$tableB->printRow(); //FILAS 1
/** ********************************************************************************************************* */

$tableB->easyCell("OBSERVACIONES DE IMPORTANCIA", 'colspan:2; border:0; font-color:#0F1C5B; font-style:B; font-size:11; line-height:2;');
$tableB->printRow(); //FILAS 2
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:0;');
$tableB->easyCell(iconv("UTF-8", "CP1252", '•') . utf8_decode(" Los costos de instalación no incluyen las obras civiles dentro del local, estos corren por cuenta exclusiva del cliente (Las obras civiles deben estar realizadas antes que se proceda con la instalación de las antenas)."), 'colspan:1; border:0; font-size:11;');
$tableB->printRow(); //FILAS 3
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:0;');
$tableB->easyCell(iconv("UTF-8", "CP1252", '•') . utf8_decode(" Los costos de instalación y viáticos en provincia corren por cuenta del cliente."), 'colspan:1; border:0; font-size:11;');
$tableB->printRow(); //FILAS 4
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:0;');
$tableB->easyCell(iconv("UTF-8", "CP1252", '•') . utf8_decode(" El cliente debe entregarun canalizado (entubado) según la longitud que deba haber entre las
antenas (170 cm etiquetas duras grandes)."), 'colspan:1; border:0; font-size:11;');
$tableB->printRow(); //FILAS 5
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:0;');
$tableB->easyCell(iconv("UTF-8", "CP1252", '•') . utf8_decode(" El canalizado a entregarse deberá de ser en tubo PVCde3/4."), 'colspan:1; border:0; font-size:11;');
$tableB->printRow(); //FILAS 6
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:0;');
$tableB->easyCell(iconv("UTF-8", "CP1252", '•') . utf8_decode(" No colocar prendas o accesorios a menos de 1.00 m de distancia de las antenas."), 'colspan:1; border:0; font-size:11;');
$tableB->printRow(); //FILAS 7
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:0;');
$tableB->easyCell(iconv("UTF-8", "CP1252", '•') . utf8_decode(" Tener corriente de 220v estabilizada con toma a tierra y estabilizador decorriente."), 'colspan:1; border:0; font-size:11;');
$tableB->printRow(); //FILAS 8
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:0;');
$tableB->easyCell(iconv("UTF-8", "CP1252", '•') . utf8_decode(" Todas las instalaciones serán coordinadas previamente con 5 días de anticipación."), 'colspan:1; border:0; font-size:11;');
$tableB->printRow(); //FILAS 9
/** ********************************************************************************************************* */
$tableB->easyCell("", 'colspan:1; border:0;');
$tableB->easyCell(iconv("UTF-8", "CP1252", '•') . utf8_decode(" Brindar al personal técnico y comercial de MAQIND S.A.C. todas las
facilidades e información necesaria para la ejecución de lainstalación."), 'colspan:1; border:0; font-size:11;');
$tableB->printRow(); //FILAS 10

$pdf ->ln(5);

$tableB->easyCell(utf8_decode("Agradecemos de antemano por la atención a la presente y estaremos atentos a cualquier consulta
adicional."), 'colspan:2; border:0; font-size:11;');
$tableB->printRow(); //FILAS 11
$pdf ->ln(5);
$tableB->easyCell(utf8_decode("Cordialmente,"), 'colspan:2; border:0; font-size:11;');
$tableB->printRow(); //FILAS 12
$pdf ->ln(5);
$tableB->easyCell(utf8_decode("Antonio Navarro \n
Soporte Comercial"), 'colspan:2; border:0; font-size:11; font-style:B; line-height:0.5;');
$tableB->printRow(); //FILAS 13
/** ********************************************************************************************************* */
$tableB->endTable(0);

if ($sending == false) {   

   $pdf->Output('Documento de Cotizacion.pdf','I');  

}else{

   $p = $pdf->Output('','S');

   // PHP MAILER SMTP SEND EMAIL ATACHMENTD 
   $mail = new PHPMailer(true);

   try {   
      $mail->SMTPDebug = 0;
      $mail->Debugoutput = 'html';                 
      $mail->isSMTP();    
      // $mail->Mailer     = "smtp";                                        
      $mail->Host       = 'smtp.gmail.com';                   
      $mail->SMTPAuth   = true;                                   
      $mail->Username   = "jesus.alberto.abanto.cruz@gmail.com";      
      $mail->Password   = 'Nevermind2020';                               
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
      $mail->Port       = 587;

      $mail->setFrom('jesus.alberto.abanto.cruz@gmail.com', 'Seguridad Retail');
      // $mail->Timeout=60;
      
      $mail->isHTML(true); 
      $mail->addAddress($rsptap['email']);                                  
      $mail->Subject = utf8_decode('PDF DE COTIZACIÓN');
      $mail->Body    = 'TU PEDIDO EN PDF</b>';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
   
      $mail->AddStringAttachment($p,'Proforma_cotizacion.pdf','base64');
      $mail->send();
      echo 'PDF enviado';
   } catch (Exception $e) {
      echo "Error al enviar mensaje: {$mail->ErrorInfo}";
   }
}
ob_end_flush(); 


?>