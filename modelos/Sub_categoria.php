<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";
Class Sub_categoria
{
	//Implementando constructor
	public function __construct()
	{
	}
	//Implementamos un metodo para inserta registros
	public function insertar($idcategoria,$nombre,$descripcion,$observador)
	{		
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)('), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo  '); 
		$ruta = strtolower(str_replace(" ", "-", ($val))); 
		$obs = $observador == true ?'1':'0';

		$sql="INSERT INTO subcategoria (idcategoria,nombre,descripcion,ruta,observador,estado)
		VALUES ('$idcategoria','$nombre','$descripcion','$ruta','$obs','1')";
		return ejecutarConsulta($sql);
	}
	//Implementar un metodo para editar registros
	public function editar($idsubcategoria,$idcategoria,$nombre,$descripcion,$observador)
	{
		$obs = $observador == true ?'1':'0';
		$sql = "UPDATE subcategoria SET idcategoria = '$idcategoria', nombre='$nombre', descripcion='$descripcion', observador='$obs'
		WHERE idsubcategoria='$idsubcategoria'";
		return ejecutarConsulta($sql);
	}
	//Implementamos un metodo para desactivar subcategorias
	public function desactivar($idsubcategoria)
	{
		$sql="UPDATE subcategoria SET estado='0' WHERE idsubcategoria = '$idsubcategoria'";
		return ejecutarConsulta($sql);
	}
	//Implementamos un metodo para activar subcategorias
	public function activar($idsubcategoria)
	{
		$sql="UPDATE subcategoria SET estado='1' WHERE idsubcategoria = '$idsubcategoria'";
		return ejecutarConsulta($sql);
	}
	//Implementar un metodo para mostrar los datos de un registro a modificar
	public function mostrar ($idsubcategoria)
	{
		$sql="SELECT * FROM subcategoria WHERE idsubcategoria='$idsubcategoria'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Implementar un metodo para listar los registros
	public function listar()
	{
		$sql="SELECT s.idsubcategoria,s.idcategoria,c.nombre as categoria, c.color ,s.nombre,s.descripcion,s.estado
		FROM subcategoria s INNER JOIN categoria c
		ON c.idcategoria = s.idcategoria ORDER BY  s.idsubcategoria DESC; ";
		return ejecutarConsulta($sql);
	}
	//Implementar un metodo para listar los registros y mostrar en el select
	public function selectsubcat()
	{
		$sql="SELECT * FROM subcategoria WHERE estado=1";
		return ejecutarConsulta($sql);
	}
	//Implementar un metodo para listar los registros y mostrar en el select
	public function selectsubcatid($idcategoria)
	{
		$sql="SELECT * FROM subcategoria WHERE estado=1 and idcategoria = '$idcategoria'";
		return ejecutarConsulta($sql);
	}
}
 ?>
