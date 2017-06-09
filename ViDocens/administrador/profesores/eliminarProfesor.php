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
							
					if (isset($_REQUEST['bEliminar'])){
						if (!empty($_REQUEST['tLista'])){
							$sentencia = 'DELETE FROM usuario 
							WHERE cod_usuario = "' . $_REQUEST['tLista'] . '";';
							// Ejecutamos las sentencia y almacenamos el resultado.
							if (mysql_query( $sentencia, $conexion)){
								echo "El profesor se ha borrado correctamente <br>";
							}else{
								echo "El profesor no se ha podido borrar <br>";
							}
						}
					}
				?>
                    <fieldset>
                        <legend>Lista de Profesores</legend>
                        <form id="eliminarProfesor" method="post" name="eliminarProfesor" action="eliminarProfesor.php">
                            <table>
                                <tr>
                                    <td><label>Nombre</label></td>
                                    <td>
                                    <select name="tLista">
										<?php
											$sentencia = 'Select cod_usuario, dni, nombre, apellido1, apellido2 
											from usuario 
											Where tipoUsuario = 1';
											$resultado = mysql_query($sentencia, $conexion);
											while ($fila = mysql_fetch_array($resultado)){
										?>
										<option value="<?php echo $fila['cod_usuario'];?>"><?php echo $fila['dni'] . " - " . $fila['apellido1'] . " " . $fila['apellido2'] . ", " . $fila['nombre'];?></option>
										<?php
											}
										?>
                                  </select></td>
                                	<td>
                                    	<input type="submit" name="bEliminar" value="Eliminar"/>
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