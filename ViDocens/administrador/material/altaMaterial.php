<?php
	setlocale(LC_ALL,"es_ES"); 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
	<head>
    	<link rel="stylesheet" href="../../estilos/estilo_video.css" type="text/css"/>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Material</title>
        <script type="text/javascript" src="../../javascript/ejercicio_video.js"></script>
    </head>
    <body>
		<?php
			if (isset($_SESSION['tipoUsuario'])&& $_SESSION['tipoUsuario']==0){
		?>
        <div id="contenedor">
            <div id="cabecera">
                <h1>Bienvenido, administrador.</h1>
            </div>        	        	
            <div id="menu">
	       		<ul>	
                	<li><a href="../index_admin.php">Inicio</a></li>
                	<li><a href="../profesores/consultarProfesores.php">Profesores</a></li>
                	<li><a href="../cursos/consultarCurso.php">Cursos</a></li>
                	<li><a href="../alumnos/consultarAlumno.php">Alumnos</a></li>
                	<li><a href="../material/altaMaterial.php">Material</a></li>
                	<li><a href="../BD/consultarCopias.php">Base de Datos</a></li>
                	<li><a href="../admin/consultarAdmin.php">Mis Datos</a></li>
					<li><a href="../../identificacion.php">Cerrar Sesi&oacute;n</a></li>
                </ul>
            </div> 
            <div id="cuerpo">
                <div id="lat_izquierdo">
					<ul>
						<li><a href="./altaMaterial.php">A&ntilde;adir Material</a></li>
						<li><a href="./bajaMaterialCurso.php">Eliminar Material</a></li>
						<li><a href="./consultarMaterial.php">Consultar Material</a></li>
						<li><a href="./modificarMaterial.php">Modificar Material</a></li>
						<li><a href="./VerMaterial.php">Ver Material por Curso</a></li>
					</ul>
                </div>
                <div id="contenido">
					<?php
					// Establecemos la conexión con la base de datos
					include("../../conexion.php");
					?>
                    <fieldset>
                        <legend>Datos del Curso</legend>						
					<?php
						// Si hemos enviado el formulario.
						if (isset($_REQUEST['bEnviar'])){
							
							// Si se ha introducido nombre al archivo y un archivo.
							if (($_REQUEST['tNombre']!='' || !$_FILES['fArchivo']['tmp_name']) && !empty($_REQUEST['tLista'])){
						
							// Establecemos el directorio en el que queremos guardar el fichero
							
							$directorio = "../../material/".$_REQUEST['tLista'];
								
								// Si el directorio no existe lo creamos y le damos todos los permisos.
								if (!file_exists($directorio)){
									mkdir($directorio,0777);
								}
								
								// Aquí indicamos donde vamos a guardar los videos. Lo guardaremos en una carpeta con el código del curso en la carpeta material en el directorio raíz.
								$_FILES['fArchivo']['name'] = "../../material/".$_REQUEST['tLista']."/".$_REQUEST['tNombre'].".mp4";
								// Sí el archivo es en MP4 realizamos la subida y la inserción en la base de datos.
								if ($_FILES['fArchivo']['type'] =='video/mp4'){
									
									// Comprobamos si existe otro video con el mismo nombre en la base de datos.
									$sentencia = 'SELECT descripcion 
									from material 
									where descripcion="'.$_REQUEST['tNombre'].'"
										and cod_curso = '.$_REQUEST['tLista'].';';
									
									$resultado = mysql_query($sentencia, $conexion);
									
									if (mysql_num_rows($resultado)==0){
									
										// Realizamos la inserción en la base de datos 
										
										$sentencia = 'insert into material (cod_curso, descripcion, fechaSubida, rutaFichero)
										values ('.$_REQUEST['tLista'].',"'.$_REQUEST['tNombre'].'", CURDATE(),"'.$_FILES['fArchivo']['name'].'");';
										
										if (mysql_query($sentencia, $conexion)){
											
											// Si el archivo está cargado podemos seguir con la inserción y la copia al directorio anterior.
											if (is_uploaded_file($_FILES['fArchivo']['tmp_name'])){
												// Realizamos la copia a la carpeta
												move_uploaded_file($_FILES['fArchivo']['tmp_name'], $_FILES['fArchivo']['name']);
												echo "El video se subió con éxito <br>";
											}else{
												switch($_FILES['fArchivo']['error']){
													case UPLOAD_ERR_OK: // No hay error, pero puede ser un ataque
														echo "Se ha producido algún problema con la carga";
														break;
													case UPLOAD_ERR_INI_SIZE: // Tamaño mayor de upload_max_filesize
														echo "Fichero demasiado grande: No se puede cargar";
														break;
													case UPLOAD_ERR_FORM_SIZE: // Tamaño mayor que MAX_FILE_SIZE
														echo "Fichero demasiado grande: No se puede cargar";
														break;
													case UPLOAD_ERR_PARTIAL: // Sólo se ha cargado parte del fichero
														echo "Sólo se ha cargado parte del fichero";
														break;
													case UPLOAD_ERR_NO_FILE: // No se ha cargado ningún fichero
														echo "Debe elegir un fichero para cargar";
														break;
													case UPLOAD_ERR_NO_TMP_DIR: //No hay directorio temporal
														echo "Problemas con el directorio temporal";
														break;
													default: // Error por defecto
														echo "Ha habido un error en la carga";
														break;
												}
											}
										}else{
											echo "No se ha podido almacenar el archivo <br>";
										}
									}else{
										echo "Ya existe un archivo con ese nombre. Pruebe a cambiarlo o asegúrese que no es el mismo. <br>";
									}
								}else{
										echo "El archivo debe tener la extensión MP4 <br>";
								}
							}else{
								echo "Introduzca un nombre o asegúrese de haber seleccionado el archivo. <br>";
							}
						}
						?>
							<form action="altaMaterial.php" method="post" enctype="multipart/form-data">
								<table>
									<tr>
										<td><label>Curso</label></td>
										<td><select name="tLista">
											<?php
												// Seleccionamos todos los cursos para cargarlos en el select.
												
												$sentencia = 'SELECT Cod_Curso, Nombre, Descripcion 
												from curso 
												order by nombre;';
												$resultado = mysql_query($sentencia, $conexion);
												
												while ($fila = mysql_fetch_array($resultado)){
												?>
											<option value="<?php echo $fila['Cod_Curso']; ?>"><?php echo $fila['Nombre'] ." - " . $fila['Descripcion']; ?></option>
											<?php 
												}
												?>
										</select></td>
									</tr>
									<tr>
										<td>Nombre del Archivo</td>
										<td><input type="text" name="tNombre" required="required"></td>
									</tr>
									<tr>
										<td><input type="hidden" name="MAX_FILE_SIZE" value="10485760">Seleccione archivo: </td>
										<td><input name="fArchivo" type="file" accept=".mp4" required="required"/></td>
									</tr>
									<tr>
										<td colspan="2" align="center">
											<input type="submit" value="Enviar" name="bEnviar"> 
											<input type="reset" value="Limpiar Campos" name="bReset"/>
										</td>
									</tr>
								</table>
							</form>
                    </fieldset>               	
                </div>
                <div id="lat_derecho">
                </div>
            </div>
          	<div id="pie">
                    Hoy es <?php echo strftime("%A %d de %B del %Y");
					mysql_close($conexion); ?>
        	</div>
        </div>
		<?php
			}else{ echo "No tiene privilegios para acceder a esta información <br>";}
		?>
    </body>
</html>
