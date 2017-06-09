<?php
	setlocale(LC_ALL,"es_ES"); 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
	<head>
    	<link rel="stylesheet" href="../../estilos/estilo_video.css" type="text/css"/>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cursos</title>
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
						<li><a href="./altaCurso.php">A&ntilde;adir Curso</a></li>
						<li><a href="./eliminarCurso.php">Eliminar Curso</a></li>
						<li><a href="./consultarCurso.php">Consultar Curso</a></li>
						<li><a href="./modificarCurso.php">Modificar Curso</a></li>
						<li><a href="./listarAlumnosCurso.php">Listar Alumnos por Cursos </a></li>
						<li><a href="./listarProfesorCursos.php">Listar Profesor por Cursos </a></li>
						<li><a href="./altaAlumnoCurso.php">A&ntilde;adir Alumno a Curso</a></li>
						<li><a href="./bajaAlumnoCurso.php">Baja Alumno de curso</a></li>
					</ul>
                </div>
                <div id="contenido">
                    <fieldset>
                        <legend>Datos del Curso</legend>						
						<?php
						
							// Establecemos la conexión con la base de datos
							include("../../conexion.php");
							
							// Si se ha enviado el formulario de modificar hacemos los cambios en la base de datos
							// y se han rellenado todos los campos obligatorios.
							
							if (isset($_REQUEST['bModificar']) && $_REQUEST['tNombre']!='' && $_REQUEST['tDescripcion']!=''){				
								//Realizamos la consulta de modificación.
								$sentencia = 'UPDATE curso 
								SET Nombre="' . $_REQUEST['tNombre'] . '", Descripcion="' . $_REQUEST['tDescripcion'] . '", creditos=' . $_REQUEST['tCreditos'] . ' 
								where cod_curso = '.$_REQUEST['hCurso'].';';
																
								// Ejecutamos la sentencia y liberamos la variable de aceptación del segundo formulario.
								if (mysql_query($sentencia, $conexion)){
									echo "La modificación se realizó correctamente.";
									unset($_REQUEST['bModificar']);
								}else{
									echo "La modificación se no realizó correctamente.";
								}

							}else{ // Si no
								// Si hemos enviado el primer formulario de búsqueda cargamos el segundo formualario
								if (isset($_REQUEST['bBuscar']) || isset($_REQUEST['bModificar']) ){
									// Si hay datos en el primer formulario
									if (!empty($_REQUEST['tLista'])){
										$sentencia = 'SELECT * 
										FROM curso 
										WHERE Cod_Curso='. $_REQUEST['tLista'] . ';';
																			
										// Ejecutamos la sentencia.
										$resultado = mysql_query($sentencia, $conexion)
											or die ("La consulta no se ha podido realizar correctamente.");
										$fila = mysql_fetch_array($resultado);
										
										// Si el formulario no se ha enviado con todos los campos obligatorios.					
										if (isset($_REQUEST['bModificar']) && ($_REQUEST['tNombre']=='' || $_REQUEST['tDescripcion']=='')){
											echo "Revise todos los campos obligatorios </br>";
										}
										
						?>
							<form id="modificarCurso2" method="post" name="modificarCurso2" action="./modificarCurso.php">
								<table>
									<tr>
										<td><label>Nombre</label></td>
										<td><input name="tNombre" type="text" size="50" maxlength="30" tabindex="1" value="<?php if(isset($_REQUEST['bModificar'])) echo $_REQUEST['tNombre']; else echo $fila['Nombre']?>" required="required"/></td>
									</tr>
									<tr>
										<td><label>Descripci&oacute;n</label></td>
										<td><textarea name="tDescripcion" cols="100" tabindex="2" required="required"><?php if(isset($_REQUEST['bModificar'])) echo $_REQUEST['tDescripcion']; else echo $fila['Descripcion']?></textarea></td>
									</tr>
									<tr>
										<td><label>Cr&eacute;ditos</label></td>
										<td><input name="tCreditos" type="text" onblur="validacion(tCreditos);" size="20" maxlength="20" tabindex="2" value="<?php if(isset($_REQUEST['bModificar'])) echo $_REQUEST['tCreditos']; else echo $fila['Creditos'];?>"/></td>
									</tr> 
										<td><input type="hidden" name="hCurso" value="<?php echo $_REQUEST['tLista']; ?>"/>
										</td>
										<td>
											<input name="bModificar" type="submit" value="Modificar" tabindex="3"/>
										</td>
									</tr> 
								</table> 
							</form>
							<?php
									}else{
										echo "No hay cursos para modificar. <br>";
									}
								}else{
							?>
							<form id="modificarCurso" method="post" name="modificarCurso" action="./modificarCurso.php">
								<table>
									<tr>
										<td><label>Curso</label></td>
										<td>
											<select name="tLista">
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
											</select>
											</td>
										<td>
											<input type="submit" name="bBuscar" value="Buscar"/>
										</td>
									</tr>
								</table>
							</form>
					<?php
							}
						}
					?>
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