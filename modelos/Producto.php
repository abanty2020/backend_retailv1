<?php 
//Incluimos inicialmente la conexion de la base de datos 
require "../config/Conexion.php"; 
 
Class Producto 
{ 
 
	//Implementando constructor 
	public function __construct() 
	{ 
 
	} 
 
	//Implementamos un metodo para inserta registros 
	public function insertar($idcategoria,$idsubcategoria,$nombre,$descripcion,$rango,$rango_option,$stock,$imagen) 
	{ 
		$sql="INSERT INTO producto(idcategoria,idsubcategoria,nombre,descripcion,rango,rango_option,stock,imagen,nuevo,estado) 
		VALUES ('$idcategoria','$idsubcategoria','$nombre','$descripcion','$rango','$rango_option','$stock','$imagen','1','1')";		 
		 
		$idproductonew=ejecutarConsulta_retornarID($sql); 
		setlocale(LC_ALL, "en_US.utf8");  
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)('), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo  '); 
		$ruta = strtolower(str_replace(" ", "-", $val)); 
		$sw = true;		 
		$sqlupdate = "UPDATE producto SET ruta='$ruta-$idproductonew' WHERE idproducto='$idproductonew'"; 
		ejecutarConsulta($sqlupdate) or $sw = false; 
		 
		return $sw; 
 
	} 
 
	//Implementar un metodo para editar registros 
	public function editar($idproducto,$idcategoria,$idsubcategoria,$nombre,$descripcion,$rango,$rango_option,$stock,$imagen) 
	{ 
		$sql = "UPDATE producto SET idcategoria='$idcategoria',idsubcategoria='$idsubcategoria',nombre='$nombre',descripcion='$descripcion', 
      rango='$rango',rango_option='$rango_option',stock='$stock',imagen='$imagen' 
		WHERE idproducto='$idproducto'"; 
		return ejecutarConsulta($sql); 
	} 
 
	//Implementamos un metodo para desactivar productos 
	public function desactivar($idproducto) 
	{ 
		$sql="UPDATE producto SET estado='0' WHERE idproducto = '$idproducto'"; 
		return ejecutarConsulta($sql); 
	} 
 
	//Implementamos un metodo para activar productos 
	public function activar($idproducto) 
	{ 
		$sql="UPDATE producto SET estado='1' WHERE idproducto = '$idproducto'"; 
		return ejecutarConsulta($sql); 
	} 
 
	//Implementar un metodo para mostrar los datos de un registro a modificar 
	public function mostrar ($idproducto) 
	{ 
		$sql="SELECT p.idproducto,p.idcategoria,p.idsubcategoria,p.nombre,c.nombre as categoria,sc.nombre as subcategoria,p.descripcion,p.rango,p.rango_option,p.stock,p.imagen,p.estado 
		FROM producto p 
		INNER JOIN categoria c on p.idcategoria = c.idcategoria 
		INNER JOIN subcategoria sc on p.idsubcategoria = sc.idsubcategoria 
		WHERE idproducto='$idproducto'"; 
		return ejecutarConsultaSimpleFila($sql); 
	} 
 
	//Implementar un metodo para listar los registros relacionados con otras tablas 
	public function listar() 
	{
		$sql="SELECT p.idproducto,p.idcategoria,p.idsubcategoria,p.nombre,c.nombre as categoria,c.color as color,sc.nombre as subcategoria,p.descripcion,p.rango,p.stock,p.imagen,p.estado 
		FROM producto p 
		INNER JOIN categoria c on p.idcategoria = c.idcategoria 
		INNER JOIN subcategoria sc on p.idsubcategoria = sc.idsubcategoria 
		ORDER BY idproducto DESC"; 
		return ejecutarConsulta($sql); 
	} 
 
	//Implementar un metodo para listar los registros 
	public function listar_solo() 
	{
		$sql="SELECT * FROM producto 
		ORDER BY idproducto ASC"; 
		return ejecutarConsulta($sql); 
	} 
 
	//Implementar un metodo para listar los registros por parametro idaccesorio
	public function listar_producto($idaccesorio) 
	{
		$sql="SELECT p.idproducto,p.nombre,ap.uso_option FROM producto p 
		INNER JOIN accesorio_producto ap 
		ON p.idproducto = ap.idproducto 
		INNER JOIN accesorio a 
		ON ap.idaccesorio = a.idaccesorio 
		WHERE a.idaccesorio = '$idaccesorio'"; 
		return ejecutarConsulta($sql); 
	}
	//Implementar un metodo para listar los registros y mostrar en el select
	public function selectpro()
	{
		$sql="SELECT * FROM producto WHERE estado=1";
		return ejecutarConsulta($sql);
	}
}
