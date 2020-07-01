<?php
session_start();
require_once "../modelos/Usuario.php";
$usuario=new Usuario();
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
//Declara la variable para evitar error de notificacion
$permisos = isset($_POST['permiso']) ? $_POST['permiso']: null ;
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}
		}
		//Hash SHA256 en la contraseña
			if (strlen($clave)>0){
	      $clavehash=hash("SHA256",$clave);
			}else{
	    	$clavehash="";
			}
		if (empty($idusuario)){
				if (empty($permisos))
				{
					$rspta=$usuario->insertar2($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen);
					echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
				}
				else
				{
					$rspta=$usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$permisos);
					echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
				}
		}
		else {
			if (empty($permisos))
			{
				$rspta=$usuario->editar2($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen);
				echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
			}
			else
			{
				$rspta=$usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$permisos);
				echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
			}
		}
	break;
	case 'verificar_login':
		$rspta=$usuario->verificarlogin();
		$valoreslogin=array();
				while ($val = $rspta->fetch_object())
					{
						array_push($valoreslogin, $val->login);
					}
		echo json_encode($valoreslogin);
	 break;
	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
		echo $rspta ? "Usuario desactivado" : "Usuario no se puede desactivar";
    break;
    case 'activar':
		$rspta=$usuario->activar($idusuario);
		echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
    break;
    case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;
		case 'listar':
			$rspta=$usuario->listar();
			//Vamos a declarar un array
			$data= Array();
			while ($reg=$rspta->fetch_object()){
				$data[]=array(
					"0"=>($reg->condicion)?'<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
						' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>' :
						'<button class="btn btn-dark btn-sm" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
						' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
					"1"=>$reg->nombre,
					"2"=>$reg->tipo_documento,
					"3"=>$reg->num_documento,
					"4"=>$reg->telefono,
					"5"=>$reg->email,
					"6"=>$reg->login,
					"7"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >",
					"8"=>($reg->condicion)?'<span class="label bg-olive">Activado</span>':
					'<span class="label bg-red">Desactivado</span>'
					);
			}
	 		$results = array(
	 			"sEcho"=>1, //Información para el datatables
	 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
	 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
	 			"aaData"=>$data);
	 		echo json_encode($results);
		break;
		case 'permisos':
			//Obtenemos todos los permisos de la tabla permisos
			require_once "../modelos/Permiso.php";
			$permiso = new Permiso();
			$rspta = $permiso->listar();
			//Obtener los permisos asignados al usuario
			$id=$_GET['id'];
			$marcados = $usuario->listarmarcados($id);
			//Declaramos el array para almacenar todos los permisos marcados
			$valores=array();
					//Almacenar los permisos asignados al usuario en el array
					while ($per = $marcados->fetch_object())
						{
							array_push($valores, $per->idpermiso);
						}
					//Mostramos la lista de permisos en la vista y si están o no marcados
					while ($reg = $rspta->fetch_object())
							{
								$sw=in_array($reg->idpermiso,$valores)?'checked':'';
								echo '<li> <input class="permisoscheck" type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->idpermiso.'"> '.$reg->nombre.'</li>';
							}
		break;
				case 'verificar':
					$logina=$_POST['logina'];
				   $clavea=$_POST['clavea'];
		    //Hash SHA256 en la contraseña
					$clavehash=hash("SHA256",$clavea);
					$rspta=$usuario->verificar($logina, $clavehash);
					$fetch=$rspta->fetch_object();
					 if (isset($fetch))
				    {
						 $forOneHour = time() + 3600;
						  if(isset($_POST['remember_me']) && $_POST['remember_me'] == 1)
							{
								setcookie("wdb_email",$logina,$forOneHour,"/");
								setcookie("wdb_password",$clavea,$forOneHour,"/");
								setcookie("wdb_remember_me",$_POST['remember_me'],$forOneHour,"/");
							}
							else
							{
								if(isset($_COOKIE['wdb_email']))
								{
									setcookie("wdb_email","",$forOneHour,"/");
								}
								if(isset($_COOKIE['wdb_password']))
								{
									setcookie("wdb_password","",$forOneHour,"/");
								}
								if(isset($_COOKIE['wdb_remember_me']))
								{
									setcookie("wdb_remember_me","",$forOneHour,"/");
								}
							}
						 //Declaramos las variables de sesión
						 $_SESSION['idusuario']=$fetch->idusuario;
						 $_SESSION['nombre']=$fetch->nombre;
						 $_SESSION['imagen']=$fetch->imagen;
						 $_SESSION['login']=$fetch->login;
						 $_SESSION['cargo']=$fetch->cargo;
						 //Obtenemos los permisos del usuario
				    	$marcados = $usuario->listarmarcados($fetch->idusuario);
				    	//Declaramos el array para almacenar todos los permisos marcados
						$valores=array();
						//Almacenamos los permisos marcados en el array
						while ($per = $marcados->fetch_object())
							{
								array_push($valores, $per->idpermiso);
							}
						//Determinamos los accesos del usuario
						in_array(1,$valores)?$_SESSION['dashboard']=1:$_SESSION['dashboard']=0;
						in_array(2,$valores)?$_SESSION['pedidos']=1:$_SESSION['pedidos']=0;
						in_array(3,$valores)?$_SESSION['productos']=1:$_SESSION['productos']=0;
						in_array(4,$valores)?$_SESSION['accesos']=1:$_SESSION['accesos']=0;
						in_array(5,$valores)?$_SESSION['plantilla']=1:$_SESSION['plantilla']=0;
						in_array(6,$valores)?$_SESSION['reportes']=1:$_SESSION['reportes']=0;
			  }
					echo json_encode($fetch);
				break;
				case 'salir':
					//Limpiamos las variables de sesión
			        session_unset();
			        //Destruìmos la sesión
			        session_destroy();
			        //Redireccionamos al login
			        header("Location: ../index.php");
				break;
			}
			?>
