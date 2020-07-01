<?php
//requerimos conexion y funciones mysqli
require	"../config/Conexion.php";

Class Configuracion{

	//Implementando constructor
	public function __construct()
	{

   }

	/*-----------------------------------------------------
	|	INSERTAR DATOS EMPRESA Y PLANTILLA SIMULTANEAMENTE	|
	-----------------------------------------------------*/
	public function insertar_empresa($razsocial,$ruc,$direccion,$telefono1,$telefono2,$textoSuperior,$colorDominante,$logo,$extra_logo,$icono,$redesSociales)
	{
      $sql_plantilla="INSERT INTO plantilla(textoSuperior,colorDominante,logo,extra_logo,icono,redesSociales)
		VALUES ('$textoSuperior','$colorDominante','$logo','$extra_logo','$icono','$redesSociales')";
		ejecutarConsulta($sql_plantilla);

		$sql="INSERT INTO empresa(razon_social,ruc,direccion,telefono1,telefono2)
		VALUES ('$razsocial','$ruc','$direccion','$telefono1','$telefono2')";
      ejecutarConsulta($sql);

      return true;
	}


	/*-----------------------------------------------------
	|	EDITAR DATOS EMPRESA Y PLANTILLA SIMULTANEAMENTE	|
	-----------------------------------------------------*/
   public function editar_empresa($idempresa,$idplantilla,$razsocial,$ruc,$direccion,$telefono1,$telefono2,$textoSuperior,$colorDominante,$logo,$extra_logo,$icono,$redesSociales)
	{
      $sql_plantilla = "UPDATE plantilla SET textoSuperior='$textoSuperior',colorDominante='$colorDominante',logo='$logo',extra_logo='$extra_logo',icono='$icono',redesSociales='$redesSociales'
      WHERE idplantilla='$idplantilla'";
      ejecutarConsulta($sql_plantilla);

		$sql = "UPDATE empresa SET razon_social='$razsocial',ruc='$ruc',direccion='$direccion',telefono1='$telefono1',telefono2='$telefono2'
		WHERE idempresa='$idempresa'";
      ejecutarConsulta($sql);

      return true;
   }


	/*---------------------
	|	OBTENER IDEMPRESA	 |
	---------------------*/
   public function obtener_idempresa(){
      $sql = "SELECT idempresa FROM empresa";
		return ejecutarConsulta($sql);
   }


	/*-----------------------
	|	OBTENER IDPLANTILLA	|
	-----------------------*/
   public function obtener_idplantilla(){
      $sql = "SELECT idplantilla FROM plantilla";
		return ejecutarConsulta($sql);
	}


	/*-----------------------------------
	|	MOSTRAR CAMPOS ENTIDAD EMPRESA   |
	-----------------------------------*/
   public function mostrar_empresa($id){
      $sql = "SELECT * FROM empresa";
		return ejecutarConsultaSimpleFila($sql);
   }


	/*-------------------------------------
	|	MOSTRAR CAMPOS ENTIDAD PLANTILLA   |
	-------------------------------------*/
   public function mostrar_plantilla($id){
      $sql = "SELECT * FROM plantilla";
		return ejecutarConsultaSimpleFila($sql);
   }


}



?>
