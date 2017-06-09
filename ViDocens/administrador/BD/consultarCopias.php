<?php 
	setlocale(LC_ALL,"es_ES"); 
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
                </div>
                <div id="contenido">
					<?php
						// Realizamos la conexión implementada en conexion.php
						include("../../conexion.php");
					?>
                    <fieldset>
                        <legend>Datos de la copia</legend>
					<?php
						// Si hemos pulsado el botón de restaurar copias
						if (isset($_REQUEST['bRestaurar'])){
							// Si el select está vacío.
							if (!empty($_REQUEST['tLista'])){
								// Seleccionamos de la base de datos los datos del archivo
								$sentencia = 'SELECT * 
									FROM copia 
									WHERE cod_copia='.$_REQUEST['tLista'].';';
									
								// Ejecutamos la consulta y guardamos el resultado
								$resultado = mysql_query($sentencia, $conexion);
								
								// Almacenamos el registro en una variable.
								$fila = mysql_fetch_array($resultado);
								
								// Almacenamos la ruta del archivo
								$directorio = '../CopiasBD';
								$archivo = date("Y-m-d_H-i-s" , strtotime($fila['FechaCopia']));
								
								$ruta = $directorio.'/'.$archivo.'.sql';
								
								// Restauramos la copia
																
								RestaurarBD($ruta);
								
								// Almacenamos cual fue la última copia que se restauró
								
								$sentencia = 'UPDATE copia
									SET Actual=0
									WHERE cod_copia<>'.$_REQUEST['tLista'].';';
								
								mysql_query($sentencia, $conexion);
								
								$sentencia = 'UPDATE copia
									SET Actual=1
									WHERE cod_copia='.$_REQUEST['tLista'].';';
								
								// Ejecutamos la consulta y restauramos la base de datos
								if (mysql_query($sentencia, $conexion)){
									echo "Se restauró la base de datos correctamente. <br>";
								}
							}else{
								echo "No hay copias de seguridad de la base de datos almacenadas. <br>";
							}
						}
						
						// Si hemos pulsado el botón de nueva copia realizamos la copia de seguridad implementada en conexion.php
						if(isset($_REQUEST['bNueva'])){
							$fecha = date("Y-m-d H:i:s" ,time());
							$directorio = '../CopiasBD';
							
							$sentencia = 'insert into copia(FechaCopia, RutaCopia) 
								values ("'.$fecha.'","'.$directorio.'/'.$fecha.'.sql");';
							
							if (mysql_query($sentencia, $conexion)){
								
								$fecha = date("Y-m-d_H-i-s",strtotime($fecha));
								CrearCopiaSeguridad($fecha, $directorio);
								echo "La copia de seguridad se realizó correctamente";
							}
							
						}
						
						// Si hemos pulsado el botón de eliminar
						if(isset($_REQUEST['bEliminar'])){
							// Sí hay algún checkbox activado.
							if (!empty($_REQUEST['cCopias'])){
								
								$checkbox = $_REQUEST['cCopias'];
								$rutas = $_REQUEST['hRuta'];
								$correcto = true;
								$i=0;
								$directorio = '../CopiasBD';
								
								foreach($checkbox as $valor){
									$sentencia = 'Delete from copia 
									where cod_Copia = ' . $valor.';';
									
									// terminar el borrado pasándole la ruta
									
									if (unlink($directorio.'/'.$rutas[$i].'.sql')){
										if (!mysql_query($sentencia, $conexion)){
											$correcto = false;
										}
									}
									$i++;
								}
								if ($correcto){
									echo "La/Las copia/s fueron borradas correctamente. <br>";
								}else{
									echo "La/Las copia/s no fueron borradas correctamente. <br>";
								}
							}else{
								echo "Seleccione alguna copia para eliminar o asegurese de que existe alguna. <br>";
							}
						}
						?>
						
						<form action="consultarCopias.php" method="post" name="consultarCopias">
						<?php
							// Realizamos la sentencia
							$sentencia = 'Select * 
								from copia';
							// Y guardamos el resultado
							$resultado = mysql_query($sentencia, $conexion);
						?>
							<table class="tablaConsultas">
								<tr>
									<td colspan="3">Copias de Seguridad</td>
								</tr>
								<tr>
									<td><span>Fecha de Copia: </span></td>
									<td><span>Ruta de Copia:</span></td>
									<td><span>Actual: </span></td>
								</tr>
								<?php
									// Mostramos todas las copias de seguridad del sistema
									while ($fila = mysql_fetch_array($resultado)){
								?>
								<tr>
									<td>
										<input type="checkbox" name="cCopias[]" value="<?php echo $fila['cod_copia']; ?>" /><?php echo $fila['FechaCopia']; ?>
									</td>
									<td><?php echo $fila['RutaCopia']; ?>
										<input type="hidden" name="hRuta[]"	value="<?php echo date("Y-m-d_H-i-s" , strtotime($fila['FechaCopia'])); ?>" />
									</td>
									<td><?php if($fila['Actual']=='0') echo 'No'; else echo 'Si'; ?></td>
								</tr>
								<?php
									}
								?>
								<tr align="center">
									<td></td>
									<td><input type="submit" value="Nueva Copia" name="bNueva" />
										<input type="submit" value="Eliminar Copia" name="bEliminar" />
									</td>
									<td></td>
								</tr>
							</table>
						</form>
                    </fieldset>
					
					<fieldset>
						<legend>Restaurar Copia</legend>
						<form action="consultarCopias.php" method="post" name="restaurarCopias">
							<table class="tablaConsultas">
								<tr>
									<td colspan="2">Copias de Seguridad</td>
								</tr>
								<tr>
									<td>
										<select name="tLista">
											<?php
												// Cargamos el select con las copias de la BD
												
												$sentencia = 'Select * 
													from copia';
												$resultado = mysql_query($sentencia, $conexion);
												while ($fila = mysql_fetch_array($resultado)){
											?>
											<option value="<?php echo $fila['cod_copia']; ?>"><?php echo date("d/m/Y H:i:s", strtotime($fila['FechaCopia'])); ?></option>
											<?php
												}
											?>
										</select></td>
									<td><input type="submit" value="Restaurar" name="bRestaurar" /></td>
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