<?php
	setlocale(LC_ALL,"es_ES"); 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
	<head>
    	<link rel="stylesheet" href="../../estilos/estilo_video.css" type="text/css"/>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Alumnos</title>
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
						// Conectamos con la base de datos.
						include("../../conexion.php");
					?>
                    <fieldset>
                        <legend>Datos del Curso</legend>
                        <form id="listarAlumnosCurso" method="post" name="listarAlumnosCurso" action="./listarAlumnosCurso.php">
                            <table>
                                <tr>
                                    <td><label>Nombre</label></td>
                                    <td>
										<select name="tLista">
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
								if (!empty($_REQUEST['tLista'])){
								// Si lo que queremos es visualizar todos
									$sentencia = 'SELECT u.*, u.*, c.Descripcion as "descripcion", c.Nombre as "nombreCurso" FROM usuario u, inscrito i, curso c WHERE i.Cod_Alumno = u.cod_usuario and i.cod_Curso = ' .$_REQUEST['tLista']. ' and i.cod_curso = c.Cod_curso ORDER BY u.apellido1, u.apellido2, u.nombre, u.dni;';
									
									$resultado = mysql_query($sentencia, $conexion);
									if (mysql_num_rows($resultado)!=0){
										$fila = mysql_fetch_array($resultado);
										?>
										<table class="tablaConsultas">
											<tr>
												<td colspan="4"><span>Curso: </span> <?php echo $fila['nombreCurso'] . " - " . $fila['descripcion']; ?></td>
											</tr>
											<?php
												do{
											?>
			
											<tr>
												<td><span>DNI:</span> <?php echo $fila['DNI']; ?></td>
												<td><span>Nombre:</span> <?php echo $fila['nombre']; ?></td>
												<td><span>Apellido 1&deg;:</span> <?php echo $fila['apellido1']; ?></td>
												<td><span>Apellido 2&deg;:</span> <?php echo $fila['apellido2']; ?></td>
											</tr>
											<tr>
												<td><span>Tel&eacute;fono:</span> <?php echo $fila['telefono']; ?></td>
												<td><span>M&oacute;vil:</span> <?php echo $fila['movil']; ?></td>
												<td><span>Correo Electr&oacute;nico:</span> <?php echo $fila['correoElectronico']; ?></td>
												<td><span>Fecha Nac:</span> <?php echo date("d/m/Y", strtotime($fila['fecNacimiento'])); ?></td>
											</tr>
											<tr>
												<td colspan="2"><span>Domicilio:</span> <?php echo $fila['domicilio']; ?></td>
												<td><span>Pa&iacute;s: </span>
													<?php if ($fila['pais']==1) echo "Espa&ntilde;a";
														if ($fila['pais']==2) echo "Portugal";
														if ($fila['pais']==3) echo "Francia";
														if ($fila['pais']==4) echo "Alemania";
														if ($fila['pais']==5) echo "Italia";
														if ($fila['pais']==6) echo "Luxemburgo";
														if ($fila['pais']==7) echo "Andorra";
														if ($fila['pais']==8) echo "B&eacute;lgica";
														if ($fila['pais']==9) echo "Inglaterra";
														if ($fila['pais']==10)echo "Noruega";
														if ($fila['pais']==11)echo "Otro pa&iacute;s"; 
													?>
												</td>
												<td><span>Usuario/Login:</span> <?php echo $fila['usuario']; ?></td>
											</tr>
											<?php
											}while ($fila = mysql_fetch_array($resultado));
											?>
										</table>
								<?php
									}else{
										echo "No hay alumnos matriculados en este curso <br>";
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
            <?php
				}else{ echo "No tiene privilegios para acceder a esta información <br>";}
			?>
        </div>
    </body>
</html>