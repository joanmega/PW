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

				?>
				
                    <fieldset>
                        <legend>Datos de los cursos</legend>
                        <form id="altatProfesorCurso" method="post" name="altatProfesorCurso" action="./altaProfesorCurso.php">
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
								</tr>
								<tr>
									<td><label>Profesor:</label></td>
                                    <td>
										<select name="tProfesor">
											<?php
											// Seleccionamos todos los cursos para cargarlos en el select.
											
											$sentencia = 'Select * 
											from usuario 
											where tipoUsuario = 1 
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
									<td colspan="2">
                                    	<input type="submit" name="bBuscar" value="Inscribir Profesor"/>
                                   	</td>
                                </tr>
                            </table>
                        </form>
						<?php
						if (isset($_REQUEST['bBuscar']) && !empty($_REQUEST['tProfesor']) && !empty($_REQUEST['tCurso'])){
							$sentencia = 'select cod_Profesor, cod_curso 
							from imparte 
							where cod_profesor = '.$_REQUEST['tProfesor'].' 
								and cod_curso='.$_REQUEST['tCurso'].';';
							// Consultamos si el profesor está ya matriculado
							$resultado = mysql_query($sentencia, $conexion) 
								or die ("No se ha podido consultar si está el profesor imparte el curso");
							// Si el usuario no está inscrito en el curso procedemos a inscribirlo
							if (mysql_num_rows($resultado)==0){
								// Realizamos la consulta de inserción
								$sentencia = 'insert into imparte(cod_profesor, cod_curso) 
								values('.$_REQUEST['tProfesor'].','.$_REQUEST['tCurso'].');';
								
								if (mysql_query($sentencia, $conexion)){
									echo "El Profesor se ha inscrito correctamente en el curso";
								}else{
									echo "El Profesor no se ha podido inscribir en el curso";
								}
							}else{ // Si está inscrito mostramos el mensaje de error
								echo "El profesor ya se encuentra inscrito en el curso. <br>";
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