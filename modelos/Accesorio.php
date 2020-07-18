<?php 
/*--------------------------- 
| 	INCLUIMOS LA CONEXION		| 
---------------------------*/ 
require	"../config/Conexion.php"; 
 
Class Accesorio 
{ 
 
	//Implementando constructor 
	public function __construct() 
	{ 
 
	} 
 
	/*--------------------------- 
	| FUNCION GUARDAR REGISTROS	| 
	---------------------------*/ 
	public function insertar_full($nombre,$precio_base,$tipo_accesorio, $rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,$style,$idproducto,$uso_option,$idtipo_producto) 
	{ 
		$sql="INSERT INTO accesorio(nombre,precio_base,tipo_accesorio,rango_option,rango,cantidad_min_option,cantidad_min,descripcion,imagen,color,style,nuevo,estado) 
		VALUES ('$nombre','$precio_base','$tipo_accesorio','$rango_option','$rango','$cantidad_min_option','$cantidad_min','$descripcion','$imagen','$color','$style','1','1')"; 
 
		$idaccesorionew=ejecutarConsulta_retornarID($sql); 
		setlocale(LC_ALL, "en_US.utf8");  
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)(.'), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo   '); 
		$ruta = strtolower(str_replace(" ", "-", $val)); 
 
		$num_elementos=0; 
		$num_elementos_tp=0; 
		$sw=true; 
 
		$sqlupdate = "UPDATE accesorio SET ruta='$ruta-$idaccesorionew' WHERE idaccesorio='$idaccesorionew'"; 
		ejecutarConsulta($sqlupdate); 
 
			while ($num_elementos_tp < count($idtipo_producto)) 
			{ 
				$sql_detalle_tp = "INSERT INTO accesorio_tipo_producto(idaccesorio,idtipo_producto) 
				VALUES ('$idaccesorionew','$idtipo_producto[$num_elementos_tp]')"; 
				ejecutarConsulta($sql_detalle_tp) or $sw = false; 
				$num_elementos_tp=$num_elementos_tp + 1; 
			} 
 
			while ($num_elementos < count($idproducto)) 
			{ 
				$sql_detalle = "INSERT INTO accesorio_producto(idaccesorio,idproducto,uso_option) 
				VALUES ('$idaccesorionew','$idproducto[$num_elementos]','$uso_option[$num_elementos]')"; 
				ejecutarConsulta($sql_detalle) or $sw = false; 
				$num_elementos=$num_elementos + 1; 
			} 
			return $sw; 
	} 
 
	/*--------------------------------------------------------- 
	| FUNCION GUARDAR REGISTROS CON DETALLE SIN TIPO PRODUCTO	| 
	---------------------------------------------------------*/ 
	public function insertar_full_sin_tp($nombre,$precio_base,$tipo_accesorio,$rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,$style,$idproducto,$uso_option) 
	{ 
		$sql="INSERT INTO accesorio(nombre,precio_base,tipo_accesorio,rango_option,rango,cantidad_min_option,cantidad_min,descripcion,imagen,color,style,nuevo,estado) 
		VALUES ('$nombre','$precio_base','$tipo_accesorio','$rango_option','$rango','$cantidad_min_option','$cantidad_min','$descripcion','$imagen','$color','$style','1','1')"; 
 
		$idaccesorionew=ejecutarConsulta_retornarID($sql); 
		setlocale(LC_ALL, "en_US.utf8");  
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)('), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo  '); 
		$ruta = strtolower(str_replace(" ", "-", $val)); 
 
		$num_elementos=0; 
		$sw=true; 
 
		$sqlupdate = "UPDATE accesorio SET ruta='$ruta-$idaccesorionew' WHERE idaccesorio='$idaccesorionew'"; 
		ejecutarConsulta($sqlupdate); 
 
			while ($num_elementos < count($idproducto)) 
			{ 
				$sql_detalle = "INSERT INTO accesorio_producto(idaccesorio,idproducto,uso_option) 
				VALUES ('$idaccesorionew','$idproducto[$num_elementos]','$uso_option[$num_elementos]')"; 
				ejecutarConsulta($sql_detalle) or $sw = false; 
				$num_elementos=$num_elementos + 1; 
			} 
			return $sw; 
	} 
 
	/*--------------------------------------- 
	| FUNCION GUARDAR REGISTROS SIN DETALLE	| 
	---------------------------------------*/ 
	public function insertar_solo_accesorio_con_tp($nombre,$precio_base,$tipo_accesorio, $rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,$style,$idtipo_producto) 
	{ 
		$sql="INSERT INTO accesorio(nombre,precio_base,tipo_accesorio,rango_option,rango,cantidad_min_option,cantidad_min,descripcion,imagen,color,style,nuevo,estado) 
		VALUES ('$nombre','$precio_base','$tipo_accesorio','$rango_option','$rango','$cantidad_min_option','$cantidad_min','$descripcion','$imagen','$color','$style','1','1')"; 
 
		$idaccesorionew=ejecutarConsulta_retornarID($sql); 
		setlocale(LC_ALL, "en_US.utf8");  
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)('), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo  '); 
		$ruta = strtolower(str_replace(" ", "-", $val)); 
 
		$num_elementos_tp=0; 
		$sw=true; 
 
		$sqlupdate = "UPDATE accesorio SET ruta='$ruta-$idaccesorionew' WHERE idaccesorio='$idaccesorionew'"; 
		ejecutarConsulta($sqlupdate); 
 
		while ($num_elementos_tp < count($idtipo_producto)) 
		{ 
			$sql_detalle_tp = "INSERT INTO accesorio_tipo_producto(idaccesorio,idtipo_producto) 
			VALUES ('$idaccesorionew','$idtipo_producto[$num_elementos_tp]')"; 
			ejecutarConsulta($sql_detalle_tp) or $sw = false; 
			$num_elementos_tp=$num_elementos_tp + 1; 
		} 
 
		return $sw; 
	} 
 
	/*--------------------------------------------------------- 
	| FUNCION GUARDAR REGISTROS SIN DETALLE NI TIPO PRODUCTO	| 
	---------------------------------------------------------*/ 
	public function insertar_solo_accesorio_sin_tp($nombre,$precio_base,$tipo_accesorio, $rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,$style) 
	{ 
		$sql="INSERT INTO accesorio(nombre,precio_base,tipo_accesorio,rango_option,rango,cantidad_min_option,cantidad_min,descripcion,imagen,color,style,nuevo,estado) 
		VALUES ('$nombre','$precio_base','$tipo_accesorio','$rango_option','$rango','$cantidad_min_option','$cantidad_min','$descripcion','$imagen','$color','$style','1','1')"; 
 
		$idaccesorionew=ejecutarConsulta_retornarID($sql); 
		setlocale(LC_ALL, "en_US.utf8");  
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)('), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo  '); 
		$ruta = strtolower(str_replace(" ", "-", $val)); 
		$sw = true; 
		$sqlupdate = "UPDATE accesorio SET ruta='$ruta-$idaccesorionew' WHERE idaccesorio='$idaccesorionew'"; 
		ejecutarConsulta($sqlupdate); 
 
		return $sw; 
	} 
 
	/*--------------------------- 
	| FUNCION EDITAR REGISTROS	| 
	---------------------------*/ 
	public function editar($idaccesorio,$nombre,$precio_base,$tipo_accesorio, $rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,$style,$idproducto,$uso_option,$idtipo_producto) 
	{ 
		setlocale(LC_ALL, "en_US.utf8");  
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)(.'), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo   '); 
		$ruta = strtolower(str_replace(" ", "-", $val)); 

		$sql = "UPDATE accesorio SET idaccesorio='$idaccesorio',nombre='$nombre',precio_base='$precio_base',tipo_accesorio='$tipo_accesorio',rango_option='$rango_option',rango='$rango', 
		cantidad_min_option='$cantidad_min_option',cantidad_min='$cantidad_min',descripcion='$descripcion',imagen='$imagen',ruta='$ruta-$idaccesorio', 
		color='$color',style='$style' 
		WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sql); 
 
		//Eliminamos todos los permisos asignados para volverlos a registrar 
		$sqldel="DELETE FROM accesorio_producto WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sqldel); 
 
		//Eliminamos todos los permisos asignados para volverlos a registrar 
		$sqldeltp="DELETE FROM accesorio_tipo_producto WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sqldeltp); 
 
		$num_elementos_tp=0; 
		$num_elementos=0; 
		$sw=true; 
 
		while ($num_elementos_tp < count($idtipo_producto)) 
		{ 
			$sql_detalle_tp = "INSERT INTO accesorio_tipo_producto(idaccesorio,idtipo_producto) 
			VALUES ('$idaccesorio','$idtipo_producto[$num_elementos_tp]')"; 
			ejecutarConsulta($sql_detalle_tp) or $sw = false; 
			$num_elementos_tp=$num_elementos_tp + 1; 
		} 
 
		while ($num_elementos < count($idproducto)) 
		{ 
			$sql_detalle = "INSERT INTO accesorio_producto(idaccesorio,idproducto,uso_option) 
			VALUES ('$idaccesorio', '$idproducto[$num_elementos]', '$uso_option[$num_elementos]')"; 
			ejecutarConsulta($sql_detalle) or $sw = false; 
			$num_elementos=$num_elementos + 1; 
		} 
		return $sw; 
	} 
 
	/*------------------------------------------------- 
	| FUNCION EDITAR REGISTROS SIN CAMPO OBLIGATORIO	| 
	-------------------------------------------------*/ 
	public function editar2($idaccesorio,$nombre,$precio_base,$tipo_accesorio, $rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,$style,$idtipo_producto) 
	{ 
		setlocale(LC_ALL, "en_US.utf8");  
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)(.'), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo   '); 
		$ruta = strtolower(str_replace(" ", "-", $val)); 

		$sql = "UPDATE accesorio SET idaccesorio='$idaccesorio',nombre='$nombre',precio_base='$precio_base',tipo_accesorio='$tipo_accesorio',rango_option='$rango_option',rango='$rango', 
		cantidad_min_option='$cantidad_min_option',cantidad_min='$cantidad_min',descripcion='$descripcion',imagen='$imagen',ruta='$ruta-$idaccesorio',
		color='$color',style='$style' 
		WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sql); 
 
		//Eliminamos todos los permisos asignados para volverlos a registrar 
		$sqldel="DELETE FROM accesorio_producto WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sqldel); 
 
		//Eliminamos todos los permisos asignados para volverlos a registrar 
		$sqldeltp="DELETE FROM accesorio_tipo_producto WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sqldeltp); 
 
		$num_elementos_tp=0; 
		$sw=true; 
 
		while ($num_elementos_tp < count($idtipo_producto)) 
		{ 
			$sql_detalle_tp = "INSERT INTO accesorio_tipo_producto(idaccesorio,idtipo_producto) 
			VALUES ('$idaccesorio','$idtipo_producto[$num_elementos_tp]')"; 
			ejecutarConsulta($sql_detalle_tp) or $sw = false; 
			$num_elementos_tp=$num_elementos_tp + 1; 
		} 
 
		return $sw; 
 
	} 
 
	/*--------------------------------------------------------- 
	| FUNCION EDITAR REGISTROS CON DETALLE SIN TIPO PRODUCTO	| 
	---------------------------------------------------------*/ 
	public function editar4($idaccesorio,$nombre,$precio_base,$tipo_accesorio, $rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,$style,$idproducto,$uso_option) 
	{ 
		setlocale(LC_ALL, "en_US.utf8");  
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)(.'), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo   '); 
		$ruta = strtolower(str_replace(" ", "-", $val)); 

		$sql = "UPDATE accesorio SET idaccesorio='$idaccesorio',nombre='$nombre',precio_base='$precio_base',tipo_accesorio='$tipo_accesorio',rango_option='$rango_option',rango='$rango', 
		cantidad_min_option='$cantidad_min_option',cantidad_min='$cantidad_min',descripcion='$descripcion',imagen='$imagen', ruta='$ruta-$idaccesorio',
		color='$color',style='$style' 
		WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sql); 
 
		//Eliminamos todos los permisos asignados para volverlos a registrar 
		$sqldel="DELETE FROM accesorio_producto WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sqldel); 
 
		//Eliminamos todos los permisos asignados para volverlos a registrar 
		$sqldeltp="DELETE FROM accesorio_tipo_producto WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sqldeltp); 
 
		$num_elementos=0; 
		$sw=true; 
 
		while ($num_elementos < count($idproducto)) 
		{ 
			$sql_detalle = "INSERT INTO accesorio_producto(idaccesorio,idproducto,uso_option) 
			VALUES ('$idaccesorio', '$idproducto[$num_elementos]', '$uso_option[$num_elementos]')"; 
			ejecutarConsulta($sql_detalle) or $sw = false; 
			$num_elementos=$num_elementos + 1; 
		} 
		return $sw; 
	} 
 
	/*----------------------------------------------------------------- 
	| FUNCION EDITAR REGISTROS SIN CAMPO OBLIGATORIO NI TIPO PRODUCTO	| 
	-----------------------------------------------------------------*/ 
	public function editar3($idaccesorio,$nombre,$precio_base,$tipo_accesorio, $rango_option,$rango,$cantidad_min_option,$cantidad_min,$descripcion,$imagen,$color,$style) 
	{ 
		setlocale(LC_ALL, "en_US.utf8");  
		$val = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ)(.'), 'AAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo   '); 
		$ruta = strtolower(str_replace(" ", "-", $val)); 
		
		$sql = "UPDATE accesorio SET idaccesorio='$idaccesorio',nombre='$nombre',precio_base='$precio_base',tipo_accesorio='$tipo_accesorio',rango_option='$rango_option',rango='$rango', 
		cantidad_min_option='$cantidad_min_option',cantidad_min='$cantidad_min',descripcion='$descripcion',imagen='$imagen', ruta='$ruta-$idaccesorio',
		color='$color',style='$style' 
		WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sql); 
 
		//Eliminamos todos los permisos asignados para volverlos a registrar 
		$sqldel="DELETE FROM accesorio_producto WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sqldel); 
 
		//Eliminamos todos los permisos asignados para volverlos a registrar 
		$sqldeltp="DELETE FROM accesorio_tipo_producto WHERE idaccesorio='$idaccesorio'"; 
		ejecutarConsulta($sqldeltp); 
 
		return ejecutarConsulta($sql); 
 
	} 
 
	/*------------------------------- 
	| FUNCION DESACTIVAR REGISTROS	| 
	-------------------------------*/ 
	public function desactivar($idaccesorio) 
	{ 
		$sql="UPDATE accesorio SET estado='0' WHERE idaccesorio = '$idaccesorio'"; 
		return ejecutarConsulta($sql); 
	} 
 
	/*--------------------------- 
	| FUNCION ACTIVAR REGISTROS	| 
	---------------------------*/ 
	public function activar($idaccesorio) 
	{ 
		$sql="UPDATE accesorio SET estado='1' WHERE idaccesorio = '$idaccesorio'"; 
		return ejecutarConsulta($sql); 
	} 
 
	/*------------------------------- 
	| FUNCION MOSTRAR REGISTROS	| 
	-------------------------------*/ 
	public function mostrar ($idaccesorio) 
	{ 
		$sql="SELECT * FROM accesorio 
		WHERE idaccesorio='$idaccesorio'"; 
		return ejecutarConsultaSimpleFila($sql); 
	} 
 
	/*--------------------------- 
	| FUNCION LISTAR REGISTROS	| 
	---------------------------*/ 
	public function listar() 
	{ 
		$sql="SELECT * FROM accesorio 
      ORDER BY idaccesorio DESC"; 
		return ejecutarConsulta($sql); 
	} 
 
	/*--------------------------- 
	| FUNCION LISTAR REGISTROS	| 
	---------------------------*/ 
	public function listar_tipoproductos_seleccionados($idaccesorio) 
	{ 
		$sql="SELECT * FROM accesorio_tipo_producto 
		WHERE idaccesorio = $idaccesorio"; 
		return ejecutarConsulta($sql); 
	} 
 
	/*----------------------------------- 
	| FUNCION LISTAR OPCIONES MARCADAS	| 
	-----------------------------------*/ 
	public function listar_marcados_productos_opciones($idaccesorio) 
	{ 
		$sql="SELECT * FROM accesorio_producto WHERE idaccesorio='$idaccesorio'"; 
		return ejecutarConsulta($sql); 
	} 
 
	/*-------------------------------- 
	| FUNCION SELECCIONAR ACCESORIOS | 
	--------------------------------*/ 
	public function selectaccesorio() 
	{ 
		$sql="SELECT * FROM accesorio WHERE estado=1"; 
		return ejecutarConsulta($sql); 
	} 
 
	/*----------------------------------- 
	| FUNCION SELECCIONAR TIPO PRODUCTO | 
	-----------------------------------*/ 
	public function select_tipo_producto() 
	{ 
		$sql="SELECT * FROM tipo_producto WHERE estado=1"; 
		return ejecutarConsulta($sql); 
	} 
 
}
