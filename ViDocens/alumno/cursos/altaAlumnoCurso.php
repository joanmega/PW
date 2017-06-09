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
			if (isset($_SESSION['tipoUsuario'])&& $_SESSION['tipoUsuario']==2){
		?>
        <div id="contenedor">
            <div id="cabecera">
                <h1>Bienvenido, Alumno/a</h1>
				
            </div>        	        	
            <div id="menu">
	        	<ul>
                	<li><a href="../index_alumno.php">Inicio</a></li>
                	<li><a href="../cursos/consultarCurso.php">Cursos</a></li>
                    <li><a href="../material/consultarMaterial.php">Material</a></li>
                	<li><a href="../alumno/consultarAlumno.php">Mis datos</a></li>
                   <li><a href="../../identificacion.php">Cerrar Sesi&oacute;n</a></li>
                </ul>
            </div> 
            <div id="cuerpo">
                <div id="lat_izquierdo">
					<ul>
                    	<li><a href="./consultarCurso.php">Consultar Curso</a></li>
                        <li><a href="./altaAlumnoCurso.php">Darse de alta en Curso</a></li>
						<li><a href="./bajaAlumnoCurso.php">Darse de baja en Curso</a></li>
					</ul>
                </div>
                <div id="contenido">
				<?php
					// Establecemos la conexión con la base de datos
					include("../../conexion.php");		
				?>
                    <fieldset>
                        <legend>Datos de los cursos</legend>
						<?php
						// Procedemos a la matriculación del alumno en el curso
						if (isset($_REQUEST['bMatricular'])){
							if (!empty($_REQUEST['tCurso'])){
								// Establecemos la consulta para comprobar si está matriculado de ese curso
								$sentencia = 'SELECT * 
									FROM inscrito 
									WHERE cod_alumno = ' .$_SESSION['Usuario']. ' 
										and cod_curso = '.$_REQUEST['tCurso'].';';
								
								$resultado = mysql_query($sentencia, $conexion)
									or die ("El usuario no se ha obtenido correctamente <br>");
									
								// Si no está matriculado de ese curso...
								if (mysql_num_rows($resultado)==0){
									
									// Realizamos la consulta de inserción
									$sentencia = 'insert into inscrito(cod_alumno, cod_curso) 
										values('. $_SESSION['Usuario'] . ',' .$_REQUEST['tCurso'] . ');';
										
									if (mysql_query($sentencia, $conexion)){
										echo "Has sido inscrito correctamente en el curso";
									}else{
										echo "No hemos podido darle de alta en el curso. Consulte al administrador o profesor del curso";
									}
								}else{ // Si está inscrito mostramos el mensaje de error
									echo "Ya se encuentra matriculado en el curso. <br>";
								}
							}else{
								echo "No hay curso en los que inscribirse. <br>";
							}
						}
						?>
                        <form id="altaAlumnoCurso" method="post" name="altaAlumnoCurso" action="./altaAlumnoCurso.php">
							<table>
								<tr>
									<td><label>Curso:</label></td>
										<?php
											// Seleccionamos todos los cursos para cargarlos en el select.
										$sentencia = 'SELECT c.Cod_Curso, c.Nombre, c.Descripcion 
												from curso c
												where c.cod_curso not in (
														select i.cod_curso 
															from inscrito i 
															where i.cod_alumno = '. $_SESSION['Usuario'] . ')
												order by c.nombre;';
												
											?>
										<td>
											<select name="tCurso">
											<?php
											$resultado = mysql_query($sentencia, $conexion);
									
											while ($fila = mysql_fetch_array($resultado)){
											?>
												<option value="<?php echo $fila['Cod_Curso']; ?>"><?php echo $fila['Nombre'] ." - " . $fila['Descripcion']; ?></option>
											<?php 
											}
											?>
										</select>
									</td>
									<td><input type="submit" name="bMatricular" value="Matricularse"/></td>
								</tr>
							</table>
                        </form>
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