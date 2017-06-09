<?php 
	setlocale(LC_ALL, "es_ES");
	session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
	<head>
    	<link rel="stylesheet" href="../../estilos/estilo_video.css" type="text/css"/>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Profesores</title>
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
						<li><a href="./altaProfesor.php">A&ntilde;adir Profesor</a></li>
						<li><a href="./eliminarProfesor.php">Eliminar Profesor</a></li>
						<li><a href="./consultarProfesores.php">Consultar Profesor</a></li>
						<li><a href="./modificarProfesor.php">Modificar Profesor</a></li>
						<li><a href="./listarProfesorCursos.php">Listar Cursos por Profesor</a></li>
						<li><a href="./altaProfesorCurso.php">A&ntilde;adir Profesor a Curso</a></li>
						<li><a href="./bajaProfesorCurso.php">Baja Profesor de curso</a></li>
					</ul>
                </div>
                <div id="contenido">
				<?php
						
					// Establecemos la conexión con la base de datos
					include("../../conexion.php");
							
					// si hemos enviado el segundo formulario
					
					if (isset($_REQUEST['bBorrar'])){
						// nos aseguramos que se ha seleccionado algún checkbox
						if (!empty($_REQUEST['cProfesor'])){
							$checkbox = $_REQUEST['cProfesor'];
							$correcto = true;
							foreach($checkbox as $valor){
								$sentencia = 'Delete from imparte 
								where cod_profesor = ' . $valor . ' 
									and cod_curso = ' . $_REQUEST['hCurso'] . ';';
								if (!mysql_query($sentencia, $conexion)){
									$correcto = false;
								}
							}
							if ($correcto){
								echo "El/La/Los Profesor/a/es fueron borrados correctamente. <br>";
							}else{
								echo "El/La/Los Profesor/a/es no fueron borrados correctamente. <br>";
							}
						}else{
							echo "Asegúrese de que ha seleccionado algún profesor o de que exista alguno para el curso. <br>";
						}
					}
				?>
				
                    <fieldset>
                        <legend>Datos de los cursos</legend>
                        <form id="bajaProfesorCurso" method="post" name="bajaProfesorCurso" action="./bajaProfesorCurso.php">
                            <table>
                                <tr>
                                    <td><label>Curso:</label></td>
                                    <td>
										<select name="tCurso">
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
					if (isset($_REQUEST['bBuscar']) && !empty($_REQUEST['tCurso'])){
						
					?>
						<form name="listaProfesor" action="bajaProfesorCurso.php" method="post">
							<?php
								$sentencia = 'Select u.cod_usuario, u.dni, u.nombre, u.apellido1, u.apellido2 from usuario u, imparte i where cod_curso =' . $_REQUEST['tCurso'] . ' and u.cod_usuario = i.cod_profesor order by dni, apellido1, apellido2, nombre;';
								$resultado = mysql_query($sentencia, $conexion);
								
								if (mysql_num_rows($resultado)!=0){
							?>
									<table class="tablaConsultas">
										<?php
										while ($fila = mysql_fetch_array($resultado)){
										?>
											<tr>
												<td><input type="checkbox" value="<?php echo $fila['cod_usuario'];?>" name="cProfesor[]"/><span>DNI: </span> <?php echo $fila['dni'];?></td>
												<td><span>Primer Apellido: </span> <?php echo $fila['apellido1'];?></td>
												<td><span>Segundo Apellido: </span> <?php echo $fila['apellido2'];?></td>												<td><span>Nombre: </span> <?php echo $fila['nombre'];?></td>
											</tr>
											<?php
										}
										?>
											<tr>
												<td colspan="4" align="center">
													<input type="hidden" name="hCurso" value="<?php echo $_REQUEST['tCurso']; ?>" />
													<input type="submit" value="Borrar" name="bBorrar" />
												</td>
											</tr>
									</table>
							<?php
								}else { echo "No hay profesores inscritos en este curso";}
							?>
						</form>
					<?php
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