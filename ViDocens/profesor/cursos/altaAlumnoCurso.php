<?php 
	setlocale(LC_ALL, "es_ES");
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
			if (isset($_SESSION['tipoUsuario'])&& $_SESSION['tipoUsuario']==1){
		?>
        <div id="contenedor">
            <div id="cabecera">
                <h1>Bienvenido, Profesor/a</h1>
            </div>        	        	
            <div id="menu">
	        	<ul>
                	<li><a href="../index_profesor.php">Inicio</a></li>
                    <li><a href="../cursos/consultarCurso.php">Cursos</a></li>
                	<li><a href="../alumnos/consultarAlumno.php">Alumnos</a></li>
                    <li><a href="../material/consultarMaterial.php">Material</a></li>
                    <li><a href="../mis_datos/consultarProfesor.php">Mis datos</a></li>
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
						<li><a href="./altaProfesorCurso.php">A&ntilde;adir Profesor a Curso</a></li>
						<li><a href="./bajaProfesorCurso.php">Baja Profesor de curso</a></li>
					</ul>
                </div>
                <div id="contenido">
				<?php
						
				// Establecemos la conexión con la base de datos
				include("../../conexion.php");
							
				?>
				
                    <fieldset>
                        <legend>Datos de los cursos</legend>
                        <form id="altaAlumnoCurso" method="post" name="altaAlumnoCurso" action="./altaAlumnoCurso.php">
                            <table>
                                <tr>
                                    <td><label>Curso:</label></td>
                                    <td>
										<select name="tCurso">
											<?php
											// Seleccionamos todos los cursos del profesor para cargarlos en el select.
											
											$sentencia = 'SELECT c.Cod_Curso, Nombre, Descripcion 
												from curso c, imparte i
												where c.cod_curso = i.cod_curso 
													and i.cod_Profesor = '. $_SESSION['Usuario'].' 
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
								</tr>
								<tr>
									<td><label>Alumno:</label></td>
                                    <td>
										<select name="tAlumno">
											<?php
											// Seleccionamos todos los cursos para cargarlos en el select.
											
											$sentencia = 'Select u.* 
											from usuario u 
											where tipoUsuario = 2 
											order by apellido1, apellido2, nombre';
											$resultado = mysql_query($sentencia, $conexion);
											
											while ($fila = mysql_fetch_array($resultado)){
											?>
												<option value="<?php echo $fila['Cod_Usuario']; ?>"><?php echo $fila['DNI'] .' - ' .$fila['apellido1']. ' ' .$fila['apellido2']. ', ' .$fila['nombre']; ?></option>
											<?php 
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>
                                    	<input type="submit" name="bBuscar" value="Matricular"/>
                                   	</td>
                                </tr>
                            </table>
                        </form>
						<?php
						if (isset($_REQUEST['bBuscar'])){
							// Si alguno de los dos select están sin datos
							if (!empty($_REQUEST['tCurso']) && !empty($_REQUEST['tAlumno'])){
								$sentencia = 'select cod_Alumno, cod_curso 
								from inscrito 
								where cod_alumno = '.$_REQUEST['tAlumno'].' 
									and cod_curso='.$_REQUEST['tCurso'].';';
								// Consultamos si el alumno está ya matriculado
								$resultado = mysql_query($sentencia, $conexion) 
									or die ("No se ha podido consultar si está matriculado el alumno en el curso");
								// Si el usuario no está inscrito en el curso procedemos a inscribirlo
								if (mysql_num_rows($resultado)==0){
									// Realizamos la consulta de inserción
									$sentencia = 'insert into inscrito(cod_alumno, cod_curso) 
									values('.$_REQUEST['tAlumno'].','.$_REQUEST['tCurso'].');';
									
									if (mysql_query($sentencia, $conexion)){
										echo "El alumno se ha inscrito correctamente en el curso";
									}else{
										echo "El alumno no se ha podido matricular en el curso";
									}
								}else{ // Si está inscrito mostramos el mensaje de error
									echo "El alumno ya se encuentra matriculado en el curso. <br>";
								}
							}
						}
						?>
                    </fieldset>
                </div>
                <div id="lat_derecho">
                </div>
            </div>
          	<div id="pie">
                    Hoy es <?php echo strftime("%A %d de %B del %Y"); ?>
        	</div>
        </div>
		<?php
			}else{ echo "No tiene privilegios para acceder a esta información <br>";}
			mysql_close($conexion);
		?>
    </body>
</html>