<?php 
/*------------------------- 
| 	INCLUIMOS LA CONEXION  | 
-------------------------*/ 
require	"../config/Conexion.php"; 

/*------------------------ 
| 	CLASE PEDIDO GENERAL  | 
------------------------*/ 
Class Pedido
{
   
   //CONSTRUCTOR VACIO 
   public function __construct()
   {
      
   }
    
   /*---------------------------
	| FUNCION GUARDAR REGISTROS | 
	---------------------------*/ 
   public function insertar(){



	}
	

	/*------------------------------
	| FUNCION ACTUALIZAR REGISTROS | 
	------------------------------*/ 
   public function actualizar_pedido($idpedido,$empresa,$tipo_negocio,$ruc,$representante,$cantidad_productos,$telefono,$email,$cantidad_entradas,$total,$estado,$idaccesorio, $idproducto, $cantidad, $precio){

		
		$sql="UPDATE pedido SET nombre_empresa='$empresa',tipo_negocio='$tipo_negocio',ruc='$ruc',nombre_representante='$representante',cantidad_aprox_productos='$cantidad_productos',telefono='$telefono',email='$email',num_entradas='$cantidad_entradas',total='$total',estado='$estado' WHERE idpedido='$idpedido'";
		ejecutarConsulta($sql);

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM detalle_pedido WHERE idpedido='$idpedido'";
		ejecutarConsulta($sqldel);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($cantidad))
			{
				$sql_detalle = "INSERT INTO detalle_pedido(idpedido, idaccesorio, idproducto, cantidad, precio) VALUES('$idpedido', $idaccesorio[$num_elementos], $idproducto[$num_elementos], '$cantidad[$num_elementos]', '$precio[$num_elementos]')";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
				
			}		
		return $sw;	

	}
	

	/*----------------------------------------------------------*
	| FUNCION PARA MODIFICAR DATOS DEL DATATABLE DINAMICAMENTE |
	.----------------------------------------------------------*/
	public function modificardatos($id,$columna_nombre,$valor)
	{
		$sql_update = "UPDATE pedido SET $columna_nombre = '$valor'
		WHERE idpedido = '$id'";
		  return ejecutarConsulta($sql_update);
	}


	/*--------------------------
	| FUNCION LISTAR REGISTROS	| 
	--------------------------*/ 
	public function listar_general() 
	{ 
		$sql="SELECT * FROM pedido 
      ORDER BY idpedido DESC"; 
		return ejecutarConsulta($sql); 
	} 
	

	/*-----------------------------
	| FUNCION LISTAR POR ESTADOS	| 
	-----------------------------*/ 
	// LISTAR PENDIENTES ********************************
		public function listar_pendientes() 
		{ 
			$sql="SELECT * FROM pedido WHERE estado = 0 
			ORDER BY idpedido DESC"; 
			return ejecutarConsulta($sql); 
		}
	// LISTAR PENDIENTES *********************************
		public function listar_atendidos() 
		{ 
			$sql="SELECT * FROM pedido WHERE estado = 1 
			ORDER BY idpedido DESC"; 
			return ejecutarConsulta($sql); 
		} 
	// LISTAR PENDIENTES *********************************
		public function listar_finalizados() 
		{ 
			$sql="SELECT * FROM pedido WHERE estado = 2 
			ORDER BY idpedido DESC"; 
			return ejecutarConsulta($sql); 
		} 
	// LISTAR PENDIENTES *********************************
		public function listar_rechazados() 
		{ 
			$sql="SELECT * FROM pedido WHERE estado = 3 
			ORDER BY idpedido DESC"; 
			return ejecutarConsulta($sql); 			
		}  
   //************************************************** */

   /*--------------------------
	| FUNCION MOSTRAR REGISTROS	| 
	--------------------------*/ 
	public function mostrar($idpedido) 
	{ 
		$sql="SELECT * FROM pedido WHERE idpedido = '$idpedido'
      ORDER BY idpedido DESC"; 
		return ejecutarConsultaSimpleFila($sql); 
	} 

	/*---------------------------
	| FUNCION MOSTRAR REGISTROS | 
	---------------------------*/ 
	public function mostrar_detalle_pedido($idpedido) 
	{ 
		$sql="SELECT dp.iddetalle_pedido,p.idpedido,a.idaccesorio,pto.idproducto, dp.cantidad, dp.precio,pto.nombre producto,pto.descripcion descripcion_producto,a.nombre accesorio,a.descripcion descripcion_accesorio,pto.imagen imagen_producto,a.imagen imagen_accesorio, p.total,p.estado,a.precio_base FROM detalle_pedido dp
		INNER JOIN pedido p ON p.idpedido = dp.idpedido 
		LEFT JOIN producto pto ON pto.idproducto = dp.idproducto
		LEFT JOIN accesorio a ON a.idaccesorio = dp.idaccesorio
		WHERE p.idpedido = '$idpedido'
      ORDER BY p.idpedido DESC"; 
		return ejecutarConsulta($sql); 
	} 


	/*---------------------------
	| ESTADOS DE LA COTIZACION  | 
	---------------------------*/
		/** ACTUALIZAR ESTADO RECHAZADO */ 
		public function rechazar_pedido($idpedido) 
		{ 
			$sql="UPDATE pedido SET estado='3' WHERE idpedido = '$idpedido'"; 
			return ejecutarConsulta($sql); 
		} 	


		/** ACTUALIZAR ESTADO RECHAZADO */ 
		public function cambiar_estado_dinamico($idpedido,$estado) 
		{ 
			$sql="UPDATE pedido SET estado='$estado' WHERE idpedido = '$idpedido'"; 
			return ejecutarConsulta($sql); 
		} 	



}



?>