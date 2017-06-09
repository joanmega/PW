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
                        <legend>Datos del Curso</legend>
                        <form id="listarProfesorCursos" method="post" name="listarProfesorCursos" action="listarProfesorCursos.php">
                            <table>
                                <tr>
                                    <td><label>Nombre</label></td>
                                    <td>
										<select name="tLista">
											<?php
											// Seleccionamos todos los cursos para cargarlos en el select.
											
											$sentencia = 'SELECT u.Cod_usuario, u.Nombre, u.apellido1, u.apellido2, u.dni
												from profesor p, usuario u, imparte i 
												where p.cod_profesor = u.cod_usuario 
													and u.tipoUsuario = 1
												group by u.Cod_usuario, u.Nombre, u.apellido1, u.apellido2, u.dni
												order by u.dni, u.apellido1, u.apellido2, u.nombre;';
											$resultado = mysql_query($sentencia, $conexion);
											
											while ($fila = mysql_fetch_array($resultado)){
											?>
												<option value="<?php echo $fila['Cod_usuario']; ?>"><?php echo $fila['dni'] ." - " . $fila['Nombre']." " . $fila['apellido1']." " . $fila['apellido2']; ?></option>
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
								if (!empty($_REQUEST['tLista'])){
								// Si lo que queremos es visualizar todos
									$sentencia = 'select c.*, u.nombre, u.dni, u.apellido1, u.apellido2 
										from curso c, imparte i, usuario u
										where c.cod_curso = i.cod_curso 
											and i.cod_profesor = u.cod_usuario
											and i.cod_profesor = '.$_REQUEST['tLista'].';';
									
									$resultado = mysql_query($sentencia, $conexion);
									if (mysql_num_rows($resultado)>0){
										$fila = mysql_fetch_array($resultado);
									?>
									<table class="tablaConsultas">
										<tr>
											<td colspan="4"><span>Profesor: </span> <?php echo $fila['dni'] ." - " . $fila['nombre']." " . $fila['apellido1']." " . $fila['apellido2']; ?></td>
										</tr>
										<?php
											do{
										?>
										<tr>
											<td><span>Nombre:</span> <?php echo $fila['Nombre']; ?></td>
											<td><span>Descripci&oacute;n:</span> <?php echo $fila['Descripcion']; ?></td>
											<td><span>Cr&eacute;ditos:</span> <?php echo $fila['Creditos']; ?></td>
										</tr>
										<?php
										}while ($fila = mysql_fetch_array($resultado));
										?>
									</table>
							<?php
									}else{
										echo "No hay curso que imparta este profesor <br>";
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
                    Hoy es <?php echo strftime("%A %d de %B del %Y");
					mysql_close($conexion); ?>
        	</div>
        </div>
		<?php
			}else{ echo "No tiene privilegios para acceder a esta información <br>";}
		?>
    </body>
</html>