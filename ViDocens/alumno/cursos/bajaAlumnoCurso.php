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
                    <fieldset>
                        <legend>Datos de los cursos</legend>
						<?php
		
							// Establecemos la conexión con la base de datos
							include("../../conexion.php");
		
							// si hemos enviado el segundo formulario
							if (isset($_REQUEST['bBaja'])){
								if (!empty($_REQUEST['tCurso'])){
									$sentencia = 'Delete from inscrito 
									where cod_alumno = ' . $_SESSION['Usuario'] . ' 
										and cod_curso = ' . $_REQUEST['tCurso'] . ';';
									if (mysql_query($sentencia, $conexion)){
										echo "Se ha dado de baja del curso correctamente <br>";
									}else{
										echo "No se ha podido realizar la baja. Contacte con el administrador o con su profesor <br>";
									}
								}else{
									echo "No está matriculado en ningún curso. <br>";
								}
							}
						?>
                        <form id="bajaAlumnoCurso" method="post" name="bajaAlumnoCurso" action="./bajaAlumnoCurso.php">
                            <table>
                                <tr>
                                    <td><label>Curso:</label></td>
                                    <td>
										<select name="tCurso">
											<?php
											// Seleccionamos todos los cursos para cargarlos en el select.
											
											$sentencia = 'SELECT c.Cod_Curso, c.Nombre, c.Descripcion 
											from curso c, inscrito i
											where c.cod_curso = i.cod_curso and
												i.cod_alumno = '.$_SESSION['Usuario'] . '  
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
                                    	<input type="submit" name="bBaja" value="Darse de Baja"/>
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