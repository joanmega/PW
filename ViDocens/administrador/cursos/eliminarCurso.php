<?php
	setlocale(LC_ALL,"es_ES"); 
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
						<li><a href="./altaCurso.php">A&ntilde;adir Curso</a></li>
						<li><a href="./eliminarCurso.php">Eliminar Curso</a></li>
						<li><a href="./consultarCurso.php">Consultar Curso</a></li>
						<li><a href="./modificarCurso.php">Modificar Curso</a></li>
						<li><a href="./listarAlumnosCurso.php">Listar Alumnos por Cursos </a></li>
						<li><a href="./listarProfesorCursos.php">Listar Profesor por Cursos </a></li>
						<li><a href="./altaAlumnoCurso.php">A&ntilde;adir Alumno a Curso</a></li>
						<li><a href="./bajaAlumnoCurso.php">Baja Alumno de curso</a></li>
					</ul>
                </div>
                <div id="contenido">
					<?php
						
						// Establecemos la conexión con la base de datos
						include("../../conexion.php");
							
						// Si hemos enviado el formulario.
						if (isset($_REQUEST['bAceptar'])){
							// Si la lista no está vacía borramos el curso
							if(!empty($_REQUEST['tLista'])){
								$sentencia = 'Delete from curso 
								where Cod_Curso = "' . $_REQUEST['tLista'] . '";';
								
								// Ejecutamos la sentencia.
								if (mysql_query($sentencia, $conexion)==1){
									echo "El curso se ha eliminado correctamente.";
								}else{
									echo "No se ha podido eliminar el curso.";
								}
							}
						}
					?>
                    <fieldset>
                        <legend>Datos del Curso</legend>
                        <form id="eliminarProfesor" method="post" name="eliminarProfesor.php" >
                            <table>
                                <tr>
                                    <td><label>Nombre</label></td>
                                    <td>
                                    	<select name="tLista">
										<?php
											$sentencia = 'Select * 
											from curso 
											order by nombre';
											
											// Ejecutamos la sentencia para recoger los datos de los cursos y guardamos el resultado
											$resultado = mysql_query($sentencia, $conexion);
											//rellenamos el select con los datos
											while ($fila = mysql_fetch_array($resultado)){											
										?>
                                    			<option value="<?php echo $fila['Cod_Curso']; ?>"><?php echo $fila['Nombre'] . " - " . $fila['Descripcion']; ?></option>
										<?php
											}
										?>
                                  		</select>
									</td>
                                	<td>
                                    	<input type="submit" name="bAceptar" value="Aceptar"/>
                                   	</td>
                                </tr>
                            </table>
                        </form>                        
                    </fieldset>               	
                </div>
                <div id="lat_derecho"></div>
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