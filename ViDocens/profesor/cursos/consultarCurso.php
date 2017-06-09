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
					//Estanblecemos la conexión con la base de datos.
						include ("../../conexion.php");
				?>
				
                    <fieldset>
                        <legend>Datos de los cursos</legend>
                        <form id="consultaCurso" method="post" name="consultaCurso" action="./consultarCurso.php">
                            <table>
                                <tr>
                                    <td><label>Curso</label></td>
                                    <td>
										<select name="tLista">
											<option value="0">Todos</option>
											<option value="-1">Impartiendo</option>
											<?php
											// Seleccionamos todos los cursos para cargarlos en el select.
											
											$sentencia = 'SELECT Cod_Curso, Nombre, Descripcion from curso order by nombre;';
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
								// Si lo que queremos es visualizar todos
								if ($_REQUEST['tLista'] == 0){
									$sentencia = 'SELECT * FROM curso ORDER BY nombre, descripcion, creditos';		
								}else{
									if ($_REQUEST['tLista']==-1){
										$sentencia = 'SELECT c.* 												
											from curso c, imparte i
												where i.cod_profesor = '. $_SESSION['Usuario'] . ' 
													and c.cod_curso = i.cod_curso  
												order by nombre;';
									}else{
										// si no
										$sentencia = 'SELECT * FROM curso WHERE Cod_Curso = ' .$_REQUEST['tLista']. ' ORDER BY nombre, descripcion, creditos';
									}
								}
								
									$resultado = mysql_query($sentencia, $conexion);
									while ($fila = mysql_fetch_array($resultado)){
						?>
								<table class="tablaConsultas">
									<tr>
										<td><span>C&oacute;digo de curso: </span> <?php echo $fila['Cod_Curso']; ?></td>
										<td><span>Nombre: </span> <?php echo $fila['Nombre']; ?></td>
										<td><span>Descripci&oacute;n: </span> <?php echo $fila['Descripcion']; ?></td>
										<td><span>Cr&eacute;ditos: </span> <?php echo $fila['Creditos']; ?></td>
									</tr>
								</table>
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
            <?php
				}else{ echo "No tiene privilegios para acceder a esta información <br>";}
			?>
        </div>
    </body>
</html>