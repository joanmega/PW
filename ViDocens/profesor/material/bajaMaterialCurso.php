<?php 
	setlocale(LC_ALL, "es_ES");
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
			if (isset($_SESSION['tipoUsuario'])&& $_SESSION['tipoUsuario']==1){
		?>
        <div id="contenedor">
            <div id="cabecera">
                <h1>Bienvenido, Profesor/a</h1>
            </div>        	        	
            <div id="menu">
	        	<ul>	
                	<li><a href="../index_admin.php">Inicio</a></li>
                	<li><a href="../cursos/consultarCurso.php">Cursos</a></li>
                	<li><a href="../alumnos/consultarAlumno.php">Alumnos</a></li>
                	<li><a href="../material/altaMaterial.php">Material</a></li>
                    <li><a href="../mis_datos/consultarProfesor.php">Mis datos</a></li>
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

					// si hemos enviado el segundo formulario
					
					if (isset($_REQUEST['bBorrar'])){
						$checkbox = $_REQUEST['cMaterial'];
						$ruta = $_REQUEST['ruta'];
						$correcto = true;
						$i = 0;
						
						foreach($checkbox as $valor){
							$sentencia = 'Delete from material 
							where cod_Material = ' . $valor . ';';
							if (!mysql_query($sentencia, $conexion)){
								$correcto = false;
							}else{
								// Si se ha borrado de la base de datos lo borramos del directorio
								unlink($ruta[$i]);
							}
							$i++;
						}
						if ($correcto){
							echo "El/Los video/s fueron borrados correctamente";
						}else{
							echo "El/Los video/s no fueron borrados correctamente";
						}
					}else{
				?>
				
                    <fieldset>
                        <legend>Datos del material por curso</legend>
                        <form id="bajaMaterialCurso" method="post" name="bajaMaterialCurso" action="./bajaMaterialCurso.php">
                            <table>
                                <tr>
                                    <td><label>Curso:</label></td>
                                    <td>
										<select name="tCurso">
											<?php
											// Seleccionamos todos los cursos para cargarlos en el select.
											
											$sentencia = 'SELECT c.Cod_Curso, c.Nombre, c.Descripcion 
											from curso c, imparte i
											where i.cod_profesor = '.$_SESSION['Usuario'].'
												and c.cod_curso = i.cod_curso
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
						if (isset($_REQUEST['bBuscar'])){
							// Si el select no está vacío
							if (!empty($_REQUEST['tCurso'])){
					?>
						<form name="listaMaterial" action="./bajaMaterialCurso.php" method="post">
							<?php
								// realizamos la sentencia para consultar los datos del material registrado en el curso.
								$sentencia = 'Select m.*, c.nombre, c.descripcion
								from material m, curso c 
								where m.cod_curso =' . $_REQUEST['tCurso'] . ' 
									and c.cod_curso = m.cod_curso 
								order by m.cod_curso, m.descripcion, m.fechaSubida;';
								
								$resultado = mysql_query($sentencia, $conexion);
								
								if (mysql_num_rows($resultado)!=0){
							?>
									<table class="tablaConsultas">
										<?php
										while ($fila = mysql_fetch_array($resultado)){
										?>
											<tr>
												<td><input type="checkbox" value="<?php echo $fila['Cod_Material'];?>" name="cMaterial[]"/><span>Descripci&oacute;n: </span> <?php echo $fila['Descripcion'];?></td>
												<td><span>Fecha de Subida: </span> <?php echo date("d/m/Y", strtotime($fila['FechaSubida']));?></td>
												<td>
													<input type="hidden" value="<?php echo $fila['RutaFichero'];?>" name="ruta[]" />
													<span>Ruta del Fichero: </span> <?php echo $fila['RutaFichero'];?></td>
											</tr>
											<?php
										}
										?>
											<tr>
												<td colspan="4" align="center">
													<input type="submit" value="Borrar" name="bBorrar" />
												</td>
											</tr>
									</table>
							<?php
								}else { 
									echo "No hay alumnos matriculados en este curso";
								}
							}else{
								echo "No hay cursos disponibles. <br>";
							}
							?>
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
                    Hoy es <?php echo strftime("%A %d de %B del %Y"); ?>
        	</div>
        </div>
		<?php
			}else{ echo "No tiene privilegios para acceder a esta información <br>";}
			mysql_close($conexion);
		?>
    </body>
</html>