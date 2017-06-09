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
					<fieldset>
                        <legend>Datos del Curso</legend>
					<?php
						if (isset($_REQUEST['bAceptar']) && $_REQUEST['tNombre'] != '' && $_REQUEST['tDescripcion'] != ''){
							if ($_REQUEST['tCreditos'] == ''){
								$_REQUEST['tCreditos'] = 0;
							}
							//Estanblecemos la conexión con la base de datos.
							
							include ("../../conexion.php");
							
							// Comprobamos que no existe otro curso con ese nombre.
							$sentencia = 'select Nombre from curso where Nombre = "' . $_REQUEST['tNombre'] . '";';
							$resultado = mysql_query($sentencia, $conexion);
							
							// Si no existe otro curso con el mismo nombre.
							if (mysql_num_rows($resultado)==0){
								// Introducimos la sentencia insert para dar de alta a un curso.
								$sentencia = 'insert into curso (Nombre, Descripcion, Creditos) values ("'
									. $_REQUEST['tNombre'] . '", "' . $_REQUEST['tDescripcion'] . '", ' . $_REQUEST['tCreditos'] . ');';
								if (mysql_query($sentencia, $conexion)==1){
									// Si hemos podido insertar bien el curso vamos a asignar a ese profesor el curso
									// Primero seleccionamos el código del curso
									$sentencia = 'Select cod_curso from curso where Nombre = "'.$_REQUEST['tNombre'].'";';
									$resultado = mysql_query($sentencia, $conexion);
									$fila = mysql_fetch_array($resultado);
									// Una vez que tenemos el codigo del curso hacemos la inserción en la tabla imparte.
									$sentencia = 'insert into imparte values ('.$_SESSION['Usuario'].','.$fila['cod_curso'].');';
									mysql_query($sentencia, $conexion);
									echo "El curso se ha añadido correctamente";
								}
							}else{
								echo "Ya existe un curso con ese nombre, elija otro";
							}
							mysql_close($conexion);
						}else{
					?>
                        <form method="post" name="anadirCurso" action="./altaCurso.php" >
                            <table>
                                <tr>
                                    <td><label>Nombre</label></td>
                                    <td><input autofocus name="tNombre" type="text" size="50" maxlength="30" tabindex="1" <?php if(isset($_REQUEST['bAceptar'])){ echo ' value="' . $_REQUEST['tNombre'] . '"'; }?> /></td>
                                </tr>
                                <tr>
                                    <td><label>Descripci&oacute;n</label></td>
                                    <td><textarea name="tDescripcion" cols="50" rows="2" tabindex="2" onkeypress="contar_letras_descripcion_Curso(tDescripcion, 100);"><?php if(isset($_REQUEST['bAceptar'])){ echo $_REQUEST['tDescripcion']; }?></textarea><br />
									</td>
                                </tr>
                                <tr>
                                    <td><label>Cr&eacute;ditos</label></td>
                                    <td><input name="tCreditos" type="text" onblur="validacion(tCreditos);" size="20" maxlength="20" tabindex="3" <?php if(isset($_REQUEST['bAceptar'])){ echo $_REQUEST['tCreditos']; }?> /></td>
                                </tr>
								<tr>
									<td></td>
                                	<td>
                                    	<input name="bAceptar" type="submit" value="Aceptar" onclick="validarAltaCurso();">
                                    	<input type="reset" name="bReset" value="Limpiar Formulario"/>
                                   	</td>
								</tr>
                            </table>                  
                        </form>     
						<?php
						}
						?>
                    </fieldset>               	
                </div>
                <div id="lat_derecho"></div>
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